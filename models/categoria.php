<?php

require_once __DIR__ . '/../config/db.php';

class Categoria
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function listarAtivas(): array
    {
        return $this->conn->query("
            SELECT id, nome
            FROM categoria
            WHERE ativo = 1
            ORDER BY nome
        ")->fetchAll();
    }
}
