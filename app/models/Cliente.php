<?php
// app/models/Cliente.php

class Cliente {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Inserir novo cliente
    public function inserir($dados) {
        // Criptografa a senha se fornecida
        $senha = !empty($dados['senha']) ? md5($dados['senha']) : '';
        $stmt = $this->conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, 'cliente')");
        $stmt->execute([$dados['nome'], $dados['email'], $senha]);

        $usuario_id = $this->conn->lastInsertId();

        $stmt = $this->conn->prepare("INSERT INTO clientes (id, nome, email, telefone, endereco) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$usuario_id, $dados['nome'], $dados['email'], $dados['telefone'], $dados['endereco']]);

        return $usuario_id;
    }

    // Autenticar cliente
    public function autenticar($email, $senha) {
    $senha = md5($senha);
    $stmt = $this->conn->prepare("
        SELECT u.id, u.nome, u.email, u.tipo, c.telefone, c.endereco
        FROM usuarios u
        LEFT JOIN clientes c ON u.id = c.id
        WHERE u.email = ? AND u.senha = ?
        LIMIT 1
    ");
    $stmt->execute([$email, $senha]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // Buscar cliente pelo ID
    public function buscarPorId($id) {
        $stmt = $this->conn->prepare("
            SELECT u.id, u.nome, u.email, c.telefone, c.endereco
            FROM usuarios u
            INNER JOIN clientes c ON u.id = c.id
            WHERE u.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Atualizar dados do cliente
    public function atualizar($id, $dados) {
        // Atualiza senha somente se fornecida
        if (!empty($dados['senha'])) {
            $senha = md5($dados['senha']);
            $stmt = $this->conn->prepare("UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?");
            $stmt->execute([$dados['nome'], $dados['email'], $senha, $id]);
        } else {
            $stmt = $this->conn->prepare("UPDATE usuarios SET nome = ?, email = ? WHERE id = ?");
            $stmt->execute([$dados['nome'], $dados['email'], $id]);
        }

        $stmt = $this->conn->prepare("UPDATE clientes SET telefone = ?, endereco = ? WHERE id = ?");
        $stmt->execute([$dados['telefone'], $dados['endereco'], $id]);
    }
}
