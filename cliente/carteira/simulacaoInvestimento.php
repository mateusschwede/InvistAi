<?php
    require_once '../../conexao.php';
    
     if(isset($_GET['a'])){$a=$_GET['a'];$_SESSION['conf']=1; session_start();}else{$_SESSION['conf']=0; session_start();
     if(!isset($_SESSION['clienteLogado'])){header('Location: ../../acessoNegado.php');}
    } 
    global $qaa; $ooo=$totproj=$v=0;
    
   
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
                $aporte=$_SESSION['valorInvestimento'];                                               //id da carteira está em $id
                $total=$acum=$h=$qac=0;
 // todos os dados dacarteira               
                    $r = $db->prepare("SELECT objetivo,percInvestimento FROM carteira WHERE id=?");
                    $r->execute(array($_SESSION['idCarteira']));    // $id
                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas as $l) 
                    {
                        echo "  ".$l['objetivo']."</h2>"; 
                        $objCarteira=$l['objetivo'];      // OLP
                        $percCart=$l['percInvestimento']; // percentual da carteira no investimento
                        
                    }
        
                    $r = $db->prepare("SELECT * FROM carteira_acao WHERE idCarteira=?");    // carteira_acao da Carteira
                    $r->execute(array($_SESSION['idCarteira']));
                    $linhas1 = $r->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas1 as $l1) 
                    {   
                        
                        $obj[$v]= $l1['objetivo'];                      // $obj[$v]=percentual da ação na carteira
                        $qtac[$v]= $l1['qtdAcao'];                         // $qtac[$v]=quant total da ação na carteira
                            $r = $db->prepare("SELECT * FROM acao WHERE ativo=?");  // tabela ação
                            $r->execute(array($l1['ativoAcao']));
                            $linhas2 = $r->fetchAll(PDO::FETCH_ASSOC);
                            foreach($linhas2 as $l2) 
                                {
                                    $cota[$v] = $l2['cotacaoAtual'];
                                    $ativo[$v] = $l2['ativo'];
                                    $nomac[$v]= $l2['nome'];
                                    $setor[$v] = $l2['setor'];
                                }
                            $total += $l1['qtdAcao'] * $cota[$v];     // Valor total, somando a quantidade * cotação da ação  
                            if($total>1)
                            {
                                $valornacart=$total;              // Valor na carteira é o total 
                            }
                            if($valornacart<1)
                                { 
                                    $valornacart=0.01;
                                }else{$valornacart-=0.01;} 
                            $tg=$valornacart+$aporte;            // Valor na carteira + valor do aporte $tg 
                            
                        $v++;                               
                    }
                    $qac=count($linhas1);     // quantidade de ações na carteira
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
                                <th scope='col'>Valor com o Aporte</th>
                                <th scope='col'>Quant. Cotas</th>
                            </tr>
                        </thead>
                        <tbody>
<?php
    $stot=$infaz=$quac[] = $cot[] = $atn[] = $n = $valAtivo[] = $valAt= 0; 
    
for($q=0;$q<$qac;$q++) 
{
$apdis[$q]=(($tg*$obj[$q])/100)-($qtac[$q]*$cota[$q]);
    if($apdis[$q]<0){$apdis[$q]=0;}
    echo ($tg*$obj[$q])/100;
        echo "
               <tr>
                    <td >".strtoupper($ativo[$q])."</td>
                    <td >".strtoupper($nomac[$q])."</td> 
                    <td class='set'>".$setor[$q]."</td>
                    <td class='set'>".$qtac[$q]."</td>
                    <td class='setx'>R$ ".number_format($cota[$q],2,",",".")."</td>
                    <td class='setx'>R$ ".number_format($qtac[$q]*$cota[$q],2,",",".")."</td>                                            
                    <td class='set'>".number_format(($qtac[$q]*$cota[$q])/$valornacart*100,2,",",".")." %</td>
                    <td class='set'>".number_format($obj[$q],2,",",".")." %</td>
                    <td class='set'>".number_format((($qtac[$q]*$cota[$q])/$valornacart*100)-$obj[$q],2,",",".")." %</td>
                    <td class='setx'>R$ ".number_format($apdis[$q],2,",",".")."</td>
                    <td class='setx'>R$ ".number_format((($tg*$obj[$q])/100)-($qtac[$q]*$cota[$q])+$qtac[$q]*$cota[$q],2,",",".")."</td>
                                           ";
                    $ooo+=$obj[$q];
                    $infaz+=(($tg*$obj[$q])/100)-($qtac[$q]*$cota[$q]);
                    $totproj+=($tg*$obj[$q]/100)-($qtac[$q]*$cota[$q])+$qtac[$q]*$cota[$q];
                                            //$qad=array();   //#############################################################                                    
                    $qaa[$q] = (int)(((($tg*$obj[$q])/100)-($qtac[$q]*$cota[$q]))/$cota[$q]);
                    $z = 0;
                                   /* while ($aporte>$cot[$y] && $z<($tg*$obj[$y]/100)-($qt[$y]*$cot[$y])) 
                                    {
                                        $qaa[$y]+=1;
                                        $aporte-=$cot[$y];
                                        $z+=$cot[$y];
                                    } */
                                    $qqq[$q]=$qaa[$q];  
                                    if($qaa[$q]<0){$qaa[$q]=0;} 
                                    if($qqq[$q]<0){$qqq[$q]=0;}
                                echo    "
                                             <td class='set'>".number_format((((int)$qaa[$q]+$qtac[$q])*$cota[$q])*100/$tg,2,",",".")." %</td>
                                            <td class='set'>".(int)$qaa[$q]."</td>
                                            <td >R$ ".number_format((int)$qaa[$q]*$cota[$q],2,",",".")."</td>
                                            <td class='set'>".(int)($qtac[$q]+$qaa[$q])."</td>
                                            
                                            </tr>
                                        ";
                                        $qa1[$q]=$qaa[$q];
                                        $stot+=$qaa[$q]*$cota[$q];
                                        $acum+=(int)$qaa[$q]*$cota[$q];

            } 
            // valornacart - totproj = aporte      (totproj*objetivo)=limite 
            // aporte distribuido=limite-patrimonioatual ($qtac[$q]*$cota[$q]) se negativo o objetivo está superado
            echo " 
            <tr>
                                        <td></td><td></td><td></td><td></td><td>Total: </td><td>R$ ".number_format($valornacart,2,",",".")."</td><td></td>
                                        <td></td><td></td><td>R$ ".number_format($infaz,2,",",".")."</td><td>R$ ".number_format($totproj,2,",",".")."</td><td></td><td></td><td>R$ ".number_format($acum,2,",",".")."</td><td></td>
                                    </tr> </tbody></table>";
            $sobra=$aporte-$acum;
           // echo '<h3>Sobra: R$ '.$sobra.'</h3>';
            $h=0;
        for($x=0;$x<$qac;$x++)
        { 
            while($sobra/$cota[$x]>=1)
            {
                 if($sobra>$cota[$x]) 
                                            {                                   
                                               $qaa[$x]+=1;
                                               $sobra-=$cota[$x];
                                            }
                
                

                                           

                } 
                if($h==0)
                {
                   echo '
            <table class="table table-striped" style="font-size: 80%; text-align: right; line-height: 95%;">
                                    <thead><th scope="col"></th> 
                                    <th scope="col"></th> 
                                    <th scope="col"></th>
                                    <th scope="col"></th> 
                                    <th scope="col"></th>
                                    <th scope="col">Distribuição</th>
                                    <th scope="col">Ativo</th>
                                    <th>Obj</th>
                                    <th>% atual</th>
                                    <th>Valor</th>                               
                                    <th scope="col">Cotação</th>
                                    <th scope="col">Qt.Atual</th>
                                    <th scope="col">Qt.adqda.</th>
                                    <th scope="col">Qt.a adq.</th>
                                    <th scope="col">Valor c/ Aporte</th>
                                    <th scope="col">Quant. Cotas</th>                                
                                    
                                    </thead>
                                    <tbody>'; 
                }
                $h++;
                 echo'   
                                               <tr><td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                         <td>R$ '.number_format(((($aporte-$stot)*$obj[$x])/100),2,",",".").'</td>
                                         <td>'.strtoupper($nomac[$x]).'</td>
                                            <td>'.$obj[$x].'%</td>
                                            <td>'.number_format((($obj[$x]/$ooo)*100),2,",",".").'%</td>
                                            
                                            <td>R$ '.number_format(($aporte-$stot)*$obj[$x]/100,2,",",".").'</td>
                                            <td>R$ '.number_format($cota[$x],2,",",".").'</td>
                                            
                                            <td>'.(int)$qtac[$x].'</td>
                                            
                                            
                                             
                                            <td>'.$qa1[$x].'</td>
                                            <td>'.$qaa[$x].'</td>
                                            <td>R$ '.number_format((int)(($aporte*$obj[$x]/100)/$cota[$x])*$cota[$x],2,",",".").'</td>
                                            <td>'.number_format(((int)$qtac[$x]+(int)$qaa[$x]),0,",",".").'</td></tr>';        // final laço while                               
            }   




echo '      <tr><td></td><td></td><td><td>Valor remanescente: R$ '.number_format($aporte-$stot,2,",",".").'</td><td>Valor final da Sobra: R$ '.number_format($sobra,2,",",".").'</td><td></td></tr>';
                                    echo "

                                    <table class='table table-striped' style='font-size: 90%; text-align: right; line-height: 95%;'>
                                    <tbody>
                                    <tr>
                                    <td class='setx' colspan='4' style='color: green;'><b>Total a ser Investido:</b> R$ ".number_format($_SESSION['valorInvestimento']-($aporte-$acum),2,",",".")."</td>
                                        <td class='setx' colspan='4' style='color: red;'><b>Sobra do Aporte:</b> R$ ".number_format($sobra,2,",",".")."</td>                                         
                                        <td class='setx' colspan='4' style='color: brown;'><b>***Investimento Projetado:</b> R$ ".number_format($tg-($aporte-$acum),2,",",".")." 
                                            </td></tr></tbody></table>


                                    ";

 echo '   <a href="../index.php" class="btn btn-danger">Cancelar</a>    
                            <a href="investirCarteira.php?id='.$id.'" class="btn btn-info">Recalcular</a>
                                <a href="simulacaoInvestimento.php?a='. 1 .'"class="btn btn-success" id="submitWithEnter" name="conf" >Confirmar Investimento</a>
                                ';
            ?>
                <br><br><br>
            </div>
        </div>
    </div>
</tr>
</tbody>
</table>
<br><br><br><br>

</body>

<?php

 
            if(isset($_GET['a']))  // #########################################################

                {
                               
                                $i=0;
                                $r = $db->prepare("SELECT * FROM pessoa WHERE cpf = ?");
                                $r->execute(array($_SESSION['cpf']));
                                $linhas9 = $r->fetchAll(PDO::FETCH_ASSOC);                                    
                                foreach($linhas9 as $l9) {
                                    $vaa=$l9['totalSobraAportes'];
                                    $r = $db->prepare("UPDATE pessoa SET totalSobraAportes=? WHERE cpf=?");
                                    $r->execute(array($aporte+$vaa,$_SESSION['cpf']));
                                }
                                $r = $db->prepare("SELECT * FROM carteira_acao WHERE idCarteira=?");
                                $r->execute(array($_SESSION['idCarteira']));
                                $linhas2 = $r->fetchAll(PDO::FETCH_ASSOC);                                    
                                foreach($linhas2 as $l2)
                                {
                                    
                                    $ativo=$l2['ativoAcao'];
                                    
                                    $r = $db->prepare("UPDATE carteira_acao SET qtdAcao=?,cpfCliente=? WHERE idCarteira=? AND ativoAcao=?");
                                    $r->execute(array((int)$qaa[$i]+$l2['qtdAcao'],$_SESSION['cpf'],$_SESSION['idCarteira'],$ativo));
                                    
                                    $r = $db->prepare("INSERT INTO operacao(qtdAcoes,idCarteira,ativoAcao) VALUES (?,?,?)");
                                            $r->execute(array((int)$qaa[$i],$_SESSION['idCarteira'],$ativo));
                                    $i++;        
                                }        
                                    unset($_SESSION['conf']);
                                    unset($_GET['a']);
                                    include("confInvestimento.php");
                                   
                } 

?>                   
</html> 
