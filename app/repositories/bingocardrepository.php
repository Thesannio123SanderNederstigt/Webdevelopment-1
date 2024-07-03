<?php
namespace Repositories;

use PDO;
use PDOException;
use Models\Bingocard;
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

            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            $row = $stmt->fetch();

            if(!$row)
            {
                return false;
            }

            $bingocard = $this->rowToBingocard($row);

            return $bingocard;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function getUserBingocards($userId)
    {
        //ophalen van alle bingokaarten van een user (op basis van de userID van waarden in deze bingoCard tabel)
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

    function addMissingFields($existingBingocard, $bingocard)
    {
        $fullBingocard = new Bingocard();

        !isset($bingocard->score) ? $fullBingocard->setScore($existingBingocard->getScore()) : $fullBingocard->setScore($bingocard->score);
        !isset($bingocard->size) ? $fullBingocard->setSize($existingBingocard->getSize()) : $fullBingocard->setSize($bingocard->size);
        !isset($bingocard->creationDate) ? $fullBingocard->setCreationDate($existingBingocard->getCreationDate()) : $fullBingocard->setCreationDate($bingocard->creationDate);
        !isset($bingocard->lastAccessedOn) ? $fullBingocard->setLastAccessedOn($existingBingocard->getLastAccessedOn()) : $fullBingocard->setLastAccessedOn($bingocard->lastAccessedOn);

        return $fullBingocard;
    }

    function create($bingocard)
    {
        try{
            $stmt = $this->connection->prepare("INSERT INTO bingocard (id, userId, score, `size`, creationDate, lastAccessedOn) VALUES (?,?,?,?,?,?)");

            $stmt->execute([$bingocard->id, $bingocard->userId, $bingocard->score, $bingocard->size, $bingocard->creationDate, $bingocard->lastAccessedOn]);

            return $bingocard;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function update($bingocard, $id)
    {
        try{
            $existingBingocard = $this->getOne($id);
            $fullBingocard = $this->addMissingFields($existingBingocard, $bingocard);

            $stmt = $this->connection->prepare("UPDATE bingocard SET userId = ?,  score = ?, `size` = ?, creationDate = ?, lastAccessedOn = ? WHERE id = ?");

            $stmt->execute([$bingocard->userId, $fullBingocard->score, $fullBingocard->size, $fullBingocard->creationDate, $fullBingocard->lastAccessedOn, $id]);
            
            $fullBingocard->setUserId($bingocard->userId);
            return $fullBingocard;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function updateLastAccessedOn($id)
    {
        try{
            $stmt = $this->connection->prepare("UPDATE bingocard SET lastAccessedOn = now() WHERE id = :id");
            $stmt->bindparam(':id', $id);

            $stmt->execute();
            
            return true;
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

    function getBingocardItemIds($bingocardId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT cardItemId FROM bingocarditem WHERE bingocardId = :id");
            $stmt->bindParam(':id', $bingocardId);

            $stmt->execute();

            $bingocardItems = $stmt->fetchAll();
            return $bingocardItems;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function insertBingocardItem($bingocardId, $cardItemId)
    {
        try{
            $stmt = $this->connection->prepare("INSERT INTO bingocarditem (bingocardId, cardItemId) VALUES (?,?)");

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
            $stmt = $this->connection->prepare("DELETE FROM bingocarditem WHERE bingocardId = :bingocardId AND cardItemId = :cardItemId");
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