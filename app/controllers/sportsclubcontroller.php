<?php
namespace viewControllers;

use viewControllers\viewController;
use Services\sportsclubService;
use Models\sportsclubDTO;
use Models\Sportsclub;

class sportsclubController extends viewController
{
    private $service;

    function __construct()
    {
        if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}
        $this->service = new sportsclubService();
    }

    public function index()
    {
        $this->viewGetRequestSessionUserCheck();

        $sportsclubs = $this->service->getAll(NULL, NULL);

        $this->checkMappingAndDisplayView($sportsclubs);
    }

    public function create() 
    {
        $this->redirectViewGetRequest("sportsclub");

        if($_SERVER['REQUEST_METHOD'] == "POST")
        {

            //$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); //deprecated vanaf PHP versie 8.1 (helaas dus)

            //$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            
            //input sanitation
            $clubname = htmlspecialchars($_POST['nieuwe-sportsclub-clubname']);
            $description = htmlspecialchars($_POST['nieuwe-sportsclub-description']);
            $foundedOn = htmlspecialchars($_POST['nieuwe-sportsclub-foundedOn']);
            $membersAmount = htmlspecialchars($_POST['nieuwe-sportsclub-membersAmount']);

            $sportsclubDTO = new sportsclubDTO($clubname, $description, $foundedOn, $membersAmount);
            
            $sportsclub = $sportsclubDTO->sportsclubMapper();

            /*
            echo ' id: ' . $sportsclub->id;
            echo '<br> name: ' . $sportsclub->clubname;
            echo '<br> description: ' . $sportsclub->description;
            echo '<br> founded on: ' . $sportsclub->foundedOn;
            echo '<br> aantal leden: ' . $sportsclub->membersAmount;
            */

            $this->service->create($sportsclub);

            header("Location: {$_SERVER['HTTP_REFERER']}");

            //header("Location: /sportsclub");
            //exit;

            //$this->index();
        }
    }

    public function alter()
    {
        $this->redirectViewGetRequest("sportsclub");

        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            if(isset($_POST["wijzigen"])) 
            {
                $this->update();
            }
            else if(isset($_POST["verwijderen"]))
            {
                $this->delete();
            }
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
        $this->redirectViewGetRequest("sportsclub");

        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            //input sanitation
            $id = htmlspecialchars($_POST['sportsclub-id']);
            $clubname = htmlspecialchars($_POST['sportsclub-clubname']);
            $description = htmlspecialchars($_POST['sportsclub-description']);
            $foundedOn = htmlspecialchars($_POST['sportsclub-foundedOn']);
            $membersAmount = htmlspecialchars($_POST['sportsclub-membersAmount']);

            //model aanmaken en de juiste typen voor properties meegeven vanuit de setters gedefinieerd in het model
            $sportsclub = new Sportsclub();
            $sportsclub->setId($id);
            $sportsclub->setClubname($clubname);
            $sportsclub->setDescription($description);
            $sportsclub->setFoundedOn($foundedOn);
            $sportsclub->setMembersAmount($membersAmount);

            $this->service->update($sportsclub, $id);

            header("Location: {$_SERVER['HTTP_REFERER']}");
        }
    }

    public function delete()
    {
        $this->redirectViewGetRequest("sportsclub");

        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            //input sanitation
            $id = htmlspecialchars($_POST['sportsclub-id']);

            $this->service->delete($id);

            header("Location: {$_SERVER['HTTP_REFERER']}");
        }
    }
}
?>