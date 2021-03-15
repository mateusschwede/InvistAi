<?php
    require_once '../../conexao.php';
    session_start();
    if(!isset($_SESSION['clienteLogado'])){header('Location: ../../acessoNegado.php');}

    
    if( (!empty($_GET['ativoAcao'])) and (!empty($_GET['idCarteira'])) and (!empty($_GET['qtdAcao'])) and (!empty($_POST['qtdAcao'])) ) {
        
        $qtdAtual = $_GET['qtdAcao'] - $_POST['qtdAcao'];
        $r = $db->prepare("UPDATE carteira_acao SET qtdAcao=? WHERE idCarteira=? AND ativoAcao=?");
        $r->execute(array($qtdAtual,$_GET['idCarteira'],$_GET['ativoAcao']));

        $qtdAtualOperacao = 0-$_POST['qtdAcao'];
        $r = $db->prepare("INSERT INTO operacao(qtdAcoes,idCarteira,ativoAcao) VALUES (?,?,?)");
        $r->execute(array($qtdAtualOperacao,$_GET['idCarteira'], $_GET['ativoAcao']));

        header("location: investirCarteira.php");
    }

    //Pega cotacaoAtual e qtd ações da ação na carteira, para estabelecer limite máximo de venda
    $r = $db->prepare("SELECT qtdAcao FROM carteira_acao WHERE idCarteira=? AND ativoAcao=?");
    $r->execute(array($_GET['idCarteira'],$_GET['ativo']));
    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
    foreach($linhas as $l) {$qtdMaxVenda = $l['qtdAcao'];}
    
    $r = $db->prepare("SELECT cotacaoAtual,nome FROM acao WHERE ativo=?");
    $r->execute(array($_GET['ativo']));
    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
    foreach($linhas as $l) {
        $cotacaoAtual = number_format($l['cotacaoAtual'],2,".",",");
        $nome=$l['nome'];
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
                <div class="container">
                    <h1>Vender ação</h1>
                    <h4 class="text-center text-muted"><?=$_GET['ativo'].' - '.strtoupper($nome)?></h4>
                    <p class="text-center">Cotação atual: R$ <?=$cotacaoAtual?><br>Quantidade em carteira: <?=$qtdMaxVenda?><br>Total à venda: R$ <?=number_format(($cotacaoAtual*$qtdMaxVenda),2,".",",")?></p>
                    <form action="venderAcao.php?ativoAcao=<?=$_GET['ativo']?>&idCarteira=<?=$_GET['idCarteira']?>&qtdAcao=<?=$qtdMaxVenda?>" method="post">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" required id="floatingInput" name="qtdAcao" min="1" max="<?=$qtdMaxVenda?>" step="1" placeholder="Quantidade">
                            <label for="floatingInput">Quantidade de venda</label>
                        </div>
                        <a href="investirCarteira.php" class="btn btn-danger">Cancelar</a>
                        <button type="submit" class="btn btn-success" id="submitWithEnter">Confirmar</button>
                    </form>
                </div>
            </div>
        </div>


    </div>
</body>
</html>