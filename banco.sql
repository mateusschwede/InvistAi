CREATE DATABASE invistai CHARSET=utf8;
USE invistai;

CREATE TABLE pessoa (
    cpf VARCHAR(11) NOT NULL, /*PK*/
    nome VARCHAR(60) NOT NULL,
    email VARCHAR(60),
    telefone VARCHAR(11),
    senha VARCHAR(5) NOT NULL,
    tipo INT NOT NULL DEFAULT 2, /*1-Analista, 2-Cliente*/
    ativo BOOLEAN NOT NULL DEFAULT 1
);

CREATE TABLE acao (
    codigo VARCHAR(5) NOT NULL, /*PK*/
    cnpj VARCHAR(12) NOT NULL,
    nome VARCHAR(60) NOT NULL,
    atividade VARCHAR(60) NOT NULL,
    setor VARCHAR(60) NOT NULL,
    preco FLOAT NOT NULL,
    ativo BOOLEAN NOT NULL DEFAULT 1
);

CREATE TABLE carteira (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(60) NOT NULL,
    precoInvestimento FLOAT NOT NULL,
    cpfCliente VARCHAR(11) NOT NULL /*FK*/
);

CREATE TABLE carteira_acao (
    idCarteira INT NOT NULL, /*FK*/
    codAcao VARCHAR(5) NOT NULL, /*FK*/
    percentual INT NOT NULL,
    precoPercentual FLOAT NOT NULL,
    qtdAcoes INT,
    nPercentual INT
);

