<?php
// app/controllers/ProdutoController.php
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../models/Produto.php';

$produtoModel = new Produto($pdo);
$action = $_GET['action'] ?? 'index';

switch ($action) {

    case 'index': // listar produtos
        $produtos = $produtoModel->listar();
        require __DIR__ . '/../../views/produtos/index.php';
        break;

    case 'create': // novo produto
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome' => $_POST['nome'],
                'descricao' => $_POST['descricao'],
                'preco' => $_POST['preco'],
                'estoque' => $_POST['estoque'],
                'imagem' => $_FILES['imagem']['name'] ?? 'semfoto.png'
            ];

            // upload simples (salva em public/img)
            if (!empty($_FILES['imagem']['tmp_name'])) {
                $destino = __DIR__ . '/../../public/img/' . basename($_FILES['imagem']['name']);
                move_uploaded_file($_FILES['imagem']['tmp_name'], $destino);
            }

            $produtoModel->inserir($dados);
            header('Location: ../public/index.php?route=produtos');
            exit;
        }
        require __DIR__ . '/../../views/produtos/create.php';
        break;

    case 'edit': // editar produto
        $id = $_GET['id'] ?? null;
        if (!$id) { die('ID do produto não informado.'); }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome' => $_POST['nome'],
                'descricao' => $_POST['descricao'],
                'preco' => $_POST['preco'],
                'estoque' => $_POST['estoque'],
                'imagem' => $_FILES['imagem']['name'] ?? 'semfoto.png'
            ];

            if (!empty($_FILES['imagem']['tmp_name'])) {
                $destino = __DIR__ . '/../../public/img/' . basename($_FILES['imagem']['name']);
                move_uploaded_file($_FILES['imagem']['tmp_name'], $destino);
            }

            $produtoModel->atualizar($id, $dados);
            header('Location: ../public/index.php?route=produtos');
            exit;
        }

        $produto = $produtoModel->buscar($id);
        require __DIR__ . '/../../views/produtos/edit.php';
        break;

    case 'delete': // excluir produto
        $id = $_GET['id'] ?? null;
        if ($id) $produtoModel->excluir($id);
        header('Location: ../public/index.php?route=produtos');
        break;
}
