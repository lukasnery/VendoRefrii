<?php
// app/models/Usuario.php
class Usuario {
    private $pdo;
    public function __construct($pdo) { $this->pdo = $pdo; }

    public function autenticar($usuario, $senha) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $row = $stmt->fetch();
        if (!$row) return false;
        // senha armazenada como md5 (inserida no SQL) ou password_hash — permitimos md5 ou password
        if (strlen($row['senha'])==32) { // md5 legacy
            if (md5($senha) === $row['senha']) return $row;
        }
        if (password_verify($senha, $row['senha'])) return $row;
        return false;
    }
}