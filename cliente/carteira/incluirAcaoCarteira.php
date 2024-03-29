<?php
    require_once '../../conexao.php';
    session_start();
    if(!isset($_SESSION['clienteLogado'])){header('Location: ../../acessoNegado.php');}

    $r = $db->prepare("SELECT SUM(objetivo) FROM carteira_acao WHERE idCarteira=?");
    $r->execute(array($_SESSION['idCarteira']));
    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
    foreach($linhas as $l) {$somaPerc = 100-$l['SUM(objetivo)'];}

    if( (!empty($_POST['ativoAcao'])) ) {
        $r = $db->prepare("SELECT ativoAcao FROM carteira_acao WHERE idCarteira=? AND ativoAcao=?");
        $r->execute(array($_SESSION['idCarteira'], $_POST['ativoAcao']));
        if($r->rowCount()>0) {echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Ação já adicionada na carteira!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";}
        else {
            $r = $db->prepare("INSERT INTO carteira_acao(idCarteira,ativoAcao,objetivo,cpfCliente) VALUES (?,?,0,?)");
            $r->execute(array($_SESSION['idCarteira'],$_POST['ativoAcao'],$_SESSION['cpf']));

            header("location: investirCarteira.php");
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
                <form action="incluirAcaoCarteira.php" method="post">
                    <div class="form-floating mb-3">
                        <select class="form-select" required id="floatingSelect" name="ativoAcao">
                            <?php
                                $r = $db->query("SELECT ativo,nome,cotacaoAtual FROM acao WHERE cotacaoAtual!=0 ORDER BY ativo");
                                $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                                foreach($linhas as $l) {echo "<option value=".$l['ativo'].">".$l['ativo']." - ".$l['nome']." - R$ ".number_format($l['cotacaoAtual'],2,",",".")."</option>";}
                            ?>
                        </select>
                        <label for="floatingSelect">Ativo da ação</label>
                    </div>
                    
                    <a href="investirCarteira.php" class="btn btn-danger">Cancelar</a>
                    <button type="submit" class="btn btn-success" id="submitWithEnter">Adicionar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>