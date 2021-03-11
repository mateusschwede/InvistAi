<?php
    require_once './conexao.php';
    session_start();

    function validaAcesso(){
        $x = 0;
        if(isset($_SESSION['clienteLogado'])){
            $x = 1;
        } elseif(isset($_SESSION['analistaLogado'])){
            $x = 1;
        }
        if($x == 0):
            header('Location: ./acessoNegado.php');
        endif;
    }
    validaAcesso();
        
    $msgErro = false;

    $msgSucesso = false;
    if(!empty($_POST['novaSenha']) && !empty($_POST['senhaAtual'])) {
        $statement = $db->prepare("SELECT senha FROM pessoa WHERE cpf = :cpf");
    
        $statement->execute(array(
            ":cpf" => $_SESSION['cpf'],
        ));

        $pessoa = $statement->fetch(PDO::FETCH_ASSOC);
        //echo $pessoa['senha'];
       // echo '<br>';
        //echo md5($_POST['senhaAtual']);
       if ($pessoa['senha'] == md5($_POST['senhaAtual'])) {
           $statement2 = $db->prepare("UPDATE pessoa SET senha = :senha WHERE cpf = :cpf");
           $statement2->execute(array(
               ':senha' => md5($_POST['novaSenha']),
               ':cpf' => $_SESSION['cpf'] 
           ));
           $msgSucesso = true;
       }
       else {
        $msgErro = true;
       }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>InvistAí</title>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="https://img.icons8.com/fluent/96/000000/bad-idea.png">
    <link rel="stylesheet" href="./estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="./script.js"></script>
    <script type="text/javascript" src="./pace.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <!-- Menu de Navegação -->
        <div class="row">
            <div class="col-sm-12" id="navbar">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#"><img src="https://img.icons8.com/fluent/24/000000/bad-idea.png"/> InvistAí</font></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item"><a class="nav-link disabled">Home</a></li>
                                <li class="nav-item"><a class="nav-link disabled">Perfil</a></li>
                                <li class="nav-item"><a class="nav-link disabled">Ações</a></li>
                                <li class="nav-item"><a class="nav-link disabled">Clientes</a></li>
                                <li class="nav-item"><a class="nav-link" href="#" onclick="confirmlogout('logout.php')" id="logout"><?=$_SESSION['nome']?>-logout</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
            <?= $msgSucesso ?  "<div class='alert alert-success alert-dismissible fade show' role='alert'>Senha atualizada!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>" : "" ?>
            <?= $msgErro ?  "<div class='alert alert-error alert-dismissible fade show' role='alert'>Dados incorretos!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>" : "" ?>

                <h1>Atualizar Senha</h1>
                <form action="atualizarSenha.php" method="post">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" placeholder="Senha Atual" maxlength="5" required name="senhaAtual">
                        <label for="floatingInput">Senha atual</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" placeholder="Nova Senha" maxlength="5" required name="novaSenha">
                        <label for="floatingInput">Nova senha</label>
                    </div>
                    <button type="button" class="btn btn-danger" onclick="window.location.href='logout.php'">Sair</button>
                    <button type="submit" class="btn btn-success" id="submitWithEnter" onclick="return validadePassoword()">Atualizar</button>
                    <button type="reset" class="btn btn-warning">Limpar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>