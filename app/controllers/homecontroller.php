<?php
namespace viewControllers;

use Exception;
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
            $username = htmlspecialchars($_POST['form-username']);
            $password = htmlspecialchars($_POST['form-password']);

            $user = $this->userService->loginCheck($username, $password);

            if($user->getIsAdmin() == true)
            {
                session_start();

                $_SESSION['user']['id'] = $user->getId();
                $_SESSION['user']['username'] = $user->getUsername();
                $_SESSION['user']['email'] = $user->getEmail();
                $_SESSION['user']['isAdmin'] = true;
                $_SESSION['user']['isPremium'] = $user->getIsPremium();
                $_SESSION['user']['cardsAmount'] = $user->getCardsAmount();
                $_SESSION['user']['sharedCardsAmount'] = $user->getSharedCardsAmount();

                //$_SESSION['userIsAdmin'] = true;
                $this->checkMappingAndDisplayView('home');
            }
            else{
                $_SESSION['userIsAdmin'] = false;
                $_SESSION['loginError'] = 'Onjuiste inloggegevens ingevoerd';
                $this->checkMappingAndDisplayView('login');
            }

            //hier ook een jwt token teruggeven? NOPE.. hier niet voor deze applicatie, dit wordt wel geïmplementeerd voor de API back-end kant voor de web development 2 nuxt applicatie
            //later... ehh, ja;toch maar wel, maar dan met het aanroepen van de apicontroller (fetch request, ofwel js of toch PHP?)

            //also: refresh tokens? en een check op of gebruikers admin zijn of anders kunnen ze niet hier inloggen toch?
            //$this->checkMappingAndDisplayView('home');
        }
    }

    public function logout()
    {
        if(isset($_POST['logout']))
        {
            unset($_SESSION['user']);
            //session_destroy();
            $this->checkMappingAndDisplayView('login');
        }
        else
        {
            $this->checkMappingAndDisplayView('home');
        }
    }
}
?>