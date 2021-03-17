<?php
    require_once 'conexao.php';
    session_start();
    global $qaa;

    if(!isset($_SESSION['clienteLogado'])){header('Location: ../../acessoNegado.php');}

if(isset($_GET['a'])){$a=$_GET['a'];$_SESSION['conf']=1;}else{$_SESSION['conf']=0;}

 
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
                $id=$_SESSION['idCarteira'];
                $h=$qac=0;
                    $r = $db->prepare("SELECT objetivo,percInvestimento FROM carteira WHERE id=?");
                    $r->execute(array($_SESSION['idCarteira']));
                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas as $l) {echo "  ".$l['objetivo']."</h2>"; $objCarteira=$l['objetivo']; $percCart=$l['percInvestimento'];$qac==count($linhas);}
                ?>

                <div class="table-responsive">
                    <table class='table table-striped' style="font-size: 80%; text-align: right; line-height: 95%;">
                        <thead>
                            <tr>
                                <th scope='col'>Ativo</th>
                                <th scope='col'>Empresa</th>
                                <th scope='col'>Setor</th>
                                <th scope='col'>Quant. Atual</th>
                                <th scope='col'>Cotação Atual</th>
                                <th scope='col'>Patrimônio Atual</th>
                                <th scope='col'>Partic. Atual</th>
                                
                                
                                <th scope='col'>Config. Objetivo</th>
                                <th scope='col'>Distância Objetivo</th>
                                <th scope='col'>Aporte distribuído</th>

                                
                                <th scope='col'>Distribuição Projetada</th>
                                <th scope='col'>Partic. Projetada</th>
                                <th scope='col'>Quant. a adq.</th>
                                <th scope='col'>Valor c/ Aporte</th>
                                <th scope='col'>Quant. Cotas</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                //Taylor (ValorNaCart)
                                $infaz=$quac[] = $cot[] = $atn[] = $n = $valAtivo[] = $valAt= $valornacart = 0;

                                $r = $db->prepare("SELECT * FROM operacao WHERE idCarteira=?");
                                $r->execute(array($_SESSION['idCarteira']));
                                $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                                foreach($linhas as $l) 
                                {

                                    $n++; 
                                    $r = $db->prepare("SELECT * FROM acao WHERE ativo=?");
                                    $r->execute(array($l['ativoAcao']));
                                    $linhas2 = $r->fetchAll(PDO::FETCH_ASSOC);                                    
                                    foreach($linhas2 as $l2) 
                                    {
                                        $cot[$n] = $cotacaoAtual = $l2['cotacaoAtual'];
                                        $atn[$n]=$l['ativoAcao'];
                                        $valAt +=$l['qtdAcoes']*$l2['cotacaoAtual'];
                                       
                                                                               
                                    }
                                    $quac[$n]=0;
                                    $valornacart+=$cot[$n]*$l['qtdAcoes'];
                                    $valAtivo[$n] = $valAt;
                                    $cot[$n] = $cotacaoAtual = $l2['cotacaoAtual'];
                                    $atn[$n]=$l['ativoAcao'];
                                     $quac[$n]+=$l['qtdAcoes'];
                                     if($quac[$n]==null){$quac[$n]=0;}
                                    
                                     // armazena na matriz o ativo e sua cotação 
                                }
                               

                                $aporte=$_SESSION['valorInvestimento'];

                                //Pegar totalPatrimonioAtualizado da carteira
                                $y=0; $v=0;
                                $totproj=$totPatrAtualizado = 0;
                                $obj[]=0;
                                $totInvestimentoReal = 0;
                                $tg=$valornacart+$aporte;
                                $taaa=$tg*$obj[$y]/100;
                                $r = $db->prepare("SELECT * FROM carteira_acao WHERE idCarteira=?");
                                $r->execute(array($_SESSION['idCarteira']));
                                $linhas3 = $r->fetchAll(PDO::FETCH_ASSOC);
                                foreach($linhas3 as $l3) 
                                {   
                                 $v++; 
                                    $obj[$v]= $l3['objetivo']; 

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

                foreach($linhas as $l) 
                { //Pegar dados específicos da ação citada

                                    $r = $db->prepare("SELECT * FROM acao WHERE ativo=?");
                                    $r->execute(array($l['ativoAcao']));
                                    $linhas2 = $r->fetchAll(PDO::FETCH_ASSOC);                                    
                                    foreach($linhas2 as $l2) 
                                    {
                                        $ativo = $l2['ativo'];
                                        $setor = $l2['setor'];
                                        $cotacaoAtual = $l2['cotacaoAtual'];
                                        $nome = $l2['nome'];
                                    }
                                    
                                    //Variáveis dos valores aqui
                                    
                                    $qtdAcoes = $l['qtdAcao'];
                                    
                                    $patrAtualizado = $qtdAcoes * $cotacaoAtual;
                                    if($totPatrAtualizado==0) 
                                        {
                                            $partAtual=0;
                                        }
                                    else 
                                        {
                                            $partAtual = ($patrAtualizado * 100) / $totPatrAtualizado;
                                        }
                                    $distObjetivo = $partAtual - $l['objetivo'];
                                    if($distObjetivo >= 0) 
                                        {
                                            $qtdAcoesComprar = 0;
                                        }
                                    else 
                                        {
                                            $qtdAcoesComprar = ($l['objetivo']*( ($_SESSION['valorInvestimento']+$totPatrAtualizado) / 100)) / $cotacaoAtual;
                                        }
                                
                                    $ainv=(($_SESSION['valorInvestimento']+$totPatrAtualizado)*($l['objetivo']/100))-$patrAtualizado;
                                    $qtdAcoesComprar=(int)$ainv/$cotacaoAtual;

                                    $investimentoReal = (int)$qtdAcoesComprar * $cotacaoAtual;
                                    if($qtdAcoesComprar!=0) 
                                    {
                                        $totInvestimentoReal += ((int)$qtdAcoesComprar*$cotacaoAtual);
                                    }

                                    //Taylor (quant)
                                    $quant = 0; $valcart = 0;

                                    $sobra=$totInvestimentoReal+$totPatrAtualizado;
                                    $qa[]=$qac=0;

                                    $r = $db->prepare("SELECT * FROM carteira_acao WHERE idCarteira=?");
                                    $r->execute(array($_SESSION['idCarteira']));
                                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                                
                                    foreach($linhas as $z) 
                                    {
                                        //echo count($linhas).'-'.$z['idCarteira'].'-'.$z['idCarteira'].'-';
                                        $at=$z['ativoAcao'];
                                        $r = $db->prepare("SELECT * FROM acao WHERE ativo=?");
                                        $r->execute(array($z['ativoAcao']));
                                        $linhas2 = $r->fetchAll(PDO::FETCH_ASSOC);                                    
                                        foreach($linhas2 as $l2) 
                                        {
                                             $cotacao = $l2['cotacaoAtual'];
                                        }
                                    if($sobra<=$cotacao) {$sobra-=$cotacao; $qa[$qac]+=1;}    
                                    }
                                


                                    $r = $db->prepare("SELECT * FROM operacao WHERE idCarteira=?");
                                    $r->execute(array($_SESSION['idCarteira']));
                                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($linhas as $l8)  
                                    {
                                        if($l8['ativoAcao']==$l['ativoAcao']) {$quant+=$l8['qtdAcoes'];} 
                                    }
                                    if($l['qtdAcao']==0) {$percAcaoCarteira=0; $propInvA=0;}
                                    else 
                                    {
                                        $percAcaoCarteira = ($quant+(int)$qtdAcoesComprar)*$cotacaoAtual*100/$valornacart;
                                        $propInvA = ($quant*$cotacaoAtual)/$valornacart*100;
                                    }

                                    if($investimentoReal<0){$investimentoReal=0;}
                                    if($qtdAcoesComprar<0){$qtdAcoesComprar=0;}
                                    $y++;
                                    if($valornacart<1 || $valornacart==null || empty($valornacart))
                                        {
                                            $valornacart=0.01;
                                            $atn[$y]=$l['ativoAcao'];$qt[$y]=$qtdAcoes;$cot[$y]=$cotacaoAtual;
                                        }
                                            $atn[$y]=$l['ativoAcao'];$qt[$y]=$qtdAcoes;$cot[$y]=$cotacaoAtual;
                                            if($quac[$n]==null || empty($quac[$n])){$quac[$n]=0; $quac[$y]=$quac[$n];}

                                    echo "
                                        <tr>
                                            <td >".strtoupper($atn[$y])."</td>
                                            <td >".strtoupper($nome)."</td> 
                                            <td class='set'>".$setor."</td>
                                            <td class='set'>".$qt[$y]."</td>
                                            <td class='setx'>R$ ".number_format($cot[$y],2,",",".")."</td>
                                            <td class='setx'>R$ ".number_format($qt[$y]*$cot[$y],2,",",".")."</td>
                                            
                                            <td class='set'>".number_format(($qt[$y]*$cot[$y])/$valornacart*100,2,",",".")." %</td>
                                            <td class='set'>".number_format($obj[$y],2,",",".")." %</td>
                                            <td class='set'>".number_format((($qt[$y]*$cot[$y])/$valornacart*100)-$obj[$y],2,",",".")." %</td>
                                            <td class='setx'>R$ ".number_format(($tg*$obj[$y]/100)-($qt[$y]*$cot[$y]),2,",",".")."</td>
                                            
                                            
                                            <td class='setx'>R$ ".number_format(($tg*$obj[$y]/100)-($qt[$y]*$cot[$y])+$qt[$y]*$cot[$y],2,",",".")."</td>
                                           ";
                                            $infaz+=($tg*$obj[$y]/100)-($qt[$y]*$cot[$y]);
                                            $totproj+=($tg*$obj[$y]/100)-($qt[$y]*$cot[$y])+$qt[$y]*$cot[$y];

                                            //$qad=array();   //#############################################################
                                    
                                 $qaa[$y] = $z = 0;
                                 
                                    
                                    while ($aporte>$cot[$y] && $z<($tg*$obj[$y]/100)-($qt[$y]*$cot[$y])) 
                                    {
                                        $qaa[$y]+=1;
                                        $aporte-=$cot[$y];
                                        $z+=$cot[$y];
                                    }       
                                        
                                       

                                echo       "
                                             <td class='set'>".number_format((((int)$qaa[$y]+$qt[$y])*$cot[$y])*100/$tg,2,",",".")." %</td>
                                            <td class='set'>".(int)$qaa[$y]."</td>
                                            <td >R$ ".number_format((int)$qaa[$y]*$cot[$y],2,",",".")."</td>
                                            <td class='set'>".(int)($qt[$y]+$qaa[$y])."</td>
                                            
                                        </tr>
                                    ";
                                    

                                
            }   
                               

                                echo "
                                    <tr>
                                        <td></td><td></td><td></td><td></td><td>Total: </td><td>R$ ".number_format($totPatrAtualizado,2,",",".")."</td><td></td>
                                        <td></td><td></td><td>R$ ".number_format($infaz,2,",",".")."</td><td>R$ ".number_format($totproj,2,",",".")."</td><td></td><td></td><td>R$ ".number_format($_SESSION['valorInvestimento']-$aporte,2,",",".")."</td><td></td>


                                    </tr> </tbody></table>";
                                   
                                 $ap=$aporte;   
                                $p=0; $qta=array();
                                for($q=1;$q<count($linhas)+1;$q++)
                                {
                                        while($aporte/$cot[$y]>=1)
                                    {
                                        for($x=1;$x<count($linhas)+2;$x++)
                                        {

                                        $p=acerto($aporte,$cot[$y]);
                                        $h+=$p;
                                        $qaa[$y]+=$p;
                                        $qta[$x]=$qaa[$y];
                                        $aporte-=$p*$cot[$y];
                                        }                                        
                                   }
                               }
//echo '<h1>'.$_SESSION['conf'].'<h1>';                          

                                   if($h>0){
                                     echo '
                                    <table class="table table-striped" style="font-size: 80%; text-align: right; line-height: 95%;">
                                    <thead>
                            <tr><th></th><th></th></th><th></th>
                                <th scope="col">Ativo</th>
                                <th scope="col">Quant. Atual</th>
                                <th scope="col">Cotação Atual</th>
                                <th scope="col">Quant. a adq.</th>
                                <th scope="col">Valor c/ Aporte</th>
                                <th scope="col">Quant. Cotas</th>                                
                            </tr>
                        </thead>
                        <tbody>                               
                                    ';    
                                   echo '<tr><td></td><td></td></td><td ></td><td>'.strtoupper($atn[$q]).'</td><td>'.$qt[$q].'</td><td>'.$cot[$q].'</td></td><td>'.$qta[$q].'</td><td>valor:R$ '.number_format($qta[$q]*$cot[$q],2,",",".").'</td><td>'.number_format((int)$qta[$q]+(int)$qt[$q],0,",",".").'</td></tr>';
                                    }
                    
                                    if($h>0){
                                        echo '<td>Valor anterior da Sobra: R$ '.number_format($ap,2,",",".").'</td><td>Valor final da Sobra: R$ '.number_format($aporte,2,",",".").'</td><td></td></tr>';}?>
                                   </tbody>
                                    </table>
                                    
                                    
                                    <table class='table table-striped' style="font-size: 90%; text-align: right; line-height: 95%;">
                                    <tbody>
                                    <tr>
                                <?php echo "       
                                        <td class='setx' colspan='4' style='color: blue;'><b>Total Patr Atual:</b> R$ ".number_format($valornacart,2,",",".")."</td>
                                        <td class='setx' colspan='4' style='color: green;'><b>Total a ser Investido:</b> R$ ".number_format($_SESSION['valorInvestimento']-$aporte,2,",",".")."</td>
                                        <td class='setx' colspan='4' style='color: red;'><b>Sobra do Aporte:</b> R$ ".number_format($aporte,2,",",".")."</td>
                                        
                                        <td class='setx' colspan='4' style='color: brown;'><b>Investimento Projetado:</b> R$ ".number_format($valornacart+$_SESSION['valorInvestimento']-$aporte,2,",",".")."</td>
                                    <tr>
                                ";
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <br>
                <a href="../index.php" class="btn btn-danger">Cancelar</a>
             <?php echo ' <a href="investirCarteira.php?id='.$id.'" class="btn btn-info">Recalcular</a>
                <a href="simulacaoInvestimento.php?a='.$_SESSION['conf'] .'"class="btn btn-success" id="submitWithEnter" name="conf" target="_blank">Confirmar Investimento</a>';
                ?>
                <br><br><br>
            </div>
        </div>
    </div> <br><br><br>
</body>
<?php
function acerto($u,$i){
    for($x=1;$x<count($linhas)+2;$x++)
                                        {
            if($u/$i>=1){return 1;}
    }                                            
}         
   if($_SESSION['conf']==1)  // #########################################################
                            {

                                   $i=0;
                                $r = $db->prepare("SELECT * FROM carteira_acao WHERE idCarteira=?");
                                $r->execute(array($_SESSION['idCarteira']));
                                $linhas2 = $r->fetchAll(PDO::FETCH_ASSOC);                                    
                                foreach($linhas2 as $l2){
                                    $i++;
                                    $ativo=$l2['ativoAcao'];
                                $d=date('Y/m/d');
                                    $r = $db->prepare("UPDATE carteira_acao SET qtdAcao=?,cpfCliente=? WHERE idCarteira=? AND ativoAcao=?");
                                    $r->execute(array((int)$qaa[$i]+$l2['qtdAcao'],$_SESSION['cpf'],$_SESSION['idCarteira'],$ativo));
                                    $r = $db->prepare("INSERT INTO operacao(dataOperacao,qtdAcoes,idCarteira,ativoAcao) VALUES (?,?,?,?)");
                                            $r->execute(array($d,(int)$qaa[$i],$_SESSION['idCarteira'],$ativo));
                                    }        
                                    unset($_SESSION['conf']);
                                    include("confInvestimento.php");
                                    echo '<a href=" ../index.php?"class="btn btn-success" id="submitWithEnter" name="conf" style="text-align: center;" target="_top">Voltar</a>';

                            }       ?>                   
                             
    </html> 

