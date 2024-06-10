<?php
namespace Models;

use Models\Bingocard;

include_once 'guid.php';

Class bingocardDTO
{
    public string $userId;
    public int $size;

    public function __construct()
    {
    }

    public function bingocardMapper(): Bingocard
    {
        $bingocard = new Bingocard();
        $bingocard->setId(createGuid());
        $bingocard->setUserId($this->userId);
        $bingocard->setSize($this->size);

        $bingocard->setScore(0);
        $bingocard->setCreationDate(date("Y-m-d H:i:s"));
        $bingocard->setLastAccessedOn(date("Y-m-d H:i:s"));
        $bingocard->setItems(array());

        return $bingocard;
    }
}
?>