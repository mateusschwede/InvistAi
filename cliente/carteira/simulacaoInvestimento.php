<?php
    require_once '../../conexao.php';
    session_start();
    if(!isset($_SESSION['logado'])){header('Location: ../../acessoNegado.php');}

    if(!empty($_POST['valorInvestimento'])) {
        //Programar Confirmar Investimento (Inserir na table 'investimento'). Tem a $_SESSION['valorInvestimento'], $_SESSION['cpfCliente] e $_SESSION['idCarteira'] para auxiar
        unset($_SESSION['idCarteira']);
        unset($_SESSION['valorInvestimento']);
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
                        <a class="navbar-brand"><img src="https://img.icons8.com/fluent/24/000000/bad-idea.png"> InvistAí<font size="2">(Cliente)</font></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                            <li class="nav-item"><a class="nav-link disabled">Home</a></li>
                                <li class="nav-item"><a class="nav-link disabled">Perfil</a></li>
                                <li class="nav-item"><a class="nav-link disabled">Ações</a></li>
                                <li class="nav-item"><a class="nav-link disabled"><?=$_SESSION['nome']?>-logout</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                <h3>Investir à carteira <?=$_SESSION['idCarteira']?>:</h3>

                Usar este valor para investir:
                <?php
                    $r = $db->query("SELECT valor FROM investimento ORDER BY id DESC LIMIT 1");
                    if($r->rowCount()==0) {$ultimoInvestimento = 0;}
                    else {
                        $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                        foreach($linhas as $l) {$ultimoInvestimento = number_format($l['valor'],2,".",",");}
                    }
                    echo "<span class='btn btn-dark'>R$ ".number_format($_SESSION['valorInvestimento'],2,".",",")." + R$ ".number_format($ultimoInvestimento,2,".",",")." = <span class='badge bg-warning'>R$ ".number_format(($ultimoInvestimento+$_SESSION['valorInvestimento']),2,".",",")."</span></span>";
                    $investimentoReal = $ultimoInvestimento+$_SESSION['valorInvestimento'];
                ?>

                <div class="table-responsive">
                    <table class='table table-striped'>
                        <thead>
                            <tr>
                                <th scope='col'>Previsão(%)</th>
                                <th scope='col'>Previsão(R$)</th>
                                <th scope='col'>Atual(R$)</th>
                                <th scope='col'>At/Total(%)</th>
                                <th scope='col'>Nr Ct</th>
                                <th scope='col'>Ativo</th>
                                <th scope='col'>Cotação(R$)</th>
                                <th scope='col'>Incluir</th>
                                <th scope='col'>Cotas(Qtd)</th>
                                <th scope='col'>Comprar(R$)</th>
                                <th scope='col'>Total(%)</th>
                                <th scope='col'>Proporção(%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $r = $db->prepare("SELECT ativoAcao,objetivo,qtdAcao FROM carteira_acao WHERE idCarteira=?");
                                $r->execute(array($_SESSION['idCarteira']));
                                $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                                foreach($linhas as $l) {

                                    $r = $db->prepare("SELECT cotacaoAtual FROM acao WHERE ativo=?");
                                    $r->execute(array($l['ativoAcao']));
                                    $linhas2 = $r->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($linhas2 as $l2) {
                                        echo "
                                            <tr>
                                                <td class='set'>".$l['objetivo']."</td>
                                                <td class='set'>".number_format(($investimentoReal/100)*$l['objetivo'],2,".",",")."</td>
                                                <td class='set'>x</td>
                                                <td class='set'>x</td>
                                                <td class='set'>x</td>
                                                <td class='setx'>".strtoupper($l['ativoAcao'])."</td>
                                                <td class='set'>".number_format($l2['cotacaoAtual'],2,".",",")."</td>
                                                <td class='set'>x</td>
                                                <td class='set'>x</td>
                                                <td class='set'>x</td>
                                                <td class='set'>x</td>
                                                <td class='set'>x</td>
                                            </tr>
                                        ";
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>

                <form action="simulacaoInvestimento.php" method="post">
                    <input type="hidden" name="valorInvestimento" value="<?$ultimoInvestimento+$_SESSION['valorInvestimento']?>">
                    <a href="canInvestimento.php" class="btn btn-danger">Cancelar</a>
                    <input type="submit" class="btn btn-success" value="Confirmar">
                </form>
            </div>
        </div>
    </div>

</body>
</html>