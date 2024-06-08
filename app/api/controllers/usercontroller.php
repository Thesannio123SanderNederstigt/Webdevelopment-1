<?php
namespace apiControllers;

use apiControllers\apiController;
use Services\userService;
use Services\sportsclubService;
use Services\bingocardService;
use Services\cardItemService;
use Exception;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use Models\userDTO;
use Models\User;

class userController extends apiController
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

    public function getAll()
    {
        $token = $this->checkForJwt();
        if (!$token)
        {
            return;
        }

        try {
            $offset = NULL;
            $limit = NULL;
    
            if (isset($_GET["offset"]) && is_numeric($_GET["offset"])) {
                $offset = $_GET["offset"];
            }
            if (isset($_GET["limit"]) && is_numeric($_GET["limit"])) {
                $limit = $_GET["limit"];
            }
    
            $users = $this->userService->getAll($offset, $limit);
    
            foreach($users as $user)
            {
                $this->setUserBingocardsAndItems($user);
                $this->setUserSportsclubs($user);
            }
    
            $this->respond($users);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function getOne($id)
    {
        $token = $this->checkForJwt();
        if (!$token)
        {
            return;
        }

        try {
            //input (id) sanitazation
            $cleanId = htmlspecialchars($id);

            $user = $this->userService->getOne($cleanId);
    
            $this->setUserBingocardsAndItems($user);
            $this->setUserSportsclubs($user);
    
            if(!$user)
            {
                $this->respondWithError(404, "gebruiker niet gevonden");
                return;
            }
    
            $this->respond($user);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }


    private function setUserBingocardsAndItems($user)
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

        return $user;
    }

    private function setUserSportsclubs($user)
    {
        $sportsclubs = array();

        $sportsclubIds = $this->userService->getUserSportsclubIds($user->getId());

        foreach($sportsclubIds as $sportsclubId)
        {
            $sportsclub = $this->sportsclubService->getOne($sportsclubId[0]);
            
            array_push($sportsclubs, $sportsclub);
        }

        $user->setSportsclubs($sportsclubs);

        return $user;
    }


    public function create($user)
    {
        $token = $this->checkForJwt();
        if (!$token)
        {
            return;
        }

        try {
            $userDTO = $this->createObjectFromPostedJson("Models\\UserDTO");
            $user = $userDTO->userMapper();
            $this->userService->create($user);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($user);
    }

    public function update($user, $id)
    {
        $token = $this->checkForJwt();
        if (!$token)
        {
            return;
        }

        try {
            $user = $this->createObjectFromPostedJson("Models\\User");
            $cleanId = htmlspecialchars($id);
            $this->userService->update($user, $cleanId);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($user);
    }

    public function delete($id)
    {
        $token = $this->checkForJwt();
        if (!$token)
        {
            return;
        }

        try {
            $cleanId = htmlspecialchars($id);
            $this->userService->delete($cleanId);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond(true);
    }

    //TODO: maak nog een get user sportsclub (waar inhoud sportclubs wordt opgehaald, bij updaten voor gebruiker wordt verwijderd uit DB en opnieuw wordt aangemaakt (allemaal in loops)?)

    //Endpoint voor het toevoegen van sportsclubs voor een gebruiker (in de koppeltabel)
    public function addUserSportsclub($userId, $sportsclubId)
    {
        $token = $this->checkForJwt();
        if (!$token)
        {
            return;
        }

        try {
            $cleanUserId = htmlspecialchars($userId);
            $cleanSportsclubId = htmlspecialchars($sportsclubId);
            $this->userService->addUserSportsclub($cleanUserId, $cleanSportsclubId);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond(true);
    }


    //Endpoint voor het verwijderen van een gebruiker van een sportsclub (zonder de user of de sportclub zelf te verwijderen)
    public function deleteUserSportsclub($userId, $sportsclubId)
    {
        $token = $this->checkForJwt();
        if (!$token)
        {
            return;
        }

        try {
            $cleanUserId = htmlspecialchars($userId);
            $cleanSportsclubId = htmlspecialchars($sportsclubId);
            $this->userService->deleteUserSportsclub($cleanUserId, $cleanSportsclubId);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond(true);
    }

    //login methode hieronder
    public function login() {

        try {
            // gebruiker lezen vanuit request body data
            $postedUser = $this->createObjectFromPostedJson("Models\\User");

            // gebruiker ophalen
            //$user = $this->userService->loginCheck($postedUser->username, $postedUser->password);
            $user = $this->userService->loginCheck($postedUser->getUsername(), $postedUser->getPassword());

            if(!$user || $user == false) {
                $this->respondWithError(401, "Onjuiste gebruikersnaam en/of wachtwoord ingevoerd");
                return;
            }

            //jwt generen en teruggeven als/in de response
            $tokenResponse = $this->generateJwt($user);

            $this->respond($tokenResponse);  
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }  
    }
}
?>