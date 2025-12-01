<?php include __DIR__ . '/../layout/header.php'; ?>

<h2>Login</h2>

<?php if (!empty($erro)) echo "<p style='color:red;'>$erro</p>"; ?>

<form method="post" action="/VendoRefri/public/index.php?route=cliente/login">
    <label>Email:</label>
    <input type="email" name="email" required><br><br>

    <label>Senha:</label>
    <input type="password" name="senha" required><br><br>

    <button type="submit">Entrar</button>
</form>

<p>Não tem conta? <a href="/VendoRefri/public/index.php?route=cliente/cadastro">Cadastre-se</a></p>

<?php include __DIR__ . '/../layout/footer.php'; ?>
