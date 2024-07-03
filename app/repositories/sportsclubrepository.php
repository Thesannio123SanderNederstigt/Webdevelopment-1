<?php
namespace Repositories;

use PDO;
use PDOException;
use Models\Sportsclub;
use Repositories\Repository;

class sportsclubRepository extends Repository
{
    function getAll($offset, $limit)
    {
        try {
            $query = "SELECT * FROM sportsclub";

            if(isset($offset) && isset($limit))
            {
                $query .= " LIMIT :limit OFFSET :offset ";
            }

            $stmt = $this->connection->prepare($query);

            if (isset($limit) && isset($offset)) 
            {
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            }

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\Sportsclub');
            $stmt->execute();

            $sportsclubs = $stmt->fetchAll();

            return $sportsclubs;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function getOne($id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM sportsclub WHERE id = :id");
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\Sportsclub');
            $sportsclub = $stmt->fetch();
            
            return $sportsclub;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function create($sportsclub)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO sportsclub (id, clubname, description, foundedOn, membersAmount) VALUES (?,?,?,?,?)");

            $stmt->execute([$sportsclub->id, $sportsclub->clubname, $sportsclub->description, $sportsclub->foundedOn, $sportsclub->membersAmount]);

            return $sportsclub;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function update($sportsclub, $id)
    {
        try {
            $existingSportsclub = $this->getOne($id);
            $fullSportsclub = $this->addMissingFields($existingSportsclub, $sportsclub);

            $stmt = $this->connection->prepare("UPDATE sportsclub SET clubname = ?, description = ?, foundedOn = ?, membersAmount = ? WHERE id = ?");

            $stmt->execute([$fullSportsclub->clubname, $fullSportsclub->description, $fullSportsclub->foundedOn, $fullSportsclub->membersAmount, $id]);

            return $fullSportsclub;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function delete($id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM sportsclub WHERE id = :id");
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            return;
        } catch(PDOException $e) {
            echo $e;
        }
        return true;
    }

    function addMissingFields($existingSportsclub, $sportsclub)
    {
        $fullSportsclub = new Sportsclub();

        !isset($sportsclub->clubname) ? $fullSportsclub->setClubname($existingSportsclub->getClubname()) : $fullSportsclub->setClubname($sportsclub->clubname);
        !isset($sportsclub->description) ? $fullSportsclub->setDescription($existingSportsclub->getDescription()) : $fullSportsclub->setDescription($sportsclub->description);
        !isset($sportsclub->foundedOn) ? $fullSportsclub->setFoundedOn($existingSportsclub->getFoundedOn()) : $fullSportsclub->setFoundedOn($sportsclub->foundedOn);
        !isset($sportsclub->membersAmount) ? $fullSportsclub->setMembersAmount($existingSportsclub->getMembersAmount()) : $fullSportsclub->setMembersAmount($sportsclub->membersAmount);

        return $fullSportsclub;
    }
}
?>