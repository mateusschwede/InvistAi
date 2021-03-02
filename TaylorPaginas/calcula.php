<?php
require 'banco.php';

$a=$_GET['a'];
session_start();
$id=$_SESSION['id'];
$inv=$_POST['inv'];

$sql = "SELECT * FROM pessoa where id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($id));
$data = $q->fetch(PDO::FETCH_ASSOC);

$sql1 = "SELECT * FROM carteira where idcli = $id && tipo = '$a'";
$q = $pdo->prepare($sql1);
$q->execute(array($id));
$data1 = $q->fetch(PDO::FETCH_ASSOC);
// pegamos aqui os dados da configuração das carteiras do cliente
$t=$data1['tipo'];
$perc=$data1['perc'];
$a1=$data1['a1']; // empresa id
$a2=$data1['a2'];
$a3=$data1['a3'];  
$a4=$data1['a4'];
$a5=$data1['a5'];     
$vv1=$data1['v1'];  // empresa percentual
$vv2=$data1['v2'];
$vv3=$data1['v3'];       
$vv4=$data1['v4'];
$vv5=$data1['v5'];      



$sql2 = "SELECT * FROM empresa";
$v1=$v2=$v3=0; //cotação
$e1=$e2=$e3="Não definido"; // nome da ação
foreach($pdo->query($sql2)as $lis) {  
    if($data1['a1']==$lis['ide']){$ep1=$lis['emp'];$v1=$data1['v1'];$va1=$lis['valor']; $e1=$lis['ide'];}        
    if($data1['a2']==$lis['ide']){$ep2=$lis['emp'];$v2=$data1['v2'];$va2=$lis['valor'];$e2=$lis['ide'];}         
    if($data1['a3']==$lis['ide']){$ep3=$lis['emp'];$v3=$data1['v3'];$va3=$lis['valor'];$e3=$lis['ide'];}
    if($data1['a4']==$lis['ide']){$ep4=$lis['emp'];$v4=$data1['v4'];$va3=$lis['valor'];$e4=$lis['ide'];}
    if($data1['a5']==$lis['ide']){$ep5=$lis['emp'];$v5=$data1['v5'];$va3=$lis['valor'];$e5=$lis['ide'];}
    // pegamos aqui o nome e a cotação da ação nas variáveis $empr e $cota
    if($a1 == $lis['ide']) {   
        $empr1 = $lis['emp'];
        $cota1= $lis['valor'];
    } 
    if($lis['ide'] == $a2) {
        $empr2= $lis['emp'] ;
        $cota2= $lis['valor'];
    } 
    if($lis['ide'] == $a3) {
        $empr3= $lis['emp'] ;
        $cota3= $lis['valor'];
    }
    if($lis['ide'] == $a4) {
        $empr4= $lis['emp'] ;
        $cota4= $lis['valor'];
    }
    if($lis['ide'] == $a5) {
        $empr5= $lis['emp'] ;
        $cota5= $lis['valor'];
    }
}


$qt1=$qt2=$qt3=$qt4=$qt5=$c1=$c2=$c3=$c4=$c5=$qq=$ep=$tot= $total=0;

$sql3 = "SELECT * FROM lance where idcli = $id && tipo = '$a'";
foreach($pdo->query($sql3) as $lnc) {
    $q=$lnc['quant']; // quantas    no lance
    $x=$lnc['idct'];  // ações (id) no lance
    $t=$lnc['tipo'];

    $sql9 = "SELECT * FROM empresa";
    foreach($pdo->query($sql9) as $ll) {
        
        if($ll['ide']==$x) { //se id é igual ao id lance só tem uma empr
            $qq=($ll['valor']); //pega cotação
            $ep=$ll['emp'];
            $tot=($q * $qq);  // em Reais
            $total+=$tot;    // em Reais
        }
    }

    if($a1==$lnc['idct']) {$c1+= $tot; $qt1+=$q; $cota1=$qq;}   // distribui total da a��o espec�fica $C em reais            
    if($a2==$lnc['idct']) {$c2+= $tot; $qt2+=$q; $cota2=$qq;}   //    quantidade total da a��o espec�fica $qt 
    if($a3==$lnc['idct']) {$c3+= $tot; $qt3+=$q; $cota3=$qq;}
    if($a4==$lnc['idct']) {$c4+= $tot; $qt4+=$q; $cota4=$qq;}
    if($a5==$lnc['idct']) {$c5+= $tot; $qt5+=$q; $cota5=$qq;}    

    $tt=$c1+$c2+$c3+$c4+$c5;
    if($tt>0) {}// não houve investimento
}


$vinv1=$vinv2=$vinv3=$vinv4=$vinv5=0;     // variável investimento na ação
$vl1=$vl2=$vl3=$vl4=$vl5=0;
$qac1=$qac2=$qac3=$qac4=$qac5=$z=0; 

$tg=$total+$inv;

$max1=$tg*$vv1/100;             // valor máximo a investir na ação   $max
$max2=$tg*$vv2/100;
$max3=$tg*$vv3/100;
$max4=$tg*$vv4/100;
$max5=$tg*$vv5/100;

$vl1=$max1/$tg*100;             // valor percentual do máximo na ação   $$vl
$vl2=$max2/$tg*100;
$vl3=$max3/$tg*100;
$vl4=$max4/$tg*100;
$vl5=$max5/$tg*100;

if($c1<$max1) {$vinv1=($max1-$c1);}  // Valor a investir vinv $máx - $c (existente na ação)
if($c2<$max2) {$vinv2=($max2-$c2);}
if($c3<$max3) {$vinv3=($max3-$c3);}
if($c4<$max4) {$vinv4=($max4-$c4);}
if($c5<$max5) {$vinv5=($max5-$c5);}     

$y=$inv+.001; 
if($qac1=0){$qac1=$vinv1;}
if($qac2=0){$qac2=$vinv2;}
if($qac3=0){$qac3=$vinv3;}
if($qac4=0){$qac4=$vinv4;}
if($qac5=0){$qac5=$vinv5;}

$qac1=(int)($vinv1/$cota1);
$qac2=(int)($vinv2/$cota2);
$qac3=(int)($vinv3/$cota3);
$qac4=(int)($vinv4/$cota4);
$qac5=(int)($vinv5/$cota5);

$z=$inv-($qac1*$cota1+$qac2*$cota2+$qac3*$cota3+$qac4*$cota4+$qac5*$cota5);

if($z>$cota1) {$z-=$cota1; $qac1++;}
if($z>$cota2) {$z-=$cota2; $qac2++;}
if($z>$cota3) {$z-=$cota3; $qac3++;}
if($z>$cota4) {$z-=$cota4; $qac4++;}
if($z>$cota5) {$z-=$cota5; $qac5++;}
$ass=$z;

$_SESSION['ass']=$ass;  // sobra em R$
$_SESSION['a']=$a;      // tipo de carteira
$_SESSION['qt1']=(int)$qac1;  // quantidade a comprar
$_SESSION['qt2']=(int)$qac2;  // quantidade a comprar
$_SESSION['qt3']=(int)$qac3;  // quantidade a comprar
$_SESSION['qt4']=(int)$qac4;
$_SESSION['qt5']=(int)$qac5;
$_SESSION['cota1']=$cota1;  // valor da cotaÃ§Ã£o aÃ§Ã£o
$_SESSION['cota2']=$cota2;  // valor da cotaÃ§Ã£o aÃ§Ã£o
$_SESSION['cota3']=$cota3;  // valor da cotaÃ§Ã£o aÃ§Ã£o
$_SESSION['cota4']=$cota4;
$_SESSION['cota5']=$cota5;
$_SESSION['ac1']=$a1;  // Ã­ndice da aÃ§Ã£o
$_SESSION['ac2']=$a2;  // Ã­ndice da aÃ§Ã£o
$_SESSION['ac3']=$a3;  // Ã­ndice da aÃ§Ã£o
$_SESSION['ac4']=$a4; 
$_SESSION['ac5']=$a5;


// variável investimento valor % da ação proporcional ao total geral  

$y=$inv; 
// sobra
echo '<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
<style type="text/css">
.wrapper{ width: 650px; margin: 0 auto;}
.page-header h2{margin-top: 0;}
table tr td:last-child a{margin-right: 15px;}
</style>
</head>
<body>
<br>
<div width="600px" align="center">
<div clas="span10 offset1">
<div class="card">
<div class="card-header">
<h3 class="well" style="text-align: center;">'.number_format($inv, 2, ',', '.'). " + " . number_format($total, 2, ',', '.') . '  (saldo atual)  = '. number_format($tg, 2, ',', '.') 
.'</h3>
</div>
<div class="card-body">
<form style="text-align: center;" class="form-horizontal" style="font-size:80%;">

<p style="text-align: center;"><h2> Investimento Futuro</h2></p>
<table class="table table-striped">
<thead style="text-align: right;" style="font-size:80%;">

<tr>

<th></th>
<th >Previsão</th>
<th >% previsão</th>
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
<tbody style="text-align: right;">
<!--   ######################### AÇÃO 1 #####################################    -->';
if($max1>0){ echo '

<tr><td></td>
<td>'. ' ' . number_format($max1, 2, ',', '.').'</td>           
<td>'. ' '  . number_format($vl1, 2, ',', '.') .'%</td>
<td>'. ' ' . number_format($c1, 2, ',', '.') .'</td>
<td>' .' ' . number_format($c1/$tg*100, 2, ',', '.')  .'%</td>
<td>' .' ' . number_format($qt1, 0, ',', '.') .'</td>
<td>'. $empr1 .'</td>    
<td>' .' ' .  number_format($vinv1, 2, ',', '.') .'</td>
<td>' .' ' . number_format($cota1, 2, ',', '.') .'</td>        
<td>' .' ' .  number_format($qac1, 0, ',', '.') .'</td>
<td>' .' ' .  number_format($qac1*$cota1, 2, ',', '.') .'</td>
<td>' .' ' .  number_format($qac1*$cota1/$tg*100, 2, ',', '.') .'%</td>        
<td>' .' ' .  number_format(($c1/$tg*100)+($qac1*$cota1/$tg*100), 2, ',', '.')  .'%</td>
<td></td> 
</tr> ';
} 
//<!--   ######################### AÇÃO 2 #####################################    -->
if($max2>0){ echo '

<tr><td></td>
<td>'. ' ' . number_format($max2, 2, ',', '.').'</td>
<td>'. ' '  . number_format($vl2, 2, ',', '.') .'%</td>
<td>'. ' ' . number_format($c2, 2, ',', '.') .'</td>
<td>' .' ' . number_format($c2/$tg*100, 2, ',', '.')  .'%</td>
<td>' .' ' . number_format($qt2, 0, ',', '.') .'</td>
<td>'. $empr2 .'</td>    
<td>' .' ' .  number_format($vinv2, 2, ',', '.') .'</td>
<td>' .' ' . number_format($cota2, 2, ',', '.') .'</td>        
<td>' .' ' .  number_format($qac2, 0, ',', '.') .'</td>
<td>' .' ' .  number_format($qac2*$cota2, 2, ',', '.') .'</td>
<td>' .' ' .  number_format($qac2*$cota2/$tg*100, 2, ',', '.') .'%</td>        
<td>' .' ' .  number_format(($c2/$tg*100)+($qac2*$cota2/$tg*100), 2, ',', '.')  .'%</td>
<td></td> 
</tr> ';
} 
// <!--   ######################### AÇÃO 3 #####################################    -->
if($max3>0){ echo '

<tr><td></td>
<td>'. ' ' . number_format($max3, 2, ',', '.').'</td>
<td>'. ' '  . number_format($vl3, 2, ',', '.') .'%</td>
<td>'. ' ' . number_format($c3, 2, ',', '.') .'</td>
<td>' .' ' . number_format($c3/$tg*100, 2, ',', '.')  .'%</td>
<td>' .' ' . number_format($qt3, 0, ',', '.') .'</td>
<td>'. $empr3 .'</td>    
<td>' .' ' .  number_format($vinv3, 2, ',', '.') .'</td>
<td>' .' ' . number_format($cota3, 2, ',', '.') .'</td>        
<td>' .' ' .  number_format($qac3, 0, ',', '.') .'</td>
<td>' .' ' .  number_format($qac3*$cota3, 2, ',', '.') .'</td>
<td>' .' ' .  number_format($qac3*$cota3/$tg*100, 2, ',', '.') .'%</td>        
<td>' .' ' .  number_format(($c3/$tg*100)+($qac3*$cota3/$tg*100), 2, ',', '.')  .'%</td>
<td></td> 
</tr> ';
}
//<!--   ######################### AÇÃO 4 #####################################    -->
if($max4>0){ echo '
<tr><td></td>
<td>'. ' ' . number_format($max4, 2, ',', '.').'</td>
<td>'. ' '  . number_format($vl4, 2, ',', '.') .'%</td>
<td>'. ' ' . number_format($c4, 2, ',', '.') .'</td>
<td>' .' ' . number_format($c4/$tg*100, 2, ',', '.')  .'%</td>
<td>' .' ' . number_format($qt4, 0, ',', '.') .'</td>
<td>'. $empr4 .'</td>    
<td>' .' ' .  number_format($vinv4, 2, ',', '.') .'</td>
<td>' .' ' . number_format($cota4, 2, ',', '.') .'</td>        
<td>' .' ' .  number_format($qac4, 0, ',', '.') .'</td>
<td>' .' ' .  number_format($qac4*$cota4, 2, ',', '.') .'</td>
<td>' .' ' .  number_format($qac4*$cota4/$tg*100, 2, ',', '.') .'%</td>        
<td>' .' ' .  number_format(($c4/$tg*100)+($qac4*$cota4/$tg*100), 2, ',', '.')  .'%</td>
<td></td> 
</tr> ';
}
// <!--   ######################### AÇÃO 5 #####################################    -->
if($max5>0){ echo '
<tr><td></td>
<td>'. ' ' . number_format($max5, 2, ',', '.').'</td>
<td>'. ' '  . number_format($vl5, 2, ',', '.') .'%</td>
<td>'. ' ' . number_format($c5, 2, ',', '.') .'</td>
<td>' .' ' . number_format($c5/$tg*100, 2, ',', '.')  .'%</td>
<td>' .' ' . number_format($qt5, 0, ',', '.') .'</td>
<td>'. $empr5 .'</td>    
<td>' .' ' .  number_format($vinv5, 2, ',', '.') .'</td>
<td>' .' ' . number_format($cota5, 2, ',', '.') .'</td>        
<td>' .' ' .  number_format($qac5, 0, ',', '.') .'</td>
<td>' .' ' .  number_format($qac5*$cota5, 2, ',', '.') .'</td>
<td>' .' ' .  number_format($qac5*$cota5/$tg*100, 2, ',', '.') .'%</td>        
<td>' .' ' .  number_format(($c5/$tg*100)+($qac5*$cota5/$tg*100), 2, ',', '.')  .'%</td>
<td></td> 
</tr> ';
} 

echo '
<tr>
<td></td>
<td>' . number_format(($max1+$max2+$max3+$max4+$max5), 2, ',', '.') .'</td>
<td>100%</td>
<td> ' . number_format($total, 2, ',', '.') .'</td>
<td></td>
<td></td>
<td> </td>
<td>' . number_format( ($vinv1+$vinv2+$vinv3+$vinv4+$vinv5), 0, ',', '.') .'</td>
<td></td>

<td>' . number_format(($qac1+$qac2+$qac3+$qac4+$qac5), 0, ',', '.') .'</td>
<td>' . number_format(($qac1*$cota1+$qac2*$cota2+$qac3*$cota3+$qac4*$cota4+$qac5*$cota5), 2, ',', '.') .'</td>
<td></td>

<td style="color: red;">sobra:' . number_format(($ass), 2, ',', '.') .' </td>
</tr>

</tbody></table>
<br/>

<a href="lista.php?a='. $a.'" type="btn" class="btn btn-success">Voltar a calcular</a> 
<a href="teste.php?id='. $id.'" type="btn" class="btn btn-warning">Voltar ao InÃ­cio</a>
<a href="fazLance.php?id='. $id.'" type="btn" class="btn btn-dark">Realizar o Investimento</a>



<br><br><br>
<br><br><p id="grade" style="font-size:120%; text-align:center;"></p>
</div>
</form>
';
?>