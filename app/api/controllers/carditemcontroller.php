<?php
namespace apiControllers;

use apiControllers\apiController;
use Services\cardItemService;
use Exception;

class cardItemController extends apiController
{
    private $service;

    function __construct()
    {
        $this->service = new cardItemService();
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
    
            $cardItems = $this->service->getAll($offset, $limit);

            if(!$cardItems || $cardItems == false)
            {
                $this->respondWithError(404, "kaart-items niet gevonden");
                return;
            } else {
                $this->respond($cardItems);
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
            //input (id) sanitazation
            $cleanId = htmlspecialchars($id);

            $cardItem = $this->service->getOne($cleanId);

            if(!$cardItem || $cardItem == false)
            {
                $this->respondWithError(404, "bingokaart-item niet gevonden");
                return;
            } else {
                $this->respond($cardItem);
            }
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function create()
    {
        $token = $this->checkForJwt();
        if (!$token)
        {
            return;
        }

        try {
            $cardItemDTO = $this->createObjectFromPostedJson("Models\\cardItemDTO");
            $cardItem = $cardItemDTO->cardItemMapper();
            $newCardItem = $this->service->create($cardItem);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($newCardItem);
    }

    public function update($id)
    {
        $token = $this->checkForJwt();
        if (!$token)
        {
            return;
        }

        try {
            //input (id) sanitazation
            $cleanId = htmlspecialchars($id);

            $cardItem = $this->createObjectFromPostedJson("Models\\CardItem");

            $exCardItem = $this->service->getOne($cleanId);

            if(!$exCardItem || $exCardItem == false)
            {
                $this->respondWithError(404, "Het kaart-item kon niet worden gevonden");
                return;
            } 

            $updatedCardItem = $this->service->update($cardItem, $cleanId);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($updatedCardItem);
    }

    public function delete($id)
    {
        $token = $this->checkForJwt();
        if (!$token)
        {
            return;
        }

        try {
            //input (id) sanitazation
            $cleanId = htmlspecialchars($id);

            $exCardItem = $this->service->getOne($cleanId);

            if(!$exCardItem || $exCardItem == false)
            {
                $this->respondWithError(404, "Het kaart-item kon niet worden gevonden");
                return;
            } 

            $this->service->delete($cleanId);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond(true);
    }
}
?>