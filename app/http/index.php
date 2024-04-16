<?php
require '../vendor/autoload.php';
require_once __DIR__ . '../router/router.php';

$uri = trim($_SERVER['REQUEST_URI'], '/');

$router = new Router();
$router->route($uri);
?>