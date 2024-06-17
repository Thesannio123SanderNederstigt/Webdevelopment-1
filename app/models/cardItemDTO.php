<?php
namespace Models;

use Models\cardItem;

include_once 'guid.php';

class cardItemDTO
{
    public string $content;
    public int $category;
    public int $points;
    public bool $isPremiumItem;

    public function __construct(){}

    public function cardItemMapper(): cardItem
    {
        $cardItem = new cardItem();
        $cardItem->setId(createGuid());
        $cardItem->setContent($this->content);
        $cardItem->setCategory($this->category);
        $cardItem->setPoints($this->points);
        $cardItem->setIsPremiumItem($this->isPremiumItem);
        return $cardItem;
    }
}
?>