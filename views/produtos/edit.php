<?php include __DIR__ . '/../layout/header.php'; ?>
<h2>Editar Produto</h2>

<form method="post" enctype="multipart/form-data">
    <label>Nome: <input type="text" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required></label><br>
    <label>Descrição: <textarea name="descricao"><?= htmlspecialchars($produto['descricao']) ?></textarea></label><br>
    <label>Preço: <input type="number" step="0.01" name="preco" value="<?= $produto['preco'] ?>" required></label><br>
    <label>Estoque: <input type="number" name="estoque" value="<?= $produto['estoque'] ?>" required></label><br>
    <button type="submit">Atualizar</button>
</form>

<?php include __DIR__ . '/../layout/footer.php'; ?>
