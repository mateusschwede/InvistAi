<?php
    require_once '../../conexao.php';
    session_start();

    if(!isset($_SESSION['logado'])):
       // header('Location: ../../acessoNegado.php');
    endif;

    if((!empty($_POST['objetivo'])) and (!empty($_POST['valor'])) ) {
        $r = $db->prepare("SELECT id FROM carteira  WHERE objetivo=? AND cpfCliente=?");
        $r->execute(array($_POST['objetivo'],$_SESSION['cpf']));
        if(($r->rowCount()==0)) {
            $r = $db->prepare("INSERT INTO carteira(objetivo,investimento,cpfCliente) VALUES (?,?,?)");
            $r->execute(array($_POST['objetivo'],number_format($_POST['valor'],2,"."),$_SESSION['cpf']));
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>Carteira adicionada!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        } else {echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Objetivo já existente!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";}
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

        
        <!-- Menu de Navegação -->
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
                                <li class="nav-item"><a class="nav-link" href="#" onclick="confirmlogout2()" id="logout"><?=$_SESSION['nome']?>-logout</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
            <div class="container">
                <h1>Adicionar carteira</h1>
                <form action="addCarteira.php" method="post">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Objetivo (ex: aposentadoria)" required name="objetivo" required maxlength="200" style="text-transform:lowercase;">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" required name="valor" pattern="\d{1,6}\.\d{2}" placeholder="valor do investimento (ex: 300.99)" onkeypress="return isNumberAndDot(event)">
                        <div class="form-text">Use ponto no lugar de vírgula</div>
                    </div>
                    <a href="../index.php" class="btn btn-danger">Voltar</a>
                    <button type="reset" class="btn btn-warning">Limpar</button>
                    <button type="submit" class="btn btn-success" id="submitWithEnter">Adicionar</button>
                    <button type="reset" class="btn btn-warning">Limpar</button>
                </form>
            </div>
            </div>
        </div>
    </div>

</body>
</html>