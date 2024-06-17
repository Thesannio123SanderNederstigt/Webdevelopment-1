<?php
namespace apiControllers;

use apiControllers\apiController;
use Services\sportsclubService;
use Exception;

class sportsclubController extends apiController
{
    private $service;

    function __construct()
    {
        $this->service = new sportsclubService();
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
    
            $sportsclubs = $this->service->getAll($offset, $limit);

            if(!$sportsclubs || $sportsclubs == false) {
                $this->respondWithError(404, "Sportsclubs niet gevonden");
                return;
            } else {
                $this->respond($sportsclubs);
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
            $sportsclub = $this->service->getOne($cleanId);

            if(!$sportsclub || $sportsclub == false)
            {
                $this->respondWithError(404, "Sportsclub niet gevonden");
                return;
            } else {
                $this->respond($sportsclub);
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
            $sportsclubDTO = $this->createObjectFromPostedJson("Models\\sportsclubDTO");
            $sportsclub = $sportsclubDTO->sportsclubMapper();
            $this->service->create($sportsclub);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($sportsclub);
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
            $sportsclub = $this->createObjectFromPostedJson("Models\\Sportsclub");
            $this->service->update($sportsclub, $cleanId);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($sportsclub);
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
            $this->service->delete($cleanId);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond(true);
    }
}
?>