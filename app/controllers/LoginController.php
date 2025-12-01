<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = md5($_POST['senha'] ?? '');

    // Consultar na tabela usuarios
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? AND senha = ?");
    $stmt->execute([$email, $senha]);
    $usuario = $stmt->fetch();

    if ($usuario) {
        $_SESSION['cliente_id'] = $usuario['id'];
        $_SESSION['cliente_nome'] = $usuario['nome'];
        $_SESSION['cliente_tipo'] = $usuario['tipo'];

        header("Location: /VendoRefri/public/index.php?route=home");
        exit;
    } else {
        $erro = "Email ou senha incorretos!";
    }
}

include __DIR__ . '/../../views/cliente/login.php';
