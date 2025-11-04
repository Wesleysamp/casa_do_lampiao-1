-- Apagar e criar o banco de dados
DROP DATABASE IF EXISTS casa_do_lampiao;
CREATE DATABASE casa_do_lampiao;
USE casa_do_lampiao;

-- Tabela restaurante
CREATE TABLE restaurante (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    endereco VARCHAR(200),
    cidade VARCHAR(100),
    estado CHAR(2),
    telefone VARCHAR(20),
    email VARCHAR(100),
    horario_funcionamento VARCHAR(100)
);

INSERT INTO restaurante (nome, endereco, cidade, estado, telefone, email, horario_funcionamento)
VALUES (
    'Casa do Lampião',
    'Rua do Cangaço, 191',
    'Recife',
    'PE',
    '(81) 4002-8922',
    'contato@casadolampiao.com',
    'Seg a Dom: 11h às 23h'
);

-- Tabela categorias (para alimentos)
CREATE TABLE categorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50)
);

INSERT INTO categorias (nome) VALUES 
('Entrada'), 
('Prato Principal'), 
('Sobremesa');

-- Tabela cardápio alimentos
CREATE TABLE pratos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    descricao TEXT,
    preco DECIMAL(10,2),
    imagem VARCHAR(255),
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

-- Alimentos do cardápio
INSERT INTO pratos (nome, descricao, preco, imagem, categoria_id) VALUES
-- Entradas
('Cuscuz com Ovo', 'Cuscuz nordestino com ovo frito e manteiga de garrafa.', 14.90, 'cuscuz.jpg', 1),
('Bolinho de Macaxeira com Queijo Coalho', 'Bolinho frito crocante recheado com queijo.', 16.00, 'bolinho_macaxeira.jpg', 1),
('Pastel de Carne de Sol', 'Pastel recheado com carne de sol desfiada.', 12.00, 'pastel_carne.jpg', 1),

-- Pratos principais
('Baião de Dois', 'Arroz, feijão verde, queijo coalho e carne seca.', 29.90, 'baiao.jpg', 2),
('Carne de Sol com Macaxeira', 'Carne de sol na manteiga com macaxeira cozida.', 34.90, 'carne_sol.jpg', 2),
('Sarapatel', 'Prato tradicional feito com miúdos de porco e temperos fortes.', 27.00, 'sarapatel.jpg', 2),
('Moqueca de Peixe', 'Moqueca com peixe branco, leite de coco e azeite de dendê.', 38.50, 'moqueca.jpg', 2),
('Feijão Verde com Queijo Coalho', 'Feijão verde cremoso com cubos de queijo coalho.', 22.00, 'feijao_verde.jpg', 2),
('Dobradinha Nordestina', 'Bucho de boi cozido com feijão branco e temperos.', 25.00, 'dobradinha.jpg', 2),
('Escondidinho de Charque', 'Purê de macaxeira com charque desfiada gratinada.', 28.00, 'escondidinho.jpg', 2),

-- Sobremesas
('Tapioca de Coco com Leite Condensado', 'Tapioca doce com recheio cremoso.', 12.00, 'tapioca.jpg', 3),
('Cartola', 'Banana frita com queijo manteiga, açúcar e canela.', 11.00, 'cartola.jpg', 3),
('Bolo de Rolo', 'Camadas finas de massa com goiabada.', 9.00, 'bolo_rolo.jpg', 3),
('Pudim de Rapadura', 'Pudim feito com rapadura e leite de coco.', 10.00, 'pudim_rapadura.jpg', 3);

-- Tabela categorias_bebidas (nova tabela para categorias de bebidas)
CREATE TABLE categorias_bebidas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50)
);

INSERT INTO categorias_bebidas (nome) VALUES 
('Refrigerante'), 
('Suco'), 
('Cerveja'), 
('Cachaça'), 
('Outros');

-- Tabela bebidas 
CREATE TABLE bebidas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    descricao TEXT,
    preco DECIMAL(10,2),
    imagem VARCHAR(255),
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES categorias_bebidas(id)
);

-- Inserir bebidas
INSERT INTO bebidas (nome, descricao, preco, imagem, categoria_id) VALUES
('Suco de Caju', 'Suco natural de caju gelado.', 7.50, 'suco_caju.jpg', 2),
('Suco de Umbu', 'Suco típico feito com fruta do sertão.', 8.00, 'suco_umbu.jpg', 2),
('Guaraná Jesus', 'Refrigerante típico do Maranhão.', 6.00, 'guarana_jesus.jpg', 1),
('Cerveja Skol', 'Long neck gelada.', 6.50, 'skol.jpg', 3),
('Cachaça Artesanal do Sertão', 'Dose de cachaça regional.', 9.00, 'cachaca.jpg', 4),
('Água de Coco', 'Servida na própria fruta.', 5.00, 'agua_coco.jpg', 5);


-- Tabela clientes
CREATE TABLE clientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    telefone VARCHAR(20),
    data_cadastro DATE
);


-- Tabela pedidos
CREATE TABLE pedidos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    cliente_id INT,
    data_pedido DATETIME,
    status ENUM('Em preparo', 'Pronto', 'Entregue', 'Cancelado') DEFAULT 'Em preparo',
    total DECIMAL(10,2),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);

-- Itens do pedido: alimentos
CREATE TABLE itens_pedido (
    id INT PRIMARY KEY AUTO_INCREMENT,
    pedido_id INT,
    pratos_id INT,
    quantidade INT,
    preco_unitario DECIMAL(10,2),
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (pratos_id) REFERENCES pratos(id)
);

-- Itens do pedido: bebidas
CREATE TABLE itens_bebida (
    id INT PRIMARY KEY AUTO_INCREMENT,
    pedido_id INT,
    bebida_id INT,
    quantidade INT,
    preco_unitario DECIMAL(10,2),
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (bebida_id) REFERENCES bebidas(id)
);

-- Tabela avaliações
CREATE TABLE avaliacoes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    cliente_id INT,
    pratos_id INT,
    nota INT CHECK(nota BETWEEN 1 AND 5),
    comentario TEXT,
    data_avaliacao DATE,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id),
    FOREIGN KEY (pratos_id) REFERENCES pratos(id)
);

-- Tabela usuários admin (para login no painel de administração)
CREATE TABLE usuarios_admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    senha VARCHAR(255) -- Armazenar o hash da senha
);

INSERT INTO usuarios_admin (nome, email, senha) VALUES
('Admin Principal', 'admin@casadolampiao.com', SHA2('admin123', 256));
