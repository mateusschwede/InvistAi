/* DROP DATABASE invistai;*/
CREATE DATABASE invistai CHARSET=utf8;
USE invistai;

CREATE TABLE pessoa (
    cpf VARCHAR(11) NOT NULL, /*PK*/
    rg VARCHAR(10) NOT NULL,
    nome VARCHAR(60) NOT NULL, /*Nome e Sobrenome*/
    email VARCHAR(60),
    celular VARCHAR(11),
    endereco VARCHAR(200),
    tipo INT NOT NULL, /*1-analista / 2-cliente*/
    senha VARCHAR(32) NOT NULL,
    totalSobraAportes FLOAT NOT NULL DEFAULT 0,
    inativado BOOLEAN NOT NULL DEFAULT 0
);

CREATE TABLE acao (
    ativo VARCHAR(8) NOT NULL, /*PK - Código dela, ex: OIBR4*/
    nome VARCHAR(100) NOT NULL,
    setor VARCHAR(200) NOT NULL,
    cotacaoAtual FLOAT NOT NULL DEFAULT 0, /*Preço da ação*/
    dtUltimaCotacao DATE NOT NULL DEFAULT now()
);

CREATE TABLE carteira (
    id INT AUTO_INCREMENT PRIMARY KEY,
    objetivo VARCHAR(60) NOT NULL, /*Ex: aposentadoria do bisneto, velório da sogra*/
    percInvestimento FLOAT NOT NULL, /*percentual investido*/
    cpfCliente VARCHAR(11) NOT NULL /*FK*/
);

CREATE TABLE carteira_acao (
    idCarteira INT NOT NULL, /*FK*/
    ativoAcao VARCHAR(8) NOT NULL, /*FK código ação*/
    objetivo INT NOT NULL, /*percent definido pelo cliente para ação na carteira*/    
    qtdAcao INT NOT NULL DEFAULT 0 /*COMPRA: qtdAcoes(operacao)+qtdAcoesComprar | VENDA: qtdAcoes(operacao)-qtdAcoesComprar*/
);

CREATE TABLE operacao ( /*Table para representar as movimentações do cliente x ao analista (compras e vendas de ações)*/
    id INT AUTO_INCREMENT PRIMARY KEY,
    dataOperacao DATETIME NOT NULL DEFAULT now(),
    qtdAcoes INT NOT NULL, /*Compra(qtdAcoesComprar): Valor positivo | Venda: Valor negativo, //Qtd de ações adicionadas/removidas no momento do investimento/venda*/
    idCarteira INT NOT NULL, /*FK*/
    ativoAcao VARCHAR(5) NOT NULL /*FK código ação*/
);