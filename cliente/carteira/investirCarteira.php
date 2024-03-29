<?php
require_once '../../conexao.php';
session_start();
if (!isset($_SESSION['clienteLogado'])) {
    header('Location: ../../acessoNegado.php');
}

if (isset($_GET['id'])) {
    $_SESSION['idCarteira'] = $_GET['id'];
}
if ((isset($_SESSION['investimentoReal'])) and (isset($_SESSION['valorInvestimento']))) {
    unset($_SESSION['investimentoReal']);
    unset($_SESSION['valorInvestimento']);
}

if ((!empty($_GET['idCarteira'])) and (!empty($_POST['valorInvestimento']))) {
    $_SESSION['idCarteira'] = $_GET['idCarteira'];
    $_SESSION['valorInvestimento'] = $_POST['valorInvestimento'];
    header("location: simulacaoInvestimento.php");
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
                                <li class="nav-item"><a class="nav-link" href="#" onclick=" confirmlogout('../../logout.php')" id="logout"><?= $_SESSION['nome'] ?>-logout</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="text-center">
                    <h1>Carteira <?= $_SESSION['idCarteira'] ?></h1>
                    <?php
                    $r = $db->prepare("SELECT * FROM carteira WHERE id=?");
                    $r->execute(array($_SESSION['idCarteira']));
                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($linhas as $l) {
                        echo "<h4 class='text-muted'>" . $l['objetivo'] . " (" . $l['percInvestimento'] . "%)</h4>";
                        $percCarteira = $l['percInvestimento'];
                    }
                    ?>
                    <a href="../index.php" class="btn btn-secondary">Voltar</a> <a href="excluirCarteira.php" class="btn btn-danger">Excluir Carteira</a> <a href="editarCarteira.php?perc=<?= $percCarteira ?>" class="btn btn-warning">Alterar carteira</a>
                </div>

                <h3>Investir na carteira:</h3>
                <form action="investirCarteira.php?idCarteira=<?= $_SESSION['idCarteira'] ?>" method="post">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" required id="floatingInput" name="valorInvestimento" placeholder="Valor à investir" step="0.01" min="0.01" max="999999999">
                        <label for="floatingInput">Valor à investir</label>
                    </div>
                    <?php
                    $r = $db->prepare("SELECT ativoAcao FROM carteira_acao WHERE idCarteira=?");
                    $r->execute(array($_SESSION['idCarteira']));
                    if ($r->rowCount() > 0) {
                        echo "<button type='submit' class='btn btn-success'>Conferir Investimento</button>";
                    } else {
                        echo "<small class='text-muted'>Para poder investir, inclua ações na carteira!</small><br><button type='submit' class='btn btn-success' disabled>Conferir Investimento</button>";
                    }
                    ?>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <br>
                <h3>Ações:</h3>
                <a href="incluirAcaoCarteira.php" class="btn btn-success btn-sm">Incluir ação</a>
                <div class="table-responsive">
                    <table class='table table-striped'>
                        <thead>
                            <tr>
                                <th scope='col'>Ativo</th>
                                <th scope='col'>Nome</th>
                                <th scope='col'>Objetivo</th>
                                <th scope='col'>Quantidade</th>
                                <th scope='col'>Cotação</th>
                                <th scope='col'>Total</th>
                                <th scope='col'></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $valorCarteira = 0;
                            $r = $db->prepare("SELECT * FROM carteira_acao WHERE idCarteira=?");
                            $r->execute(array($_SESSION['idCarteira']));
                            $linhas = $r->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($linhas as $l) {
                                $r = $db->prepare("SELECT * FROM acao WHERE ativo=?");
                                $r->execute(array($l['ativoAcao']));
                                $linhas2 = $r->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($linhas2 as $l2) {
                                    $valorCarteira += $l2['cotacaoAtual'] * $l['qtdAcao'];
                                    echo "
                                            <tr>
                                                <td class='setx'>" . $l['ativoAcao'] . "</td>
                                                <td class='setx'>" . $l2['nome'] . "</td>
                                                <td class='setx'>" . $l['objetivo'] . "%</td>
                                                <td class='setx'>" . $l['qtdAcao'] . "</td>
                                                <td class='setx'>R$ " . number_format($l2['cotacaoAtual'], 2, ".", ",") . "</td>
                                                <td class='setx'>R$ " . number_format(($l2['cotacaoAtual'] * $l['qtdAcao']), 2, ".", ",") . "</td>
                                                <td class='setx'><a href='excluirAcaoCarteira.php?ativoAcao=" . $l['ativoAcao'] . "&qtdAcao=" . $l['qtdAcao'] . "' class='btn btn-danger btn-sm'>Excluir</a> <a href='editarAcaoCarteira.php?ativoAcao=" . $l['ativoAcao'] . "' class='btn btn-warning btn-sm'>Alterar</a> <a href='moverAcaoCarteira.php?ativoAcao=" . $l['ativoAcao'] . "' class='btn btn-info btn-sm'>Trocar carteira</a> <a href='venderAcao.php?ativo=" . $l['ativoAcao'] . "&idCarteira=" . $_SESSION['idCarteira'] . "' class='btn btn-primary btn-sm'>Vender</a></td>
                                            </tr>
                                        ";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- grafics here 
        <div class="container">
            <script type="text/javascript">
                google.charts.load("current", {
                    packages: ["corechart"]
                });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    let data = google.visualization.arrayToDataTable([
                        ['Ativo', 'Part. Atual'],
                        < ?php
                            $patrAtualizado = 0;
                            
                            $r = $db->prepare("SELECT * FROM carteira_acao WHERE idCarteira=?");
                            $r->execute(array($_SESSION['idCarteira']));
                            $linhas2 = $r->fetchAll(PDO::FETCH_ASSOC);
                            
                            foreach ($linhas2 as $l2) {
                                $r = $db->prepare("SELECT * FROM acao WHERE ativo=?");
                                $r->execute(array($l2['ativoAcao']));
                                $linhas3 = $r->fetchAll(PDO::FETCH_ASSOC);
                                
                                foreach ($linhas3 as $l3) {
                                    $valorAcao = $l3['cotacaoAtual'] * $l2['qtdAcao'];
                                    $patrAtualizado += $valorAcao;
                                }
                            }

                            $partAtual = ($patrAtualizado * 100) / $totalCarteiras;
                            
                            //Linha do gráfico
                            echo "['" . $l2['ativoAcao'] . "', " . $partAtual . "],";                        
                        ?>
                    ]);
                    let options = {
                        title: 'Ações',
                        pieHole: 0.4
                    };
                    let chart = new google.visualization.PieChart(document.getElementById('donutchart3'));
                    chart.draw(data, options);
                }
            </script>
            <div id="donutchart3" style="width: 100px; height: 75px; margin: auto;"></div>
        </div>
                        -->
        <div class="row">
            <div class="col-sm-12">
                <br>
                <h3>Operações:</h3>
                <small><b>Compra:</b> Quantidade positiva<br><b>Venda:</b> Quantidade negativa</small>
                <div class="table-responsive">
                    <table class='table table-striped'>
                        <thead>
                            <tr>
                                <th scope='col'>Data</th>
                                <th scope='col'>Ativo</th>
                                <th scope='col'>Quantidade</th>
                                <th scope='col'>Valor</th>
                                <th scope='col'>Proporção Atual</th>
                                <th scope='col'>Objetivo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $r = $db->prepare("SELECT * FROM operacao WHERE idCarteira=? ORDER BY dataOperacao DESC");
                            $r->execute(array($_SESSION['idCarteira']));
                            $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($linhas as $l) {

                                $r = $db->prepare("SELECT * FROM acao WHERE ativo=?");
                                $r->execute(array($l['ativoAcao']));
                                $linhas2 = $r->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($linhas2 as $l2) {
                                    $r = $db->prepare("SELECT objetivo FROM carteira_acao WHERE idCarteira=? AND ativoAcao=?");
                                    $r->execute(array($_SESSION['idCarteira'], $l['ativoAcao']));
                                    $linhas3 = $r->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($linhas3 as $l3) {
                                        $valorOperacao = $l['qtdAcoes'] * $l2['cotacaoAtual'];
                                        if ($valorCarteira == 0) {
                                            $proporcao = 0;
                                        } else {
                                            $proporcao = ($valorOperacao * 100) / $valorCarteira;
                                        }

                                        echo "
                                                <tr>
                                                    <th scope='row'>" . $l['dataOperacao'] . "</th>
                                                    <td class='setx'>" . $l['ativoAcao'] . "</td>
                                                    <td class='setx'>" . $l['qtdAcoes'] . "</td>
                                                    <td class='setx'>R$ " . number_format($valorOperacao, 2, ".", ",") . "</td>
                                                    <td class='setx'>" . number_format($proporcao, 2, ".", ",") . "%</td>
                                                    <td class='setx'>" . $l3['objetivo'] . "%</td>
                                                </tr>
                                            ";
                                    }
                                }
                            }
                            echo "
                                    <tr>
                                        <td colspan=2><td class='setx'><b>Total em Carteira:</b></td><td class='setx' colspan=3><b>R$ " . number_format($valorCarteira, 2, ".", ",") . "</b></td>
                                    </tr>
                                ";
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</body>

</html>