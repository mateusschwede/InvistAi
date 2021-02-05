CREATE DATABASE invistai CHARSET=utf8;
USE invistai;

CREATE TABLE analista (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(30) NOT NULL,
    senha VARCHAR(5) NOT NULL
);

CREATE TABLE cliente (
    cpf VARCHAR(11) NOT NULL, /*PK*/
    nome VARCHAR(60),
    email VARCHAR(60),
    telefone VARCHAR(11),
    senha VARCHAR(5)
);

CREATE TABLE acao (
    codigo VARCHAR(5) NOT NULL, /*PK*/
    cnpj VARCHAR(12) NOT NULL,
    nome VARCHAR(60) NOT NULL,
    atividade VARCHAR(60) NOT NULL,
    setor VARCHAR(60) NOT NULL,
    preco FLOAT NOT NULL
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



INSERT INTO analista(nome,senha) VALUES ("aaa","111"),("bbb","222");
INSERT INTO cliente(cpf,nome,email,celular,senha) VALUES ("99999999999","cliente x","cliente@outlook.com","51999415233","12345");
INSERT INTO acao(codigo,cnpj,nome,atividade,setor,preco) VALUES ("test1","111111111111","empresa x","produção de alimentos","alimentício",26.55);
INSERT INTO carteira(nome,precoInvestimento,cpfCliente) VALUES ("carteira da filha",5000.50,"99999999999");
INSERT INTO carteira_acao(idCarteira,idAcao,percentual) VALUES (1,"test1",90);