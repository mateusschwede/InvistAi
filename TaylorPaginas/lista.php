<?php
require 'banco.php';
$a=$_GET['a'];
session_start();
$id=$_SESSION['id'];
$_SESSION['a']=$a;


    $_GET['id']=$id;
    $qt1=$qt2=$qt3=$c1=$c2=$c3=0;
    if(!empty($_GET['id'])) {$id = $_GET['id'];}
    
    if(null==$id){header("Location: index.php");}
    else {
       $pdo = Banco::conectar();
       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
        $v1=$v2=$v3=0;               //cotação
        $e1=$e2=$e3="Não definido";  // nome da ação
        foreach($pdo->query($sql2)as $lis) {  
            if($data1['a1']==$lis['ide']) {$ep1=$lis['emp'];$v1=$data1['v1'];$va1=$lis['valor']; $e1=$lis['ide'];}        
            if($data1['a2']==$lis['ide']) {$ep2=$lis['emp'];$v2=$data1['v2'];$va2=$lis['valor'];$e2=$lis['ide'];}         
            if($data1['a3']==$lis['ide']) {$ep3=$lis['emp'];$v3=$data1['v3'];$va3=$lis['valor'];$e3=$lis['ide'];}
            if($data1['a4']==$lis['ide']) {$ep4=$lis['emp'];$v4=$data1['v4'];$va3=$lis['valor'];$e4=$lis['ide'];}
            if($data1['a5']==$lis['ide']) {$ep5=$lis['emp'];$v5=$data1['v5'];$va3=$lis['valor'];$e5=$lis['ide'];}
            
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
$tottal=0;

  echo '<div width="600px" align="center"><h1>Carteira'.' - '.$a.' - ' .$perc.'% </h1><br><br></div>';
  echo  '
    <div><table  width="600px" align="center">
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
    <tbody >
  '; 

    $qt1=$qt2=$qt3=$qt4=$qt5=$c1=$c2=$c3=$c4=$c5=$qq=$ep=$tot= $total=0;
    $sql3 = "SELECT * FROM lance where idcli = $id && tipo = '$a'";
  
  foreach($pdo->query($sql3) as $lnc) {

  $q=$lnc['quant']; // quantas    no lance        
  $x=$lnc['idct'];  // ações (id) no lance
  $t=$lnc['tipo'];

         $sql9 = "SELECT * FROM empresa";        
              foreach($pdo->query($sql9) as $ll) {
                  if($ll['ide']==$x)
                      { // se o íd é igual ao id lance só tem uma empr
                          $qq=($ll['valor']); //pega cotação
                          $ep=$ll['emp'];
                          $tot=($q * $qq);  // em Reais
                          $total+=$tot;    // em Reais
                      }
              }

      if($a1==$lnc['idct']) {$c1+= $tot; $qt1+=$q;}   // distribui total da ação específica $C em reais            
      if($a2==$lnc['idct']) {$c2+= $tot; $qt2+=$q;}   //    quantidade total da ação específica $qt 
      if($a3==$lnc['idct']) {$c3+= $tot; $qt3+=$q;}
      if($a4==$lnc['idct']) {$c4+= $tot; $qt4+=$q;}
      if($a5==$lnc['idct']) {$c5+= $tot; $qt5+=$q;}          
    
    // tela do lance
    echo '
        <tr style="font-size:80%;>
            <th scope="row"></th>
            <td></td>
            <td>'.$x.'</td>
            <td>'.$t.'</td>
            <td>'.$ep.'</td>
            <td>'.$qq.'</td>
            <td>'.$lnc['quant'].'</td>  
            <td>'.$tot.'</td>
            <td>'.$lnc['datac'].'</td>
        </tr>
    ';
    $tt=$c1+$c2+$c3+$c4+$c5;
    if($tt>0) {/*Não houve investimento*/}
}

echo '<tr><tr style="font-size:80%;"><td></td><td></td><td></td><td></td><td></td><td>Total:R$</td><td>'.$total.'</td></tr></tbody></table>';
}

Banco::desconectar();
$config='';
if($vv1>0){$config.='['.$empr1.'-'.$vv1.'%]';}
if($vv2>0){$config.='['.$empr2.'-'.$vv2.'%]';}
if($vv3>0){$config.='['.$empr3.'-'.$vv3.'%]';}
if($vv4>0){$config.='['.$empr4.'-'.$vv4.'%]';}
if($vv5>0){$config.='['.$empr5.'-'.$vv5.'%]';}

$_SESSION['$vv1']=$vv1;
$_SESSION['$vv2']=$vv2;
$_SESSION['$vv3']=$vv3;
$_SESSION['$vv4']=$vv4;
$_SESSION['$vv5']=$vv5;
$_SESSION['$cota1']=$cota1;
$_SESSION['$cota2']=$cota2;
$_SESSION['$cota3']=$cota3;
$_SESSION['$cota4']=$cota4;
$_SESSION['$cota5']=$cota5;
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{width: 650px;margin: 0 auto;}
        .page-header h2{margin-top: 0;}
        table tr td:last-child a{margin-right: 15px;}
    </style>
</head>
<body>
  <br>
  <p class="wrapper" align="center;"><strong>Configuração atual: </strong>
  <?php echo $config ?></p><br>
  
    <form class="wrapper" action="calcula.php?a=<?php echo $a ?>" method="post">
        <h3 class="well" align="center;"> Quanto Investir  -  R$<span size="20">
            <input size="7" name="inv" type="text" placeholder="Nº inteiro" required value="<?php echo !empty($inv)?$inv: '';?>"></span>    
        </h3>
        <button type="btn" id="b1" class="btn btn-blk" onclick="faz()">Ver</button>
        <button type="submit" class="btn btn-success">Consultar</button>
        <a href="teste.php?id=<?php echo $id?>" type="btn" class="btn btn-default">Voltar</a>
        
        <p id="grade" style="font-size:120%; text-align:center;"></p>
        </div>
    </form>
</div>
         

        
</body>
</html>