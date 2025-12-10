<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;
use PDOException;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$pdo = new PDO(
    "mysql:host={$_ENV['DB_HOST']};charset=utf8mb4",
    $_ENV['DB_USER'],
    $_ENV['DB_PASS']
);

try {
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `weight` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    echo "Base de donnée créé ou déjà existante.";

    $pdo->exec("USE weight");

    $sqlUsers = "CREATE TABLE IF NOT EXISTS `users` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `username` VARCHAR(255) NOT NULL,
        `email` VARCHAR(255) NOT NULL,
        `password_hash` VARCHAR(255) NOT NULL,
        `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
        `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";

    $pdo->exec($sqlUsers);
    echo "Table 'users' créée ou déjà existante.";

    $sqlWeights = "CREATE TABLE IF NOT EXISTS `weights` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT UNSIGNED NOT NULL,
        `weight` DECIMAL(5,2) NOT NULL,
        `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
    ) ENGINE=INNODB DEFAULT CHARSET=utf8mb4;
    ";

    $pdo->exec($sqlWeights);
    echo "Table `weights` créée ou déjà existante-.";
} catch (PDOException $e) {
    throw new PDOException("Error " . $e->getMessage() . "Code : " . $e->getCode());
}
