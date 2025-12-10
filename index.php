<?php

require __DIR__ . "/vendor/autoload.php";

use Connexion\database\Database;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = new Database();
var_dump($db->connect());
