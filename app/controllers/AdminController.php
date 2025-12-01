<?php
// app/controllers/AdminController.php
require_once __DIR__ . '/../core/Database.php';

session_start();
$conn = Database::getInstance();

$action = $_GET['action'] ?? 'login';

switch ($action) {

    // LOGIN ADMIN
    case 'login':
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $senha_md5 = md5($senha); // Certifique-se que no banco a senha está em MD5

            // Busca admin no banco
            $stmt = $conn->prepare("SELECT id, nome FROM usuarios WHERE email = ? AND senha = ? AND tipo = 'admin'");
            $stmt->execute([$email, $senha_md5]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_nome'] = $admin['nome'];
                header('Location: ../public/index.php?route=admin/dashboard');
                exit;
            } else {
                $error = 'Email ou senha inválidos';
            }
        }

        // Carregar view de login admin
        require __DIR__ . '/../../views/admin/login.php';
        break;

    // DASHBOARD ADMIN
    case 'dashboard':
        if (empty($_SESSION['admin_id'])) {
            header('Location: ../public/index.php?route=admin/login');
            exit;
        }

        // Exemplo de dados do dashboard
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

    // LOGOUT ADMIN
    case 'logout':
        session_destroy();
        header('Location: ../public/index.php?route=admin/login');
        exit;

    default:
        echo "<h2>Ação inválida</h2>";
        break;
}
