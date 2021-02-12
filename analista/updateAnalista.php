<?php
    require_once '../conexao.php';
    session_start();
    $msgSucesso = false;
    if((!empty($_POST['cpf'])) and (!empty($_POST['rg'])) and (!empty($_POST['nome'])) and (!empty($_POST['termo'])) and (!empty($_POST['senha']))) {
        $r = $db->prepare("UPDATE pessoa SET cpf = :cpf, rg = :rg, nome = :nome, senha = :senha, tipo = :tipo WHERE cpf = :cpf");
        print_r($_POST);
        print_r($_SESSION);
        $r->execute(array(
            ":cpf" => $_SESSION['cpf'],
            ":rg" => $_POST['rg'],
            ":nome" => $_POST['nome'],
            ":senha" => $_POST['senha'],
            ":tipo" => $_SESSION['tipo']
        ));
        $msgSucesso = true;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>InvistAí</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="script.js"></script>
</head>
<body>
<div class="container">
    <div class="container-fluid">


        <div class="row">
            <div class="col-sm-12 text-center">
            <?= $msgSucesso ?  "<div class='alert alert-success alert-dismissible fade show' role='alert'>Dados Atualizados!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>" : "" ?>

                <h1>Novo analista</h1>
                <form action="updateAnalista.php" method="post">
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
                        <input type="text" class="form-control" placeholder="termo de segurança" required name="termo" maxlength="5" style="text-transform:lowercase;">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="senha" required name="senha" maxlength="5" style="text-transform:lowercase;">
                    </div>
                    <button type="button" class="btn btn-danger" onclick="window.location.href='../index.php'">Voltar</button>
                    <button type="submit" class="btn btn-success">Adicionar</button>
                </form>
            </div>
        </div>


    </div>
</div>
</body>
</html>