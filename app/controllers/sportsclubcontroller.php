<?php
namespace viewControllers;

use viewControllers\viewController;
use Services\sportsclubService;
use Models\SportsclubDTO;
use Models\Sportsclub;

class sportsclubController extends viewController
{
    private $service;

    function __construct()
    {
        $this->service = new sportsclubService();
    }

    public function index()
    {
        $sportsclubs = $this->service->getAll(NULL, NULL);

        $this->checkMappingAndDisplayView($sportsclubs);
    }

    public function create() {        
        if($_SERVER['REQUEST_METHOD'] == "GET") 
        {
            require '../views/sportsclub/create.php';
        }

        if($_SERVER['REQUEST_METHOD'] == "POST") 
        {

            //$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); //deprecated vanaf PHP versie 8.1 (helaas dus)

            //$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            
            //input sanitation
            $clubname = htmlspecialchars($_POST['clubname']);
            $description = htmlspecialchars($_POST['description']);
            $foundedOn = htmlspecialchars($_POST['foundedOn']);
            $membersAmount = htmlspecialchars($_POST['membersAmount']);

            $sportsclubDTO = new SportsclubDTO($clubname, $description, $foundedOn, $membersAmount);
            
            $sportsclub = $sportsclubDTO->sportsclubMapper();

            $this->service->create($sportsclub);

            $this->index();
        }
    }

    /*public function displayOne()
    {
        if($_SERVER['REQUEST_METHOD'] == "GET") 
        {
            $id = htmlspecialchars($_GET['id']);

            $sportsclub = $this->service->getOne($id);

            require __DIR__ . '../views/sportsclub/viewClub.php';
        }

    }*/

    public function update()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            //input sanitation
            $id = htmlspecialchars($_POST['id']); //sportsclubId?
            $clubname = htmlspecialchars($_POST['clubname']);
            $description = htmlspecialchars($_POST['description']);
            $foundedOn = htmlspecialchars($_POST['foundedOn']);
            $membersAmount = htmlspecialchars($_POST['membersAmount']);

            $sportsclub = new Sportsclub($id, $clubname, $description, $foundedOn, $membersAmount);

            $this->service->update($sportsclub, $id);

            $this->index();
        }
    }

    public function delete()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            //input sanitation
            $id = htmlspecialchars($_POST['id']); //sportsclubId?

            $this->service->delete($id);

            $this->index();
        }
    }
}
?>