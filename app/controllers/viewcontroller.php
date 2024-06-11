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

    function redirectViewGetRequest ($viewName)
    {
        if($_SERVER['REQUEST_METHOD'] == "GET") 
        {
            header("Location: /$viewName");
            exit;
        }
    }

    function viewGetRequestSessionUserCheck()
    {
        if(isset($_SESSION['user']) == false)
        {
            header("Location: /");
            exit;
        }
    }

    function provideBoolValue($cleanIsBoolItem): bool
    {
        if($cleanIsBoolItem == "Ja" || $cleanIsBoolItem == "ja" || $cleanIsBoolItem == "Yes" || $cleanIsBoolItem == "yes")
        {
            $isBoolItem = true;
        } 
        else if($cleanIsBoolItem == "Nee" || $cleanIsBoolItem == "nee" || $cleanIsBoolItem == "No" || $cleanIsBoolItem == "no")
        {
            $isBoolItem = false;
        }

        return $isBoolItem;
    }
}
?>