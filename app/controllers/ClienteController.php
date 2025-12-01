<?php
// app/controllers/ClienteController.php
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../models/Cliente.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$conn = Database::getInstance();
$clienteModel = new Cliente($conn);

$action = $_GET['action'] ?? 'login';

switch ($action) {

    // LOGIN
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $cliente = $clienteModel->autenticar($email, $senha);

            if ($cliente) {
                $_SESSION['cliente_id']   = $cliente['id'];
                $_SESSION['cliente_nome'] = $cliente['nome'];
                $_SESSION['cliente_tipo'] = 'cliente'; // Sempre cliente aqui

                header('Location: ../public/index.php?route=produtos');
                exit;
            } else {
                $error = 'Email ou senha inválidos';
            }
        }
        require __DIR__ . '/../../views/cliente/login.php';
        break;

    // PERFIL
    case 'perfil':
        if (empty($_SESSION['cliente_id'])) {
            header('Location: ../public/index.php?route=cliente/login');
            exit;
        }

        $cliente_id = $_SESSION['cliente_id'];
        $cliente = $clienteModel->buscarPorId($cliente_id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome'     => $_POST['nome'],
                'email'    => $_POST['email'],
                'telefone' => $_POST['telefone'] ?? '',
                'endereco' => $_POST['endereco'] ?? '',
                'senha'    => $_POST['senha'] ?? null
            ];
            $clienteModel->atualizar($cliente_id, $dados);
            $_SESSION['cliente_nome'] = $dados['nome'];
            $success = 'Perfil atualizado com sucesso!';
            $cliente = $clienteModel->buscarPorId($cliente_id); // Recarrega dados
        }

        require __DIR__ . '/../../views/cliente/perfil.php';
        break;

    // LOGOUT
    case 'logout':
        session_destroy();
        header('Location: ../public/index.php');
        exit;

    // CADASTRO
    case 'cadastro':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome'     => $_POST['nome'],
                'email'    => $_POST['email'],
                'senha'    => $_POST['senha'],
                'telefone' => $_POST['telefone'] ?? '',
                'endereco' => $_POST['endereco'] ?? '',
                'tipo'     => 'cliente'
            ];
            $clienteModel->inserir($dados);
            header('Location: ../public/index.php?route=cliente/login');
            exit;
        }
        require __DIR__ . '/../../views/cliente/cadastro.php';
        break;

    default:
        echo "<h2>Ação inválida</h2>";
        break;
}
