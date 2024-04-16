<?php
namespace Models;
Class User 
{
    private string $id; //guids gebruikt voor alle vormen van id's in deze applicatie
    private string $username;
    private string $password;
    private string $email;
    private bool $isAdmin; //voor cms update van gegevens check (of check if userId gelijk aan eigen userId in token, dan mag userUpdate wel (update endpoint gebruikt straks direct dit object/setters van dit model?, en geen DTO?), maar andere cms updates van andere objecten natuurlijk niet!)
    private bool $isPremium;
    private int $cardsAmount;
    private int $sharedCardsAmount;

    private array $bingocards; //bingocard array
    private array $sportsclubs; //string array

    //$this->$bingocards = array(new Bingocard(), 3);

    //dto ==> no userid, isAdmin == default false, isPremium == default false, cardsAmount = 0, sharedCardsAmount = 0, 
    //bingocards (not allowed to send through api in user endpoint? or create empty array?), sportsclubs = also not allowed (except through the updateUser endpoint)
    //respone => geen password, array van card id's?
    //empty constructor
    public function __construct()
    {
    }

    /*public function User()
    {

    }*/

    /*public function __construct($_id, $_username, $_password, $_email, $_isPremium, $_cardsAmount, $_sharedCardsAmount, $_bingocards, $_sportsclubs)
    {
        $this->id = $_id;
        $this->username = $_username;
        $this->password = $_password;
        $this->email = $_email;
        $this->isPremium = $_isPremium;
        $this->cardsAmount = $_cardsAmount;
        $this->sharedCardsAmount = $_sharedCardsAmount;
        $this->bingocards = $_bingocards;
        $this->sportsclubs = $_sportsclubs;
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

    /*public function setId(): void
    {
        $this->id = com_create_guid();
    }*/

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