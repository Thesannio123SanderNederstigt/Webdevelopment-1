<?php
namespace apiControllers;

use apiControllers\apiController;
use Services\sportsclubService;
use Exception;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use Models\sportsclubDTO;
use Models\Sportsclub;

class sportsclubController extends apiController
{
    private $service;

    function __construct()
    {
        $this->service = new sportsclubService();
    }

    public function getAll()
    {
        // controleren op jwt, geeft 401 terug zonder token
        // $token = $this->checkForJwt();
        // if (!$token)
        // {
        //    return;
        // }

        $offset = NULL;
        $limit = NULL;

        if (isset($_GET["offset"]) && is_numeric($_GET["offset"])) {
            $offset = $_GET["offset"];
        }
        if (isset($_GET["limit"]) && is_numeric($_GET["limit"])) {
            $limit = $_GET["limit"];
        }

        $sportsclubs = $this->service->getAll($offset, $limit);

        $this->respond($sportsclubs);
    }

    public function getOne($id)
    {
        $token = $this->checkForJwt();
        if (!$token)
        {
            return;
        }

        $sportsclub = $this->service->getOne($id);

        if(!$sportsclub)
        {
            $this->respondWithError(404, "Sportsclub niet gevonden");
            return;
        }

        $this->respond($sportsclub);
    }

    public function create()
    {
        $token = $this->checkForJwt();
        if (!$token)
        {
            return;
        }

        try {
            $sportsclubDTO = $this->createObjectFromPostedJson("Models\\SportsclubDTO");
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
            $sportsclub = $this->createObjectFromPostedJson("Models\\Sportsclub");
            $this->service->update($sportsclub, $id);
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
            $this->service->delete($id);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond(true);
    }
}
?>