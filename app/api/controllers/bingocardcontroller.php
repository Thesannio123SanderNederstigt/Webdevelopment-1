<?php
namespace apiControllers;

use apiControllers\apiController;
use Services\bingocardService;
use Services\cardItemService;
use Services\userService;
use Exception;

class bingocardController extends apiController
{
    private $bingocardService;
    private $cardItemService;
    private $userService;

    function __construct()
    {
        $this->bingocardService = new bingocardService();
        $this->cardItemService = new cardItemService();
        $this->userService = new userService();
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
    
            $bingocards = $this->bingocardService->getAll($offset, $limit);

            if(!$bingocards || $bingocards == false)
            {
                $this->respondWithError(404, "bingokaarten niet gevonden");
                return;
            } else {

                foreach($bingocards as $bingocard)
                {    
                    $this->setBingocardItems($bingocard);
                }
        
                $this->respond($bingocards);
            }

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
            $cleanId = htmlspecialchars($id);

            $bingocard = $this->bingocardService->getOne($cleanId);
   
            if(!$bingocard || $bingocard == false)
            {
                $this->respondWithError(404, "bingokaart niet gevonden");
                return;
            } else {
                $this->setBingocardItems($bingocard);

                $this->respond($bingocard);
            }

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    private function setBingocardItems($bingocard)
    {
        $cardItems = array();

        $cardItemIds = $this->bingocardService->getBingocardItemIds($bingocard->getId());

        foreach($cardItemIds as $cardItemId)
        {
            $cardItem = $this->cardItemService->getOne($cardItemId[0]);

            array_push($cardItems,$cardItem);
        }

        $bingocard->setItems($cardItems);
        
        return $bingocard;
    }


    public function create()
    {
        $token = $this->checkForJwt();
        if (!$token)
        {
            return;
        }

        try {
            $bingocardDTO = $this->createObjectFromPostedJson("Models\\bingocardDTO");
            $bingocard = $bingocardDTO->bingocardMapper();

            if(!isset($bingocard->userId))
            {
                $this->respondWithError(404, "Er is geen (bestaand) gebruikers-id meegegeven");
                return;
            }

            $user = $this->userService->getOne($bingocard->getUserId());
    
            if(!$user || $user == false) 
            {
                $this->respondWithError(404, "Een corresponderende gebruiker (bij het opgegeven gebruikers-id) kon niet worden gevonden");
                return;
            } else {
                $newBingocard = $this->bingocardService->create($bingocard);
            }
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($newBingocard);
    }

    public function update($id)
    {
        $token = $this->checkForJwt();
        if (!$token)
        {
            return;
        }

        try {
            $cleanId = htmlspecialchars($id);
            $bingocard = $this->createObjectFromPostedJson("Models\\Bingocard");

            $exBingocard = $this->bingocardService->getOne($cleanId);

            if(!$exBingocard || $exBingocard == false)
            {
                $this->respondWithError(404, "De bingokaart kon niet worden gevonden");
                return;
            }           

            if(!isset($bingocard->userId))
            {
                $this->respondWithError(404, "Er is geen (bestaand) gebruikers-id meegegeven");
                return;
            }

            $user = $this->userService->getOne($bingocard->getUserId());

            if(!$user || $user == false)
            {
                $this->respondWithError(404, "Een corresponderende gebruiker (bij het opgegeven gebruikers-id) kon niet worden gevonden");
                return;
            } else {
                $updatedBingocard = $this->bingocardService->update($bingocard, $cleanId);
            }
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($updatedBingocard);
    }

    public function updateLastAccessedOn($id)
    {
        $token = $this->checkForJwt();
        if (!$token)
        {
            return;
        }

        try {
            $cleanId = htmlspecialchars($id);

            $exBingocard = $this->bingocardService->getOne($cleanId);

            if(!$exBingocard || $exBingocard == false)
            {
                $this->respondWithError(404, "De bingokaart kon niet worden gevonden");
                return;
            } 

            $this->bingocardService->updateLastAccessedOn($cleanId);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond(true);
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

            $exBingocard = $this->bingocardService->getOne($cleanId);

            if(!$exBingocard || $exBingocard == false)
            {
                $this->respondWithError(404, "De bingokaart kon niet worden gevonden");
                return;
            } 
            
            $this->bingocardService->delete($cleanId);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond(true);
    }

    public function getBingocardItems($bingocardId)
    {
        $token = $this->checkForJwt();
        if (!$token)
        {
            return;
        }

        try {
            $cleanBingocardId = htmlspecialchars($bingocardId);

            $exBingocard = $this->bingocardService->getOne($cleanBingocardId);

            if(!$exBingocard || $exBingocard == false)
            {
                $this->respondWithError(404, "De bingokaart kon niet worden gevonden");
                return;
            } 

            $bingocardItems = array();

            $cardItemIds = $this->bingocardService->getBingocardItemIds($cleanBingocardId);

            foreach($cardItemIds as $cardItemId)
            {
                $cardItem = $this->cardItemService->getOne($cardItemId[0]);

                array_push($bingocardItems, $cardItem);
            }

            $this->respond($bingocardItems);

        } catch(Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    //Endpoint voor het toevoegen van card-items voor een bingokaart (in de koppeltabel)
    public function addBingocardItem($bingocardId, $cardItemId)
    {
        $token = $this->checkForJwt();
        if (!$token)
        {
            return;
        }

        try {
            $cleanBingocardId = htmlspecialchars($bingocardId);
            $cleanCardItemId = htmlspecialchars($cardItemId);

            $exBingocard = $this->bingocardService->getOne($cleanBingocardId);

            if(!$exBingocard || $exBingocard == false)
            {
                $this->respondWithError(404, "De bingokaart kon niet worden gevonden");
                return;
            } 

            $exCardItem = $this->cardItemService->getOne($cleanCardItemId);

            if(!$exCardItem || $exCardItem == false)
            {
                $this->respondWithError(404, "Het kaart-item kon niet worden gevonden");
                return;
            } 
            
            $this->bingocardService->addBingocardItem($cleanBingocardId, $cleanCardItemId);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond(true);
    }

    //Endpoint voor het verwijderen van een item van een bingokaart (zonder de bingokaart of het bingokaart-item zelf te verwijderen)
    public function deleteBingocardItem($bingocardId, $cardItemId)
    {
        $token = $this->checkForJwt();
        if (!$token)
        {
            return;
        }

        try {
            $cleanBingocardId = htmlspecialchars($bingocardId);
            $cleanCardItemId = htmlspecialchars($cardItemId);

            $exBingocard = $this->bingocardService->getOne($cleanBingocardId);

            if(!$exBingocard || $exBingocard == false)
            {
                $this->respondWithError(404, "De bingokaart kon niet worden gevonden");
                return;
            } 

            $exCardItem = $this->cardItemService->getOne($cleanCardItemId);

            if(!$exCardItem || $exCardItem == false)
            {
                $this->respondWithError(404, "Het kaart-item kon niet worden gevonden");
                return;
            } 


            $this->bingocardService->deleteBingocardItem($cleanBingocardId, $cleanCardItemId);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond(true);
    }
}
?>