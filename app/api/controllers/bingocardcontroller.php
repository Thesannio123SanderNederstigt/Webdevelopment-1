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
    }

    public function getOne($id)
    {
        $token = $this->checkForJwt();
        if (!$token)
        {
            return;
        }

        $bingocard = $this->bingocardService->getOne($id);

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
            $bingocard = $this->createObjectFromPostedJson("Models\\Bingocard");
            $this->bingocardService->update($bingocard, $id);
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
            $bingocard = $this->bingocardService->updateLastAccessedOn($id);
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
            $this->bingocardService->delete($id);
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
            $this->bingocardService->deleteBingocardItem($bingocardId, $cardItemId);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond(true);
    }
}
?>