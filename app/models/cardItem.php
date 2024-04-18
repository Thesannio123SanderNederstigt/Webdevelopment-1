<?php
namespace Models;

Class cardItem
{
    private string $id; //guid
    private string $content; //text
    private int $category;
    private int $points;
    private bool $isPremiumItem;

    //empty constructor
    public function __construct()
    {
    }

    /*public function __construct($_id, $_content, $_category, $_points, $_isPremiumItem)
    {
        $this->id = $_id;
        $this->content = $_content;
        $this->category = $_category;
        $this->points = $_points;
        $this->isPremiumItem = $_isPremiumItem;
    }*/

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getCategory(): int
    {
        return $this->category;
    }

    public function setCategory(int $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;
        return $this;
    }

    public function getIsPremiumItem(): bool
    {
        return $this->isPremiumItem;
    }

    public function setIsPremiumItem(bool $isPremiumItem): self
    {
        $this->isPremiumItem = $isPremiumItem;
        return $this;
    }
}
?>