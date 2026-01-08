<?php

require __DIR__ . "/vendor/autoload.php";

use OnTheWeight\database\Database;
use Dotenv\Dotenv;
use OnTheWeight\controllers\AuthController;
use OnTheWeight\repositories\WeightRepository;
use OnTheWeight\services\WeightService;
use OnTheWeight\controllers\WeightController;
use OnTheWeight\repositories\UserRepository;
use OnTheWeight\services\AuthService;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = new Database();
$pdo = $db->connect();

$userRepo = new UserRepository($pdo);
$authService = new AuthService($userRepo);
$authController = new AuthController($authService);
$weightRepo = new WeightRepository($pdo);
$weightService = new WeightService($weightRepo);
$weightController = new WeightController($weightService);


$action = $_GET['action'] ?? null;

switch ($action) {
    case 'add-weight':
        $weightController->addWeight();
        break;

    case 'get-weights':
        $weightController->getWeightsByUser();
        break;

    case 'login':
        $authController->login();
        break;

    case 'logout':
        $authController->logout();
        break;

    case 'register':
        $authController->register();
        break;
    default:
        echo "No route matched";
}
