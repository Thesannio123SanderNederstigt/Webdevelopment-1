<?php
namespace Models;

use Models\Sportsclub;

include_once 'guid.php';

class sportsclubDTO
{
    public string $clubname;
    public string $description;
    public string $foundedOn;
    public int $membersAmount;

    public function __construct(){}

    public function sportsclubMapper(): Sportsclub
    {
        $sportsclub = new Sportsclub();
        $sportsclub->setId(createGuid());
        $sportsclub->setClubname($this->clubname);
        $sportsclub->setDescription($this->description);
        $sportsclub->setFoundedOn($this->foundedOn);
        $sportsclub->setMembersAmount($this->membersAmount);
        return $sportsclub;
    }
}
?>