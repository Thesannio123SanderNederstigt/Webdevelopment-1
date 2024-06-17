<?php
namespace Models;

Class User
{
    public string $id;
    public string $username;
    public string $password;
    public string $email;
    public bool $isAdmin;
    public bool $isPremium;
    public int $cardsAmount;
    public int $sharedCardsAmount;

    public array $bingocards;
    public array $sportsclubs;

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

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getIsPremium(): bool
    {
        return $this->isPremium;
    }

    public function setIsPremium(bool $isPremium): self 
    {
        $this->isPremium = $isPremium;
        return $this;
    }

    public function getIsAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;
        return $this;
    }

    public function getCardsAmount(): int
    {
        return $this->cardsAmount;
    }

    public function setCardsAmount(int $cardsAmount): self
    {
        $this->cardsAmount = $cardsAmount;
        return $this;
    }

    public function getSharedCardsAmount(): int
    {
        return $this->sharedCardsAmount;
    }

    public function setSharedCardsAmount(int $sharedCardsAmount): self
    {
        $this->sharedCardsAmount = $sharedCardsAmount;
        return $this;
    }

    public function getBingocards(): array 
    {
        return $this->bingocards;
    }

    public function setBingocards(array $bingocards): self
    {
        $this->bingocards = $bingocards;
        return $this;
    }

    public function getSportsclubs(): array 
    {
        return $this->sportsclubs;
    }

    public function setSportsclubs(array $sportsclubs): self
    {
        $this->sportsclubs = $sportsclubs;
        return $this;
    }
}
?>