<?php

class Database
{
    private $host = "localhost";
    private $dbname = "equipment_rental";
    private $username = "root";
    private $password = "";

    public function getConnection()
    {
        try {
            $pdo = new PDO(
                "mysql:host=" . $this->host .
                ";dbname=" . $this->dbname .
                ";charset=utf8mb4",
                $this->username,
                $this->password
            );

            $pdo->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            return $pdo;

        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
}