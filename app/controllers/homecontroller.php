<?php
namespace viewControllers;

use viewControllers\viewController;
use Services\userService;
//require __DIR__ . '/controller.php';

class HomeController extends viewController 
{
    private $userService;

    function __construct()
    {
        $this->userService = new userService();

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

    public function login()
    {
        if($_SERVER['REQUEST_METHOD'] == "GET") 
        {
            require '../views/login/index.php';
        }

        if($_SERVER['REQUEST_METHOD'] == "POST") 
        {
            //input sanitation
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);

            $this->userService->loginCheck($username, $password);

            //hier ook een jwt token teruggeven? NOPE hier niet voor deze applicatie, dit wordt wel geïmplementeerd voor de API back-end kant voor de web development 2 nuxt applicatie
            $this->checkMappingAndDisplayView('home');
        }
    }

    public function users()
    {

    }

    public function sportsclubs()
    {

    }

    public function cardItems()
    {

    }

    public function bingocards()
    {

    }
}
?>