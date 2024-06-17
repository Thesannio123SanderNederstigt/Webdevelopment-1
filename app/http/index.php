<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

//note: error reporting/de weergave van errors (en de access control allow headers hierboven) zijn hier alleen
//aangezet voor lokale draai, ontwikkel en test doeleinden! (m.a.w.: deze zouden hier niet staan in een live/productie applicatie omgeving)

error_reporting(E_ALL);
ini_set("display_errors", 1);

require __DIR__ . '/../vendor/autoload.php';

use Routers\Router;

$uri = trim($_SERVER['REQUEST_URI'], '/');

$router = new Router();
$router->route($uri);
?>