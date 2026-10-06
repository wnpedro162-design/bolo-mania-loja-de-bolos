<?php
require_once __DIR__ . '/../models/Usuario.php';
class AuthController
{
public function form()
{
require_once __DIR__ . '/../views/login.php';
}
public function login()
{
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';
$usuarioModel = new Usuario();
$user = $usuarioModel->buscarPorEmail($email);
if (!$user || (int)$user['ativo'] !== 1) {
die("Usuário inválido ou inativo.");
}
if (!password_verify($senha, $user['senha'])) {
die("Senha inválida.");
}
// sessão
$_SESSION['usuario_id'] = $user['id'];
$_SESSION['perfil'] = $user['perfil'];
$_SESSION['nome'] = $user['nome'];
header("Location: index.php?controller=auth&action=dashboard");
exit;
}
public function dashboard()
{


$this->check();
require_once __DIR__ . '/../views/dashboard.php';
}
public function logout()
{
session_destroy();
header("Location: index.php?controller=auth&action=form");
exit;
}
public function check()
{
if (!isset($_SESSION['usuario_id'])) {
header("Location: index.php?controller=auth&action=form");
exit;
} }
public function onlyAdmin()
{
$this->check();
if (($_SESSION['perfil'] ?? '') !== 'admin') {
die("Acesso negado.");
} } }
