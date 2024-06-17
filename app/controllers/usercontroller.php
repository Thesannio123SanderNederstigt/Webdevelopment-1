<?php
namespace viewControllers;

use viewControllers\viewController;
use Services\userService;
use Services\sportsclubService;
use Services\bingocardService;
use Services\cardItemService;
use Models\userDTO;
use Models\User;

class UserController extends viewController 
{
    private $userService;
    private $sportsclubService;
    private $bingocardService;
    private $cardItemService;

    function __construct()
    {
        if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}
        $this->userService = new userService();
        $this->sportsclubService = new sportsclubService();
        $this->bingocardService = new bingocardService();
        $this->cardItemService = new cardItemService();
    }

    public function index()
    {
        $this->viewGetRequestSessionUserCheck();

        $users = $this->userService->getAll(NULL, NULL);

        foreach($users as $user)
        {
            $bingocards = $this->bingocardService->getUserBingocards($user->getId());
    
            foreach($bingocards as $bingocard)
            {
                $cardItems = array();
    
                $cardItemIds = $this->bingocardService->getBingocardItemIds($bingocard->getId());
    
                foreach($cardItemIds as $cardItemId)
                {
                    $cardItem = $this->cardItemService->getOne($cardItemId[0]);
    
                    array_push($cardItems, $cardItem);
                }
    
                $bingocard->setItems($cardItems);
            }

            $user->setBingocards($bingocards);

            $sportsclubs = array();

            $sportsclubIds = $this->userService->getUserSportsclubIds($user->getId());

            foreach($sportsclubIds as $sportsclubId)
            {
                $sportsclub = $this->sportsclubService->getOne($sportsclubId[0]);
                
                array_push($sportsclubs, $sportsclub);
            }

            $user->setSportsclubs($sportsclubs);
        }

        $this->checkMappingAndDisplayView($users);
    }

    public function create() 
    {
        $this->redirectViewGetRequest("user");

        if($_SERVER['REQUEST_METHOD'] == "POST") 
        {
            //input sanitation
            $username = htmlspecialchars($_POST['nieuwe-user-username']);
            $password = htmlspecialchars($_POST['nieuwe-user-password']);
            $email = htmlspecialchars($_POST['nieuwe-user-email']);

            $userDTO = new userDTO($username, $password, $email);

            $user = $userDTO->userMapper();

            $this->userService->create($user);

            header("Location: {$_SERVER['HTTP_REFERER']}");
        }
    }

    public function alter()
    {
        $this->redirectViewGetRequest("user");

        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            if(isset($_POST["wijzigen"])) 
            {
                $this->update();
            }
            else if(isset($_POST["verwijderen"]))
            {
                $this->delete();
            }
        }
    }
    
    public function update()
    {
        $this->redirectViewGetRequest("user");

        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            //input sanitation
            $id = htmlspecialchars($_POST['user-id']);
            $username = htmlspecialchars($_POST['user-username']);
            $email = htmlspecialchars($_POST['user-email']);
            $cleanIsAdmin = htmlspecialchars($_POST['user-isAdmin']);
            $cleanIsPremium = htmlspecialchars($_POST['user-isPremium']);
            $cardsAmount = htmlspecialchars($_POST['user-cardsAmount']);
            $sharedCardsAmount = htmlspecialchars($_POST['user-sharedCardsAmount']);

            $user = new User();
            $user->setId($id);
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setIsAdmin($this->provideBoolValue($cleanIsAdmin));
            $user->setIsPremium($this->provideBoolValue($cleanIsPremium));
            $user->setCardsAmount($cardsAmount);
            $user->setSharedCardsAmount($sharedCardsAmount);

            $this->userService->update($user, $id);

            header("Location: {$_SERVER['HTTP_REFERER']}");
        }
    }

    public function delete()
    {
        $this->redirectViewGetRequest("user");

        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            //input sanitation
            $id = htmlspecialchars($_POST['user-id']);

            $this->userService->delete($id);

            header("Location: {$_SERVER['HTTP_REFERER']}");
        }
    }
}
?>