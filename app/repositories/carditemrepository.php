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
        try {
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
        try {
            $stmt = $this->connection->prepare("INSERT INTO cardItem (id, content, category, points, isPremiumItem) VALUES (?,?,?,?,?)");

            $stmt->execute([$cardItem->id, $cardItem->content, $cardItem->category, $cardItem->points, $cardItem->isPremiumItem]);

            return $cardItem;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function update($cardItem, $id)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE cardItem SET content = ?, category = ?, points = ?, isPremiumItem = ? WHERE id = ?");

            $stmt->execute([$cardItem->content, $cardItem->category, $cardItem->points, $cardItem->isPremiumItem, $id]);

            return $cardItem;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function delete($id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM cardItem WHERE id = :id");
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            return;
        } catch(PDOException $e) {
            echo $e;
        }
        return true;
    }
}
?>