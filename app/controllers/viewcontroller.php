<?php
namespace viewControllers;

class viewController
{
    function checkMappingAndDisplayView($models)
    {
        $directory = substr(get_class($this), 16, -10);
        require __DIR__ . "/../views/$directory/index.php";
    }

    function redirectViewGetRequest ($viewName)
    {
        if($_SERVER['REQUEST_METHOD'] == "GET") 
        {
            header("Location: /$viewName");
            exit;
        }
    }

    function viewRequestSessionUserCheck()
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