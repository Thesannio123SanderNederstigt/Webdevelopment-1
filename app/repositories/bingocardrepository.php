<?php
namespace Repositories;

use PDO;
use PDOException;
use Models\Bingocard;
//use Models\BingocardResponse;
use Repositories\Repository;

class bingocardRepository extends Repository
{
    function getAll($offset, $limit)
    {
        try{
            $query = "SELECT * FROM bingocard";

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

            $bingocards = array();

            while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
                $bingocards[] = $this->rowToBingocard($row);
            }
            return $bingocards;
        
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function getOne($id)
    {
        try{
            $stmt = $this->connection->prepare("SELECT * FROM bingocard WHERE id = :id");
            $stmt->bindparam(':id', $id);

            $stmt->execute();

            $row = $stmt->fetch();

            $bingocard = $this->rowToBingocard($row);

            return $bingocard;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function getUserBingocards($userId)
    {
        //ophalen van alle bingokaarten van een user (op basis van de userID van waarden in deze bingoCard tabel dus!)
        try {
            $stmt = $this->connection->prepare("SELECT * FROM bingocard WHERE userId = :id");
            $stmt->bindparam(':id', $userId);

            $stmt->execute();

            $userBingocards = array();

            while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
                $userBingocards[] = $this->rowToBingocard($row);
            }
            return $userBingocards;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function rowToBingocard($row)
    {
        $bingocard = new Bingocard();
        $bingocard->setId($row['id']);
        $bingocard->setuserId($row['userId']);
        $bingocard->setScore($row['score']);
        $bingocard->setSize($row['size']);
        $bingocard->setCreationDate($row['creationDate']);
        $bingocard->setLastAccessedOn($row['lastAccessedOn']);
        $bingocard->setItems(array());
        return $bingocard;
    }

    function create($bingocard)
    {
        try{
            $stmt = $this->connection->prepare("INSERT INTO bingocard (id, userId, score, size, creationDate, lastAccessedOn) VALUES (?,?,?,?,?,?)");

            $stmt->execute([$bingocard->id, $bingocard->userId, $bingocard->score, $bingocard->size, $bingocard->creationDate, $bingocard->lastAccessedOn]);

            return $bingocard;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function update($bingocard, $id)
    {
        try{
            $stmt = $this->connection->prepare("UPDATE bingocard SET userId = ?,  score = ?, size = ?, creationDate = ?, lastAccessedOn = ? WHERE id = ?");

            $stmt->execute([$bingocard->userId, $bingocard->score, $bingocard->size, $bingocard->creationDate, $bingocard->lastAccessedOn, $id]);
            
            return $bingocard;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function updateLastAccessedOn($id)
    {
        try{
            $stmt = $this->connection->prepare("UPDATE bingocard SET lastAccessedOn = now() WHERE id = ?");
            $stmt->bindparam(':id', $id);

            $stmt->execute();

            $bingocard = $stmt->fetch();
            
            return $bingocard;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function delete($id)
    {
        try{
            $stmt = $this->connection->prepare("DELETE FROM bingocard WHERE id = :id");
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            return;
        } catch(PDOException $e) {
            echo $e;
        }
        return true;
    }

    //connecting table/koppeltabel voor de n:n relatie tussen de kaart en kaart-item tabellen bewerkingen hieronder 
    //(update functie is/was hier onnodig, ON UPDATE CASCADE is de bedoeling voor daadwerkelijke bingocard en cardItem tabel data bewerkingen; ook/zelfs bij id wijzigingen)

    function getBingocardItemIds($bingocardId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT cardItemId FROM bingocardItem WHERE bingocardId = :id");
            $stmt->bindParam(':id', $bingocardId);

            $stmt->execute();

            $bingocardItems = $stmt->fetchAll();
            return $bingocardItems;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function createBingocardItem($bingocardId, $cardItemId)
    {
        try{
            $stmt = $this->connection->prepare("INSERT INTO bingocardItem (bingocardId, cardItemId) VALUES (?,?)");

            $stmt->execute([$bingocardId, $cardItemId]);

            $bingocardItemId = $this->connection->lastInsertId();

            return $bingocardItemId;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function deleteBingocardItem($bingocardId, $cardItemId)
    {
        try{
            $stmt = $this->connection->prepare("DELETE FROM bingocardItem WHERE bingocardId = :bingocardId AND cardItemId = :cardItemId");
            $stmt->bindParam(':bingocardId', $bingocardId);
            $stmt->bindParam(':cardItemId', $cardItemId);

            $stmt->execute();
            return;
        } catch(PDOException $e) {
            echo $e;
        }
        return true;
    }
}
?>