CREATE TABLE carteira (
  idc int(5) NOT NULL,
  idcli int(5) NOT NULL, /*id cliente (no nosso será cpf)*/
  datac date NOT NULL, /*dataCadastro*/
  tipo varchar(20) NOT NULL, /*objetivo*/
  perc int(3) NOT NULL, /*percentual investido*/
  a1 int(5) NOT NULL, /*ativo da ação 1 (Ex: OIBR3))*/
  v1 int(5) NOT NULL, /*percentual da ação 1*/
  a2 int(5) NOT NULL,
  v2 int(5) NOT NULL DEFAULT 0,
  a3 int(5) NOT NULL,
  v3 int(5) NOT NULL DEFAULT 0,
  a4 int(5) NOT NULL,
  v4 int(5) NOT NULL DEFAULT 0,
  a5 int(5) NOT NULL,
  v5 int(5) NOT NULL DEFAULT 0
);

INSERT INTO carteira (idc, idcli, datac, tipo, perc, a1, v1, a2, v2, a3, v3, a4, v4, a5, v5) VALUES
(0, 17, '2021-02-15', 'Aposentadoria', 60, 556, 30, 625, 50, 57, 20, 46, 0, 1, 0),
(0, 17, '2021-02-18', 'Estudos', 60, 10, 30, 28, 50, 17, 20, 1, 0, 1, 0),
(0, 19, '2021-02-20', 'Viagem', 50, 7, 60, 9, 40, 1, 0, 1, 0, 1, 0);


CREATE TABLE empresa (
  ide int(5) NOT NULL PRIMARY KEY,
  codigo varchar(6) NOT NULL, /*ativo da ação (Ex: OIBR3)*/
  emp varchar(40) NOT NULL, /*nome da empresa*/
  valor double NOT NULL, /*valor da cotação atual*/
  datac date NOT NULL /*data da cotação atual*/
);

INSERT INTO empresa (ide, codigo, emp, valor, datac) VALUES
(1, 'AALR3', 'ALLIAR', 21.51, '2021-02-20'),
(2, 'AAPL34', 'APPLE', 147.65, '2021-02-20'),
(3, 'ABCB4', 'ABC BRASIL', 21.45, '2021-02-20'),
(4, 'ABEV3', 'AMBEV S/A', 16.6, '2021-02-20'),
(10, 'ALSO3', 'ALIANSCSONAE', 52.17, '2021-02-20');


CREATE TABLE lance (
  idl int(5) NOT NULL PRIMARY KEY, /*id do lance*/
  idcli int(5) NOT NULL, /*id cliente (no nosso será cpf)*/
  tipo varchar(20) NOT NULL, /*objetivo da carteira (no nosso será desnecessário)*/
  idct int(5) NOT NULL, /*id carteira*/
  quant int(5) NOT NULL, /*qtd de recomendações de compra de ações*/
  datac date NOT NULL, /*dataCadastro (Eu acho... ou dataCotacao)*/
  sobra double NOT NULL DEFAULT 0 /*sobra dos aportes*/
);

INSERT INTO lance (idl, idcli, tipo, idct, quant, datac, sobra) VALUES
(105, 17, 'Aposentadoria', 556, 21, '2021-02-15', 0.20399999999998),
(106, 17, 'Aposentadoria', 625, 39, '2021-02-15', 0.20399999999998);


CREATE TABLE pessoa (
  id int(5) NOT NULL PRIMARY KEY,
  nome varchar(15) NOT NULL,
  sobrenome varchar(25) NOT NULL,
  cpf varchar(14) NOT NULL,
  rg varchar(10) DEFAULT NULL,
  email varchar(35) NOT NULL,
  ender varchar(40) DEFAULT NULL,
  cidade varchar(40) NOT NULL,
  uf varchar(2) NOT NULL,
  cep varchar(9) NOT NULL,
  celular varchar(14) NOT NULL,
  a1 int(5) NOT NULL DEFAULT 0,
  a2 int(5) NOT NULL DEFAULT 0,
  a3 int(5) NOT NULL DEFAULT 0,
  p1 int(5) NOT NULL DEFAULT 0,
  p2 int(5) NOT NULL DEFAULT 0,
  p3 int(5) NOT NULL DEFAULT 0,
  ct int(1) NOT NULL DEFAULT 0,
  dt date NOT NULL, /*dtCadastro*/
  lg varchar(20) DEFAULT NULL, /*login*/
  ps varchar(20) DEFAULT NULL /*senha*/
);

INSERT INTO pessoa (id, nome, sobrenome, cpf, rg, email, ender, cidade, uf, cep, celular, a1, a2, a3, p1, p2, p3, ct, dt, lg, ps) VALUES
(16, 'Pongo', 'ggg', '00000000000', NULL, 'pg@tt.ing', NULL, '', '', '', '(51)9999.99888', 5, 6, 4, 35, 25, 40, 0, '2021-02-09', 'pongo', 'pongo'),
(17, 'Prof. Tiago2', 'Cinto', '999.999.999.99', '', 'tiago.cinto@feliz.ifrs.edu.br', '', '', '', '', '(11)999999999', 0, 0, 0, 0, 0, 0, 0, '2021-02-09', '', '');