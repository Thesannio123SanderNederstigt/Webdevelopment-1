<?php
namespace apiControllers;

use apiControllers\apiController;
use Services\bingocardService;
use Services\cardItemService;
use Exception;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use Models\BingocardDTO;
use Models\Bingocard;

class bingocardController extends apiController
{
    private $bingocardService;
    private $cardItemService;

    function __construct()
    {
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
    
    
            $bingocards = $this->bingocardService->getAll($offset, $limit);
    
            foreach($bingocards as $bingocard)
            {
                /*
                $cardItems = array();
    
                $cardItemIds = $this->bingocardService->getBingocardItemIds($bingocard->getId());
    
                foreach($cardItemIds as $cardItemId)
                {
                    $cardItem = $this->cardItemService->getOne($cardItemId);
    
                    array_push($cardItems,$cardItem);
                }
    
                $bingocard->setItems($cardItems);
                */
    
                $this->setBingocardItems($bingocard);
            }
    
            $this->respond($bingocards);

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

            /*
            $cardItems = array();
    
            $cardItemIds = $this->bingocardService->getBingocardItemIds($bingocard->getId());
    
            foreach($cardItemIds as $cardItemId)
            {
                $cardItem = $this->cardItemService->getOne($cardItemId);
    
                array_push($cardItems,$cardItem);
            }
    
            $bingocard->setItems($cardItems);
            */
    
            $this->setBingocardItems($bingocard);
    
            if(!$bingocard)
            {
                $this->respondWithError(404, "bingokaart niet gevonden");
                return;
            }
    
            $this->respond($bingocard);

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
            $cardItem = $this->cardItemService->getOne($cardItemId);

            array_push($cardItems,$cardItem);
        }

        $bingocard->setItems($cardItems);
        
        return $bingocard;
    }


    public function create($bingocard)
    {
        $token = $this->checkForJwt();
        if (!$token)
        {
            return;
        }

        try {
            $bingocardDTO = $this->createObjectFromPostedJson("Models\\BingocardDTO");
            $bingocard = $bingocardDTO->bingocardMapper();
            $this->bingocardService->create($bingocard);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($bingocard);
    }

    public function update($bingocard, $id)
    {
        $token = $this->checkForJwt();
        if (!$token)
        {
            return;
        }

        try {
            $cleanId = htmlspecialchars($id);
            $bingocard = $this->createObjectFromPostedJson("Models\\Bingocard");
            $this->bingocardService->update($bingocard, $cleanId);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($bingocard);
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
            $bingocard = $this->bingocardService->updateLastAccessedOn($cleanId);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($bingocard);
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
            $this->bingocardService->delete($cleanId);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond(true);
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
            $this->bingocardService->deleteBingocardItem($cleanBingocardId, $cleanCardItemId);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond(true);
    }
}
?>