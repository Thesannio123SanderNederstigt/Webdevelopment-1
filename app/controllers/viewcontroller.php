<?php
namespace viewControllers;

class viewController
{
    function checkMappingAndDisplayView($models)
    {
        /*if(session_status() !== PHP_SESSION_ACTIVE || !isset($_SERVER['HTTP_AUTHORIZATION'])) {
            //session_start();
            $directory = 'login';
        } else {
            $directory = substr(get_class($this), 16, -10); //$this === $model?
        }*/

        //$viewName = debug_backtrace()[1]['function']; //index

        $directory = substr(get_class($this), 16, -10);
        require __DIR__ . "/../views/$directory/index.php"; //voeg de view toe
    }
}
?>