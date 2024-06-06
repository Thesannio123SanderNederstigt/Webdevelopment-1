<?php
namespace viewControllers;

use viewControllers\viewController;
use Services\cardItemService;
use Models\cardItemDTO;
use Models\cardItem;

class carditemController extends viewController
{
    private $service;

    function __construct()
    {
        if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}
        $this->service = new cardItemService();
    }

    public function index()
    {
        $carditems = $this->service->getAll(NULL, NULL);
        $this->checkMappingAndDisplayView($carditems);
    }

    public function create() {        
        if($_SERVER['REQUEST_METHOD'] == "GET") 
        {
            require '../views/cardItem/create.php';
        }

        if($_SERVER['REQUEST_METHOD'] == "POST") 
        {
            
            //input sanitation
            $content = htmlspecialchars($_POST['content']);
            $category = htmlspecialchars($_POST['category']);
            $points = htmlspecialchars($_POST['points']);
            $isPremiumItem = htmlspecialchars($_POST['isPremiumItem']);

            $cardItemDTO = new cardItemDTO($content, $category, $points, $isPremiumItem);

            $cardItem = $cardItemDTO->cardItemMapper();

            $this->service->create($cardItem);

            $this->index();
        }
    }

    public function update()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            //input sanitation
            $id = htmlspecialchars($_POST['id']); //cardItemId?
            $content = htmlspecialchars($_POST['content']);
            $category = htmlspecialchars($_POST['category']);
            $points = htmlspecialchars($_POST['points']);
            $isPremiumItem = htmlspecialchars($_POST['isPremiumItem']);

            $cardItem = new cardItem($id, $content, $category, $points, $isPremiumItem);

            $this->service->update($cardItem, $id);

            $this->index();
        }
    }

    public function delete()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            //input sanitation
            $id = htmlspecialchars($_POST['id']); //cardItemId?

            $this->service->delete($id);

            $this->index();
        }
    }
}
?>