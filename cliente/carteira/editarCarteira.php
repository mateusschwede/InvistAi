<?php
    require_once '../../conexao.php';
    session_start();

    if(!isset($_SESSION['clienteLogado'])){
        header('Location: ../../acessoNegado.php');
    }

    $r = $db->prepare("SELECT SUM(percInvestimento) FROM carteira WHERE cpfCliente=? AND id!=?");
    $r->execute(array($_SESSION['cpf'], $_SESSION['idCarteira']));
    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
    foreach($linhas as $l) {
        $percInvestimento = 100-$l['SUM(percInvestimento)'];
    }

    //Pegar dados para preencher form, coloquei Php aqui pra cima
    $r = $db->prepare("SELECT * FROM carteira WHERE id=?");
    $r->execute(array($_SESSION['idCarteira']));
    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);                        
    foreach($linhas as $l) {        
        $percCarteira = $l['percInvestimento'];
        $objetivoDaCarteira = $l['objetivo'];                            
    }

    if((!empty($_POST['novoObjetivo']) && !empty($_POST['novoPercentual']))){        
        
        //Atualizei aqui, e o '>' no rowCount :)
        $r = $db->prepare("SELECT * FROM carteira WHERE cpfCliente=? AND objetivo=? AND objetivo!=?");
        $r->execute(array($_SESSION['cpf'],$_POST['novoObjetivo'],$objetivoDaCarteira));

        if($r->rowCount()>0) {echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Objetivo já existente em outra carteira!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";}
        else {
            $r = $db->prepare("UPDATE carteira SET objetivo = :objetivo, percInvestimento = :novoPercentual WHERE id = :id");
            $r->execute(array(
                ":objetivo" => $_POST['novoObjetivo'],
                ":novoPercentual" => $_POST['novoPercentual'],
                ":id" => $_SESSION['idCarteira']
            ));
            header("Location: investirCarteira.php");
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
                    <h2>Alterar Carteira <?=$_SESSION['idCarteira']?></h2>
                    <form method="post">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="objetivo da carteira" required id="lblObjetivo" name="novoObjetivo" maxlength="60" style="text-transform:lowercase;" value="<?=$objetivoDaCarteira?>">
                            <label for="lblObjetivo">Objetivo da carteira</label>
                        </div>                        
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" required id="floatingInput" name="novoPercentual" step="1" min="1" max=<?=$percInvestimento?> value=<?=$percCarteira?>>
                            <label for="floatingInput">Percentual</label>
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