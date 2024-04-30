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
        //require __DIR__ . '/../config/dbconfig.php';
        try {

            //utilizing environmental variables with phpdotenv
            $dotenv = Dotenv::createImmutable(__DIR__);
            $dotenv->required(['TYPE', 'SERVERNAME', 'USERNAME', 'PASSWORD', 'DATABASE']);
            $dotenv->load();

            $type = $_ENV['TYPE'];
            $servername = $_ENV['SERVERNAME'];
            $database = $_ENV['DATABASE'];
            $username = $_ENV['USERNAME'];
            $password = $_ENV['PASSWORD'];

            $this->connection = new PDO("$type:host=$servername;dbname=$database", $username, $password);

            //setting the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "failed to connect: " . $e->getMessage();
        }
    }
}
?>