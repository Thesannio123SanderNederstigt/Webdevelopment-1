<?php
namespace viewControllers;

use viewControllers\viewController;
use Services\userService;

class HomeController extends viewController
{
    private $userService;
	private $viewName;

    function __construct()
    {
        $this->userService = new userService();

        if(session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
            $this->viewName = 'login';
        }

        if(isset($_SESSION['user']))
        {
            $this->viewName = 'home';
        }
    }

    public function index()
    {
        require __DIR__ . '../../views/' . $this->viewName . '/index.php';
    }

    public function login()
    {
        if($_SERVER['REQUEST_METHOD'] == "GET") 
        {
            header("Location: /");
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] == "POST") 
        {
            //input sanitation
            $username = htmlspecialchars($_POST['form-username']);
            $password = htmlspecialchars($_POST['form-password']);
            
            $user = $this->userService->loginCheck($username, $password);

            if($user == false)
            {
                $_SESSION['userIsAdmin'] = false;
                $_SESSION['loginError'] = 'Onjuiste inloggegevens ingevoerd!';

                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit;
            } else {

                if($user->getIsAdmin() == true)
                {    
                    $_SESSION['user']['id'] = $user->getId();
                    $_SESSION['user']['username'] = $user->getUsername();
                    $_SESSION['user']['email'] = $user->getEmail();
                    $_SESSION['user']['isAdmin'] = true;
                    $_SESSION['user']['isPremium'] = $user->getIsPremium();
                    $_SESSION['user']['cardsAmount'] = $user->getCardsAmount();
                    $_SESSION['user']['sharedCardsAmount'] = $user->getSharedCardsAmount();
    
                    $_SESSION['userIsAdmin'] = true;
    
                } else {
                    $_SESSION['userIsAdmin'] = false;
                    $_SESSION['loginError'] = 'Onjuiste inloggegevens ingevoerd!';
                }

                header("Location: {$_SERVER['HTTP_REFERER']}");
            }
        }
    }

    public function logout()
    {
        if(isset($_POST['logout']))
        {
            unset($_SESSION['user']);
            unset($_SESSION['userIsAdmin']);
            unset($_SESSION['username']);

            header("Location: /");
        }
    }
}
?>