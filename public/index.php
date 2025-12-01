<?php
session_start();

require_once __DIR__ . '/../app/config/database.php';

// Roteamento simples via parâmetro ?route=
$route = $_GET['route'] ?? 'home';

switch ($route) {

    case 'home':
        require __DIR__ . '/../views/home.php';
        break;

    case 'produtos':
    case 'produtos/index':
        require __DIR__ . '/../app/controllers/ProdutoController.php';
        break;

    case 'produtos/create':
        $_GET['action'] = 'create';
        require __DIR__ . '/../app/controllers/ProdutoController.php';
        break;

    case 'produtos/edit':
        $_GET['action'] = 'edit';
        require __DIR__ . '/../app/controllers/ProdutoController.php';
        break;

    case 'produtos/delete':
        $_GET['action'] = 'delete';
        require __DIR__ . '/../app/controllers/ProdutoController.php';
        break;

    case 'admin/login':
        $_GET['action'] = 'login';
        require __DIR__ . '/../app/controllers/AdminController.php';
        break;

    case 'admin/dashboard':
        $_GET['action'] = 'dashboard';
        require __DIR__ . '/../app/controllers/AdminController.php';
        break;

    case 'admin/logout':
        $_GET['action'] = 'logout';
        require __DIR__ . '/../app/controllers/AdminController.php';
        break;

    case 'cliente/login':
        $_GET['action'] = 'login';
        require __DIR__ . '/../app/controllers/ClienteController.php';
        break;

    case 'cliente/cadastro':
        $_GET['action'] = 'cadastro';
        require __DIR__ . '/../app/controllers/ClienteController.php';
        break;

    case 'cliente/perfil':
        $_GET['action'] = 'perfil';
        require __DIR__ . '/../app/controllers/ClienteController.php';
        break;

    case 'cliente/logout':
        $_GET['action'] = 'logout';
        require __DIR__ . '/../app/controllers/ClienteController.php';
        break;

    case 'pedido':
    case 'pedido/adicionar':
    case 'pedido/carrinho':
    case 'pedido/finalizar':
    case 'pedido/remover':
        require __DIR__ . '/../app/controllers/PedidoController.php';
        break;

    default:
        echo "<h2>404 - Página não encontrada</h2>";
        break;
}
