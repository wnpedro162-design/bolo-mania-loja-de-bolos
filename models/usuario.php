<?php
require_once __DIR__ . '/../config/db.php';
class Usuario
{
private $conn;
public function __construct()
{
$this->conn = Database::getConnection();
}
public function buscarPorEmail($email)
{
$sql = "SELECT * FROM usuario WHERE email = :email LIMIT 1";
$stmt = $this->conn->prepare($sql);
$stmt->execute([':email' => $email]);
return $stmt->fetch();
}
public function cadastrar($nome, $email, $senha_hash, $perfil = 'vendedor', $ativo = 1)
    {
        $sql = "INSERT INTO usuario (nome, email, senha, perfil, ativo)
                VALUES (:nome, :email, :senha, :perfil, :ativo)";
       
        $stmt = $this->conn->prepare($sql);
       
        return $stmt->execute([
            ':nome'   => $nome,
            ':email'  => $email,
            ':senha'  => $senha_hash,
            ':perfil' => $perfil,
            ':ativo'  => $ativo
        ]);
    }


}

