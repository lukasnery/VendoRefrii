<?php
// app/models/Pedido.php
class Pedido {
private $pdo;
public function __construct($pdo) { $this->pdo = $pdo; }


public function criar($cliente_id, $itens, $total) {
try {
$this->pdo->beginTransaction();
$stmt = $this->pdo->prepare("INSERT INTO pedidos (cliente_id, total) VALUES (?,?)");
$stmt->execute([$cliente_id, $total]);
$pedido_id = $this->pdo->lastInsertId();


$itensStmt = $this->pdo->prepare("INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unitario) VALUES (?,?,?,?)");
$updateEst = $this->pdo->prepare("UPDATE produtos SET estoque = estoque - ? WHERE id = ? AND estoque >= ?");


foreach ($itens as $item) {
// verifica estoque
$check = $this->pdo->prepare("SELECT estoque FROM produtos WHERE id = ?");
$check->execute([$item['id']]);
$row = $check->fetch();
if (!$row || $row['estoque'] < $item['qtd']) {
throw new Exception('Estoque insuficiente para o produto ' . $item['nome']);
}
$itensStmt->execute([$pedido_id, $item['id'], $item['qtd'], $item['preco']]);
$updateEst->execute([$item['qtd'], $item['id'], $item['qtd']]);
}


$this->pdo->commit();
return $pedido_id;
} catch (Exception $e) {
$this->pdo->rollBack();
throw $e;
}
}
}