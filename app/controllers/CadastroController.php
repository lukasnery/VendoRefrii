<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = md5($_POST['senha'] ?? ''); // ou password_hash
    $telefone = $_POST['telefone'] ?? '';
    $endereco = $_POST['endereco'] ?? '';

    try {
        // Inserir no usuarios
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, 'cliente')");
        $stmt->execute([$nome, $email, $senha]);
        $usuario_id = $pdo->lastInsertId();

        // Inserir no clientes
        $stmt = $pdo->prepare("INSERT INTO clientes (id, nome, email, telefone, endereco) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$usuario_id, $nome, $email, $telefone, $endereco]);

        // Criar sessão
        $_SESSION['cliente_id'] = $usuario_id; // id da tabela clientes
        $_SESSION['cliente_nome'] = $nome;

        header("Location: /VendoRefri/public/index.php?route=home");
        exit;

    } catch (PDOException $e) {
        $erro = "Erro ao cadastrar: " . $e->getMessage();
    }
}

include __DIR__ . '/../../views/cliente/cadastro.php';
