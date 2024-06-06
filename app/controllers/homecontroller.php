<?php
namespace viewControllers;

use Exception;
use viewControllers\viewController;
use Services\userService;
//require __DIR__ . '/controller.php';

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

        /*
        if((session_status() !== PHP_SESSION_ACTIVE) //&& !(isset($_SESSION['user']))){
            session_start();
            //var_dump($_SESSION);
            //echo 'test: wordt dit nu altijd uitgevoerd, of alleen wanneer een PHP SESSION ECHT niet actief is???';
            $this->viewName = 'login';
        } else if(isset($_SESSION['user'])) {
            echo 'what? hoe kom je hier NOOIT???';
            $this->viewName = 'home';
        }*/
    }

    public function index()
    {
        require __DIR__ . '../../views/' . $this->viewName . '/index.php';
    }

    public function login()
    {
        if($_SERVER['REQUEST_METHOD'] == "GET") 
        {
            //require '../../views/login/index.php';

            //$this->index();

            header("Location: /");
            exit;

            /*if(isset($_SESSION['user']))
            {
                header("Location: /home");
            } else {
                header("Location: /");
                exit;
            }*/


        }

        if($_SERVER['REQUEST_METHOD'] == "POST") 
        {
            //input sanitation
            $username = htmlspecialchars($_POST['form-username']);
            $password = htmlspecialchars($_POST['form-password']);
            
            /*
            echo $username . '<br>';
            echo $password . '<br>';
            */
            
            $user = $this->userService->loginCheck($username, $password);

            //echo $user->getId();

            if($user == false)
            {
                $_SESSION['userIsAdmin'] = false;
                $_SESSION['loginError'] = 'Onjuiste inloggegevens ingevoerd!';

                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit;
            } else {
                
                if($user->getIsAdmin() == true)
                {
                    //session_start();
    
                    $_SESSION['user']['id'] = $user->getId();
                    $_SESSION['user']['username'] = $user->getUsername();
                    $_SESSION['user']['email'] = $user->getEmail();
                    $_SESSION['user']['isAdmin'] = true;
                    $_SESSION['user']['isPremium'] = $user->getIsPremium();
                    $_SESSION['user']['cardsAmount'] = $user->getCardsAmount();
                    $_SESSION['user']['sharedCardsAmount'] = $user->getSharedCardsAmount();
    
                    $_SESSION['userIsAdmin'] = true;
    
                    //$this->checkMappingAndDisplayView('home');
    
                    /*$this->viewName = 'home';
                    $this->index();*/
                    
                    //header("Location: /home");
    
                } else {
                    $_SESSION['userIsAdmin'] = false;
                    $_SESSION['loginError'] = 'Onjuiste inloggegevens ingevoerd!';
                }

                header("Location: {$_SERVER['HTTP_REFERER']}");
            }

            /*
            if($user->getIsAdmin() == true)
            {
                //session_start();

                $_SESSION['user']['id'] = $user->getId();
                $_SESSION['user']['username'] = $user->getUsername();
                $_SESSION['user']['email'] = $user->getEmail();
                $_SESSION['user']['isAdmin'] = true;
                $_SESSION['user']['isPremium'] = $user->getIsPremium();
                $_SESSION['user']['cardsAmount'] = $user->getCardsAmount();
                $_SESSION['user']['sharedCardsAmount'] = $user->getSharedCardsAmount();

                $_SESSION['userIsAdmin'] = true;

                //$this->checkMappingAndDisplayView('home');

                //$this->viewName = 'home';
                //$this->index();
                
                //header("Location: /home");
                header("Location: /");

            }
            else {

                $_SESSION['userIsAdmin'] = false;
                $_SESSION['loginError'] = 'Onjuiste inloggegevens ingevoerd';

                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit;
                //$this->checkMappingAndDisplayView('login');
            }
            */

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
            unset($_SESSION['userIsAdmin']);
            unset($_SESSION['username']);
            //unset($_SESSION);

            //session_destroy();

            //$this->checkMappingAndDisplayView('login');

            //session_unset();
            
            //session_abort();

            //session_write_close();

            header("Location: /");

            /*$this->viewName = 'login';
            $this->index();*/

            //header("Location: /home/login");
        }
        /*else
        {

            $this->viewName = 'home';
            $this->index();

            //$this->checkMappingAndDisplayView('home');
            //header("Location: /home");

        }*/
    }
}
?>