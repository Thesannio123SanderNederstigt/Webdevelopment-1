<?php
namespace Models;

include_once 'sportsclub.php';
include_once 'guid.php';

class sportsclubDTO
{
    public string $clubname;
    public string $description;
    public string $foundedOn;
    public int $membersAmount;

    public function __construct($_clubname, $_description, $_foundedOn, $_membersAmount)
    {
        $this->clubname = $_clubname;
        $this->description = $_description;
        $this->foundedOn = $_foundedOn;
        $this->membersAmount = $_membersAmount;
    }

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