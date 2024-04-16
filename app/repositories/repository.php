<?php
namespace Repositories;

use PDO;
use PDOException;

class Repository
{
    protected $connection;

    public function __construct()
    {
        require __DIR__ . '/../config/dbconfig.php';

        try{
            $this->connection = new PDO("$type:host=$servername;dbname=$database", $username, $password);

            //setting the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e){
            echo "failed to connect: " . $e->getMessage();
        }
    }
}
?>