<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meu Perfil - VendoRefri</title>
    <link rel="stylesheet" href="/VendoRefri/public/style.css">
    <style>
        body { font-family: Arial, sans-serif; margin:0; padding:0; background:#f4f4f4; }
        header { background:#0099cc; color:white; padding:15px; text-align:center; }
        header nav a { color:white; margin:0 10px; text-decoration:none; font-weight:bold; }
        header nav a:hover { text-decoration:underline; }
        main { padding:20px; min-height: 80vh; display:flex; justify-content:center; align-items:center; }
        footer { text-align:center; padding:10px; background:#222; color:white; margin-top:20px; }

        .perfil-form {
            width: 100%;
            max-width: 500px;
            background: #f9f9f9;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .perfil-form div { margin-bottom: 15px; }
        .perfil-form label { display:block; margin-bottom:5px; font-weight:bold; }
        .perfil-form input { width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #ccc; }
        .perfil-form button {
            width: 100%;
            padding: 12px;
            background: #0099cc;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .perfil-form button:hover { background: #0077aa; }
        .mensagem { color: green; font-weight: bold; text-align:center; margin-bottom: 15px; }
    </style>
</head>
<body>

<header>
    <h1>VendoRefri</h1>
    <nav>
        <a href="/VendoRefri/public/">Home</a>
        <a href="/VendoRefri/public/index.php?route=produtos">Produtos</a>

        <?php if (!empty($_SESSION['cliente_id'])): ?>
            <a href="/VendoRefri/public/index.php?route=cliente/perfil">Meu Perfil</a>
            <a href="/VendoRefri/public/index.php?route=pedido/carrinho">Carrinho</a>
            <a href="/VendoRefri/public/index.php?route=logout">Sair</a>
        <?php else: ?>
            <a href="/VendoRefri/public/index.php?route=cliente/login">Login</a>
            <a href="/VendoRefri/public/index.php?route=cliente/cadastro">Cadastro</a>
        <?php endif; ?>

        <?php if (!empty($_SESSION['admin_id'])): ?>
            <a href="/VendoRefri/public/index.php?route=admin/dashboard">Painel Administrativo</a>
        <?php endif; ?>
    </nav>
</header>

<main>
    <form method="post" class="perfil-form">
        <h2 style="text-align:center; margin-bottom:20px;">Meu Perfil</h2>

        <?php if (!empty($mensagem)) : ?>
            <div class="mensagem"><?= htmlspecialchars($mensagem) ?></div>
        <?php endif; ?>

        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($cliente['nome']) ?>" required>
        </div>

        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($cliente['email']) ?>" required>
        </div>

        <div>
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" value="<?= htmlspecialchars($cliente['telefone']) ?>">
        </div>

        <div>
            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" value="<?= htmlspecialchars($cliente['endereco']) ?>">
        </div>

        <div>
            <label for="senha">Nova Senha (deixe em branco para manter):</label>
            <input type="password" id="senha" name="senha">
        </div>

        <button type="submit">Atualizar</button>
    </form>
</main>

<footer>
    &copy; <?= date('Y') ?> VendoRefri
</footer>

</body>
</html>
