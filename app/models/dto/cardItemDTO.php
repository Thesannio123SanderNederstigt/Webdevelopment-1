<?php
namespace Models;

include_once '../cardItem.php';
include_once '../guid.php';

class cardItemDTO
{
    public string $content;
    public int $category;
    public int $points;
    public bool $isPremiumItem;

    public function __construct($_content, $_category, $_points, $_isPremiumItem)
    {
        $this->content = $_content;
        $this->category = $_category;
        $this->points = $_points;
        $this->isPremiumItem = $_isPremiumItem;
    }

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