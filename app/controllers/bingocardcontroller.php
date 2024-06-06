<?php
namespace viewControllers;

use viewControllers\viewController;
use Services\bingocardService;
use Services\cardItemService;
use Models\bingocardDTO;
use Models\bingocard;
use Models\cardItem;

class bingocardController extends viewController
{
    private $bingocardService;
    private $cardItemService;

    function __construct()
    {
        if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}
        $this->bingocardService = new bingocardService();
        $this->cardItemService = new cardItemService();
    }

    public function index()
    {
        $bingocards = $this->bingocardService->getAll(NULL, NULL);

        foreach($bingocards as $bingocard)
        {
            $cardItems = array();

            $cardItemIds = $this->bingocardService->getBingocardItemIds($bingocard->getId());

            foreach($cardItemIds as $cardItemId)
            {
                $cardItem = $this->cardItemService->getOne($cardItemId);

                array_push($cardItems,$cardItem);
            }

            $bingocard->setItems($cardItems);

            //Moet ik hier de $cardItems array weer legen of verwijderen?
            //$cardItems = array();
        }

        $this->checkMappingAndDisplayView($bingocards);
    }

    public function create() {        
        if($_SERVER['REQUEST_METHOD'] == "GET") 
        {
            require '../views/bingocard/create.php';
        }

        if($_SERVER['REQUEST_METHOD'] == "POST") 
        {
            
            //input sanitation
            $userId = htmlspecialchars($_POST['userId']);
            $size = htmlspecialchars($_POST['size']);

            $bingocardDTO = new bingocardDTO($userId, $size);

            $bingocard = $bingocardDTO->bingocardMapper();

            $this->bingocardService->create($bingocard);

            $this->index();
        }
    }
    
    public function update()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            //input sanitation
            $id = htmlspecialchars($_POST['id']); //bingocardId?
            $userId = htmlspecialchars($_POST['userId']);
            $score = htmlspecialchars($_POST['score']);
            $size = htmlspecialchars($_POST['size']);
            $creationDate = htmlspecialchars($_POST['creationDate']);
            $lastAccessedOn = htmlspecialchars($_POST['lastAccessedOn']);

            $bingocard = new Bingocard($id, $userId, $score, $size, $creationDate, $lastAccessedOn);

            $this->bingocardService->update($bingocard, $id);

            $this->index();
        }
    }

    public function delete()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            //input sanitation
            $id = htmlspecialchars($_POST['id']); //bingocardId?

            $this->bingocardService->delete($id);

            $this->index();
        }
    }
}
?>