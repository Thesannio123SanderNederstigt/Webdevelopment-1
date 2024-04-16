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
        try{
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

            $stmt->execute();

            $sportsclubs = $stmt->fetchAll();

            return $sportsclubs;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function getOne($id)
    {
        try{
            $stmt = $this->connection->prepare("SELECT * FROM sportsclub WHERE id = :id");
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            $sportsclub = $stmt->fetch();
            return $sportsclub;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function create($sportsclub)
    {
        try{
            $stmt = $this->connection->prepare("INSERT INTO sportsclub (id, clubname, [description], foundedOn, membersAmount) VALUES (?,?,?,?,?)");

            $stmt->execute([$sportsclub->id, $sportsclub->clubname, $sportsclub->description, $sportsclub->foundedOn, $sportsclub->membersAmount]);

            return $sportsclub;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function update($sportsclub, $id)
    {
        try{
            $stmt = $this->connection->prepare("UPDATE sportsclub SET clubname = ?, [description] = ?, foundedOn = ?, membersAmount = ? WHERE id = ?");

            $stmt->execute([$sportsclub->clubname, $sportsclub->description, $sportsclub->foundedOn, $sportsclub->membersAmount, $id]);

            return $sportsclub;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function delete($id)
    {
        try{
            $stmt = $this->connection->prepare("DELETE FROM sportsclub WHERE id = :id");
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            return;
        } catch(PDOException $e) {
            echo $e;
        }
        return true;
    }

    //onderstaande functies zijn uitgewerkt voor de koppeltabel tussen user en sportsclub (behalve update, aangezien dit hier niet nodig is)

    function getUserSportsclubs($userId) //* L00K HERE part 5*\\
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM userSportsclub WHERE userId = :id");
            $stmt->bindParam(':id', $userId);

            $stmt->execute();

            $userSportsclubs = $stmt->fetchAll();
            return $userSportsclubs;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function createUserSportsclub($userId, $sportsclubId) //* L00K HERE part 6*\\ 
    {
        try{
            $stmt = $this->connection->prepare("INSERT INTO userSportsclub (userId, sportsclubId) VALUES (?,?)");

            $stmt->execute([$userId, $sportsclubId]);

            $userSportsclubId = $this->connection->lastInsertId();

            return $userSportsclubId;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function deleteUserSportsclub($userId, $sportsclubId) //* L00K HERE part 7*\\
    {
        try{
            $stmt = $this->connection->prepare("DELETE FROM userSportsclub WHERE userId = :userId AND sportsclubId = :sportsclubId");
            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':sportsclubId', $sportsclubId);

            $stmt->execute();
            return;
        } catch(PDOException $e) {
            echo $e;
        }
        return true;
    }
}
?>