<?php
class Produto {
private $pdo;
public function __construct($pdo) { $this->pdo = $pdo; }

public function listar() {
$stmt = $this->pdo->query("SELECT id,nome,descricao,preco,estoque,imagem FROM produtos ORDER BY nome");
return $stmt->fetchAll();
}

public function buscar($id) {
$stmt = $this->pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
return $stmt->fetch();
}

public function inserir($dados) {
$sql = "INSERT INTO produtos (nome, descricao, preco, estoque, imagem) VALUES (?,?,?,?,?)";
$stmt = $this->pdo->prepare($sql);
return $stmt->execute([
$dados['nome'],$dados['descricao'],$dados['preco'],$dados['estoque'],$dados['imagem']
]);
}

public function atualizar($id, $dados) {
$sql = "UPDATE produtos SET nome=?, descricao=?, preco=?, estoque=?, imagem=? WHERE id=?";
$stmt = $this->pdo->prepare($sql);
return $stmt->execute([
$dados['nome'],$dados['descricao'],$dados['preco'],$dados['estoque'],$dados['imagem'],$id
]);
}

public function excluir($id) {
$stmt = $this->pdo->prepare("DELETE FROM produtos WHERE id = ?");
return $stmt->execute([$id]);
}
}
