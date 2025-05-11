<?php

namespace TicketProPlus\App\Config;

use PDO, PDOException;

class Database
{
    private string $host;
    private string $dbName;
    private string $dbUser;
    private string $dbPwd;
    protected ?PDO $conn = null;

    public function __construct()
    {
        $this->host   = $_ENV["DB_HOST"];
        $this->dbName = $_ENV["DB_NAME"];
        $this->dbUser = $_ENV["DB_USER"];
        $this->dbPwd  = $_ENV["DB_PWD"];
        $this->getConnection();
    }

    public function getConnection()
    {
        if ($this->conn === null) {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->dbName};charset=utf8mb4";
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];
                $this->conn = new PDO($dsn, $this->dbUser, $this->dbPwd, $options);
            } catch (PDOException $e) {
                echo "Erreur de connexion à la base de données : <br>" . $e->getMessage();
                die();
            }
        }
        return $this->conn;
    }
}
