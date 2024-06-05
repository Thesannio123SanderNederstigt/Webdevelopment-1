<?php
namespace Models;

Class Bingocard
{
    public string $id; //guid
    public string $userId; //also guid
    public int $score;
    public int $size; //9, 16 or 25
    public string $creationDate; //datetime
    public string $lastAccessedOn; //datetime
    public array $items; //carditem

    //empty constructor
    public function __construct()
    {
    }

    /*public function __construct($_id, $_userId, $_score, $_size, $_creationDate, $_lastAccessedOn, $_items){
        //$_id = com_create_guid(); //put this in the service?
        $this->id = $_id;
        $this->userId = $_userId;
        $this->score = $_score;
        $this->size = $_size;
        $this->creationDate = $_creationDate;
        $this->lastAccessedOn = $_lastAccessedOn;
        $this->items = $_items;
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

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): self 
    {
        $this->userId = $userId;
        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(string $score): self 
    {
        $this->score = $score;
        return $this;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(string $size): self 
    {
        $this->size = $size;
        return $this;
    }

    public function getCreationDate(): string
    {
        return $this->creationDate;
    }

    public function setCreationDate(string $creationDate): self
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    public function getLastAccessedOn(): string
    {
        return $this->lastAccessedOn;
    }

    public function setLastAccessedOn(string $lastAccessedOn): self
    {
        $this->lastAccessedOn = $$lastAccessedOn;
        return $this;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): self
    {
        $this->items = $items;
        return $this;
    }
}
?>