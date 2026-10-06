<?php
session_start();

require_once __DIR__ . '/config/db.php';

Database::getConnection();

// Roteamento simples via GET
$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'form';


// Carregar controller
switch ($controller) {
    case 'auth':
        require_once __DIR__ . '/controllers/AuthController.php';
        $c = new AuthController();
        break;


    // CRUD PRODUTOS E VENDAS
    case 'produto':
       require_once __DIR__ . '/controllers/AuthController.php';
        $c = new ProdutoController();
        break;


    case 'entrada':
        require_once _DIR_ . '/controllers/EntradaController.php';
        $c = new EntradaController();
        break;


    case 'venda':
        require_once _DIR_ . '/controllers/VendaController.php';
        $c = new VendaController();
        break;


    case 'relatorio':
        require_once _DIR_ . '/controllers/RelatorioController.php';
        $c = new RelatorioController();
        break;


   // CRUD USUARIO / VENDEDOR
case 'usuario':
    require_once __DIR__ . '/controllers/UsuarioController.php';
    $c = new UsuarioController();
    break;


    // Caminho padrão caso o controller não exista
    default:
        die("Controller inválido.");
}


// Executar ação
if (!method_exists($c, $action)) {
    die("Ação inválida.");
}


$c->$action();
    
        