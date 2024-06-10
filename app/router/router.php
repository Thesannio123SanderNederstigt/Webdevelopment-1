<?php
namespace Routers;

use Error;
class Router
{
    private function stripParameters($uri)
    {
        if (str_contains($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }
        return $uri;
    }
    
    public function route($uri)
    {
        //api route check
        $api = false;
        if (str_starts_with($uri, "api/")) {
            $uri = substr($uri, 4);
            $api = true;
        }
        
        $uri = $this->stripParameters($uri);
        
        //read the controller/method names from the URL
        $explodedUri = explode('/', $uri);
        
        if (!isset($explodedUri[0]) || empty($explodedUri[0])) {
            $explodedUri[0] = 'home';
        }
        
        $controllerName = $explodedUri[0] . "controller";
        
        if (!isset($explodedUri[1]) || empty($explodedUri[1])) {
            $explodedUri[1] = 'index';
        }
        
        $methodName = $explodedUri[1];
        
        //load the controller file
        if ($api) {
            $filename = __DIR__ . '../../api/controllers/' . $controllerName . '.php';

            $controllerName = "apiControllers\\" . $controllerName;
        } else {

            $filename = __DIR__ . '../../controllers/' . $controllerName . '.php';

            $controllerName = "viewControllers\\" . $controllerName;
        }
        
        if (file_exists($filename) || method_exists($controllerName, $methodName)) {
            require_once $filename;
        } else {
            http_response_code(404);
            //return;
        }
        
        try {
            $controllerObj = new $controllerName();

            //mocht er een derde (of zelfs een vierde) param zijn, gebruik deze dan als argument(s)/input voor de methode/functie (en anders niet)
            if(isset($explodedUri[2]) && !empty($explodedUri[2]))
            {
                if(isset($explodedUri[3]) && !empty($explodedUri[3]))
                {
                    $controllerObj->{$methodName}($explodedUri[2], $explodedUri[3]);
                } else {
                    $controllerObj->{$methodName}($explodedUri[2]);
                }
            } else {
                $controllerObj->{$methodName}();
            }
        } catch(Error $e) {
            echo $e;
            //$_SESSION['ERROR'] = $e;
            //var_dump($_SESSION);
            //http_response_code(500);
        }
    }
}
?>