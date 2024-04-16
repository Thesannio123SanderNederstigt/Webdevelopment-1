<?php
require __DIR__ . '/controller.php';

class HomeController extends Controller 
{
    function __construct()
    {
        if(session_status() !== PHP_SESSION_ACTIVE || !isset($_SERVER['HTTP_AUTHORIZATION'])){
            session_start();
            $viewName = 'login';
        } else {
            $viewName = 'home';
        }
    }

    public function index()
    {
        require __DIR__ . '../views/' . $viewName . '/index.php';
    }
}
?>