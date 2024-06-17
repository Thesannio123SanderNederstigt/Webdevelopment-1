<?php
namespace Repositories;

use PDO;
use PDOException;
use Models\User;
use Repositories\Repository;

class userRepository extends Repository
{
    function getAll($offset, $limit)
    {
        try {
            $query = "SELECT * FROM user";

            if (isset($limit) && isset($offset)) {
                $query .= " LIMIT :limit OFFSET :offset ";
            }

            $stmt = $this->connection->prepare($query);

            if (isset($limit) && isset($offset)) {
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            }

            $stmt->execute();

            $users = array();

            while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== false) {               
                $users[] = $this->rowToUser($row);
            }
            return $users;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function getOne($id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM user WHERE id = :id");
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            
            if(!$row)
            {
                return false;
            }

            $user = $this->rowToUser($row);

            return $user;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function rowToUser($row) 
    {
        $user = new User();
        $user->setId($row['id']);
        $user->setUsername($row['username']);
        $user->setPassword('Wouldnt_you_like_to_know_ha_ha');
        $user->setEmail($row['email']);
        $user->setIsAdmin($row['isAdmin']);
        $user->setIsPremium($row['isPremium']);
        $user->setCardsAmount($row['cardsAmount']);
        $user->setSharedCardsAmount($row['sharedCardsAmount']);
        $user->setBingocards(array());
        $user->setSportsclubs(array());
        return $user;
    }

    function create($user)
    {
        try {
            $hashedPassword = $this->hashPassword($user->password);

            $stmt = $this->connection->prepare("INSERT INTO user (id, username, `password`, email, isAdmin, isPremium, cardsAmount, sharedCardsAmount) VALUES (?,?,?,?,?,?,?,?)");
            $stmt->execute([$user->id, $user->username, $hashedPassword, $user->email, $this->provideBooleanIntValue($user->isAdmin), $this->provideBooleanIntValue($user->isPremium), $user->cardsAmount, $user->sharedCardsAmount]);
            
            return $user;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function update($user, $id)
    {
        try {

            if(isset($user->password))
            {
                $hashedPassword = $this->hashPassword($user->password);

                $stmt = $this->connection->prepare("UPDATE user SET username = ?, `password` = ?, email = ?, isAdmin = ?, isPremium = ?, cardsAmount = ?, sharedCardsAmount = ? WHERE id = ?");
                $stmt->execute([$user->username, $hashedPassword, $user->email, $this->provideBooleanIntValue($user->isAdmin), $this->provideBooleanIntValue($user->isPremium), $user->cardsAmount, $user->sharedCardsAmount, $id]);
                
                //geeft geen versleuteld ww, maar loze string terug
                $user->setPassword("Dat is geheim weet je wel ;)");
            } else {
                $stmt = $this->connection->prepare("UPDATE user SET username = ?, email = ?, isAdmin = ?, isPremium = ?, cardsAmount = ?, sharedCardsAmount = ? WHERE id = ?");
                $stmt->execute([$user->username, $user->email, $this->provideBooleanIntValue($user->isAdmin), $this->provideBooleanIntValue($user->isPremium), $user->cardsAmount, $user->sharedCardsAmount, $id]);
            }

            return $user;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function delete($id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM user WHERE id = :id");
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            return true;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    //username en password check
    function loginCredentialsCheck($username, $password)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM user WHERE username = :username");
            $stmt->bindParam(':username', $username);

            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\User');
            $user = $stmt->fetch();


            if (!$user)
            {               
                return false;
            }
            else {
                //verifiëren van het wachtwoord
                $result = $this->verifyPassword($password, $user->getPassword());
            }

            if($result == true)
            {
                //wachtwoord hash wordt hier niet teruggeven
                $user->password = "";

                return $user;
            }
            else {
                return false;
            }

        } catch (PDOException $e) {
            echo $e;
        }
    }

    // hash een wachtwoord
    function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    // verifiëren van een wachtwoord hash
    function verifyPassword($input, $hash)
    {
        return password_verify($input, $hash);
    }

    //onderstaande functies zijn uitgewerkt voor de koppeltabel tussen user en sportsclub (behalve update, aangezien dit niet gewenst/nodig is voor deze koppeltabellen (on update cascade))
    function getUserSportsclubIds($userId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT sportsclubId FROM usersportsclub WHERE userId = :id");
            $stmt->bindParam(':id', $userId);

            $stmt->execute();

            $userSportsclubs = $stmt->fetchAll();
            return $userSportsclubs;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function insertUserSportsclub($userId, $sportsclubId)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO usersportsclub (userId, sportsclubId) VALUES (?,?)");

            $stmt->execute([$userId, $sportsclubId]);

            $userSportsclubId = $this->connection->lastInsertId();

            return $userSportsclubId;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    function deleteUserSportsclub($userId, $sportsclubId)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM usersportsclub WHERE userId = :userId AND sportsclubId = :sportsclubId");
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