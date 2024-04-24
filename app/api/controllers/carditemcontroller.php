<?php
namespace apiControllers;

use apiControllers\apiController;
use Services\cardItemService;
use Exception;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use Models\cardItemDTO;
use Models\cardItem;

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
    
            $this->respond($cardItems);
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

            if(!$cardItem)
            {
                $this->respondWithError(404, "bingokaart-item niet gevonden");
                return;
            }

            $this->respond($cardItem);
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
            $this->service->create($cardItem);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($cardItem);
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
            $this->service->update($cardItem, $cleanId);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($cardItem);
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

            $this->service->delete($cleanId);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond(true);
    }
}
?>