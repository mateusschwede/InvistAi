<?php
    require 'banco.php';
$id=$_GET['id'];
$c1=$c2=$c3=$y=$a=$v=$c=$d=0;
    if(!empty($id))
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

       $sql2 = "SELECT * FROM empresa";
       foreach($pdo->query($sql2)as $lis)
                        {  
        
        if($ac1 == $lis['ide']) { // se id da ação = id da empresa Um
            $empr1 = $lis['emp'];   // o nome da empresa UM 
            $cota1= $lis['valor'];  // O valor da Ação Um
        } 
        if($ac2 == $lis['ide']) {
            $empr2= $lis['emp'] ;
             $cota2= $lis['valor'];
        } 
        if($ac3 == $lis['ide']) {
            $empr3= $lis['emp'] ;
             $cota3= $lis['valor'];
        }
            

    }
             
        $sql = "SELECT * FROM lance where idcli = $id";
                    $total=$tt=$x=0;

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
        $h=$m=0; 
        $it[]="";
        $vi[]="";                             
       foreach($pdo->query($sql) as $lnc) 
{
       // seleciona os dados da empresa
        $q=$lnc['quant']; // quantas    no lance
        
        $x=$lnc['idct'];  // ações (id) no lance
               $sql9 = "SELECT * FROM empresa";        
                    foreach($pdo->query($sql9) as $ll)
                    {   // 
                        if($ll['ide']==$x)
                            { // se o íd é igual ao id lance só tem uma empr
                                $qq=($ll['valor']); //pega cotação
                                $ep=$ll['emp'];
                                $tot=($q * $qq);  // em Reais
                                $total+=$tot;    // em Reais
                            }
                            
                    }

        if($ac1!=$lnc['idct'] && $ac2!=$lnc['idct'] && $ac3!=$lnc['idct'])
        {             // guarda as ações retiradas do cálculo
            $m++;
            $it[$m]=$ll['emp'];
            $vi[$m]=$tot;
            $h+=$tot;
                //echo $ll['emp'].'-'.$tot.'= R$'.$h.'<br>';
            
        } 

        if($ac1==0)
        {
            $empr1=$empr2=$empr3='';
            $cota1=$cota1=$cota1=0;
        } 

        $x++; 
        if($ac1 ==$lnc['idct'])
            {
                $y = $empr1; 
                $v = $vl1;
                $c = $cota1 * $lnc['quant'];
                $c1 += $c; 
                $qt1=  $lnc['quant'];                   //<!-- valor investido -->
                $a = $cota1;
            }
        if($ac2==$lnc['idct']) 
            {
                $y = $empr2;
                $v = $vl2;
                $c = $cota2 * $lnc['quant'];
                $c2 += $c;
                $qt2=  $lnc['quant']; 
                $a = $cota2;
            }
        if($ac3==$lnc['idct']) 
            {
                $y = $empr3;
                $v = $vl3;
                $c = $cota3 * $lnc['quant'];
                $c3 += $c;
                $qt3=  $lnc['quant']; 
                $a = $cota3;
            }
        

$tt=$c1+$c2+$c3;
        if($tt>0) {
 
//echo '</h1>'.$inv.'</h1>';

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
       }
 
       

/*$tg=($inv+$tt);  // novo invest + saldo
$dfper=($tt/$tg);  // percentual da diferença entre o que tem e o total
$dov=($tg*$dfper)/100;  // obter o total * diferença /100
$difer=100-$dov;    // obter a diferença percentual
$noval=$difer*$inv/100;   // diferença * percentual do novo valor
$noval1=($vl1)*($tg/100);    // percentual da empr 1 em rel ao total
$noval2=($vl2)*($tg/100);    // percentual da empr 2 em rel ao total
$noval3=($vl3)*($tg/100);   // percentual da empr 3 em rel ao total
$incl1= $noval1 - $c1;   // valor total proporc - o valor que tem
$incl2= $noval2 - $c2;   // valor total proporc - o valor que tem
$incl3= $noval3 - $c3;   // valor total proporc - o valor que tem
if($ac1>0)
        {
$pa1=($c1/$tg)*1000; // percentual da emp1 com o investimento
$pa2=($c2/$tg)*1000; // percentual da emp1 com o investimento
$pa3=($c3/$tg)*1000; // percentual da emp1 com o investimento
$np1=$vl1-$pa1; // percentual projetado para a emp1 com o investimento
$np2=$vl2-$pa2; // percentual projetado para a emp1 com o investimento
$np3=$vl3-$pa3; // percentual projetado para a emp1 com o investimento
$qac1=(int)($incl1/$cota1);
$qac2=(int)($incl2/$cota2);
$qac3=(int)($incl3/$cota3);
$tocot1=(int)($qac1)+$qt1;
$tocot2=(int)($qac2)+$qt2;
$tocot3=(int)($qac3)+$qt3;
}
//echo $pa1.' | '.$c1.' | '.$np1.' | '.$pa2.' | '.$c2.' | '.$np2.' | valor '.$dov.' | difer perc'.$difer;
           // echo $form; */
    Banco::desconectar();
    
}
if($ac1 > 0)
        {
   // $_SESSION['qt1']=$qac1;  // quantidade a comprar
   // $_SESSION['qt2']=$qac2;  // quantidade a comprar
   // $_SESSION['qt3']=$qac3;  // quantidade a comprar
   // $_SESSION['cota1']=$cota1;  // valor da ação
    //$_SESSION['cota2']=$cota2;  // valor da ação
    //$_SESSION['cota3']=$cota3;  // valor da ação
    //$_SESSION['ac1']=$ac1;  // índice da ação
    //$_SESSION['ac2']=$ac2;  // índice da ação
    //$_SESSION['ac3']=$ac3;  // índice da ação
    }
echo '<tr><tr style="font-size:80%;"><td></td><td></td><td></td><td></td><td></td><td>Total:</td><td>R$'.$total.'</td></tr><br><br>';
$h=0;
for($x=1;$x<($m)+1;$x++){
                $h+=$vi[$x];
                echo 'Valor desconsiderado para o cálculo:'.$it[$x].'= R$'.$h.'<br>';
            }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
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
    <p style="text-align:center;">Configuração atual:<strong>|<?php echo $empr1.':'.$vl1.'% |  |'.$empr2.':'.$vl2.'% |  |'.$empr3.':'.$vl3.'% |'?></strong></p>
    <div class="container">
        <div clas="span10 offset1">
          <div class="card">
            <div class="card-header">
                <h3 class="well"> Quanto Investir</h3>
            </div>
            <div class="card-body">
            <form class="form-horizontal" action="inve.php?id=<?php echo $_GET['id']?>" method="post">
               R$ <span size="20">
<input size="7" name="inv" type="text" placeholder="Nº inteiro" required=""
                         value="<?php echo !empty($inv)?$inv: '';?>"></span>
    <div class="form-actions">
                    <br/>
                    <button type="btn" id="b1" class="btn btn-blk">Ver</button>
                    <button type="submit" class="btn btn-success">Consultar</button>
                    <a href="read.php?id=<?php echo $id?>" type="btn" class="btn btn-default">Voltar</a>
                    <br><br>
<br><br><p style="font-size:120%; text-align:center;">Seu investimento</p>
                </div>
            </form>
 <?php
