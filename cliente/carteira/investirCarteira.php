<?php
    require_once '../../conexao.php';
    session_start();
    if(!isset($_SESSION['logado'])){header('Location: ../../acessoNegado.php');}

    if( (!empty($_GET['idCarteira'])) and (!empty($_POST['valorInvestimento'])) ) {
        $_SESSION['idCarteira'] = $_GET['idCarteira'];
        $_SESSION['valorInvestimento'] = $_POST['valorInvestimento'];
        header("location: simulacaoInvestimento.php");
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<title>InvistAí</title>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="https://img.icons8.com/fluent/96/000000/bad-idea.png">
    <link rel="stylesheet" href="../../estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="../../script.js"></script>
    <script type="text/javascript" src="../../pace.min.js"></script>
</head>
<body>
    <div class="container-fluid">

        
        <!-- Menu de Navegação -->
        <div class="row">
            <div class="col-sm-12" id="navbar">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="../index.php"><img src="https://img.icons8.com/fluent/24/000000/bad-idea.png"> InvistAí<font size="2">(Cliente)</font></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                            <li class="nav-item"><a class="nav-link active" aria-current="page" href="../index.php">Home</a></li>
                                <li class="nav-item"><a class="nav-link" href="../perfil.php">Perfil</a></li>
                                <li class="nav-item"><a class="nav-link" href="../acoes.php">Ações</a></li>
                                <li class="nav-item"><a class="nav-link" href="#" onclick=" confirmlogout('../../logout.php')" id="logout"><?=$_SESSION['nome']?>-logout</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                <h1>Carteira <?=$_GET['id']?></h1>
                <?php
                    $r = $db->prepare("SELECT * FROM carteira_acao WHERE idCarteira=?");
                    $r->execute(array($_GET['id']));
                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas as $l) {echo "<span class='btn btn-dark btn-sm'>".$l['ativoAcao']." <span class='badge bg-warning'>".$l['objetivo']."%</span></span> ";}
                ?>

                <br><br><h3>Investir na carteira:</h3>
                <form action="investirCarteira.php?idCarteira=<?=$_GET['id']?>" method="post">
                    <div class="mb-3">
                        <input type="text" class="form-control" required name="valorInvestimento" pattern="\d{1,9}\.\d{2}" placeholder="Valor à investir" onkeypress="return isNumberAndDot(event)">
                        <div class="form-text">Use ponto no lugar de vírgula</div>
                    </div>
                    <a href="../index.php" class="btn btn-danger">Voltar</a>
                    <button type="submit" class="btn btn-success" id="submitWithEnter">Conferir Investimento</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
            <br><h4>Investimentos:</h4>
                
                <div class="table-responsive">
                    <table class='table table-striped'>
                        <thead>
                            <tr>
                                <th scope='col'>Data</th>
                                <th scope='col'>Ativo</th>
                                <th scope='col'>Nome</th>
                                <th scope='col'>Cotação atual (R$)</th>
                                <th scope='col'>Quantidade</th>
                                <th scope='col'>Valor (R$)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope='row'>x</th>
                                <td class='set'>x</td>
                                <td class='set'>x</td>
                                <td class='set'>x</td>
                                <td class='set'>x</td>
                                <td class='set'>x</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</body>
</html>