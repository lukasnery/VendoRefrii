<?php

require_once __DIR__ . '/../core/Database.php';

// A sessão já deve estar no index.php, então não inicia aqui

// Aqui a conexão está correta
$conn = Database::getInstance();  // <-- JÁ É O PDO

$action = $_GET['action'] ?? 'login';

switch ($action) {

    // LOGIN ADMIN
    case 'login':
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $senha_md5 = md5($senha);

            $stmt = $conn->prepare("SELECT id, nome FROM usuarios WHERE email = ? AND senha = ? AND tipo = 'admin'");
            $stmt->execute([$email, $senha_md5]);

            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_nome'] = $admin['nome'];

                header("Location: /VendoRefri/public/index.php?route=admin/dashboard");
                exit;
            } else {
                $error = 'Email ou senha inválidos';
            }
        }

        require __DIR__ . '/../../views/admin/login.php';
        break;

    // DASHBOARD ADMIN
    case 'dashboard':
        if (empty($_SESSION['admin_id'])) {
            header("Location: /VendoRefri/public/index.php?route=admin/login");
            exit;
        }

        $stmt = $conn->query("SELECT COUNT(*) as total FROM produtos");
        $totalProdutos = $stmt->fetch()['total'] ?? 0;

        $stmt = $conn->query("SELECT COUNT(*) as total FROM clientes");
        $totalClientes = $stmt->fetch()['total'] ?? 0;

        $stmt = $conn->query("SELECT COUNT(*) as total FROM pedidos");
        $totalPedidos = $stmt->fetch()['total'] ?? 0;

        $stmt = $conn->query("SELECT SUM(total) as faturamento FROM pedidos");
        $faturamento = $stmt->fetch()['faturamento'] ?? 0.00;

        require __DIR__ . '/../../views/admin/dashboard.php';
        break;

    // LOGOUT
    case 'logout':
        session_destroy();
        header("Location: /VendoRefri/public/index.php?route=admin/login");
        exit;

    default:
        echo "<h2>Ação inválida</h2>";
        break;
}
