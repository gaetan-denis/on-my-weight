<?php

namespace OnTheWeight\database;

use PDO;
use PDOException;

class Database
{
    private string $dbHost;
    private string $dbName;
    private string $dbUser;
    private string $dbPass;

    public function __construct()
    {
        $this->dbHost = $_ENV['DB_HOST'];
        $this->dbName = $_ENV['DB_NAME'];
        $this->dbUser = $_ENV['DB_USER'];
        $this->dbPass = $_ENV['DB_PASS'];
    }
    /**
     * Return a PDO connection
     *
     * @return PDO The PDO connection
     *
     * @throws PDOException If the PDO connection failed.
     */
    public function connect(): PDO
    {
        try {
            $dsn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName . ";charset=utf8mb4";
            return new PDO($dsn, $this->dbUser, $this->dbPass);
        } catch (PDOException $e) {
            throw new PDOException("Error :" . $e->getMessage() . "; Code" . $e -> getCode());
        }
    }
}
