<?php
    require 'banco.php';
    $id=$_GET['id'];
     session_start();
    $_SESSION['id']=$_GET['id'];
   
      $qt1=$qt2=$qt3=$qt4=$qt5=$c1=$c2=$c3=$c4=$c5=0;
    if(!empty($_GET['id']))
    {
        $id = $_GET['id'];
    }
    if(null==$id)
    {
        header("Location: index.php");
    }
    else
{
       $pdo = Banco::conectar();
       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $sql = "SELECT * FROM pessoa where id = ?";
       $q = $pdo->prepare($sql);
       $q->execute(array($id));
       $data = $q->fetch(PDO::FETCH_ASSOC);
       
       $sql1 = "SELECT * FROM carteira where idcli = $id";
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
       $v1=$data1['v1'];  // empresa percentual
       $v2=$data1['v2'];
       $v3=$data1['v3'];       
       $v4=$data1['v4'];
       $v5=$data1['v5'];       
if(empty($data1)){header("Location: createcart.php?id=$id");}

 $sql2 = "SELECT * FROM empresa";
        $v1=$v2=$v3=0;               //cotação
        $e1=$e2=$e3="Não definido";  // nome da ação
        foreach($pdo->query($sql2)as $lis)
      {  
        if($a1==$lis['ide']){$ep1=$lis['emp'];$v1=$data1['v1'];$va1=$lis['valor'];}        
        if($a2==$lis['ide']){$ep2=$lis['emp'];$v2=$data1['v2'];$va2=$lis['valor'];}         
        if($a3==$lis['ide']){$ep3=$lis['emp'];$v3=$data1['v3'];$va3=$lis['valor'];}
        if($a4==$lis['ide']){$ep4=$lis['emp'];$v4=$data1['v4'];$va4=$lis['valor'];}
        if($a5==$lis['ide']){$ep5=$lis['emp'];$v5=$data1['v5'];$va5=$lis['valor'];}

               

      }
$pess= '
<table class="table table-striped" style=width="650px;">
            <!--      <br>   <?php echo $minha ?><br> -->
                    <thead>
                        <tr><th></th>

                            <th scope="col">Id</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Sobrenome</th>
                            <th scope="col">CPF</th>
                            <th scope="col">Celular</th>
                            <th scope="col">Email</th>
                            <th></th>
                            
                        </tr>
                        </thead>
                    <tbody>
                        <tr>
                            <td></td>
                           
                            ';
$x=$tot=$qq=$q=$total=0;
 /*        echo  '<div><table  width="600px" align="center">
                    <thead style="font-size:80%;">
                        <tr><th></th>
                            <th scope="col">Id</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Ação</th>
                            <th scope="col">Cotação</th>
                            <th scope="col">Quant</th>
                            <th scope="col">- R$ -</th>
                            <th scope="col">data</th>
                            
                        
                        </tr>
                    </thead>
                    <tbody >'; */
       // peda os lances do cliente 
       $ep=""; $ta=$te=$ti=$tve=$tvi=$r=0;   
    $sql3 = "SELECT * FROM lance where idcli = $id";
      foreach($pdo->query($sql3) as $lnc) 
  {
    $r++;
    $tttt=$lnc['tipo'];
        // seleciona os dados da empresa
        

        $q=$lnc['quant']; // quantas    no lance
        
        $x=$lnc['idct'];  // ações (id) no lance
        $t=$lnc['tipo'];
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



        // tela do lance
        if($q>0){            
      /*  echo '<tr style="font-size:80%;>
              <th scope="row" align="right"></th>
              <td></td>
             <td>'. $x . '</td>
              <td>'. $lnc['tipo'] . '</td>
              <td>'. $ep . '</td>
              <td>'. number_format($qq, 2, ',', '.') . '</td>
              <td>'. $q . '</td>  
              <td>'. number_format($tot, 2, ',', '.') . '</td>
              <td>'. $lnc['datac'] . '</td>
              </tr>';
              */

              if($lnc['tipo']=="Aposentadoria") {$ta+=$tot;}
              if($lnc['tipo']=="Estudos") {$te+=$tot;}
              if($lnc['tipo']=="Imóvel") {$ti+=$tot;}
              if($lnc['tipo']=="Veículo") {$tve+=$tot;}
              if($lnc['tipo']=="Viagem") {$tvi+=$tot;}


          }


        if($v1==0)
        {


        } 
        $vl1=$v1;
        $vl2=$v2;
        $vl3=$v3;
        $vl4=$v4;
        $vl5=$v5;
        $x++;




        if($a1==$lnc['idct']) 
            {
                $y = $ep1; 
                $v = $vl1;
                $c = $va1 * $lnc['quant'];
                $c1 = $c; 
                $qt1+=  $lnc['quant'];                   //<!-- valor investido -->
                $at = $va1;
            }
        if($a2==$lnc['idct']) 
            {
                $y = $ep2;
                $v = $vl2;
                $c = $va2 * $lnc['quant'];
                $c2 = $c;
                $qt2+=  $lnc['quant']; 
                $at = $va2;
            }
        if($a3==$lnc['idct']) 
            {
                $y = $ep3;
                $v = $vl3;
                $c = $va3 * $lnc['quant'];
                $c3 = $c;
                $qt3+=  $lnc['quant']; 
                $at = $va3;
            }
        if($a4==$lnc['idct']) 
            {
                $y = $ep4;
                $v = $vl4;
                $c = $va4 * $lnc['quant'];
                $c4 = $c;
                $qt4+=  $lnc['quant']; 
                $at = $va4;
            }
            if($a5==$lnc['idct']) 
            {
                $y = $ep5;
                $v = $vl5;
                $c = $va5 * $lnc['quant'];
                $c5 = $c;
                $qt5+=  $lnc['quant']; 
                $at = $va5;
            }
    $tt=$c1+$c2+$c3+$c4+$c5;
        if($tt>0) 
        {
 

        }
       

    
  }
//echo '<tr><tr><p  style="font-size:80%;" align="right;"><td></td><td></td><td></td><td></td><td></td><td>Total:      R$</td><td>'.number_format($total, 2, ',', '.').'</td></p></tr>';

$w1=$w2=$w3=$w4=$w5=0;
  $sql7 = "SELECT * FROM carteira where idcli = $id";
  $botao=$t1=$t2=$t3=$t4=$t5="";
  foreach($pdo->query($sql7) as $ct)
  {

    $t=$ct['tipo']; $perc=$ct['perc'];
    if($t=="Aposentadoria") {$t1="Aposentadoria";$botao.='<a href="lista.php?a='.$t1.'" type="btn" class="btn btn-primary">Aposentadoria : '.$perc.'%</a>'; $cart1=$perc;}
    if($t=="Estudos") {$t2="Estudos";$botao.='<a href="lista.php?a='.$t2.'" type="btn" class="btn btn-info">Estudos : '.$perc.'%</a>';$cart2=$perc;}
    if($t=="Imóvel") {$t3="Imóvel";$botao.='<a href="lista.php?a='.$t3.'" type="btn" class="btn btn-primary">Imóvel : '.$perc.'%</a>';$cart3=$perc;}
    if($t=="Veículo") {$t4="Veículo";$botao.='<a href="lista.php?a='.$t4.'" type="btn" class="btn btn-info">Veículo : '.$perc.'%</a>';$cart4=$perc;}
    if($t=="Viagem") {$t5="Viagem";$botao.='<a href="lista.php?a='.$t5.'" type="btn" class="btn btn-success">Viagem : '.$perc.'%</a>';$cart5=$perc;}
  
  }

    
  // echo $t1.'>>>>'.$t2.'>>>>'.$t3.'>>>>'.$t4.'>>>>'.$t5.'>>>>';
    //<a href="index.php" type="btn" class="btn btn-default">Voltar</a>
}   
$w11=0;
$aps='Aposentadoria';
$sql10 = "SELECT idct, quant FROM lance where idcli = $id && tipo = '$aps'";
      foreach($pdo->query($sql10) as $lca) 
  {     
    $ep=$lca['idct'];
            $sql9 = "SELECT ide,valor FROM empresa WHERE ide = $ep";        
                    foreach($pdo->query($sql9) as $ll)
                    {                          
                    }

    if($lca['idct']==$ll['ide']){
    $w11+=($ll['valor']*$lca['quant']);
    }
  } 
 $aps='Estudos';  
$sql11 = "SELECT idct, quant FROM lance where idcli = $id && tipo='$aps'";
      foreach($pdo->query($sql11) as $lca) 
  { 
  $ep=$lca['idct']; 
  $sql9 = "SELECT ide,valor FROM empresa WHERE ide = $ep";        
                    foreach($pdo->query($sql9) as $ll)
                    {                          
                    }   
    if($lca['idct']==$ll['ide']){
    $w2+=($ll['valor']*$lca['quant']);
    }
  } 
   $aps='Imóvel'; 
  $sql12 = "SELECT idct, quant FROM lance where idcli = $id && tipo='$aps'";
      foreach($pdo->query($sql12) as $lca) 
      
  {     
  $ep=$lca['idct']; 
  $sql9 = "SELECT ide,valor FROM empresa WHERE ide = $ep";        
                    foreach($pdo->query($sql9) as $ll)
                    {                          
                    }   
    if($lca['idct']==$ll['ide']){
    $w3+=($ll['valor']*$lca['quant']);
    }
  } 
   $aps='Veículo'; 
  $sql13 = "SELECT idct, quant FROM lance where idcli = $id && tipo='$aps'";
      foreach($pdo->query($sql13) as $lca) 
    
  {     
  $ep=$lca['idct']; 
  $sql9 = "SELECT ide,valor FROM empresa WHERE ide = $ep";        
                    foreach($pdo->query($sql9) as $ll)
                    {                          
                    }   
    if($lca['idct']==$ll['ide']){
    $w4+=($ll['valor']*$lca['quant']);
    }
  } 
   $aps='Viagem'; 
  $sql14 = "SELECT idct, quant FROM lance where idcli = $id && tipo='$aps'";
      foreach($pdo->query($sql14) as $lca) 
      
  {     
  $ep=$lca['idct']; 
  $sql9 = "SELECT ide,valor FROM empresa WHERE ide = $ep";        
                    foreach($pdo->query($sql9) as $ll)
                    {                          
                    }   
    if($lca['idct']==$ll['ide']){
    $w5+=($ll['valor']*$lca['quant']);
    }
  }  
?>

    <!DOCTYPE html>
    <html lang="pt-br">


    <head>
   
    <!-- Latest compiled and minified CSS -->
    <!--<link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Página Inicial</title>-->


    <meta charset="UTF-8">
    <title>Carteira de Investimentos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css"></link>    

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
  
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
    
        <div class="container" align="center;">
          <!--   <div class="span10 offset1">
                 <div class="card">
    								<div class="card-header"> -->

<?php echo $pess .' 
 <td>'.  $id.'</td>
                            <td>'.  $data['nome'].' </td>
                            <td>'.  $data['sobrenome'].'</td>
                            <td>'.  $data['cpf'].'</td>
                            <td>'.  $data['celular'].'</td>
                            <td>'. $data['email'].' </td><td></td>
                        </tr>
                        
                    </tbody>   
                    </table>';
?>


                     <p  style="align:center;">
                        <?php $_GET['id']=$data['id']; ?>
                        <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                       <!-- <a href="createLance.php?id=<?php echo $_GET['id']?>" class="btn btn-success">Consultar</a> -->
                        <a href="update.php?id=<?php echo $_GET['id']?>" type="btn" class="btn btn-warning">Mudar seus dados</a>
                        <a href="createcart.php?id=<?php echo $_GET['id']?>" type="btn" class="btn btn-blk">Criar Carteira</a>
                    </p>
                    <h3 class="well">Seu Investimento  - R$ <text style="text-align: right;"><?php echo number_format($total, 2, ',', '.') ?></text> </h3> 
                    <?php echo $botao;
                    echo "<br> proporção do investimento nas carteiras: ".'<br>';
                    echo '<div><table  width="600px" align="center">
                    <thead style="font-size:80%;">
                        <tr>
                            <th scope="col">Carteira</th>
                            <th scope="col">Previsto</th>
                            <th scope="col">Atual</th>
                            <th scope="col">Valor R$</th>
                            <th scope="col">Prev.R$</th>
                            <th scope="col">Diferença</th>
                            
                            <th scope="col">situaçao</th>
                        </tr>
                    </thead>
                    <tbody >'; 
                    if($ta>0){echo '<tr><td>Aposentadoria</td>
                    <td>'.$cart1.'%</td>
                    <td>'.number_format(($ta/$total*100), 2, ',', '.').'%</td>
                    <td>R$ '.number_format($w11, 2, ',', '.').'</td>
                    <td>'.number_format($cart1*$total/100, 2, ',', '.').'</td>
                    <td>'.number_format($w11-($cart1*$total/100), 2, ',', '.').'</td>
                    <td>'.number_format(($w11/$total*100)-($cart1), 2, ',', '.').'%</td>';
                    if(($cart1)-($w11/$total*100)<0){echo '<td>Excedente</td>';}
                        else{echo '<td>em falta</td>';}
                   
                    }   
              
                    
                    if($te>0){echo '<tr><td>Estudos</td>
                    <td>'.$cart2.'%</td>
                    <td>'.number_format(($te/$total*100), 2, ',', '.').'%</td>
                    <td>R$ '.number_format($w2, 2, ',', '.').'</td>
                    <td>'.number_format($cart2*$total/100, 2, ',', '.').'</td>
                    <td>'.number_format($w2-($cart2*$total/100), 2, ',', '.').'</td>
                    <td>'.number_format(($w2/$total*100)-$cart2, 2, ',', '.').'%</td>';
                    if(($cart2)-($w2/$total*100)<0){echo '<td>Excedente</td>';}
                        else{echo '<td>em falta</td>';}
                    }

                    

                    if($ti>0){echo '<tr><td>Imóvel</td>
                    <td>'.$cart3.'%</td>
                    <td>'.number_format(($ti/$total*100), 2, ',', '.').'%</td>
                    <td>R$ '.number_format($w3, 2, ',', '.').'</td>
                    <td>'.number_format($cart3*$total/100, 2, ',', '.').'</td>
                    <td>'.number_format($w3-($cart3*$total/100), 2, ',', '.').'</td>
                    <td>'.number_format(($w3/$total*100)-($cart3), 2, ',', '.').'%</td>';
                    if(($cart3)-($w3/$total*100)<0){echo '<td>Excedente</td>';}
                        else{echo '<td>em falta</td>';}
                    }
                


                    if($tve>0){echo '<tr><td>Veículo</td>
                    <td>'.$cart4.'%</td>
                    <td>'.number_format(($tve/$total*100), 2, ',', '.').'%</td>
                    <td>R$ '.number_format($w4, 2, ',', '.').'</td>
                    <td>'.number_format($cart4*$total/100, 2, ',', '.').'</td>
                    <td>'.number_format($w4-($cart4*$total/100), 2, ',', '.').'</td>
                    <td>'.number_format(($w4/$total*100)-($cart4), 2, ',', '.').'%</td>';
                    if(($cart4)-($w4/$total*100)<0){echo '<td>Excedente</td>';}
                        else{echo '<td>em falta</td>';}
                    }

                

                    if($tvi>0){echo '<tr><td>Viagem</td>
                    <td>'.$cart5.'%</td>
                    <td>'.number_format(($tvi/$total*100), 2, ',', '.').'%</td>
                    <td>R$ '.number_format($w5, 2, ',', '.').'</td>
                    <td>'.number_format($cart5*$total/100, 2, ',', '.').'</td>
                    <td>'.number_format($w5-($cart5*$total/100), 2, ',', '.').'</td>
                    <td>'.number_format(($w5/$total*100)-($cart5), 2, ',', '.').'%</td>';
                    if(($cart5)-($w5/$total*100)<0){echo '<td>Excedente</td>';}
                        else{echo '<td>em falta</td>';}
                    }
                    ?>
                </div>

                <div class="container">
                    <form class="form-horizontal" action="createLance.php?id" method="post">
                    <input type="hidden" name="id" id="id"
                         value="<?php echo $id; ?>">
            <!--     <div class="form-horizontal"> -->
                                        
                   

                    

                  </div>
                  </div>
                </div>
            </div>
       


        <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="assets/js/bootstrap.min.js"></script>

    </div>    
                    
    </body>

</html>

