<?php
    require_once '../conexao.php';
    session_start();
    if(!isset($_SESSION['logado'])) {header('Location: ../acessoNegado.php');}
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
                        <a class="navbar-brand" href="index.php"><img src="https://img.icons8.com/fluent/24/000000/bad-idea.png"/> InvistAí<font size="2">(Cliente)</font></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                                <li class="nav-item"><a class="nav-link" href="perfil.php">Perfil</a></li>
                                <li class="nav-item"><a class="nav-link" href="acoes.php">Ações</a></li>
                                <li class="nav-item"><a class="nav-link" href="#" onclick="confirmlogout()" id="logout"><?=$_SESSION['nome']?>-logout</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                <h1>Minhas Carteiras</h1>
                <h3>Investimento Total: R$</h3>

                <a href="carteira/addCarteira.php" class="btn btn-primary">Adicionar Carteira</a>
                <div class="table-responsive">
                    <table class='table table-striped'>
                        <thead>
                            <tr>
                                <th scope='col'>Cód</th>
                                <th scope='col'>Objetivo</th>
                                <th scope='col'>Previsto</th>
                                <th scope='col'>Atual(%)</th>
                                <th scope='col'>Valor</th>
                                <th scope='col'>Previsto</th>
                                <th scope='col'>Diferença</th>
                                <th scope='col'>Situação</th>
                                <th scope='col'>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $r = $db->prepare("SELECT * FROM carteira WHERE cpfCliente=?");
                                $r->execute(array($_SESSION['cpf']));
                                $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                                foreach($linhas as $l) {
                                    echo "
                                        <tr>
                                            <th scope='row'>".($l['id'])."</th>
                                            <td class='setn'>".$l['objetivo']."</td>
                                            <td class='set'>".$l['percInvestimento']."%</td>
                                            <td class='set'>Atual(%)</td>
                                            <td class='set'>Valor</td>
                                            <td class='set'>Previsto</td>
                                            <td class='set'>Diferença</td>
                                            <td class='set'>Situação</td>
                                            <td class='set'><a href='remCarteira.php' class='btn btn-danger btn-sm'>Excluir</a> <a href='updateCarteira.php' class='btn btn-warning btn-sm'>Editar</a> <a href='carteira/verCarteira.php?id=".$l['id']."' class='btn btn-primary btn-sm'>Ver</a> <a href='investirCarteira.php' class='btn btn-success btn-sm'>Investir</a></td>
                                        </tr>
                                    ";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
</body>
</html>