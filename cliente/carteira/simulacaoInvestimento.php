<?php
    require_once '../../conexao.php';
    session_start();
    if(!isset($_SESSION['clienteLogado'])){header('Location: ../../acessoNegado.php');}
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
            <div class="col-sm-12 text-center">
                <h2 style='color: blue;'>Investir na carteira <?=$_SESSION['idCarteira']?>:
                <?php
                    $r = $db->prepare("SELECT objetivo,percInvestimento FROM carteira WHERE id=?");
                    $r->execute(array($_SESSION['idCarteira']));
                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas as $l) {echo "  ".$l['objetivo']."</h2>"; $objCarteira=$l['objetivo']; $percCart=$l['percInvestimento'];}
                ?>
                <div class="table-responsive">
                    <table class='table table-striped' style="font-size: 90%; text-align: right; line-height: 95%;">
                        <thead>
                            <tr>
                                <th scope='col'>Ativo</th>
                                <th scope='col'>Setor</th>
                                <th scope='col'>Quant. Atual</th>
                                <th scope='col'>Cotação Atual</th>
                                <th scope='col'>Patrimônio Atual</th>
                                <th scope='col'>Partic. Atual</th>                                
                                
                                <th scope='col'>Config. Objetivo</th>
                                <th scope='col'>Invest. a fazer</th>

                                <th scope='col'>Distância Objetivo</th>
                                <th scope='col'>Valor Projetado</th>
                                <th scope='col'>Partic. Projetada</th>
                                <th scope='col'>Quant.a adquirir</th>
                                <th scope='col'>Quant. Cotas</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                //Taylor (ValorNaCart)
                                $valornacart = 0;
                                $r = $db->prepare("SELECT * FROM operacao WHERE idCarteira=?");
                                $r->execute(array($_SESSION['idCarteira']));
                                $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                                foreach($linhas as $l) {
                                    $r = $db->prepare("SELECT * FROM acao WHERE ativo=?");
                                    $r->execute(array($l['ativoAcao']));
                                    $linhas2 = $r->fetchAll(PDO::FETCH_ASSOC);                                    
                                    
                                    foreach($linhas2 as $l2) {$cotacaoAtual = $l2['cotacaoAtual'];}
                                    $valornacart+=$l['qtdAcoes']*$l2['cotacaoAtual'];
                                }

                                //Pegar totalPatrimonioAtualizado da carteira
                                $totproj=$totPatrAtualizado = 0;
                                $totInvestimentoReal = 0;
                                $r = $db->prepare("SELECT * FROM carteira_acao WHERE idCarteira=?");
                                $r->execute(array($_SESSION['idCarteira']));
                                $linhas3 = $r->fetchAll(PDO::FETCH_ASSOC);
                                foreach($linhas3 as $l3) {                                    
                                    $r = $db->prepare("SELECT * FROM acao WHERE ativo=?");
                                    $r->execute(array($l3['ativoAcao']));
                                    $linhas4 = $r->fetchAll(PDO::FETCH_ASSOC);
                                    
                                    foreach($linhas4 as $l4) {$cotacaoAtualAcao = $l4['cotacaoAtual'];}
                                    $totPatrAtualizado += $l3['qtdAcao'] * $cotacaoAtualAcao;     // ERRO
                                }                                

                                //Percorre todas ações da carteira
                                $r = $db->prepare("SELECT * FROM carteira_acao WHERE idCarteira=?");
                                $r->execute(array($_SESSION['idCarteira']));
                                $linhas = $r->fetchAll(PDO::FETCH_ASSOC);                                

                                foreach($linhas as $l) { //Pegar dados específicos da ação citada
                                    $r = $db->prepare("SELECT * FROM acao WHERE ativo=?");
                                    $r->execute(array($l['ativoAcao']));
                                    $linhas2 = $r->fetchAll(PDO::FETCH_ASSOC);                                    
                                    
                                    foreach($linhas2 as $l2) {
                                        $ativo = $l2['ativo'];
                                        $setor = $l2['setor'];
                                        $cotacaoAtual = $l2['cotacaoAtual'];
                                    }
                                
                                    //Variáveis dos valores aqui
                                    $qtdAcoes = $l['qtdAcao'];
                                    $patrAtualizado = $qtdAcoes * $cotacaoAtual;
                                    
                                    if($totPatrAtualizado==0) {$partAtual=0;}
                                    else {$partAtual = ($patrAtualizado * 100) / $totPatrAtualizado;}
                                    
                                    $distObjetivo = $partAtual - $l['objetivo'];
                                   
                                    if($distObjetivo >= 0) {$qtdAcoesComprar = 0;}
                                    else {$qtdAcoesComprar = ($l['objetivo']*( ($_SESSION['valorInvestimento']+$totPatrAtualizado) / 100)) / $cotacaoAtual;}

                                    $ainv=(($_SESSION['valorInvestimento']+$totPatrAtualizado)*($l['objetivo']/100))-$patrAtualizado;
                                    $qtdAcoesComprar=(int)$ainv/$cotacaoAtual;
                                    $investimentoReal = (int)$qtdAcoesComprar * $cotacaoAtual;
                                    
                                    if($qtdAcoesComprar!=0) {$totInvestimentoReal += ((int)$qtdAcoesComprar*$cotacaoAtual);}

                                    //Taylor (quant)
                                    $quant = 0; $valcart = 0;
                                    $r = $db->prepare("SELECT * FROM operacao WHERE idCarteira=?");
                                    $r->execute(array($_SESSION['idCarteira']));
                                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                                    
                                    foreach($linhas as $l8)  {if($l8['ativoAcao']==$l['ativoAcao']) {$quant+=$l8['qtdAcoes'];} }
                                    
                                    if($l['qtdAcao']==0) {$percAcaoCarteira=0; $propInvA=0;}
                                    else {
                                        $percAcaoCarteira = ($quant+(int)$qtdAcoesComprar)*$cotacaoAtual*100/$valornacart;
                                        $propInvA = ($quant*$cotacaoAtual)/$valornacart*100;
                                    }
                                    
                                    if($investimentoReal<0){$investimentoReal=0;}
                                    
                                    if($qtdAcoesComprar<0){$qtdAcoesComprar=0;}
                                   
                                    echo "
                                        <tr>
                                            <td class='setx'>".strtoupper($ativo)."</td>
                                            <td class='set'>".$setor."</td>
                                            <td class='set'>".$qtdAcoes."</td>
                                            <td class='setx'>R$ ".number_format($cotacaoAtual,2,",",".")."</td>
                                            <td class='setx'>R$ ".number_format($patrAtualizado,2,",",".")."</td>
                                            
                                            <td class='set'>".number_format($propInvA,2,",",".")." %</td>
                                            <td class='set'>".number_format($l['objetivo'],2,",",".")." %</td>

                                            <td class='setx'>R$ ".number_format($investimentoReal,2,",",".")."</td>
                                            
                                            <td class='set'>".number_format($distObjetivo,2,",",".")." %</td>
                                            <td class='setx'>R$ ".number_format($investimentoReal+$patrAtualizado,2,",",".")."</td>
                                            <td class='set'>".number_format(($_SESSION['valorInvestimento']*($l['objetivo']/100)+$quant*$cotacaoAtual)/($_SESSION['valorInvestimento']+$valornacart)*100,2,",",".")." %</td>
                                            <td class='set'>".(int)$qtdAcoesComprar."</td>
                                            <td class='set'>".(int)($qtdAcoes+$qtdAcoesComprar)."</td>
                          
                                        </tr>
                                    ";
                                    $totproj+=$investimentoReal+$patrAtualizado;
                                }
                                echo "
                                    <tr>
                                        <td></td><td></td><td></td><td>Total: </td><td>R$ ".number_format($totPatrAtualizado,2,",",".")."</td>
                                        <td></td><td></td><td></td><td></td><td>R$".number_format($totproj,2,",",".")."</td><td></td><td></td><td></td><td></td>
                                    </tr>    


                                    <tr>
                                        <td class='setx' colspan='4' style='color: blue;'><b>Total Patr Atual:</b> R$ ".number_format($totPatrAtualizado,2,",",".")."</td>
                                        <td class='setx' colspan='4' style='color: green;'><b>Total a ser Investido:</b> R$ ".number_format($totInvestimentoReal,2,",",".")."</td>
                                        <td class='setx' colspan='4' style='color: red;'><b>Sobra do Aporte:</b> R$ ".number_format(($_SESSION['valorInvestimento']-$totInvestimentoReal),2,",",".")."</td>
                                        
                              <!--          <td class='setx' colspan='4' style='color: brown;'><b>Total Atual Projetado:</b> R$ ".number_format($totInvestimentoReal+$totPatrAtualizado,2,",",".")."</td>   -->
                                    <tr>
                                ";
                            ?>
                        </tbody>
                    </table>
                </div>                
                <br>
                <a href="canInvestimento.php" class="btn btn-danger">Cancelar</a>
                <a href="confInvestimento.php" class="btn btn-success" id="submitWithEnter">Confirmar Investimento</a>
            </div>
        </div>
    </div>
</body>
</html>  <!-- <td class='set'>".number_format($partAtual,2,",",".")." %</td>  <th scope='col'>Propor. Invest.</th> -->
