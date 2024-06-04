<?php
namespace viewControllers;

use viewControllers\viewController;
use Services\userService;
use Services\sportsclubService;
use Services\bingocardService;
use Services\cardItemService;
use Models\UserDTO;
use Models\User;

//require __DIR__ . '/controller.php';
//require __DIR__ . '/services/userservice.php';

class UserController extends viewController 
{
    private $userService;
    private $sportsclubService;
    private $bingocardService;
    private $cardItemService;

    function __construct()
    {
        $this->userService = new userService();
        $this->sportsclubService = new sportsclubService();
        $this->bingocardService = new bingocardService();
        $this->cardItemService = new cardItemService();
    }

    public function index()
    {
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
                    $cardItem = $this->cardItemService->getOne($cardItemId);
    
                    array_push($cardItems, $cardItem);
                }
    
                $bingocard->setItems($cardItems);
                //$cardItems = array();
            }

            $user->setBingocards($bingocards);


            $sportsclubs = array();

            $sportsclubIds = $this->userService->getUserSportsclubIds($user->getId());

            foreach($sportsclubIds as $sportsclubId)
            {
                $sportsclub = $this->sportsclubService->getOne($sportsclubId);
                
                array_push($sportsclubs, $sportsclub);
            }

            $user->setSportsclubs($sportsclubs);
        }

        $this->checkMappingAndDisplayView($users);
    }

    public function create() {        
        /*if($_SERVER['REQUEST_METHOD'] == "GET") 
        {
            require '../views/user/create.php';
        }*/

        if($_SERVER['REQUEST_METHOD'] == "POST") 
        {
            //input sanitation
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            $email = htmlspecialchars($_POST['email']);

            $userDTO = new UserDTO($username, $password, $email);

            $user = $userDTO->userMapper();

            $this->userService->create($user);

            $this->index();
        }
    }

    public function alter()
    {
        if($_SERVER['REQUEST_METHOD'] == "GET") 
        {
            require '../views/user/index.php';
        }

        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            if(isset($_POST["wijzigen"])) 
            {
                //update();
            }
            else if(isset($_POST["verwijderen"]))
            {
                //delete();
            }
        }
    }
    
    public function update()
    {
        if($_SERVER['REQUEST_METHOD'] == "GET") 
        {
            require '../views/user/index.php'; //geen aparte view single, update of delete pagina's toch? (of wil ik dit hier helemaal verwijderen en gewoon de API gaan gebruiken?)
        }

        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            //input sanitation
            $id = htmlspecialchars($_POST['id']); //userTableId?
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            $email = htmlspecialchars($_POST['email']);
            $isAdmin = htmlspecialchars($_POST['isAdmin']);
            $isPremium = htmlspecialchars($_POST['isPremium']);
            $cardsAmount = htmlspecialchars($_POST['cardsAmount']);
            $sharedCardsAmount = htmlspecialchars($_POST['sharedCardsAmount']);

            $user = new User($id, $username, $password, $email, $isAdmin, $isPremium, $cardsAmount, $sharedCardsAmount);

            $this->userService->update($user, $id);

            $this->index();
        }
    }

    public function delete()
    {
        if($_SERVER['REQUEST_METHOD'] == "GET")
        {
            require '../views/user/index.php';
        }

        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            //input sanitation
            $id = htmlspecialchars($_POST['id']); //userTableId?

            $this->userService->delete($id);

            $this->index();
        }
    }
}
?>