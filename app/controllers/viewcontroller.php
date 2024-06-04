<?php
namespace viewControllers;

class viewController
{
    function checkMappingAndDisplayView($model) 
    {
        if(session_status() !== PHP_SESSION_ACTIVE || !isset($_SERVER['HTTP_AUTHORIZATION'])) { //TODO: figure these checks for sessions out!
            session_start();
            $directory = 'login';
        } else {
            $directory = substr(get_class($this), 0, -10); //$this === $model?
        }

        $viewName = debug_backtrace()[1]['function']; //index

        require __DIR__ . "/../views/$directory/$viewName.php"; //voeg de view toe
    }
}
?>