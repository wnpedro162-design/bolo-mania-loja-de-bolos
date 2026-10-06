<?php

class Database
{
    private static $conn = null;

    public static function getConnection()
    {
        if (self::$conn === null) {
            self::$conn = new PDO(
                "mysql:host=localhost;dbname=bolomania;charset=utf8mb4",
                "root",
                "",
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        }

        return self::$conn;
    }
}