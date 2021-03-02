<?php
    require_once '../../conexao.php';
    session_start();
    if(!isset($_SESSION['logado'])){header('Location: ../../acessoNegado.php');}
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
                <h2>Investir na carteira <?=$_SESSION['idCarteira']?>:</h2>
                <?php
                    $r = $db->prepare("SELECT totValorInvestimento FROM investimento WHERE idCarteira=? ORDER BY id DESC LIMIT 1");
                    $r->execute(array($_SESSION['idCarteira']));
                    if($r->rowCount()==0) {$ultimoInvestimento = 0;}
                    else {
                        $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                        foreach($linhas as $l) {$ultimoInvestimento = number_format($l['totValorInvestimento'],2,".",",");}
                    }
                    echo "<span class='btn btn-dark'>R$ ".number_format($_SESSION['valorInvestimento'],2,".",",")." + R$ ".number_format($ultimoInvestimento,2,".",",")." = <span class='badge bg-warning'>R$ ".number_format(($ultimoInvestimento+$_SESSION['valorInvestimento']),2,".",",")."</span></span>";
                    $investimentoReal = $ultimoInvestimento+$_SESSION['valorInvestimento'];
                ?>
                <p>Sobra dos Aportes: R$ 0.00</p>

                <div class="table-responsive">
                    <table class='table table-striped'>
                        <thead>
                            <tr>
                                <th scope='col'>Ativo</th>
                                <th scope='col'>Setor</th>
                                <th scope='col'>Quantidade</th>
                                <th scope='col'>Cotação Atual</th>
                                <th scope='col'>Patrimônio Atualizado</th>
                                <th scope='col'>Participação Atual(%)</th>
                                <th scope='col'>Objetivo(%)</th>
                                <th scope='col'>Distância do Objetivo(%)</th>
                                <th scope='col'>Quantas Ações Comprar</th>  
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                //Programar tabela visual com variáveis aqui
                                $r = $db->prepare("SELECT * FROM carteira_acao WHERE idCarteira=?");
                                $r->execute(array($_SESSION['idCarteira']));
                                $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                                
                                foreach($linhas as $l) {
                                    //Pegar dados específicos da ação citada
                                    $r = $db->prepare("SELECT * FROM acao WHERE ativo=?");
                                    $r->execute(array($l['ativoAcao']));
                                    $linhas2 = $r->fetchAll(PDO::FETCH_ASSOC);
                                    
                                    foreach($linhas2 as $l2) {
                                        $ativo = $l2['ativo'];
                                        $setor = $l2['setor'];
                                        $cotacaoAtual = $l2['cotacaoAtual'];
                                    }

                                    //Programar variáveis aqui
                                    $quantidadeAcoes = $l['qtdAcao'];
                                    $qtdAcoesComprar = ($l['objetivo']*($investimentoReal/100)) / $cotacaoAtual;
                                    $patrimonioAtualizado = $quantidadeAcoes * $cotacaoAtual;
                                    $participacaoAtual = ($patrimonioAtualizado / $investimentoReal) * 100;                                
                                    $distanciaDoObjetivo = $participacaoAtual -  $l['objetivo'];

                                    echo "
                                        <tr>
                                            <td class='setx'>".strtoupper($ativo)."</td>
                                            <td class='set'>".$setor."</td>
                                            <td class='set'>".$quantidadeAcoes."</td>
                                            <td class='setx'>R$ ".$cotacaoAtual."</td>
                                            <td class='setx'>R$ ".number_format($patrimonioAtualizado,2,".",",")."</td>
                                            <td class='set'>".number_format($participacaoAtual,2,".",",")." %</td>                                            
                                            <td class='set'>".number_format($l['objetivo'],2,".",",")." %</td>
                                            <td class='set'>".number_format($distanciaDoObjetivo,2,".",",")." %</td>
                                            <td class='set'>".(int)$qtdAcoesComprar."</td>
                                        </tr>
                                    ";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <form action="confInvestimento.php" method="post">
                    <a href="canInvestimento.php" class="btn btn-danger">Cancelar</a>
                    <button type="submit" class="btn btn-success">Realizar Investimento</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>