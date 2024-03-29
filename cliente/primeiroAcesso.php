<?php
    require_once '../conexao.php';
    session_start();

    if(!isset($_SESSION['clienteLogado'])):
        header('Location: ../acessoNegado.php');
    endif;

    $r = $db->prepare("SELECT * FROM pessoa WHERE cpf=?");
    $r->execute(array($_SESSION['cpf']));
    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
    foreach($linhas as $l) {$nome = $l['nome'];$senha = $l['senha'];}

    if( (!empty($_POST['nome'])) and (!empty($_POST['email'])) and (!empty($_POST['celular'])) and (!empty($_POST['endereco'])) and (!empty($_POST['senha'])) ) {
        $r = $db->prepare("UPDATE pessoa SET nome=?,email=?,celular=?,endereco=?,senha=? WHERE cpf=?");
        $r->execute(array($_POST['nome'],$_POST['email'],$_POST['celular'],$_POST['endereco'],md5($_POST['senha']),$_SESSION['cpf']));
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>Cadastro atualizado, retorne e faça login!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
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
    <script src="../script.js"></script>
    <script type="text/javascript" src="../pace.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="container">
    <div class="container-fluid">
        <div class="row text-center">
            <div class="col-sm-12">
                <h2><?=$nome?>, bem-vindo(a) ao InvistAí!</h2>
                <h4 class="text-muted">Complete seu cadastro para acessar o sistema</h4>                
                <form action="primeiroAcesso.php" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="nome e sobrenome" required name="nome" maxlength="60" style="text-transform:lowercase;" value="<?=$nome?>">
                        <label for="floatingInput"> Nome </label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" placeholder="email" required name="email" maxlength="60" style="text-transform:lowercase;">
                        <label for="floatingInput"> E-mail </label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="celular" required name="celular" pattern="\d{11}" onkeypress="return isNumber(event)">
                        <label for="floatingInput"> Celular </label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="endereço completo" required name="endereco" maxlength="200" style="text-transform:lowercase;">
                        <label for="floatingInput"> Endereço completo </label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" placeholder="nova senha" required name="senha" maxlength="5" style="text-transform:lowercase;">
                        <label for="floatingInput"> Senha </label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" placeholder="confirmar senha" required name="senha-confirma" id="senha-confirma" maxlength="5" style="text-transform:lowercase;">
                        <label for="floatingInput"> Confirmar senha </label>
                    </div>
                    <button type="button" class="btn btn-danger" onclick="window.location.href='../index.php'">Voltar</button>
                    <button type="submit" class="btn btn-success" id="submitWithEnter" onclick="return validadePassoword()">Confirmar</button>
                    <button type="reset" class="btn btn-warning">Limpar</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>