<?php
include __DIR__ . '/layout/header.php';
require_once __DIR__ . '/../app/config/database.php';

// Busca produtos em destaque (3 mais recentes)
$stmt = $pdo->query("SELECT * FROM produtos ORDER BY criado_em DESC LIMIT 3");
$produtosDestaque = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Bem-vindo à VendoRefri!</h2>
<p>Confira nossos produtos em destaque:</p>

<div class="produtos-container">
<?php foreach($produtosDestaque as $produto): ?>
    <div class="produto-card">
        <h3><?= htmlspecialchars($produto['nome']) ?></h3>
        <p>R$ <?= number_format($produto['preco'],2,',','.') ?></p>
        <form method="post" action="/VendoRefri/public/index.php?route=pedido/adicionar">
            <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
            <label>Qtd:</label>
            <input type="number" name="quantidade" value="1" min="1">
            <br><br>
            <button type="submit">Adicionar ao Carrinho</button>
        </form>
    </div>
<?php endforeach; ?>
</div>

<a href="/VendoRefri/public/index.php?route=produtos" class="botao-ver-todos">Ver todos os produtos</a>

<?php include __DIR__ . '/layout/footer.php'; ?>
