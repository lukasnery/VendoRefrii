<?php
if (session_status() == PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['cliente_id'])) {
    header("Location: /VendoRefri/public/index.php?route=cliente/login");
    exit;
}

$erro = '';
$sucesso = '';

$cliente_id = $_SESSION['cliente_id'];

// Buscar dados atuais
$stmt = $pdo->prepare("SELECT c.*, u.email, u.senha FROM clientes c JOIN usuarios u ON u.id = c.id WHERE c.id = ?");
$stmt->execute([$cliente_id]);
$cliente = $stmt->fetch();

// Atualizar dados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? $cliente['nome'];
    $email = $_POST['email'] ?? $cliente['email'];
    $telefone = $_POST['telefone'] ?? $cliente['telefone'];
    $endereco = $_POST['endereco'] ?? $cliente['endereco'];
    $senha = $_POST['senha'] ?? '';

    // Atualizar clientes
    $stmt = $pdo->prepare("UPDATE clientes SET nome = ?, telefone = ?, endereco = ? WHERE id = ?");
    $stmt->execute([$nome, $telefone, $endereco, $cliente_id]);

    // Atualizar usuarios
    if (!empty($senha)) {
        $senha_hash = md5($senha);
        $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?");
        $stmt->execute([$nome, $email, $senha_hash, $cliente_id]);
    } else {
        $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ? WHERE id = ?");
        $stmt->execute([$nome, $email, $cliente_id]);
    }

    $_SESSION['cliente_nome'] = $nome;
    $sucesso = "Dados atualizados com sucesso!";
}

// Incluir view
include __DIR__ . '/../../views/cliente/perfil.php';
