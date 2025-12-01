<?php include __DIR__ . '/../layout/header.php'; ?>
<h2>Novo Produto</h2>

<form method="post" enctype="multipart/form-data">
    <label>Nome: <input type="text" name="nome" required></label><br>
    <label>Descrição: <textarea name="descricao"></textarea></label><br>
    <label>Preço: <input type="number" step="0.01" name="preco" required></label><br>
    <label>Estoque: <input type="number" name="estoque" required></label><br>
    <label>Imagem: <input type="file" name="imagem"></label><br>
    <button type="submit">Salvar</button>
</form>

<?php include __DIR__ . '/../layout/footer.php'; ?>
