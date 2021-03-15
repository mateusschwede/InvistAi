<?php
    require_once '../../conexao.php';
    session_start();

    if(!isset($_SESSION['clienteLogado'])){
        header('Location: ../../acessoNegado.php');
    }  
    
    if(!empty($_POST['carteiraDestinoSelecionado']) && !empty($_GET['ativoAcao'])){        
        $r = $db->prepare("UPDATE carteira_acao SET idCarteira = :idCarteiraNovo, objetivo = :objetivo, cpfCliente = :cpfCliente WHERE idCarteira = :idCarteira AND ativoAcao = :ativoAcao;");
        $r->execute(array(
            ":idCarteiraNovo" => $_POST['carteiraDestinoSelecionado'],
            ":objetivo" => "0",
            ":cpfCliente" => $_SESSION['cpf'],
            ":idCarteira" => $_SESSION['idCarteira'],
            ":ativoAcao" => $_GET['ativoAcao']
        ));        
        header('Location: investirCarteira.php');
    
    /* CONDIÇÃO SE MOVER AÇÃO EM CARTEIRA COM MESMA AÇÃO
    $r = $db->prepare("SELECT ativoAcao FROM carteira_acao WHERE idCarteira = :idCarteira AND ativoAcao = :ativoAcao");
    $r->execute(array(
        ":idCarteira" => $_SESSION['idCarteira'],
        ":ativoAcao" => $_GET['ativoAcao']
    ));

    if($r->rowCount()>0) {
        UPDATE INCREMENTANDO QTDE DE AÇÕES NA AÇÃO DA CARTEIRA DESTINO ($_POST['carteiraDestinoSelecionado'])
        DELETA AÇÃO DA CARTEIRA EM QUESTÃO (DE ORIGEM: $_SESSION['idCarteira'])
    } else {
        $r = $db->prepare("UPDATE carteira_acao SET idCarteira = :idCarteiraNovo, objetivo = :objetivo, cpfCliente = :cpfCliente WHERE idCarteira = :idCarteira AND ativoAcao = :ativoAcao;");
            $r->execute(array(
                ":idCarteiraNovo" => $_POST['carteiraDestinoSelecionado'],
                ":objetivo" => "0",
                ":cpfCliente" => $_SESSION['cpf'],
                ":idCarteira" => $_SESSION['idCarteira'],
                ":ativoAcao" => $_GET['ativoAcao']             
            ));   
    }
    header('Location: investirCarteira.php');
    */
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
                    <h4>Ação <?=$_GET['ativoAcao']?></h4>
                    <form method="post">                                         
                        <div class="form-floating mb-3">
                            <select class="form-select" required id="floatingSelect" name="carteiraDestinoSelecionado">
                                <?php
                                    $r = $db->prepare("SELECT * FROM carteira WHERE cpfCliente = ? AND id != ?");
                                    $r->execute(array($_SESSION['cpf'], $_SESSION['idCarteira']));
                                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($linhas as $l) {
                                        echo "<option value=".$l['id'].">".$l['objetivo']."</option>";
                                    }
                                ?>
                            </select>
                            <label for="floatingSelect">Carteira </label>
                        </div>
                        <button type="submit" class="btn btn-success" id="submitWithEnter">Confirma</button> 
                        <a href="investirCarteira.php" class="btn btn-secondary">Voltar</a>
                    </form>
                </div>
            </div>
        </div>       
    </div>
</body>
</html>