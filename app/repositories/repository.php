<?php
namespace Repositories;

use Dotenv\Dotenv;
use PDO;
use PDOException;

class Repository
{
    protected $connection;

    public function __construct()
    {
        try {

            //utilizing environmental variables with phpdotenv
            $dotenv = Dotenv::createImmutable(__DIR__ . '../..');
            $dotenv->load();
            $dotenv->required(['TYPE', 'SERVERNAME', 'USERNAME', 'PASSWORD', 'DATABASE']);

            $type = $_ENV['TYPE'];
            $servername = $_ENV['SERVERNAME'];
            $database = $_ENV['DATABASE'];
            $username = $_ENV['USERNAME'];
            $password = $_ENV['PASSWORD'];

            $this->connection = new PDO("$type:host=$servername;dbname=$database", $username, $password);
            //$this->connection = new PDO("mysql:host=localhost;dbname=webdevelopmentdb", 'webdeveloper', 'sander123');

            //setting the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "failed to connect: " . $e->getMessage();
        }
    }

    public function provideBooleanIntValue($boolItem): int
    {
        if($boolItem == true)
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