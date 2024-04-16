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
        try{
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
            $user = $stmt->fetch();
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

        //TODO na vrijdag 12 April 2024:

        //Database data aanmaken en opnieuw database sql script uit phpMyAdmin exporteren en plaatsen in de sql folder van deze repo
        //(check), later meer cardItems aanmaken (leukere/nieuwe natuurlijk ook), om te testen met volle kaarten/premium items, etc. voor deel 2 en deze toevoegen uiteraard

        //daarna verder met onderstaande zaken, ook gerelateerde zaken voor login, wachtwoord (reminder: nu haal je nooit een ww op van een user namelijk)
        //en beveiliging/token stuff (jwt claims, token validity/expiration en refresh stuff later, maar eerst zorgen voor comprehensive en kloppende, services)
        //die op de repo's aansluiten, en daarbij behorende controllers voor deze applicatie (CMS geschikt om views aan te hangen), en natuurlijk de
        //non-cms API controllers die data terug gaan geven en die ook allemaal (behalve het login punt, tot een extend) beveiligd moeten worden! (niet zonder
        //authorization (een geldige/goede jwt token dus) toegankelijk zijn!)

        //define logic in services (ook fallback/default sturen van eerdere waarden wanneer dingen niet ingevuld voor update request/call naar die functie, etc.)
        //denk aan: niet meegegeven username? dan houd je aan wat de waarde is in database/niet overschrijven voor api, 
        //wat object heeft voor cms controllers/non-api controllers? (als dit kan natuurlijk)

        //en: het aanroepen van functie om voor iedere user de bingocards op te halen 
        //en in service voor user object in te vullen (lege array daarmee dan vervangen/overschrijven)
        //en ook down the pipeline zorgen voor ophalen van de items van de kaarten, nadat je voor een user eerst ook kaarten hebt opgehaald, je weet wel
    }
    function create($user)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO user (id, username, [password], email, isAdmin, isPremium, cardsAmount, sharedCardsAmount) VALUES (?,?,?,?,?,?,?,?)");
            $stmt->execute([$user->id, $user->username, $user->password, $user->email, $user->isAdmin, $user->isPremium, $user->cardsAmount, $user->sharedCardsAmount]);
            
            return $user;
        } catch(PDOException $e) {
            echo $e;
        }
    }
    function update($user, $id)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE user SET userName = ?,  [password] = ?, email = ?, isAdmin = ?, isPremium = ?, cardsAmount = ?, sharedCardsAmount = ? WHERE id = ?");
            $stmt->execute([$user->userId, $user->userName, $user->password, $user->email, $user->isAdmin, $user->isPremium, $user->cardsAmount, $user->sharedCardsAmount, $id]);
            
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

            return;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    //Ik wil deze functies (net als een functie die pseudo/als inlog-functie moet gaan werken) ook daar hebben, en hier een kort low niveau/kern methode ook voor,
    // gaan verplaatsen naar de userService, die het wachtwoord al voordat deze door wordt gezet naar deze userrepository ALLANG heeft versleuteld/ge-encrypt!!!
    function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    // verify the password hash
    function verifyPassword($input, $hash)
    {
        return password_verify($input, $hash);
    }
}
?>