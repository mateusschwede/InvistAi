<?php
    require_once 'conexao.php';

    if( (!empty($_POST['cpf'])) and (!empty($_POST['senha'])) ) {
        $r = $db->prepare("SELECT * FROM pessoa WHERE cpf=? AND senha=? AND inativado=0");
        $r->execute(array($_POST['cpf'],$_POST['senha']));
        
        if($r->rowCount()==0) {echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Dado(s) incorreto(s) ou inativados!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";}
        else {
            session_start();

            $_SESSION['logado'] = true;
            
            $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
            foreach($linhas as $l) {
                
                $_SESSION['cpf'] = $l['cpf'];
                $_SESSION['tipo'] = $l['tipo'];
                $_SESSION['nome'] = $l['nome'];             

                if($l['tipo']==1) {header("location: analista/index.php");}
                elseif($l['tipo']==2) {
                    if($l['email']==null) {header("location: cliente/primeiroAcesso.php");}
                    else {header("location: cliente/index.php");}
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>InvistAí</title>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="https://img.icons8.com/fluent/96/000000/bad-idea.png">
    <link rel="stylesheet" href="estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<script src="../script.js"></script> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="script.js"></script>
    <script type="text/javascript" src="pace.min.js"></script>

</head>
<body id="login">
<div class="container" id="login2">
    <div class="container-fluid">


        <div class="row">
            <div class="col-sm-12 text-center">
                <img src="https://img.icons8.com/fluent/96/000000/bad-idea.png"/>
                <h1>InvistAí</h1>
                <h4 class="text-muted">Software de recomendações de compras de ações</h4>
                <form action="index.php" method="post">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="cpf" required name="cpf" pattern="\d{11}" onkeypress="return isNumber(event)">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="senha" required name="senha" maxlength="5" style="text-transform:lowercase;">
                    </div>
                    <button id="submitWithEnter" type="submit" class="btn btn-primary btn-lg">Entrar</button>
                </form>
                <br>
                <a href="cliente/addAnalista.php" class="btn btn-secondary btn-sm">Novo analista</a>
            </div>
        </div>


    </div>
</div>
</body>
</html>