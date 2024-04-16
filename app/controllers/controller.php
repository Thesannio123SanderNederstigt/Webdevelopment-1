<?php
class Controller
{
    function checkMappingAndDisplayView($model) {

        if(session_status() !== PHP_SESSION_ACTIVE || !isset($_SERVER['HTTP_AUTHORIZATION'])){ //TODO: figure these checks for sessions and later on JWT tokens out!
            session_start();
            $directory = 'login';
        } else {
            $directory = substr(get_class($this), 0, -10);
        }

        $viewName = debug_backtrace()[1]['function']; //index

        require __DIR__ . "/../views/$directory/$viewName.php";
    }
}
?>