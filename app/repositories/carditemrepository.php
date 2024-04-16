<?php
namespace Repositories;

use PDO;
use PDOException;
use Models\CardItem;
use Repositories\Repository;

class cardItemRepository extends Repository
{
    function getAll($offset, $limit)
    {
        try {
            $query = "SELECT * FROM cardItem";

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

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'CardItem');
            $cardItems = $stmt->fetchAll();

            return $cardItems;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function getOne($id)
    {
        try{
            $stmt = $this->connection->prepare("SELECT * FROM cardItem WHERE id = :id");
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            $cardItem = $stmt->fetch();
            return $cardItem;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function create($cardItem)
    {
        try{
            $stmt = $this->connection->prepare("INSERT INTO cardItem (id, content, category, points, isPremiumItem) VALUES (?,?,?,?,?)");

            $stmt->execute([$cardItem->id, $cardItem->content, $cardItem->category, $cardItem->points, $cardItem->isPremiumItem]);

            return $cardItem;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function update($cardItem, $id)
    {
        try{
            $stmt = $this->connection->prepare("UPDATE cardItem SET content = ?, category = ?, points = ?, isPremiumItem = ? WHERE id = ?");

            $stmt->execute([$cardItem->content, $cardItem->category, $cardItem->points, $cardItem->isPremiumItem, $id]);

            return $cardItem;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function delete($id)
    {
        try{
            $stmt = $this->connection->prepare("DELETE FROM cardItem WHERE id = :id");
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

    function getBingocardItems($bingocardId) //* L00K HERE part 2*\\
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM bingocardItem WHERE bingocardId = :id");
            $stmt->bindParam(':id', $bingocardId);

            $stmt->execute();

            $bingocardItems = $stmt->fetchAll();
            return $bingocardItems;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    //NOTE TO SELF: IK WIL AUTO_INCREMENT OP DEZE KOPPELTABEL (anders moet ik later hier alsnog een guid o.i.d. als id hier toevoegen!)
    function createBingocardItem($bingocardId, $cardItemId) //* L00K HERE part 3*\\ 
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

    function deleteBingocardItem($bingocardId, $cardItemId) //* L00K HERE part 4*\\
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