<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>VendoRefri</title>
    <link rel="stylesheet" href="/VendoRefri/public/style.css">
    <style>
        body { font-family: Arial, sans-serif; margin:0; padding:0; background:#f4f4f4; }
        header { background:#0099cc; color:white; padding:15px; text-align:center; }
        header nav a { color:white; margin:0 10px; text-decoration:none; font-weight:bold; }
        header nav a:hover { text-decoration:underline; }
        main { padding:20px; }
        footer { text-align:center; padding:10px; background:#222; color:white; margin-top:20px; }
        .produto-card { background:white; border:1px solid #ccc; border-radius:10px; padding:15px; width:200px; text-align:center; }
        .produtos-container { display:flex; flex-wrap:wrap; gap:20px; justify-content:flex-start; }
        .produto-card button { background:#0099cc; color:white; border:none; padding:8px 12px; border-radius:5px; cursor:pointer; }
        .produto-card button:hover { background:#0077aa; }
        a.botao-ver-todos { display:inline-block; margin-top:20px; padding:10px 15px; background:#0099cc; color:white; border-radius:5px; text-decoration:none; }
        a.botao-ver-todos:hover { background:#0077aa; }
        table { border-collapse: collapse; width: 100%; max-width:600px; margin-top:20px;}
        table, th, td { border:1px solid #ccc; }
        th, td { padding:10px; text-align:center; }
        form input[type=number]{ width:50px; }
    </style>
</head>
<body>
<header>
    <h1>VendoRefri</h1>
    <nav>
    <a href="/VendoRefri/public/">Home</a>
    <a href="/VendoRefri/public/index.php?route=produtos">Produtos</a>

    <!-- Se cliente está logado -->
    <?php if (!empty($_SESSION['cliente_id'])): ?>
        <a href="/VendoRefri/public/index.php?route=cliente/perfil">Meu Perfil</a>
        <a href="/VendoRefri/public/index.php?route=pedido/carrinho">Carrinho</a>
        <a href="/VendoRefri/public/index.php?route=cliente/logout">Sair</a>

    <?php else: ?>
        <!-- Visitante -->
        <a href="/VendoRefri/public/index.php?route=cliente/login">Login</a>
        <a href="/VendoRefri/public/index.php?route=cliente/cadastro">Cadastro</a>
    <?php endif; ?>

    <!-- Acesso do ADMIN -->
    <?php if (!empty($_SESSION['admin_id'])): ?>
        <a href="/VendoRefri/public/index.php?route=admin/dashboard">Painel Administrativo</a>
        <a href="/VendoRefri/public/index.php?route=admin/logout">Sair Admin</a>
    <?php else: ?>
        <a href="/VendoRefri/public/index.php?route=admin/login" style="color:#FFD700;">Login Admin</a>
    <?php endif; ?>
</nav>

</header>
<main>
