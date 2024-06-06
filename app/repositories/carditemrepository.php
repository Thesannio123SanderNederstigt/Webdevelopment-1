<?php
namespace Repositories;

use PDO;
use PDOException;
use Models\cardItem;
use Repositories\Repository;

class cardItemRepository extends Repository
{
    function getAll($offset, $limit)
    {
        try {
            $query = "SELECT * FROM carditem";

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

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\cardItem');
            $cardItems = $stmt->fetchAll();

            return $cardItems;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function getOne($id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM carditem WHERE id = :id");
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
        try {
            $stmt = $this->connection->prepare("INSERT INTO carditem (id, content, category, points, isPremiumItem) VALUES (?,?,?,?,?)");

            $boolValue = $this->provideBooleanIntValue($cardItem->isPremiumItem);

            $stmt->execute([$cardItem->id, $cardItem->content, $cardItem->category, $cardItem->points, $boolValue]);

            return $cardItem;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function update($cardItem, $id)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE carditem SET content = ?, category = ?, points = ?, isPremiumItem = ? WHERE id = ?");

            $stmt->execute([$cardItem->content, $cardItem->category, $cardItem->points, $this->provideBooleanIntValue($cardItem->isPremiumItem), $id]);

            return $cardItem;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function delete($id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM carditem WHERE id = :id");
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            return;
        } catch(PDOException $e) {
            echo $e;
        }
        return true;
    }

    private function provideBooleanIntValue($isPremiumItem): int
    {
        if($isPremiumItem == true)
        {
            $boolVal = 1;
        }
        else {
            $boolVal = 0;
        }

        return $boolVal;
    }
}
?>