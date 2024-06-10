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

        //TODO na woensdag 17 April 2024:

        //TODO: NIET VERGETEN OM IN DE CONTROLLER DE ECHTE SPORTSCLUB OP BASIS VAN DEZE ID'S, DE USER BINGOKAARTEN EN DE KAARTITEM OBJECTEN OP TE HALEN VANUIT DE ANDERE SERVICES!!!
        //ALSO: checken en zorgen voor juiste implementatie van wel/geen DTO's, juiste zaken hier in deze DTO's en objecten, en input sanitation, ww hashing (check), tokens, etc.
        //so much to do in the controllers and beyond...en later zaken omgooien/debuggen, etc. ...HOW FUN!!!

        //Database data aanmaken en opnieuw database sql script uit phpMyAdmin exporteren en plaatsen in de sql folder van deze repo
        //(check), later meer cardItems aanmaken (leukere/nieuwe natuurlijk ook), om te testen met volle kaarten/premium items, etc. voor deel 2 en deze toevoegen uiteraard

        //daarna verder met onderstaande zaken, ook gerelateerde zaken voor login, wachtwoord (reminder: nu haal je nooit een ww op van een user namelijk)(check)
        //en beveiliging/token stuff (jwt claims, token validity/expiration en refresh stuff later, maar eerst zorgen voor comprehensive en kloppende, services)
        //die op de repo's aansluiten, en daarbij behorende controllers voor deze applicatie (CMS geschikt om views aan te hangen), en natuurlijk de
        //non-cms API controllers die data terug gaan geven en die ook allemaal (behalve het login punt, tot een extend) beveiligd moeten worden! (niet zonder
        //authorization (een geldige/goede jwt token dus) toegankelijk zijn!)

        //define logic in services (ook fallback/default sturen van eerdere waarden wanneer dingen niet ingevuld voor update request/call naar die functie, etc.)
        //denk aan update calls: niet meegegeven username? dan houd je aan wat de waarde is in database/niet overschrijven voor api, 
        //wat object heeft voor cms controllers/non-api controllers? (als dit kan natuurlijk)

        //en: het aanroepen van functie om voor iedere user de bingocards op te halen 
        //en in service voor user object in te vullen (lege array daarmee dan vervangen/overschrijven)
        //en ook down the pipeline zorgen voor ophalen van de items van de kaarten, nadat je voor een user eerst ook kaarten hebt opgehaald, je weet wel
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
                
                //geeft versleuteld ww of loze string terug
                
                //$user->setPassword($hashedPassword);
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

    //username en password check voor inlog service/controller endpoint(s)
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
                /*$this->respondWithError(401, "Invalid login");
                return;*/
                
                return false;
            }
            else {
                // verifiëren van het wachtwoord
                $result = $this->verifyPassword($password, $user->getPassword());
            }

            if($result == true)
            {
                // wachtwoord hash wordt hier niet teruggeven
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

    //onderstaande functies zijn uitgewerkt voor de koppeltabel tussen user en sportsclub (behalve update, aangezien dit hier niet nodig is)

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