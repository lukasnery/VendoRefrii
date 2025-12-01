<?php
include __DIR__ . '/../layout/header.php';
?>

<h2>Cadastro</h2>

<form method="post" action="/VendoRefri/public/index.php?route=cliente/cadastro">
    <label>Nome:</label><br>
    <input type="text" name="nome" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Senha:</label><br>
    <input type="password" name="senha" required><br><br>

    <button type="submit">Cadastrar</button>
</form>

<?php include __DIR__ . '/../layout/footer.php'; ?>
