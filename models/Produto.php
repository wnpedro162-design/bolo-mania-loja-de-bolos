<?php

require_once __DIR__ . '/../config/db.php';

class Produto
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function listarComCategoria(bool $somenteAtivos = false): array
    {
        $sql = "
            SELECT
                p.id,
                p.categoria_id,
                p.nome,
                p.descricao,
                p.ativo,
                c.nome AS categoria_nome

            FROM produto p

            INNER JOIN categoria c
            ON c.id = p.categoria_id
        ";

        if ($somenteAtivos) {
            $sql .= " WHERE p.ativo = 1 AND c.ativo = 1 ";
        }

        $sql .= " ORDER BY p.id DESC";

        return $this->conn->query($sql)->fetchAll();
    }

    public function buscarPorId(int $id): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM produto
            WHERE id = :id
        ");

        $stmt->execute([
            ':id' => $id
        ]);

        $r = $stmt->fetch();

        return $r ?: null;
    }

    public function inserir(
        int $categoriaId,
        string $nome,
        ?string $descricao
    ): int
    {
        $stmt = $this->conn->prepare("
            INSERT INTO produto
            (categoria_id, nome, descricao, ativo)

            VALUES
            (:categoria_id, :nome, :descricao, 1)
        ");

        $stmt->execute([
            ':categoria_id' => $categoriaId,
            ':nome' => $nome,
            ':descricao' => $descricao
        ]);

        return (int)$this->conn->lastInsertId();
    }

    public function atualizar(
        int $id,
        int $categoriaId,
        string $nome,
        ?string $descricao
    ): void
    {
        $stmt = $this->conn->prepare("
            UPDATE produto

            SET
                categoria_id = :categoria_id,
                nome = :nome,
                descricao = :descricao

            WHERE id = :id
        ");

        $stmt->execute([
            ':id' => $id,
            ':categoria_id' => $categoriaId,
            ':nome' => $nome,
            ':descricao' => $descricao
        ]);
    }

    public function setAtivo(int $id, bool $ativo): void
    {
        $stmt = $this->conn->prepare("
            UPDATE produto
            SET ativo = :ativo
            WHERE id = :id
        ");

        $stmt->execute([
            ':id' => $id,
            ':ativo' => $ativo ? 1 : 0
        ]);
    }

    public function deletar(int $id): void
    {
        $stmt = $this->conn->prepare("
            DELETE FROM produto
            WHERE id = :id
        ");

        $stmt->execute([
            ':id' => $id
        ]);
    }
}