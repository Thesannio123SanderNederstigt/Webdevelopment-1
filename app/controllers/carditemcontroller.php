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
        $this->viewRequestSessionUserCheck();

        $carditems = $this->service->getAll(NULL, NULL);

        $this->checkMappingAndDisplayView($carditems);
    }

    public function create() 
    {   
        $this->viewRequestSessionUserCheck();
        $this->redirectViewGetRequest("carditem");

        if($_SERVER['REQUEST_METHOD'] == "POST") 
        {
            //input sanitation
            $content = htmlspecialchars($_POST['nieuwe-cardItem-content']);
            $cleanCategory = htmlspecialchars($_POST['nieuwe-cardItem-content-categories']);
            $points = htmlspecialchars($_POST['nieuwe-cardItem-points']);
            $cleanIsPremiumItem = htmlspecialchars($_POST['nieuwe-cardItem-premium-items']);

            //$cardItemDTO = new cardItemDTO($content, $this->provideCategory($cleanCategory), $points, $this->provideBoolValue($cleanIsPremiumItem));

            $cardItemDTO = new cardItemDTO();
            $cardItemDTO->content = $content;
            $cardItemDTO->category = $this->provideCategory($cleanCategory);
            $cardItemDTO->points = $points;
            $cardItemDTO->isPremiumItem = $this->provideBoolValue($cleanIsPremiumItem);

            $cardItem = $cardItemDTO->cardItemMapper();         

            $this->service->create($cardItem);

            header("Location: {$_SERVER['HTTP_REFERER']}");
        }
    }

    public function alter()
    {
        $this->viewRequestSessionUserCheck();
        $this->redirectViewGetRequest("carditem");

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
        $this->redirectViewGetRequest("carditem");

        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            //input sanitation
            $id = htmlspecialchars($_POST['cardItem-id']);
            $content = htmlspecialchars($_POST['cardItem-content']);
            $cleanCategory = htmlspecialchars($_POST['cardItem-category']);
            $points = htmlspecialchars($_POST['cardItem-points']);
            $cleanIsPremiumItem = htmlspecialchars($_POST['cardItem-isPremiumItem']);

            $cardItem = new cardItem();
            $cardItem->setId($id);
            $cardItem->setContent($content);
            $cardItem->setCategory($this->provideCategory($cleanCategory));
            $cardItem->setPoints($points);
            $cardItem->setIsPremiumItem($this->provideBoolValue($cleanIsPremiumItem));

            $this->service->update($cardItem, $id);

            header("Location: {$_SERVER['HTTP_REFERER']}");
        }
    }

    public function delete()
    {
        $this->viewRequestSessionUserCheck();
        $this->redirectViewGetRequest("carditem");

        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            //input sanitation
            $id = htmlspecialchars($_POST['cardItem-id']);

            $this->service->delete($id);

            header("Location: {$_SERVER['HTTP_REFERER']}");
        }
    }

    private function provideCategory($cleanCategory): int
    {
        switch($cleanCategory)
        {
            case("standaard tekst"):
                $category = 0;
                break;

            case("0"):
                $category = 0;
                break;

            case("speciaal font of effect"):
                $category = 1;
                break;

            case("1"):
                $category = 1;
                break;
            
            case("afbeelding"):
                $category = 2;
                break;

            case("2"):
                $category = 2;
                break;

            case("geluidseffect"):
                $category = 3;
                break;

            case("3"):
                $category = 3;
                break;
            
            case("video"):
                $category = 4;
                break;

            case("4"):
                $category = 4;
                break;

            case("animatie"):
                $category = 5;
                break;

            case("5"):
                $category = 5;
                break;
        }

        return $category;
    }
}
?>