<?php
    require_once '../conexao.php';
    session_start();
    if(!isset($_SESSION['clienteLogado'])) {header('Location: ../acessoNegado.php');}
    if(isset($_SESSION['msg'])) {echo $_SESSION['msg'];unset($_SESSION['msg']);}
    if(isset($_SESSION['idCarteira'])) {unset($_SESSION['idCarteira']);}
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
                        <a class="navbar-brand" href="index.php"><img src="https://img.icons8.com/fluent/24/000000/bad-idea.png"/> InvistAí<font size="2">(Cliente)</font></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                                <li class="nav-item"><a class="nav-link" href="perfil.php">Perfil</a></li>
                                <li class="nav-item"><a class="nav-link" href="acoes.php">Ações</a></li>
                                <li class="nav-item"><a class="nav-link" href="#" onclick=" confirmlogout('../logout.php')" id="logout"><?=$_SESSION['nome']?>-logout</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <h1>Minhas Carteiras</h1>
                <?php
                    $r = $db->prepare("SELECT totalSobraAportes FROM pessoa WHERE cpf=?");
                    $r->execute(array($_SESSION['cpf']));
                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas as $l) {$totalSobraAportes = $l['totalSobraAportes'];}
                ?>
                <div class="text-center">
                    <a href="carteira/addCarteira.php" class="btn btn-primary">Adicionar Carteira</a>
                    <?php
                    //VALOR TOTAL DO CLIENTE NO SISTEMA: Soma das quantidades de ações de cada carteira + Total da Sobra dos Aportes
                    $totalCarteiras = 0;
                    //Pegar Soma das Quantidades de Ações:
                    $r = $db->prepare("SELECT * FROM carteira WHERE cpfCliente=?");
                    $r->execute(array($_SESSION['cpf']));
                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas as $l) {
                        
                        //Pegar qtdes das ações na carteira * valor da cotação
                        $r = $db->prepare("SELECT * FROM carteira_acao WHERE idCarteira=?");
                        $r->execute(array($l['id']));
                        $linhas2 = $r->fetchAll(PDO::FETCH_ASSOC);
                        foreach($linhas2 as $l2) {

                            //Pegar valor da cotação da ação
                            $r = $db->prepare("SELECT cotacaoAtual FROM acao WHERE ativo=?");
                            $r->execute(array($l2['ativoAcao']));
                            $linhas3 = $r->fetchAll(PDO::FETCH_ASSOC);
                            foreach($linhas3 as $l3) {$cotacaoAtual = $l3['cotacaoAtual'];}

                            if($l2['qtdAcao']!=0) {$totalCarteiras += ($l2['qtdAcao']*$cotacaoAtual);}
                        }

                    }

                    //Pegar valor total das sobras dos investimentos
                    $r = $db->prepare("SELECT totalSobraAportes FROM pessoa WHERE cpf=?");
                    $r->execute(array($_SESSION['cpf']));
                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas as $l) {$totalSobras = $l['totalSobraAportes'];}

                ?></div>





                <div class="table-responsive">
                    <table class='table table-striped'>
                        <thead>
                            <tr>
                                <th scope='col'>Id</th>
                                <th scope='col'>Descrição</th>
                                <th scope='col'>Objetivo(%)</th>
                                <th scope='col'>Participação Atual(%)</th>
                                <th scope='col'>Patrimônio Atualizado</th>
                                <th scope='col'>Patrimônio Previsto</th>
                                <th scope='col'>Diferença de Patrimônios</th>
                                <th scope='col'>Situação</th>
                                <th scope='col'></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $r = $db->prepare("SELECT * FROM carteira WHERE cpfCliente=?");
                                $r->execute(array($_SESSION['cpf']));
                                $linhas = $r->fetchAll(PDO::FETCH_ASSOC);                                

                                foreach($linhas as $l) {
                                    $p = $db->prepare("SELECT objetivo FROM carteira_acao WHERE idCarteira=?");
                                    $p->execute(array($l['id']));
                                    $ob = $p->fetchAll(PDO::FETCH_ASSOC);
                                    $tot=0;

                                    foreach($ob as $o) {$tot=$tot+$o['objetivo'];}
                                    $sit="Objetivo Completo";
                                    $pati1= $totalCarteiras/100*$l['percInvestimento']/100*$tot;
                                    $pati2= $totalCarteiras/100*$l['percInvestimento'];
                                    if ($pati2-$pati1>0) {
                                        $sit="Objetivo incompleto";
                                    }
                                    echo "
                                        <tr>
                                            <th scope='row'>".($l['id'])."</th>
                                            <td class='setn'>".$l['objetivo']."</td>
                                            <td class='set'>".number_format($l['percInvestimento'],2,".",",")." %</td>
                                            <td class='set'>".$l['percInvestimento']/100*$tot."%</td> 
                                            <td class='set'style=' text-transform: capitalize !important;'>R$ ".number_format($pati1,2,",",".")."</td>
                                            <td class='set'style=' text-transform: capitalize !important;'>R$ ".number_format($pati2,2,",",".")."</td>
                                            <td class='set'style=' text-transform: capitalize !important;'>R$ ".number_format($pati2-$pati1,2,",",".")."</td>
                                            <td class='set'style=' text-transform: capitalize !important;' >".$sit."</td>
                                            <td class='set'><a href='carteira/investirCarteira.php?id=".$l['id']."' class='btn btn-success btn-sm'>Acessar carteira</a></td>
                                        </tr>
                                    ";
                                }
                                echo "
                                    <tr class='text-muted'>
                                        <td class='setn' colspan=8>Ações sem carteiras no momento</td>
                                        <td class='set'><a href='editarCarteira/acoesSemCarteira.php' class='btn btn-warning btn-sm'>Acessar ações</a></td>
                                    </tr>
                                ";
                            ?>
                        </tbody>
                    </table>
                </div>
                <div>
                <?php
                echo "Total em Investimentos: R$ ".number_format($totalCarteiras,2,".",",")."<br>";
                echo "Total de Sobras R$ ".number_format($totalCarteiras,2,".",",")."<br>";
                $totalCarteiras += $totalSobras;
                echo "TOTAL R$ ".number_format($totalCarteiras,2,".",",");
                ?>
                </div>

            </div>
        </div>        
    </div>
</body>
</html>