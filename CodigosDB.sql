CREATE DATABASE kbrtecpets;

CREATE TABLE animais (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    especie VARCHAR(255) NOT NULL,
    raca VARCHAR(255) NOT NULL,
    idade INT NOT NULL,
    peso DECIMAL(5,2),
    porte VARCHAR(50) NOT NULL,
    local VARCHAR(255) NOT NULL,
    sobre_pet TEXT,
    status ENUM('Ativo', 'Inativo') NOT NULL
);

CREATE TABLE solicitacoes_adocao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_animal INT NOT NULL,
    nome_solicitante VARCHAR(255) NOT NULL,
    cpf VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    celular VARCHAR(20) NOT NULL,
    data_nascimento DATE NOT NULL,
    data_insercao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_animal) REFERENCES animais(id)
);

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE senha_reset_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    expiracao TIMESTAMP NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);