<?php include __DIR__ . '/../layout/header.php'; ?>

<h2>Seu Carrinho</h2>

<?php if (empty($carrinho)): ?>
    <p>O carrinho está vazio.</p>
<?php else: ?>
<form method="post" action="/VendoRefri/public/index.php?route=pedido/carrinho">
<table border="1" cellpadding="5">
    <tr>
        <th>Produto</th>
        <th>Qtd</th>
        <th>Preço</th>
        <th>Total</th>
        <th>Ação</th>
    </tr>
    <?php $total=0; foreach ($carrinho as $id => $item): 
        $subtotal = $item['preco'] * $item['quantidade'];
        $total += $subtotal;
    ?>
    <tr>
        <td><?= htmlspecialchars($item['nome']) ?></td>
        <td>
            <input type="number" name="quantidade[<?= $id ?>]" value="<?= $item['quantidade'] ?>" min="1" style="width:50px;">
        </td>
        <td>R$ <?= number_format($item['preco'],2,',','.') ?></td>
        <td>R$ <?= number_format($subtotal,2,',','.') ?></td>
        <td><a href="/VendoRefri/public/index.php?route=pedido/remover&id=<?= $id ?>">Remover</a></td>
    </tr>
    <?php endforeach; ?>
</table>

<p><strong>Total: R$ <?= number_format($total,2,',','.') ?></strong></p>

<button type="submit" name="atualizar">Atualizar Quantidade</button>
</form>

<form method="post" action="/VendoRefri/public/index.php?route=pedido/finalizar">
    <button type="submit">Finalizar Pedido</button>
</form>

<?php if(!empty($erro)): ?>
    <p style="color:red;"><?= htmlspecialchars($erro) ?></p>
<?php endif; ?>

<?php endif; ?>

<?php include __DIR__ . '/../layout/footer.php'; ?>
