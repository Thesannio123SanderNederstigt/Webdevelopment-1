<?php
namespace Models;

Class cardItem
{
    public string $id;
    public string $content;
    public int $category;
    public int $points;
    public bool $isPremiumItem;

    //lege constructor
    public function __construct()
    {
    }

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