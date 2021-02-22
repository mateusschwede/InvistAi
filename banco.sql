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
    inativado BOOLEAN DEFAULT 0
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
    ativoAcao VARCHAR(5) NOT NULL, /*FK código ação*/
    qtdAcao INT NOT NULL, /*Qtd de ações compras de acordo com objetivo*/
    patrAtualizado FLOAT NOT NULL, /*precoAção X qtdAcao*/
    partAtual FLOAT NOT NULL, /*percent de participação atualizado de uma ação em relação a toda carteira (precoAção / patrAtualizado)*/
    objetivo INT NOT NULL, /*percent definido pelo cliente para investimento da ação na carteira*/
    distObjetivo FLOAT NOT NULL, /*percent de distância que falta para alcançar o objetivo (situacao)*/
);

CREATE TABLE lance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cpfCliente VARCHAR(11) NOT NULL, /*FK*/
    idCarteira INT NOT NULL, /*FK*/
    qtdAcoesComprar INT NOT NULL,
    dataCotacao DATE NOT NULL DEFAULT now(),
    sobraAportes FLOAT NOT NULL DEFAULT 0, /*Resto do valor na divisão entre as ações*/
);

CREATE TABLE movimentacao ( /*Table para representar as movimentações do cliente x ao analista (compras e vendas de ações)*/
    id INT AUTO_INCREMENT PRIMARY KEY,
    dataMovimentacao DATETIME NOT NULL DEFAULT now(),
    qtdAcoes INT NOT NULL, /*Compra: Valor positivo | Venda: Valor negativo*/
    idCarteira INT NOT NULL, /*FK*/
    ativoAcao VARCHAR(5) NOT NULL /*FK código ação*/
);