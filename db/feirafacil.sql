CREATE DATABASE feirafacil DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE feirafacil;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (name, email, password) VALUES
('João', 'joao@email.com', '123456'),
('Gabriel', 'gabriel@email.com', '123456'),
('Fábio', 'fabio@email.com', '123456');

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

INSERT INTO categories (name) VALUES
('Frutas'),
('Verduras'),
('Laticínios');

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idCategory INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (idCategory) REFERENCES categories(id)
);

INSERT INTO products (idCategory, name, price) VALUES
(1, 'Maçã Fuji', 6.00),
(2, 'Couve Manteiga', 3.20),
(3, 'Queijo Minas', 12.50);

CREATE TABLE markets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    participants VARCHAR(255) NOT NULL,
    durationTime VARCHAR(50) NOT NULL
);

INSERT INTO markets (name, address, participants, durationTime) VALUES
('Feira das Marias', 'Parque Eldorado, Eldorado do Sul', 'João, Gabriel', '4h'),
('Feira da AMAP', 'Parque Eldorado, Eldorado do Sul', 'Fábio, Gabriel', '3h'),
('Feira de Verduras', 'General Câmara, RS', 'João, Fábio', '5h');

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idUser INT NOT NULL,
    idMarket INT NOT NULL,
    totalValue DECIMAL(10,2) NOT NULL,
    status VARCHAR(50) DEFAULT 'pendente',
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idUser) REFERENCES users(id),
    FOREIGN KEY (idMarket) REFERENCES markets(id)
);

CREATE TABLE orderItems (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idOrder INT NOT NULL,
    idProduct INT NOT NULL,
    quantity INT NOT NULL,
    unitPrice DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (idOrder) REFERENCES orders(id),
    FOREIGN KEY (idProduct) REFERENCES products(id)
);

CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idUser INT NOT NULL,
    idProduct INT DEFAULT NULL,
    idMarket INT DEFAULT NULL,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idUser) REFERENCES users(id),
    FOREIGN KEY (idProduct) REFERENCES products(id),
    FOREIGN KEY (idMarket) REFERENCES markets(id)
);

CREATE TABLE addresses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idUser INT NOT NULL,
    street VARCHAR(100),
    number VARCHAR(10),
    neighborhood VARCHAR(100),
    city VARCHAR(100),
    state VARCHAR(2),
    postalCode VARCHAR(10),
    complement VARCHAR(100),
    FOREIGN KEY (idUser) REFERENCES users(id)
);

CREATE TABLE marketSchedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idMarket INT NOT NULL,
    dayOfWeek VARCHAR(15) NOT NULL,
    openTime TIME NOT NULL,
    closeTime TIME NOT NULL,
    FOREIGN KEY (idMarket) REFERENCES markets(id)
);

INSERT INTO marketSchedules (idMarket, dayOfWeek, openTime, closeTime) VALUES
(1, 'Sábado', '08:00:00', '12:00:00'),
(2, 'Domingo', '07:30:00', '11:00:00'),
(3, 'Quarta-feira', '14:00:00', '18:00:00');

CREATE TABLE productStock (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idProduct INT NOT NULL,
    quantityAvailable INT NOT NULL,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (idProduct) REFERENCES products(id)
);

INSERT INTO productStock (idProduct, quantityAvailable) VALUES
(1, 50),
(2, 30),
(3, 20);