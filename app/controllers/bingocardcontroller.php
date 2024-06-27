<?php
namespace viewControllers;

use viewControllers\viewController;
use Services\bingocardService;
use Services\cardItemService;
use Services\userService;
use Models\bingocardDTO;
use Models\bingocard;

class bingocardController extends viewController
{
    private $bingocardService;
    private $cardItemService;
    private $userService;

    function __construct()
    {
        if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}
        $this->bingocardService = new bingocardService();
        $this->cardItemService = new cardItemService();
        $this->userService = new userService();
    }

    public function index()
    {
        $this->viewRequestSessionUserCheck();

        $bingocards = $this->bingocardService->getAll(NULL, NULL);

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

        $this->checkMappingAndDisplayView($bingocards);
    }

    public function create() 
    {        
        $this->viewRequestSessionUserCheck();
        $this->redirectViewGetRequest("bingocard");

        if($_SERVER['REQUEST_METHOD'] == "POST") 
        {
            
            //input sanitation
            $userId = htmlspecialchars($_POST['nieuwe-bingocard-userId']);
            $cleanSize = htmlspecialchars($_POST['nieuwe-bingocard-size']);

            $bingocardDTO = new bingocardDTO($userId, $this->provideSize($cleanSize));

            $bingocard = $bingocardDTO->bingocardMapper();

            $user = $this->userService->getOne($bingocard->getUserId());

            if(!$user || $user == false) {
                //de gebruiker kon niet worden gevonden hier (incorrect meegegeven userId voor deze bingokaart)
                header("Location: {$_SERVER['HTTP_REFERER']}");
                return;
            } else {
                $this->bingocardService->create($bingocard);

                header("Location: {$_SERVER['HTTP_REFERER']}");
            }
        }
    }

    public function alter()
    {
        $this->viewRequestSessionUserCheck();
        $this->redirectViewGetRequest("bingocard");

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
    
    public function update()
    {
        $this->viewRequestSessionUserCheck();
        $this->redirectViewGetRequest("bingocard");

        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            //input sanitation
            $id = htmlspecialchars($_POST['bingocard-id']);
            $userId = htmlspecialchars($_POST['bingocard-userId']);
            $score = htmlspecialchars($_POST['bingocard-score']);
            $cleanSize = htmlspecialchars($_POST['bingocard-size']);
            $creationDate = htmlspecialchars($_POST['bingocard-creationDate']);
            $lastAccessedOn = htmlspecialchars($_POST['bingocard-lastAccessedOn']);

            $bingocard = new Bingocard();
            $bingocard->setId($id);
            $bingocard->setUserId($userId);
            $bingocard->setScore($score);
            $bingocard->setSize($this->provideSize($cleanSize));
            $bingocard->setCreationDate($creationDate);
            $bingocard->setLastAccessedOn($lastAccessedOn);

            $user = $this->userService->getOne($bingocard->getUserId());

            if(!$user || $user == false) {
                //de gebruiker kon niet worden gevonden hier (incorrect meegegeven userId voor deze bingokaart)
                header("Location: {$_SERVER['HTTP_REFERER']}");
                return;
            } else {
                $this->bingocardService->update($bingocard, $id);

                header("Location: {$_SERVER['HTTP_REFERER']}");
            }
        }
    }

    public function delete()
    {
        $this->viewRequestSessionUserCheck();
        $this->redirectViewGetRequest("bingocard");

        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            //input sanitation
            $id = htmlspecialchars($_POST['bingocard-id']);

            $this->bingocardService->delete($id);

            header("Location: {$_SERVER['HTTP_REFERER']}");
        }
    }

    private function provideSize($cleanSize): int
    {
        switch($cleanSize)
        {
            case("3x3"):
                $size = 9;
                break;

            case("3 bij 3"):
                $size = 9;
                break;
            
            case("9"):
                $size = 9;
                break;

            case("4x4"):
                $size = 16;
                break;

            case("4 bij 4"):
                $size = 16;
                break;
            
            case("16"):
                $size = 16;
                break;
            
            case("5x5"):
                $size = 25;
                break;

            case("5 bij 5"):
                $size = 25;
                break;
            
            case("25"):
                $size = 25;
                break;
        }

        return $size;
    }
}
?>