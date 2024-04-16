<?php
namespace Models;

class bingocardResponse
{
    public string $id;
    public string $userId;
    public int $score;
    public int $size;
    public string $creationDate;
    public string $lastAccessedOn;

    public function __construct($_id, $_userId, $_score, $_size, $_creationDate, $_lastAccessedOn)
    {
        $this->id = $_id;
        $this->userId = $_userId;
        $this->score = $_score;
        $this->size = $_size;
        $this->creationDate = $_creationDate;
        $this->lastAccessedOn = $_lastAccessedOn;
    }
}
?>