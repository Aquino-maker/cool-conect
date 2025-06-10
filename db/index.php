<?php

include('/laragon/www/Preparacao-para-ADE/back-end/conexao.php');

$pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    name_user VARCHAR(100) NOT NULL,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    pass VARCHAR(255) NOT NULL
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS organizadores (
    id_org INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    name_fugleman VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    type_org ENUM('Pessoa Física', 'Empresa') DEFAULT 'Pessoa Física',
    FOREIGN KEY (id_user) REFERENCES usuarios(id_user) ON DELETE CASCADE
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS eventos (
    id_event INT AUTO_INCREMENT PRIMARY KEY,
    id_org INT NOT NULL,
    name_event VARCHAR(100),
    description_event TEXT,
    start_date_event DATETIME NOT NULL,
    end_date DATETIME,
    event_location VARCHAR(255),
    address_event VARCHAR(255),
    city VARCHAR(100),
    event_type ENUM('Presencial', 'Online', 'Híbrido') DEFAULT 'Presencial',
    capacity INT, 
    price DECIMAL(10,2) DEFAULT 0.00,
    image_event VARCHAR(255), -- campo para o caminho da imagem
    status_event ENUM('Ativo', 'Cancelado', 'Encerrado') DEFAULT 'Ativo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_org) REFERENCES organizadores(id_org) ON DELETE CASCADE
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS interacoes (
    id_interactions INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_event INT NOT NULL,
    tipo ENUM('like', 'subscribe', 'favorite') NOT NULL,
    UNIQUE (id_user, id_event, tipo),
    FOREIGN KEY (id_user) REFERENCES usuarios(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_event) REFERENCES eventos(id_event) ON DELETE CASCADE
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS comentarios (
    id_comment INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_event INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES usuarios(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_event) REFERENCES eventos(id_event) ON DELETE CASCADE
)");
