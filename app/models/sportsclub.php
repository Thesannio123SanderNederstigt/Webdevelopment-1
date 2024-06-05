<?php
namespace Models;

Class Sportsclub
{
    public string $id;
    public string $clubname;
    public string $description;
    public string $foundedOn;
    public int $membersAmount;

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

    public function getclubname(): string
    {
        return $this->clubname;
    }

    public function setClubname(string $clubname): self
    {
        $this->clubname = $clubname;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getFoundedOn(): string
    {
        return $this->foundedOn;
    }

    public function setFoundedOn(string $foundedOn): self
    {
        $this->foundedOn = $foundedOn;
        return $this;
    }

    public function getMembersAmount(): int
    {
        return $this->membersAmount;
    }

    public function setMembersAmount(int $membersAmount): self
    {
        $this->membersAmount = $membersAmount;
        return $this;
    }
}
?>