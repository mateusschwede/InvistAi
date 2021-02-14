<?php
    require_once '../conexao.php';
    session_start();

    if((!empty($_POST['cpf'])) and (!empty($_POST['rg'])) and (!empty($_POST['nome'])) and (!empty($_POST['senha']))) {
        $r = $db->prepare("SELECT cpf FROM pessoa WHERE cpf=? OR rg=?");
        $r->execute(array($_POST['cpf'],$_POST['rg']));
        if(($r->rowCount()==0)) {
            $r = $db->prepare("INSERT INTO pessoa(cpf,rg,nome,senha,tipo) VALUES (?,?,?,?,2)");
            $r->execute(array($_POST['cpf'],$_POST['rg'],$_POST['nome'],$_POST['senha']));
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>Cliente adicionado!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        } else {echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Cpf ou rg já existente!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";}
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>InvistAí</title>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="https://img.icons8.com/fluent/96/000000/bad-idea.png">
    <link rel="stylesheet" href="../estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="script.js"></script>
</head>
<body>
    <div class="container-fluid">

        
        <!-- Menu de Navegação -->
        <div class="row">
            <div class="col-sm-12" id="navbar">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="index.php"><img src="https://img.icons8.com/fluent/24/000000/bad-idea.png"/> InvistAí(Analista)</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                                <li class="nav-item"><a class="nav-link" href="perfil.php">Perfil</a></li>
                                <li class="nav-item"><a class="nav-link" href="acoes.php">Ações</a></li>
                                <li class="nav-item"><a class="nav-link active" aria-current="page" href="clientes.php">Clientes</a></li>
                                <li class="nav-item"><a class="nav-link" href="../logout.php" id="logout"><?=$_SESSION['cpf']?>-logout</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>


        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1>Novo cliente</h1>
                    <form action="addCliente.php" method="post">
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="cpf" required name="cpf" pattern="\d{11}" onkeypress="return isNumber(event)">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="rg" required name="rg" pattern="\d{10}" onkeypress="return isNumber(event)">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="nome" required name="nome" maxlength="60" style="text-transform:lowercase;">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" placeholder="senha temporária" required name="senha" maxlength="5" style="text-transform:lowercase;">
                        </div>
                        <button type="button" class="btn btn-danger" onclick="window.location.href='clientes.php'">Voltar</button>
                        <button type="submit" class="btn btn-success" id="submitWithEnter">Adicionar</button>
                    </form>
                </div>
            </div>
        </div>


    </div>
</body>
</html>