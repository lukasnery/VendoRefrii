-- ARQUIVO COMPLETO DO PROJETO VENDO_REFRI
DROP DATABASE IF EXISTS vendo_refri;
CREATE DATABASE vendo_refri DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE vendo_refri;

-- --------------------------------------------------------
-- TABELA clientes
CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(20),
  `endereco` varchar(255),
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB;

INSERT INTO clientes VALUES
(1,'João da Silva','joao@email.com','44999999999','Rua das Flores, 123','2025-11-10 23:40:35'),
(2,'Maria Oliveira','maria@email.com','44988888888','Av. Brasil, 45','2025-11-10 23:40:35'),
(7,'roberto','roberto@gmail.com','','','2025-12-01 03:05:27');

-- --------------------------------------------------------
-- TABELA produtos
CREATE TABLE `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text,
  `preco` decimal(10,2) NOT NULL,
  `estoque` int(11) DEFAULT 0,
  `imagem` varchar(255),
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

INSERT INTO produtos VALUES
(1,'Coca-Cola Lata 350ml','Refrigerante tradicional da Coca-Cola',4.50,100,'coca.jpg','2025-11-10 23:40:35'),
(2,'Guaraná Antarctica 2L','Guaraná clássico em garrafa 2 litros',8.99,50,'guarana.jpg','2025-11-10 23:40:35'),
(3,'Água Mineral 500ml','Sem gás, natural',2.00,200,'agua.jpg','2025-11-10 23:40:35');

-- --------------------------------------------------------
-- TABELA pedidos
CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `data_pedido` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `status` enum('Pendente','Pago','Enviado','Concluído','Cancelado') DEFAULT 'Pendente',
  PRIMARY KEY (`id`),
  KEY `cliente_id` (`cliente_id`),
  CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO pedidos VALUES
(1,1,'2025-11-10 23:40:36',17.98,'Pago'),
(2,2,'2025-11-10 23:40:36',9.00,'Pendente');

-- --------------------------------------------------------
-- TABELA itens_pedido
CREATE TABLE `itens_pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unit` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pedido_id` (`pedido_id`),
  KEY `produto_id` (`produto_id`),
  CONSTRAINT `itens_pedido_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `itens_pedido_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO itens_pedido VALUES
(1,1,1,2,4.50),
(2,1,3,1,2.00),
(3,2,2,1,9.00);

-- --------------------------------------------------------
-- TABELA usuarios
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` enum('admin','cliente') DEFAULT 'cliente',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB;

INSERT INTO usuarios VALUES
(1,'Administrador','admin@vendorefri.com','e10adc3949ba59abbe56e057f20f883e','admin','2025-11-10 23:40:35'),
(7,'roberto','roberto@gmail.com','c1bfc188dba59d2681648aa0e6ca8c8e','cliente','2025-12-01 03:05:27');

-- --------------------------------------------------------
-- TABELA auditoria_preco
CREATE TABLE `auditoria_preco` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    preco_antigo DECIMAL(10,2),
    preco_novo DECIMAL(10,2),
    alterado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- --------------------------------------------------------
-- TRIGGER auditoria
DELIMITER $$

CREATE TRIGGER trg_auditoria_preco
AFTER UPDATE ON produtos
FOR EACH ROW
BEGIN
    IF NEW.preco <> OLD.preco THEN
        INSERT INTO auditoria_preco (produto_id, preco_antigo, preco_novo)
        VALUES (OLD.id, OLD.preco, NEW.preco);
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------
-- PROCEDURE para inserção massiva
DELIMITER $$

CREATE PROCEDURE inserir_massivo_produtos(IN qtd INT)
BEGIN
    DECLARE i INT DEFAULT 1;
    WHILE i <= qtd DO
        INSERT INTO produtos (nome, descricao, preco, estoque, imagem)
        VALUES (
            CONCAT('Produto Teste ', i),
            'Inserido pela procedure massiva',
            ROUND(RAND() * 20 + 1, 2),
            FLOOR(RAND() * 200),
            'teste.jpg'
        );
        SET i = i + 1;
    END WHILE;
END$$

DELIMITER ;

-- --------------------------------------------------------
-- FUNÇÃO verificar estoque
DELIMITER $$

CREATE FUNCTION verificar_estoque(prod_id INT, qtd INT)
RETURNS VARCHAR(50)
DETERMINISTIC
BEGIN
    DECLARE est INT;
    SELECT estoque INTO est FROM produtos WHERE id = prod_id;

    IF est >= qtd THEN
        RETURN 'OK';
    ELSE
        RETURN 'INSUFICIENTE';
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------
-- ÍNDICES EXTRAS
CREATE INDEX idx_produto_nome ON produtos(nome);
CREATE INDEX idx_pedidos_cliente ON pedidos(cliente_id);
CREATE INDEX idx_itens_pedido_produto ON itens_pedido(produto_id);

