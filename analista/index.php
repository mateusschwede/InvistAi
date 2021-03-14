<?php
    require_once '../conexao.php';
    session_start();
    if(!isset($_SESSION['analistaLogado'])) {header('Location: ../acessoNegado.php');}
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
<div class="container-fluid">

    <div class="row">
        <div class="col-sm-12" id="navbar">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php"><img src="https://img.icons8.com/fluent/24/000000/bad-idea.png"/> InvistAí<font size="2">(Analista)</font></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="perfil.php">Perfil</a></li>
                            <li class="nav-item"><a class="nav-link" href="acoes.php">Ações</a></li>
                            <li class="nav-item"><a class="nav-link" href="clientes.php">Clientes</a></li>
                            <li class="nav-item"><a class="nav-link" href="#" onclick="confirmlogout('../logout.php')" id="logout"><?=$_SESSION['nome']?>-logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h1>Operações de Cliente</h1>
            <div class="row">
                <div class="col-sm-12">
                    <form action="index.php" method="post">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" name="cpf">
                            <option selected>Selecione o cliente</option>
                                <?php
                                    $r = $db->query("SELECT cpf,nome FROM pessoa WHERE tipo=2 AND inativado=0 ORDER BY nome");
                                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($linhas as $l) {echo "<option value='".$l['cpf']."'>".$l['nome']." (cpf ".$l['cpf'].")</option>";}
                                ?>
                            </select>
                            <label for="floatingSelect">Dados do cliente</label>
                        </div>
                        <button type="submit" class="btn btn-success" id="submitWithEnter">Gerar relatório</button>
                        <button type="button" class="btn btn-primary" onclick="window.print()">Imprimir relatório</button>
                    </form>
                    <br><small><b>Compra:</b> Quantidade positiva<br><b>Venda:</b> Quantidade negativa</small>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Data</th>
                                    <th scope="col">Carteira</th>
                                    <th scope="col">Ativo</th>
                                    <th scope="col">Quantidade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(!empty($_POST['cpf'])) {
                                        $r = $db->prepare("SELECT id,objetivo FROM carteira WHERE cpfCliente=? ORDER BY objetivo");
                                        $r->execute(array($_POST['cpf']));
                                        $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                                        
                                        foreach($linhas as $l) {                                            
                                            $r = $db->prepare("SELECT * FROM operacao WHERE idCarteira=? ORDER BY dataOperacao DESC");
                                            $r->execute(array($l['id']));
                                            $linhas2 = $r->fetchAll(PDO::FETCH_ASSOC);
                                            
                                            foreach($linhas2 as $l2) {
                                                echo "
                                                    <tr>
                                                        <th scope='row'>".$l2['dataOperacao']."</th>
                                                        <td>".$l['objetivo']."</td>
                                                        <td>".$l2['ativoAcao']."</td>
                                                        <td>".$l2['qtdAcoes']."</td>
                                                    </tr>
                                                ";
                                            }
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>


</div>
</body>
</html>