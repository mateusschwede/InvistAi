<?php
    require_once '../conexao.php';

    if((!empty($_POST['cpf'])) and (!empty($_POST['rg'])) and (!empty($_POST['nome'])) and (!empty($_POST['termo'])) and (!empty($_POST['senha']))) {
        $r = $db->prepare("SELECT cpf FROM pessoa WHERE cpf=? OR rg=?");
        $r->execute(array($_POST['cpf'],$_POST['rg']));
        if(($r->rowCount()==0) and ($_POST['termo']=="admin")) {
            $r = $db->prepare("INSERT INTO pessoa(cpf,rg,nome,senha,tipo) VALUES (?,?,?,?,1)");
            $r->execute(array($_POST['cpf'],$_POST['rg'],$_POST['nome'],md5($_POST['senha'])));
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>Analista adicionado!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        } else {echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Termo inválido, cpf ou rg já existente!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";}
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
    <script type="text/javascript" src="../script.js"></script>
    <script type="text/javascript" src="../pace.min.js"></script>
</head>
<body>
<div class="container">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h1>Novo analista</h1>
                <form action="addAnalista.php" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="cpf" required name="cpf" pattern="\d{11}" maxlength="11" onkeypress="return isNumber(event)">
                        <label for="floatingInput">CPF</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="rg" required name="rg" pattern="\d{10}" maxlength="10" onkeypress="return isNumber(event)">
                        <label for="floatingInput">RG</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="nome" required name="nome" maxlength="60" style="text-transform:lowercase;">
                        <label for="floatingInput">Nome</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="termo de segurança" required name="termo" maxlength="5" style="text-transform:lowercase;">
                        <label for="floatingInput">Termo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" placeholder="senha" required name="senha" id="senha" maxlength="5" style="text-transform:lowercase;">
                        <label for="floatingInput">Senha</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" placeholder="confirmar senha" required name="senha-confirma" id="senha-confirma" maxlength="5" style="text-transform:lowercase;">
                        <label for="floatingInput">Confirmar senha</label>
                    </div>
                    <button type="button" class="btn btn-danger" onclick="window.location.href='../index.php'">Voltar</button>
                    <button type="submit" class="btn btn-success" id="submitWithEnter" onclick="return validadePassoword()">Adicionar</button>
                    <button type="reset" class="btn btn-warning">Limpar</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>