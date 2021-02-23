<?php
    require_once '../conexao.php';
    session_start();

    if(!isset($_SESSION['logado'])):
        header('Location: ../acessoNegado.php');
    endif;
    
    $msgSucesso = false;
    if(!empty($_POST['nome']) and (!empty($_POST['senha']))) {
        $r = $db->prepare("UPDATE pessoa SET nome = :nome, senha = :senha WHERE cpf = :cpf");
    
        $r->execute(array(
            ":cpf" => $_SESSION['cpf'],
            ":nome" => $_POST['nome'],
            ":senha" => md5($_POST['senha'])
        ));
        header('Location: ./perfil.php');
    }

    if(!$_GET['cpf']) {
        //header('Location: ../acessoNegado.php');
    }

    $req = $db->prepare("SELECT * FROM pessoa WHERE cpf = :cpf");

    $req->execute(array(
        ":cpf" => $_SESSION['cpf']
    ));

    $analista = $req->fetchAll();

    if (!count($analista)) {
        //header('Location: ../acessoNegado.php');
    }

    $analista = $analista[0];
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
    <div class="container-fluid">
        <!-- Menu de Navegação -->
        <div class="row">
            <div class="col-sm-12" id="navbar">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="index.php"><img src="https://img.icons8.com/fluent/24/000000/bad-idea.png"/> InvistAí<font size="2">(Analista)</font></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                                <li class="nav-item"><a class="nav-link"href="perfil.php">Perfil</a></li>
                                <li class="nav-item"><a class="nav-link active" aria-current="page" href="acoes.php">Ações</a></li>
                                <li class="nav-item"><a class="nav-link" href="clientes.php">Clientes</a></li>
                                  <li class="nav-item"><a class="nav-link" href="#" onclick=" confirmlogout('../logout.php')" id="logout"><?=$_SESSION['nome']?>-logout</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12 text-center">
            <?= $msgSucesso ?  "<div class='alert alert-success alert-dismissible fade show' role='alert'>Dados Atualizados!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>" : "" ?>

                <h1>Editar Perfil</h1>
                <form action="updateAnalista.php" method="post">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="cpf" required name="cpf" pattern="\d{11}" onkeypress="return isNumber(event)" disabled value="<?=$analista['cpf']?>">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="rg" required name="rg" pattern="\d{10}" onkeypress="return isNumber(event)" disabled value="<?=$analista['rg']?>">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="nome" required name="nome" maxlength="60" style="text-transform:lowercase;" value="<?=$analista['nome']?>">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="senha" required name="senha" id="senha" maxlength="5" style="text-transform:lowercase;" value="<?=$analista['senha']?>">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="confirmar senha" required name="senha-confirma" id="senha-confirma" maxlength="5" style="text-transform:lowercase;" value="<?=$analista['senha']?>">
                    </div>
                <button type="button" class="btn btn-danger" onclick="window.location.href='perfil.php'">Voltar</button>
                    <button type="submit" class="btn btn-success" id="submitWithEnter" onclick="return validadePassoword()">Atualizar</button>
                    <button type="reset" class="btn btn-warning">Limpar</button>
                </form>
            </div>
        </div>


    </div>
</body>
</html>