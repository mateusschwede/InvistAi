<?php
    require_once '../../conexao.php';
    session_start();

    if(!isset($_SESSION['logado'])):
       header('Location: ../../acessoNegado.php');
    endif;
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
                                <li class="nav-item"><a class="nav-link" href="#" onclick="confirmlogout2()" id="logout"><?=$_SESSION['nome']?>-logout</a></li>
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
                    $r = $db->prepare("SELECT * FROM carteira WHERE id=?");
                    $r->execute(array($_GET['id']));
                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas as $l) {
                        echo "
                            <p><b>Código:</b> ".$l['id']."</p>
                            <p><b>Objetivo:</b> ".$l['objetivo']."</p>
                            <p><b>Cpf do cliente:</b> ".$l['cpfCliente']."</p>
                            <p><b>Investimento:</b> R$ ".number_format($l['investimento'],2,".",",")."</p>
                            <p><b>Sobra dos aportes:</b> R$ ".number_format($l['sobraAportes'],2,".",",")."</p>
                        ";
                    }
                ?>
                
                <br>
                <h3>Ações vinculadas</h3>
                <?php
                    $r = $db->prepare("SELECT * FROM carteira_acao WHERE idCarteira=?");
                    $r->execute(array($_GET['id']));
                    if($r->rowCount()==0) {echo "<p class='text-muted'>Não há ações vinculadas à carteira ".$_GET['id']."</p>";}
                ?>
                <a href="../index.php" class="btn btn-danger">Voltar</a>
            </div>
        </div>
    </div>

</body>
</html>