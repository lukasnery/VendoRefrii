-- Criar o banco de dados
CREATE DATABASE IF NOT EXISTS vendo_refri CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE vendo_refri;

-- ======================
-- TABELA: usuarios
-- ======================
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('admin','cliente') DEFAULT 'cliente',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO usuarios (nome, email, senha, tipo)
VALUES 
('Administrador', 'admin@vendorefri.com', MD5('123456'), 'admin'),
('Lucas', 'lucas@cliente.com', MD5('123456'), 'cliente');

-- ======================
-- TABELA: produtos
-- ======================
CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    estoque INT DEFAULT 0,
    imagem VARCHAR(255),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO produtos (nome, descricao, preco, estoque, imagem) VALUES
('Coca-Cola Lata 350ml', 'Refrigerante tradicional da Coca-Cola', 4.50, 100, 'coca.jpg'),
('Guaraná Antarctica 2L', 'Guaraná clássico em garrafa 2 litros', 8.99, 50, 'guarana.jpg'),
('Água Mineral 500ml', 'Sem gás, natural', 2.00, 200, 'agua.jpg');

-- ======================
-- TABELA: clientes
-- ======================
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefone VARCHAR(20),
    endereco VARCHAR(255),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO clientes (nome, email, telefone, endereco) VALUES
('João da Silva', 'joao@email.com', '44999999999', 'Rua das Flores, 123'),
('Maria Oliveira', 'maria@email.com', '44988888888', 'Av. Brasil, 45');

-- ======================
-- TABELA: pedidos
-- ======================
CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    status ENUM('Pendente','Pago','Enviado','Concluído','Cancelado') DEFAULT 'Pendente',
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE
);

INSERT INTO pedidos (cliente_id, total, status) VALUES
(1, 17.98, 'Pago'),
(2, 9.00, 'Pendente');

-- ======================
-- TABELA: itens_pedido
-- ======================
CREATE TABLE IF NOT EXISTS itens_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unit DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
);

INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unit) VALUES
(1, 1, 2, 4.50),
(1, 3, 1, 2.00),
(2, 2, 1, 9.00);
