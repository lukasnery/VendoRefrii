<?php include __DIR__ . '/../layout/header.php'; ?>

<h2>Todos os Produtos</h2>

<div style="display:flex; gap:20px; flex-wrap:wrap;">

<?php foreach ($produtos as $produto): ?>
    <div style="border:1px solid #ccc; padding:15px; width:200px; text-align:center; border-radius:10px;">
        <h3><?= htmlspecialchars($produto['nome']) ?></h3>
        <p>R$ <?= number_format($produto['preco'],2,',','.') ?></p>
        <form method="post" action="/VendoRefri/public/index.php?route=pedido/adicionar">
            <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
            <label>Qtd:</label>
            <input type="number" name="quantidade" value="1" min="1">
            <button type="submit">Adicionar ao Carrinho</button>
        </form>
    </div>
<?php endforeach; ?>

</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
