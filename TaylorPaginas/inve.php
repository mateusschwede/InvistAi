<?php
    require 'banco.php';
session_start();
$id=$_GET['id'];
    $inv=$_POST['inv'];
$qt1=$qt2=$qt3=$tt=0;
$ass=$qc1=$qc2=$qc3=$tt=0;
    if(!empty($id))    // Foi passado o id do cliente
    {
        //Acompanha os erros de validação
        $empErro = null;
        $valorErro = null;
        $datac = date('Y/m/d');
    $pdo = Banco::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
       $sql4 = "SELECT * FROM pessoa where id = '$id'";
       $q4 = $pdo->prepare($sql4);
       $q4->execute(array($id));
       $data4 = $q4->fetch(PDO::FETCH_ASSOC);
       $ac1=$data4['a1'];  //dados da configuração
       $ac2=$data4['a2'];
       $ac3=$data4['a3'];
       $vl1=$data4['p1'];
       $vl2=$data4['p2'];
       $vl3=$data4['p3'];
        
       $sql1 = "SELECT * FROM carteira where id = '$id'";
    //   $q1 = $pdo->prepare($sql1);
    //   $q1->execute(array($id));
    //   $data1 = $q1->fetch(PDO::FETCH_ASSOC);
       // EXTRAINDO O VALOR DAS EMPRESAS CADSTRADAS NA CARTEIRA do CLIENTE
        foreach($pdo->query($sql1) as $data1) {
       		$acao1= $data1['idac1'];
            $acao2= $data1['idac2'];
            $acao3= $data1['idac3'];
            $vlr1= $data1['valor1'];
            $vlr2= $data1['valor2'];
            $vlr3= $data1['valor3'];
        }
       //echo '<h2>'.$id.'----'.$acao1.'dat:'.$data1['idac1'].'</h2>';

       $sql2 = "SELECT * FROM empresa";
    foreach($pdo->query($sql2) as $lis)
    {
       
        if($ac1 == $lis['ide']) 
        {
            $empr1 = $lis['emp'];
            $cota1= $lis['valor'];
        } 
        if($lis['ide'] == $ac2) 
        {
            $empr2= $lis['emp'] ;
             $cota2= $lis['valor'];
        } 
        if($lis['ide'] == $ac3) 
        {
            $empr3= $lis['emp'] ;
             $cota3= $lis['valor'];
        }
        if($lis['ide'] == $ac1) {$e1=$lis['emp'];}
        if($lis['ide'] == $ac2) {$e2=$lis['emp'];}
        if($lis['ide'] == $ac3) {$e3=$lis['emp'];}
    }

    $sql = "SELECT * FROM lance where idcli = $id";
                    $total=$tt=$x=0;
/*
         echo  '<div style="font-size:80%; text-align:center;"><table  width="600px" align="center">
                    <thead style="font-size:80%;">
                    
                        <tr >
                            <th scope="col">Id</th>
                            <th scope="col">clie</th>
                            <th scope="col">Cota</th>
                            <th scope="col">Quant</th>
                            <th scope="col">Empresa</th>
                            <th scope="col">Cota</th>
                            
                            <th scope="col">Invest</th>
                        
                        </tr>
                    </thead>
                    <tbody >'; 
                    */        
 
        $h=$m=0; 
        $it[]="";
        $vi[]="";  
         $tem=false;  
         $c1=$c2=$c3=0;                         
       foreach($pdo->query($sql) as $lnc) 

{
       // seleciona os dados da empresa
        $q=$lnc['quant']; // quantas    no lance
        
        $x=$lnc['idct'];  // ações (id) no lance
               $sql9 = "SELECT * FROM empresa";        
                    foreach($pdo->query($sql9) as $ll)
                    {   // 
                         $qq=($ll['valor']); $ep=$ll['emp']; 
                        if($ac1==$ll['ide']){$cota1=$qq;$empr1=$ep;}
                        if($ac2==$ll['ide']){$cota2=$qq;$empr2=$ep;}
                        if($ac3==$ll['ide']){$cota3=$qq;$empr3=$ep;}
                        if($ll['ide']==$x)
                            { // se o íd é igual ao id lance só tem uma empr
                                
                                $tot=($q * $qq);  // em Reais
                                $total+=$tot;   // acumula o valor em Reais
                            }
                                
                    }

        if($ac1!=$lnc['idct'] && $ac2!=$lnc['idct'] && $ac3!=$lnc['idct'])
        {
            $tem=true;          // guarda as ações retiradas do cálculo
            $m++;
            $it[$m]=$ll['emp'];
            $vi[$m]=$tot;
            $h+=$tot;   // h acumula os valores das ações não configuradas
            
                //echo $ll['emp'].'-'.$tot.'= R$'.$h.'<br>';
            
        } 

       	if($ac1==0)
       	{
       		$empr1=$empr2=$empr3='';
       		$cota1=$cota1=$cota1=1;
       	} 

        
        if($ac1 ==$lnc['idct'])

            {
                $c=0;
                //$empr1=$ep;
                $y = $empr1;  // nome  da ação
                $v = $vl1;        // percentual configurado
                $c = $cota1 * $lnc['quant'];    //<!-- valor investido nesta ação R$-->
                $c1 += $c;                // Acumulado do valor nesta ação
                $qt1=  $lnc['quant'];                   //<!-- valor investido nesta ação -->
                $a = $cota1;          // A cotação desta ação repetida
            }
        if($ac2==$lnc['idct']) 
            {
                $c=0;
                //$empr2=$ep;
                $y = $empr2;
                $v = $vl2;
                $c = $cota2 * $lnc['quant'];
                $c2 += $c;
                $qt2=  $lnc['quant']; 
                $a = $cota2;
            }
        if($ac3==$lnc['idct']) 
            {
                $c=0;
               // $empr3=$ep;
                $y = $empr3;
                $v = $vl3;
                $c = $cota3 * $lnc['quant'];
                $c3 += $c;
                $qt3=  $lnc['quant']; 
                $a = $cota3;
            }
       

$tt=$c1+$c2+$c3;
 /*       if($tt>0) 
            {  // para não imprimir vazio 

               echo '
                            <tr style="font-size:80%; ">
                            <th scope="row">'. $lnc['idl'] . '</th>';
                            echo '<td>'. $lnc['idcli'] . '</td>';
                            echo '<td>'. $lnc['idct'] . '</td>';
                            echo '<td>'. $lnc['quant'] . '</td>';
                            //echo '<td>'. $lnc['datac'] . '</td>';
                            echo '<td>'.$ep.'</td>';
                            echo '<td>'.$qq.'</td>';
                            
                            echo '<td>R$ '.$lnc['quant']*$qq.'</td>';
                            //echo '<td>R$ '.$c/$tt.'</td>';
                            echo '</tr></div></tbody>';   


            }
            */
}    // fecha o laço foreach
 
$vinv1=$vinv2=$vinv3=0;
$tg=$total+$inv;
$max1=$tg*$vl1/100;
$max2=$tg*$vl2/100;
$max3=$tg*$vl3/100;
if($c1<$max1) {$vinv1=($max1-$c1);}
if($c2<$max2) {$vinv2=($max2-$c2);}
if($c3<$max3) {$vinv3=($max3-$c3);}
$y=$inv; $qac1=$qac2=$qac3=$z=0;
$m=$d=$x1=$x2=$x3=0;
if($tem){ 
    $tg-=$h;                  // se tiver empresas não config.
    }
for($x=0;$x<$inv;$x+=$z)
{
$m++;
   // echo 'valor de y : '.$y.'----- Valor de X >>>'.$x.'----- Valor de d >>>'.$d.
    //'----- quant >>>'.$m.'<br>';
    if($vinv1>$cota1 && $vinv1>($x1-.001) && $y>$cota1-.001)
    {
        $z=$cota1;
        $y-=$z;
        $qac1++;
        $x1+=$z;
        $d+=$z;
    }

    if($vinv2>$cota2 && $vinv2>($x2-.001) && $y>$cota2-.001)
    {
        $z=$cota2;
        $y-=$z;
        $qac2++;
        $x2+=$z;
        $d+=$z;
    }

    if($vinv3>$cota3 && $vinv3>($x3-.001) && $y>$cota3-0.001)
    {
        $z=$cota3;
        $y-=$z;
        $qac3++;
        $x3+=$z;
        $d+=$z;
    }
}


/* %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
$tg=($inv+$total);  // novo invest + saldo
$considerar=$tg;
$dfper=($total/$tg);  // percentual da diferença entre o que tem e o total

$difer=1-$dfper;    // obter a diferença percentual
$noval=$difer*$inv/100;   // diferença * percentual do novo valor


        
$noval1=($vl1)*($considerar/100);    // percentual da empr 1 em rel ao total
$noval2=($vl2)*($considerar/100);    // percentual da empr 2 em rel ao total
$noval3=($vl3)*($considerar/100);   //  percentual da empr 3 em rel ao total


$totconf=$noval1+$noval2+$noval3;   // total almejado 

$incl1= $noval1 - $c1;   // valor total proporc - o valor que tem  será o máximo
$incl2= $noval2 - $c2;   // valor total proporc - o valor que tem
$incl3= $noval3 - $c3;   // 

//$incl3= $tg-($incl1+$incl2)-$c3;   // valor total proporc - o valor que tem

//$incl1= $incl1*$inv/1000;
//$incl2= $incl2*$inv/1000;
//$incl3= $incl3*$inv/1000;
if($incl1<0){$incl1=0;}
if($incl2<0){$incl2=0;}
if($incl3<0){$incl3=0;}
if($ac1>0)
       	{
$pa1=($c1/$tg)*100; // percentual da emp1 com o investimento
$pa2=($c2/$tg)*100; // percentual da emp2 com o investimento
$pa3=($c3/$tg)*100; // percentual da emp3 com o investimento
$np1=$vl1-$pa1; // percentual projetado para a emp1 com o investimento
$np2=$vl2-$pa2; // percentual projetado para a emp1 com o investimento
$np3=$vl3-$pa3; // percentual projetado para a emp1 com o investimento

$qac1=($noval1-$c1); // valor total de cotas a adquirir em valor R$ 
$qac2=($noval2-$c2); // valor total de cotas a adquirir
$qac3=($noval3-$c3); // valor total de cotas a adquirir
$qc1=($noval1-$c1)/$cota1;
$qc2=($noval2-$c2)/$cota2;
$qc3=($noval3-$c3)/$cota3;
$tocot1=(int)($qc1)+$qt1; // quant total de cotas adquidas 
$tocot2=(int)($qc2)+$qt2; //quant total de cotas a adquidas 
$tocot3=(int)($qc3)+$qt3;
$toco1= $cota1*(int)($tocot1);    // cotação vezes a quantidade total de ações
$toco2= $cota2*(int)($tocot2);
$toco3= $cota3*(int)($tocot3);
$comp1=$cota1*(int)$qc1;
$comp2=$cota2*(int)$qc2;
$comp3=$cota3*(int)$qc3;
$stot=$tg;
if($incl1>$noval1 || $c1>$noval1){$comp1=0;$qc1=0;}
if($incl2>$noval2 || $c2>$noval2){$comp2=0;$qc2=0;}
if($incl3>$noval3 || $c3>$noval3){$comp3=0;$qc3=0;}

if($tem){      //    CASO HAJA EXCLUSÃO DE EMPRESAS DO CÁLCULO
    $considerar=$tg-$h; // O TOTAL GERAL EXCLUI O VALOR DESSAS EMPRESAS E PASSA A SER O VALOR CONSIDERADO
    global $x;
    $x=$considerar-$total;
    $y=0; $v=0; $p=0;
     while ($x<=$cota1 && $v<$qac1) {
        $y++;
        $v+=$cota1;
        $x-=$cota1;

     } 
     $qc1=$y;
     

     $y=0; $v=0;
     while ($x<=$cota2 && $v<$qac2) {
        $y++;
        $v+=$cota2;
        $x-=$cota2;

     } 
     $qc2=$y;

    $y=0; $v=0;
     while ($x<=$cota3 && $v<$qac3) {
        $y++;
        $v+=$cota3;
        $x-=$cota3;

     } 
     $qc3=$y;

        }


$topar= ($comp1)+($comp2)+($comp3);             //total das cotas adquiridas
$toger=$tg-$comp1-$comp2-$comp3;

$w1=$noval1-$c1;
$w2=$noval2-$c2;
$w3=$noval3-$c3;
$z1=$w1-$cota1;
$z2=$w2-$cota2;
$z3=$w3-$cota3;
// quant total de cotas a adquidas
$ass=$inv-$topar;
*/
// if() %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
/*
while($ass>=$cota1) {
    if((($noval1-$c1)-$comp1)>$cota1){
        $ass-=$cota1;
        $comp1+=$cota1;
        }
    }
while ($ass>=$cota2) {
    if((($noval2-$c2)-$comp2)>$cota2){
        $ass-=$cota2;
        $comp2+=$cota2;
        }
    }

while ($ass>=$cota3) {
    if((($noval3-$c3)-$comp3)>$cota3){
        $ass-=$cota3;
        $comp3+=$cota3;
        }
    }
*/







$ass=$inv-($qac1*$cota1+$qac2*$cota2+$qac3*$cota3);
 

}                   // ÚLTIMO 

  $_SESSION['ass']=$ass;
  $_SESSION['qt1']=$qac1;  // quantidade a comprar ------------  vai ser o lance
  $_SESSION['qt2']=$qac2;  // quantidade a comprar
  $_SESSION['qt3']=$qac3;  // quantidade a comprar
    $_SESSION['cota1']=$cota1;  // valor da ação
    $_SESSION['cota2']=$cota2;  // valor da ação
    $_SESSION['cota3']=$cota3;  // valor da ação
    $_SESSION['ac1']=$ac1;  // índice da ação
    $_SESSION['ac2']=$ac2;  // índice da ação
    $_SESSION['ac3']=$ac3;  // índice da ação

//echo $pa1.' | '.$c1.' | '.$np1.' | '.$pa2.' | '.$c2.' | '.$np2.' | valor '.$dov.' | difer perc'.$difer;
           // echo $form;
    Banco::desconectar();
/*
    $y=0;
     if($h>0) {
     for($x=1;$x<($m)+1;$x++){
                     $y+=$vi[$x];
                     echo "Retirar do cálculo : ".$it[$x].'-'.$vi[$x].'= R$'.$y.'<br>';
                 }
              }   
      $tg-=$h; 
  */   
     ?>
     
     
     <!DOCT3YPE html>
     <html lang="pt-br">
     
     <head>
         <meta charset="utf-8"></meta>
         <!-- Latest compiled and minified CSS -->
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
         <style type="text/css">
             .wrapper{
                 width: 650px;
                 margin: 0 auto;
             }
             .page-header h2{
                 margin-top: 0;
             }
             table tr td:last-child a{
                 margin-right: 15px;
             }
         </style>
     
     </head>
     
     <body>
         <div class="container">
             <div clas="span10 offset1">
               <div class="card">
                 <div class="card-header">
                     <h3 class="well" style="text-align: center;"> <?php echo number_format($inv, 2, ',', '.'). " + " . number_format($total, 2, ',', '.') . '  (saldo atual considerado para o cálculo) ' 
                                     ; ?></h3>
                 </div>
                 <div class="card-body">
                 <form style="text-align: center;" class="form-horizontal" action="inve.php" method="post"> Total do Investimento a distribuir:
                 <p><?php echo '( '. number_format(($inv+$total), 2, ',', '.').' - ' . number_format($h, 2, ',', '.') . ' = '.number_format($tg, 2, ',', '.').' ) será o valor considerado para o cálculo) ' 
                                     ; ?></p>
                     <span size="20">
     <input size="7" style="text-align: center" class="form-control" name="inv" type="text" placeholder="NÂº inteiro" required=""
                              value="<?php echo ' ' . number_format($tg, 2, ',', '.') ?>"> </span>
                                <p style="text-align: center;"><h2> Investimento Futuro</h2></p>
     <table class="table table-striped">
                         <thead style="text-align: right;">
                            
                             <tr>
                                 <th></th><th></th><th></th><th></th><th></th><th></th></tr>
                           
                             
                             <tr>

                                 <th></th>
                                 <th >Previsão</th>
                                 <th >% previsao</th>
                                 <th >Atual</th>
                                 <th >% At/total</th>
                                 <th >Nr Ct</th>
                                 <th >Ação </th>
                                 
                                 <th >Incluir</th>
                                 <th >cotação</th>
                                 
                                  <th >Cotas</th>
                                 <th >comprar</th>
                                 <th >% / total</th>
                                
                                 <th >Proporção</th>
                                 <th></th>
                             </tr>
                             
                         </thead>
                         <tbody style="text-align: right;"><tr><td></td>

     <td><?php echo ' ' . number_format($max1, 2, ',', '.') ?></td>

    <td><?php echo ' ' . number_format($vl1, 2, ',', '.') ?>%</td>
    <td><?php echo ' ' . number_format($c1, 2, ',', '.') ?></td>
    <td><?php echo ' ' . number_format($c1/$tg*100, 2, ',', '.')  ?>%</td>
    <td><?php echo ' ' . number_format($qt1, 0, ',', '.') ?></td>
        <td><?php echo $empr1 ?></td>
    
        <td><?php echo ' ' . number_format($vinv1, 2, ',', '.') ?></td>
    <td><?php echo ' ' . number_format($cota1, 2, ',', '.') ?></td>
        
        <td><?php echo ' ' . number_format($qac1, 0, ',', '.') ?></td>
    <td><?php echo ' ' . number_format($qac1*$cota1, 2, ',', '.') ?></td>
    <td><?php echo ' ' . number_format($qac1*$cota1/$tg*100, 2, ',', '.') ?>%</td>
        
        <td><?php echo ' ' . number_format(($c1/$tg*100)+($qac1*$cota1/$tg*100), 2, ',', '.')  ?>%</td>
  </tr>
    <tr>
    <td></td>
    
    <td><?php echo ' ' . number_format($max2, 2, ',', '.') ?></td>

        <td><?php echo ' ' . number_format($vl2, 2, ',', '.') ?>%</td>
    <td><?php echo ' ' . number_format($c2, 2, ',', '.') ?></td>
    <td><?php echo ' ' . number_format($c2/$tg*100, 2, ',', '.')  ?>%</td>
    <td><?php echo ' ' . number_format($qt2, 0, ',', '.') ?></td>
        <td><?php echo $empr2 ?></td>
    
        <td><?php echo ' ' . number_format($vinv2, 2, ',', '.') ?></td>
    <td><?php echo ' ' . number_format($cota2, 2, ',', '.') ?></td>
    <td><?php echo ' ' . number_format($qac2, 0, ',', '.') ?></td>    
    <td><?php echo ' ' . number_format($qac2*$cota2, 2, ',', '.') ?></td>
    <td><?php echo ' ' . number_format($qac2*$cota2/$tg*100, 2, ',', '.') ?>%</td>
        
        <td><?php echo ' ' . number_format(($c2/$tg*100)+($qac2*$cota2/$tg*100), 2, ',', '.')  ?>%</td>
  </tr>
  <tr>
    <td></td>
    
    <td><?php echo ' ' . number_format($max3, 2, ',', '.') ?></td>

        <td><?php echo ' ' . number_format($vl3, 2, ',', '.') ?>%</td>
    <td><?php echo ' ' . number_format($c3, 2, ',', '.') ?></td>
    <td><?php echo ' ' . number_format($c3/$tg*100, 2, ',', '.')  ?>%</td>
     <td><?php echo ' ' . number_format($qt3, 0, ',', '.') ?></td>
        <td><?php echo $empr3 ?></td>
    
        <td><?php echo ' ' . number_format($vinv3, 2, ',', '.') ?></td>
    <td><?php echo ' ' . number_format($cota3, 2, ',', '.') ?></td>
     <td><?php echo ' ' . number_format($qac3, 0, ',', '.') ?></td>   
    <td><?php echo ' ' . number_format($qac3*$cota3, 2, ',', '.') ?></td>
    <td><?php echo ' ' . number_format($qac3*$cota3/$tg*100, 2, ',', '.') ?>%</td>
       
    <td><?php echo ' ' . number_format(($c3/$tg*100)+($qac3*$cota3/$tg*100), 2, ',', '.')  ?>%</td>
  </tr>
 
     <tr>
    <td></td>
    <td><?php echo ' ' . number_format(($max1+$max2+$max3), 2, ',', '.') ?></td>
        <td>100%</td>
    <td><?php echo ' ' . number_format($total, 2, ',', '.') ?></td>
        <td></td>
    <td></td>
    <td> </td>
    <td> </td>
    <td></td>
    
    <td><?php echo ' ' . number_format(($qac1+$qac2+$qac3), 0, ',', '.') ?></td>
    <td><?php echo ' ' . number_format(($qac1*$cota1+$qac2*$cota2+$qac3*$cota3), 2, ',', '.') ?></td>
    <td></td>
        
        <td style="color: red;">sobra:<?php echo ' ' . number_format(($ass), 2, ',', '.') ?> </td>
  </tr>

                         </tbody></table>

                <!-- BOTÕES -->
                                 
     <a href="createLance.php?id=<?php echo $_GET['id']?>" type="btn" class="btn btn-success">Voltar a Calcular</a> 
     <a href="index.php" type="btn" class="btn btn-warning">Voltar ao Início</a>
     <a href="fazLance.php?id=<?php echo $_GET['id']?>" type="btn" class="btn btn-dark">Realizar o Investimento</a>
     </form>