<?php
namespace Models;

class userResponse
{
    public string $id;
    public string $username;
    public string $email;
    public bool $isAdmin;
    public bool $isPremium;
    public int $cardsAmount;
    public int $sharedCardsAmount;

    public function __construct($_id, $_username, $_email, $_isAdmin, $_isPremium, $_cardsAmount, $_sharedCardsAmount)
    {
        $this->id = $_id;
        $this->username = $_username;
        $this->email = $_email;
        $this->isAdmin = $_isAdmin;
        $this->isPremium = $_isPremium;
        $this->cardsAmount = $_cardsAmount;
        $this->sharedCardsAmount = $_sharedCardsAmount;
    }
}
?>