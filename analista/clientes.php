<?php
    require_once '../conexao.php';
    session_start();

    if(!isset($_SESSION['analistaLogado'])):
        header('Location: ../acessoNegado.php');
    endif;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>InvistAí</title>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="https://img.icons8.com/fluent/96/000000/bad-idea.png">
    <link rel="stylesheet" href="../estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="../script.js"></script>
    <script type="text/javascript" src="../pace.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="container-fluid">        
        <!-- Menu de Navegação -->
        <div class="row">
            <div class="col-sm-12" id="navbar">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="index.php"><img src="https://img.icons8.com/fluent/24/000000/bad-idea.png"/> InvistAí<font size="2">(Analista)</font></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                                <li class="nav-item"><a class="nav-link" href="perfil.php">Perfil</a></li>
                                <li class="nav-item"><a class="nav-link" href="acoes.php">Ações</a></li>
                                <li class="nav-item"><a class="nav-link active" aria-current="page" href="clientes.php">Clientes</a></li>
                                  <li class="nav-item"><a class="nav-link" href="#" onclick=" confirmlogout('../logout.php')" id="logout"><?=$_SESSION['nome']?>-logout</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="text-center">
                    <h1>Clientes</h1>
                    <a href="addCliente.php" class="btn btn-primary">Pré-cadastrar cliente</a><br><br>
                </div>
                <div class="row">                    
                    <div class="col-sm-4">                         
                        <h3>Clientes pré-cadastrados</h3><br>
                        <?php
                            $r = $db->query("SELECT * FROM pessoa WHERE tipo = 2 and email is null ORDER BY nome");
                            $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                            foreach($linhas as $l) {
                            echo "
                                <p>
                                    <b>Nome: </b>".$l['nome']."<br>
                                    <b>CPF: </b>".$l['cpf']."<br>
                                    <a href='removeUnregisteredClient.php?cpf=".$l['cpf']."'  class='btn btn-danger btn-sm' onclick='return confirm('Deseja mesmo desativar?');'>Remover</a>
                                </p>
                                <hr>";
                            }
                        ?>
                    </div>
                    <div class="col-sm-4">                        
                        <h3>Clientes ativos</h3><br>
                        <?php
                            $r = $db->query("SELECT * FROM pessoa WHERE tipo = 2 and inativado = 0 and email is not null ORDER BY nome");
                            $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                            foreach($linhas as $l) {
                            echo "
                                <p>
                                    <b>Nome: </b>".$l['nome']."<br>
                                    <b>CPF: </b>".$l['cpf']."<br>
                                </p>
                                <hr>";
                            }
                        ?>
                    </div>
                    <div class="col-sm-4">
                        <h3>Clientes inativos</h3><br>   
                        <?php
                            $r = $db->query("SELECT * FROM pessoa WHERE tipo = 2 and inativado = 1 ORDER BY nome");
                            $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                            foreach($linhas as $l) {
                            echo "
                                <p>
                                    <b>Nome: </b>".$l['nome']."<br>
                                    <b>CPF: </b>".$l['cpf']."<br>
                                    <a  href='enableClient.php?cpf=".$l['cpf']."'  class='btn btn-secondary btn-sm' onclick='return confirm('Deseja mesmo desativar?');'>Ativar</a>
                                </p>
                                <hr>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>