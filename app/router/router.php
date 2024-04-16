<?php
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
        $filename = __DIR__ . '../controllers/' .$controllerName . '.php';
        
        if ($api) {
            $filename = __DIR__ . '../api/controllers/' . $controllerName . '.php';
        }
        
        if (file_exists($filename)) {
            require $filename;
        } else {
            http_response_code(404);
            return;
        }
        
        /*
        if(!class_exists($controllerName) || !method_exists($conrollerName, $methodName)) {
            http_response_code(404);
            //die();
            //exit();
            return;
        }
        */
        
        try {
            $controllerObj = new $controllerName();
            $controllerObj->$methodName();
        } catch(Error $e) {
            //$_SESSION['ERROR'] = $e;
            //var_dump($_SESSION);
            http_response_code(500);
        }
    }
}
?>