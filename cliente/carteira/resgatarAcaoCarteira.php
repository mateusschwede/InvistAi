<?php
    require_once '../../conexao.php';
    session_start();
    if(!isset($_SESSION['clienteLogado'])) {header('Location: ../../acessoNegado.php');}
    
    /*
    Qtd da ação origem: $_POST['qtdAcoesOrigem']
    Código da ação origem: $_POST['ativoAcaoOrigem']
    Id da carteira destino: $_POST['cartDestino']
    */


    if( (!empty($_POST['cartDestino'])) && (!empty($_POST['qtdAcoesOrigem'])) && (!empty($_POST['ativoAcaoOrigem']))) {

        $r = $db->prepare("SELECT * FROM carteira_acao WHERE idCarteira=? AND ativoAcao=?");
        $r->execute(array($_POST['cartDestino'], $_POST['ativoAcaoOrigem']));
        
        if($r->rowCount()>0) {
            //CENÁRIO 2
            $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
            foreach($linhas as $l) {$qtdAcoesDestino = $l['qtdAcao'] + $_POST['qtdAcoesOrigem'];}
            //Update qtdes na carteira destino
            $r = $db->prepare("UPDATE carteira_acao SET qtdAcao=? WHERE idCarteira=? AND ativoAcao=?");
            $r->execute(array($qtdAcoesDestino, $_POST['cartDestino'], $_POST['ativoAcaoOrigem']));


            //Remover ação na carteira origem (lixeira, id=0)
            $r = $db->prepare("DELETE from carteira_acao WHERE idCarteira=0 AND ativoAcao=? AND cpfCliente=? ");
            $r->execute(array($_POST['ativoAcaoOrigem'], $_SESSION['cpf']));


        } else {          
            //CENÁRIO 1
            $r = $db->prepare("UPDATE carteira_acao SET idCarteira=? WHERE cpfCliente=? AND idCarteira=0 AND ativoAcao=?");
            $r->execute(array($_POST['cartDestino'],$_SESSION['cpf'],$_POST['ativoAcaoOrigem']));
        }
        header('Location: acoesSemCarteira.php');
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
                <div class="text-center">
                    <div class="container">
                        <h2>Resgatar Ação <?=$_GET['ativoAcao']?></h2>
                        <h4 class="text-muted">Quantidade: <?=$_GET['qtdAcao']?></h4>
                        <form method="post">                                         
                            <div class="form-floating mb-3">
                                <select class="form-select" required id="floatingSelect" name="cartDestino">
                                    <?php
                                        $r = $db->prepare("SELECT * FROM carteira WHERE cpfCliente=?");
                                        $r->execute(array($_SESSION['cpf']));
                                        $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($linhas as $l) {
                                            echo "<option value=".$l['id'].">".$l['objetivo']."</option>";
                                        }
                                    ?>
                                </select>
                                <label for="floatingSelect">Carteira destino de resgate</label>
                            </div>
                            <input type="hidden" name="qtdAcoesOrigem" value="<?=$_GET['qtdAcao']?>">
                            <input type="hidden" name="ativoAcaoOrigem" value="<?=$_GET['ativoAcao']?>">
                            <a href="acoesSemCarteira.php" class="btn btn-danger">Cancelar</a>
                            <button type="submit" class="btn btn-success" id="submitWithEnter">Confirmar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>       
    </div>
</body>
</html>