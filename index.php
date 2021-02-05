<?php
    require_once 'conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>InvistAí</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="container-fluid">


    <div class="row">
        <div class="col-sm-12 text-center">
            <h1>InvistAí</h1>
            <h4 class="text-muted">Software de recomendações de compras de ações</h4>
            <form action="index.php" method="post">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="nome" required name="nome" maxlength="60" style="text-transform:lowercase;">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" placeholder="senha" required name="senha" maxlength="5" style="text-transform:lowercase;">
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
            </form>
            <br>
            <a href="analista/addAnalista.php" class="btn btn-secondary btn-sm">Novo analista</a>
        </div>
    </div>


</div>
</body>
</html>