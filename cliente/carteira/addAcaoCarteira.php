<?php
    require_once '../../conexao.php';
    session_start();
    if(!isset($_SESSION['logado'])){header('Location: ../../acessoNegado.php');}

    $r = $db->prepare("SELECT SUM(objetivo) FROM carteira_acao WHERE idCarteira=?");
    $r->execute(array($_SESSION['idCarteira']));
    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
    foreach($linhas as $l) {$somaPerc = 100-$l['SUM(objetivo)'];}

    if( (!empty($_POST['ativoAcao'])) and (!empty($_POST['objetivo'])) ) {
        $r = $db->prepare("SELECT ativoAcao FROM carteira_acao WHERE idCarteira=? AND ativoAcao=?");
        $r->execute(array($_SESSION['idCarteira'],$_POST['ativoAcao']));
        if($r->rowCount()>0) {echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Ação já adicionada na carteira!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";}
        else {
            $r = $db->prepare("INSERT INTO carteira_acao(idCarteira,ativoAcao,objetivo) VALUES (?,?,?)");
            $r->execute(array($_SESSION['idCarteira'],$_POST['ativoAcao'],$_POST['objetivo']));
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Ação adicionada na carteira ".$_SESSION['idCarteira']."!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            header("location: telaAcoes.php");
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
            <div class="col-sm-12">
                <h3>Adicionar ação à carteira <?=$_SESSION['idCarteira']?>:</h3>
                <form action="addAcaoCarteira.php" method="post">
                    <div class="mb-3">
                        <label class="form-label">Ação</label>
                        <select class="form-select" required name="ativoAcao">                            
                            <?php
                                $r = $db->query("SELECT ativo,nome FROM acao");
                                $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                                foreach($linhas as $l) {
                                    echo "<option value=".$l['ativo'].">(".$l['ativo'].") ".$l['nome']."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="number" class="form-control" required name="objetivo" min="10" max="<?=$somaPerc?>" step="10" placeholder="Objetivo(%)" value="<?=$somaPerc?>" onkeypress="return isNumberAndDot(event)">
                        <div class="form-text">O objetivo não pode ultrapassar a soma dos percentuais das ações cadastradas na carteira</div>
                    </div>
                    <a href="telaAcoes.php" class="btn btn-danger">Cancelar</a>
                    <button type="submit" class="btn btn-success" id="submitWithEnter">Adicionar</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>