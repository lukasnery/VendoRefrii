<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$route = $_GET['route'] ?? 'pedido';

switch ($route) {

    // Adicionar produto ao carrinho
    case 'pedido/adicionar':
        $produto_id = $_POST['produto_id'] ?? null;
        $quantidade = $_POST['quantidade'] ?? 1;

        if (!$produto_id) {
            die("Produto não especificado!");
        }

        // Buscar produto no banco
        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
        $stmt->execute([$produto_id]);
        $produto = $stmt->fetch();

        if (!$produto) {
            die("Produto não encontrado!");
        }

        // Inicializar carrinho
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        // Se já existe no carrinho, somar quantidade
        if (isset($_SESSION['carrinho'][$produto_id])) {
            $_SESSION['carrinho'][$produto_id]['quantidade'] += $quantidade;
        } else {
            $_SESSION['carrinho'][$produto_id] = [
                'id' => $produto['id'],
                'nome' => $produto['nome'],
                'preco' => $produto['preco'],
                'quantidade' => $quantidade
            ];
        }

        header("Location: /VendoRefri/public/index.php?route=pedido/carrinho");
        exit;
        break;

    // Mostrar carrinho
    case 'pedido/carrinho':
        $carrinho = $_SESSION['carrinho'] ?? [];
        include __DIR__ . '/../../views/pedido/carrinho.php';
        break;

    // Remover item do carrinho
    case 'pedido/remover':
        $produto_id = $_GET['id'] ?? null;
        if ($produto_id && isset($_SESSION['carrinho'][$produto_id])) {
            unset($_SESSION['carrinho'][$produto_id]);
        }
        header("Location: /VendoRefri/public/index.php?route=pedido/carrinho");
        exit;
        break;

    case 'pedido/finalizar':
    if (!isset($_SESSION['cliente_id']) || empty($_SESSION['carrinho'])) {
        die("Carrinho vazio ou usuário não logado!");
    }

    $total = 0;
    foreach ($_SESSION['carrinho'] as $item) {
        $total += $item['preco'] * $item['quantidade'];
    }

    // Inserir pedido usando cliente_id correto
    $stmt = $pdo->prepare("INSERT INTO pedidos (cliente_id, total, status) VALUES (?, ?, 'Pendente')");
    $stmt->execute([$_SESSION['cliente_id'], $total]);
    $pedido_id = $pdo->lastInsertId();

    // Inserir itens do pedido
    foreach ($_SESSION['carrinho'] as $item) {
        $stmt = $pdo->prepare("INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unit) VALUES (?, ?, ?, ?)");
        $stmt->execute([$pedido_id, $item['id'], $item['quantidade'], $item['preco']]);
    }

    unset($_SESSION['carrinho']);

    echo "<h2>Pedido finalizado com sucesso!</h2>";
    echo "<a href='/VendoRefri/public/index.php?route=home'>Voltar para Home</a>";
    break;


    default:
        echo "<h2>404 - Página de pedidos não encontrada</h2>";
        break;
}
