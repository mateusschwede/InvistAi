<?php
    require_once '../../conexao.php';
    session_start();
    if(!isset($_SESSION['clienteLogado'])){header('Location: ../../acessoNegado.php');}

    $r = $db->prepare("SELECT SUM(percInvestimento) FROM carteira WHERE cpfCliente=?");
    $r->execute(array($_SESSION['cpf']));
    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
    foreach($linhas as $l) {$percInvestimento = 100-$l['SUM(percInvestimento)'];}

    if( (!empty($_POST['objetivo'])) and (!empty($_POST['percInvestimento'])) ) {
        $r = $db->prepare("SELECT objetivo FROM carteira WHERE cpfCliente=? AND objetivo=?");
        $r->execute(array($_SESSION['cpf'],$_POST['objetivo']));
        
        if($r->rowCount()>0) {echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Objetivo já existente!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";}
        else {
            $r = $db->prepare("INSERT INTO carteira(objetivo,percInvestimento,cpfCliente) VALUES (?,?,?)");
            $r->execute(array($_POST['objetivo'],$_POST['percInvestimento'],$_SESSION['cpf']));  
            
            $r = $db->prepare("SELECT id FROM carteira WHERE objetivo=? AND percInvestimento=? AND cpfCliente=?");
            $r->execute(array($_POST['objetivo'],$_POST['percInvestimento'],$_SESSION['cpf']));
            $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
            foreach($linhas as $l) {$_SESSION['idCarteira'] = $l['id'];}
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
            <div class="container">
                <h1>Minhas Carteira</h1>
                Minhas Carteiras Aqui com suas ações
                Cabeçalho: Objetivo da Carteira - Porcentagem investida
                      Ex:  Carteira - Aposentadoria - 60%
                Dados:
              Datacotacao(lance) - Ativo - NomeAcao - CotaçãoAtual - QtdAcao - R$"CotacaoXQtd" 


                Configuração Atual
            </div>
            </div>
        </div>
    </div>

</body>
</html>