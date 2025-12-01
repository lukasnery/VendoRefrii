<?php include __DIR__ . '/../layout/header.php'; ?>

<main style="display:flex; justify-content:center; align-items:center; height:80vh;">
    <div style="background:white; padding:30px; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.2); width:300px; text-align:center;">
        <h2>Login Admin</h2>

        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

        <form method="post" action="/VendoRefri/public/index.php?route=admin/login">
            <label>Email:</label><br>
            <input type="email" name="email" required style="width:100%; padding:8px; margin:8px 0;"><br>

            <label>Senha:</label><br>
            <input type="password" name="senha" required style="width:100%; padding:8px; margin:8px 0;"><br>

            <button type="submit" style="width:100%; padding:10px; background:#f44336; color:white; border:none; border-radius:5px; cursor:pointer;">Entrar</button>
        </form>
    </div>
</main>

<?php include __DIR__ . '/../layout/footer.php'; ?>
