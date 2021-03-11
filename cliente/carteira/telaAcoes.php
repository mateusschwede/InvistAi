<?php
    require_once '../../conexao.php';
    session_start();
    if(!isset($_SESSION['clienteLogado'])){header('Location: ../../acessoNegado.php');}

    if(!empty($_POST['finalizarCarteira'])) {
        $r = $db->prepare("SELECT SUM(objetivo) FROM carteira_acao WHERE idCarteira=?");
        $r->execute(array($_SESSION['idCarteira']));
        $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
        foreach($linhas as $l) {
            if($l['SUM(objetivo)']==100) {
                unset($_SESSION['idCarteira']);
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Carteira finalizada!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                header("location: ../index.php");
            } else {echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>A distribuição percentual das ações precisa somar 100%!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";}
        }
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
                        <a class="navbar-brand"><img src="https://img.icons8.com/fluent/24/000000/bad-idea.png"> InvistAí<font size="2">(Cliente)</font></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                            <li class="nav-item"><a class="nav-link disabled">Home</a></li>
                                <li class="nav-item"><a class="nav-link disabled">Perfil</a></li>
                                <li class="nav-item"><a class="nav-link disabled">Ações</a></li>
                                <li class="nav-item"><a class="nav-link disabled"><?=$_SESSION['nome']?>-logout</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <h1>Carteira <?=$_SESSION['idCarteira']?></h1>
                <?php
                    $r = $db->prepare("SELECT * FROM carteira WHERE id=?");
                    $r->execute(array($_SESSION['idCarteira']));
                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach($linhas as $l) {echo "<h4 class='text-muted'>".$l['objetivo']."<br>(".$l['percInvestimento']."%)</h4><br>";}
                ?>

                <h3>Ações vinculadas</h3>
                <?php
                    if((isset($_SESSION['msg'])) and ($_SESSION['msg']!=null)) {echo $_SESSION['msg']; $_SESSION['msg']=null;}

                    $r = $db->prepare("SELECT * FROM carteira_acao WHERE idCarteira=?");
                    $r->execute(array($_SESSION['idCarteira']));
                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                   
                    foreach($linhas as $l) {echo "<b>(".$l['objetivo']."%)</b> ".$l['ativoAcao']."<br>";}
                ?>                               
                <a href="addAcaoCarteira.php" class="btn btn-primary btn-sm">Adicionar ação</a><br><br>
                <form action="telaAcoes.php" method="post">
                    <input type="hidden" name="finalizarCarteira" value="1">
                    <a href="canCarteira.php" class="btn btn-danger">Cancelar carteira</a>
                    <button type="submit" class="btn btn-success" id="submitWithEnter">Finalizar carteira</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>