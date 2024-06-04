<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

error_reporting(E_ALL);
ini_set("display_errors", 1);

require '../vendor/autoload.php';
//require_once __DIR__ . '../../router/router.php';

use Routers\Router;

$uri = trim($_SERVER['REQUEST_URI'], '/');

$router = new Router();
$router->route($uri);
//$router->add()
?>