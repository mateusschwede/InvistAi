<?php
    require 'banco.php';
      $qt1=$qt2=$qt3=$c1=$c2=$c3=0;
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
       $e1=$data['a1']; // empresa id
       $e2=$data['a2'];
       $e3=$data['a3'];       
       $v1=$data['p1'];  // empresa percentual
       $v2=$data['p2'];
       $v3=$data['p3'];       


 $sql2 = "SELECT * FROM empresa";
        $v1=$v2=$v3=0;               //cotação
        $e1=$e2=$e3="Não definido";  // nome da ação
        foreach($pdo->query($sql2)as $lis)
                        {  
        if($data['a1']==$lis['ide']){$ep1=$lis['emp'];$v1=$data['p1'];$va1=$lis['valor']; $e1=$lis['ide'];}        
        if($data['a2']==$lis['ide']){$ep2=$lis['emp'];$v2=$data['p2'];$va2=$lis['valor'];$e2=$lis['ide'];}         
        if($data['a3']==$lis['ide']){$ep3=$lis['emp'];$v3=$data['p3'];$va3=$lis['valor'];$e3=$lis['ide'];}

        if($e1 == $lis['ide']) {   
            $empr1 = $lis['emp'];
            $cota1= $lis['valor'];
        } 
        if($lis['ide'] == $e2) {
            $empr2= $lis['emp'] ;
             $cota2= $lis['valor'];
        } 
        if($lis['ide'] == $e3) {
            $empr3= $lis['emp'] ;
             $cota3= $lis['valor'];
        }
            

    }



$x=$tot=$qq=$q=$total=0;
         echo  '<div><table  width="600px" align="center">
                    <thead style="font-size:80%;">
                        <tr><th></th>
                            <th scope="col">Id</th>
                            
                            <th scope="col">Ação</th>
                            <th scope="col">Cotação</th>
                            <th scope="col">Quant</th>
                            <th scope="col">- R$ -</th>
                            <th scope="col">data</th>
                            
                        
                        </tr>
                    </thead>
                    <tbody >'; 
       // peda os lances do cliente     
    $sql3 = "SELECT * FROM lance where idcli = $id";
      foreach($pdo->query($sql3) as $lnc) 
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
        // tela do lance
        echo '<tr style="font-size:80%;>
              <th scope="row"></th>
              <td></td>
              <td>'. $x . '</td>
              <td>'. $ep . '</td>
              <td>'. $qq . '</td>
              <td>'. $q . '</td>  
              <td>'. $tot . '</td>
              <td>'. $lnc['datac'] . '</td>
              </tr>';



        if($v1==0)
        {
            $empr1=$empr2=$empr3='';
            $cota1=$cota1=$cota1=0;
        } 
$vl1=$v1;
$vl2=$v2;
$vl3=$v3;
        $x++; 
        if($e1==$lnc['idct']) 
            {
                $y = $empr1; 
                $v = $vl1;
                $c = $cota1 * $lnc['quant'];
                $c1 = $c; 
                $qt1+=  $lnc['quant'];                   //<!-- valor investido -->
                $a = $cota1;
            }
        if($e2==$lnc['idct']) 
            {
                $y = $empr2;
                $v = $vl2;
                $c = $cota2 * $lnc['quant'];
                $c2 = $c;
                $qt2+=  $lnc['quant']; 
                $a = $cota2;
            }
        if($e3==$lnc['idct']) 
            {
                $y = $empr3;
                $v = $vl3;
                $c = $cota3 * $lnc['quant'];
                $c3 = $c;
                $qt3+=  $lnc['quant']; 
                $a = $cota3;
            }
        

$tt=$c1+$c2+$c3;
        if($tt>0) {
 
//echo '</h1>'.$inv.'</h1>';
/*
                            echo '
                            <tr style="font-size:70%;>
                            <th scope="row">'. $lnc['idl'] . '</th>';
                            echo '<td>'. $lnc['idcli'] . '</td>';
                            echo '<td>'. $lnc['idct'] . '</td>';
                            echo '<td>'. $lnc['quant'] . '</td>';
                            //echo '<td>'. $lnc['datac'] . '</td>';
                            echo '<td>'.$y.'</td>';
                            echo '<td>'.$a.'</td>';
                            echo '<td>'.$v.'%</td>';
                            echo '<td>R$ '.$c.'</td>';
                            //echo '<td>R$ '.$c/$tt.'</td>';
                            echo '</tr></div></tbody>';
*/
                        }
       

    
}
echo '<tr><tr style="font-size:80%;"><td></td><td></td><td></td><td></td><td>Total:R$</td><td>'.$total.'</td></tr>';

/*$sql4 = "SELECT * FROM minha where idcli = $id";
 $minha='';      
foreach($pdo->query($sql3) as $mn) {

        if($mn['idct']==$lis['ide']) {
            $mv=$lis['valor']*$mn['quant'];
            $me=$list['emp'];

        }

        if(!empty($me)){
       $minha.= '
                            <tr style="font-size:80%;>
                            <th scope="row">'. $mn['idm'] . '</th>
                            <td>'. $mn['idcli'] . '</td>
                            <td>'. $mn['idct'] . '</td>
                            <td>'. $me . '</td>
                            <td>'. $mn['quant'] . '</td>
                            <td>'. $mv . '</td>
                            </tr></div></tbody>';
        }
}*/


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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

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
        <div class="container">
          <!--   <div class="span10 offset1">
                 <div class="card">
    								<div class="card-header"> -->
                    <h3 class="well">Informações do Cliente</h3>
                </div>

                <div class="container">
                    <form class="form-horizontal" action="createLance.php?id" method="post">
                    <input type="hidden" name="id" id="id"
                         value="<?php echo $id; ?>">
            <!--     <div class="form-horizontal"> -->
                    <table class="table table-striped">
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
                            <td><?php echo $id; ?></td>
                            <td><?php echo $data['nome']; ?></td>
                            <td><?php echo $data['sobrenome']; ?></td>
                            <td><?php echo $data['cpf']; ?></td>
                            <td><?php echo $data['celular']; ?></td>
                            <td><?php echo $data['email']; ?></td>
                            <td></td>
                        </tr>
                        
                    </tbody>   
                    </table>
                    <p style="text-align:center;">Configuração atual:<strong>|<?php echo $ep1.':'.$v1.'% |  |'.$ep2.':'.$v2.'% |  |'.$ep3.':'.$v3.'% |'?></strong></p>
<div class="row">                   
<table class="table table-striped">
                    <thead>
                        <tr><th></th><!--
                            <th scope="col">Id</th>
                            <th scope="col">clie</th>
                        -->
                            <th scope="col">Ação</th>
                            
                            <th scope="col">Empresa</th>
                            <th scope="col">Cota</th>
                            <th scope="col">pv</th>
                            <th scope="col">Quant</th>
                            <th scope="col">Investimento</th>
                        
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td ></td>
                        <!--
                            <td><?php echo $data['id']; ?></td>
                            <td><?php echo $data['nome']; ?></td>-->
                            <td>cod:<?php echo $e1; ?></td>  <!-- índice da ação -->
                            
                            <td><?php echo $ep1; ?></td>  <!-- empresa -->
                            <td>R$<?php echo ' '.$va1; ?></td> <!-- cotação -->
                            <td><?php echo $v1; ?>%</td>
                            <td><?php echo $qt1; ?></td>
                            
                            <td>R$<?php echo ' '. $qt1*$va1 ?></td> 
                        </tr>    <!-- % previsto -->
                        <tr> <td ></td><!-- % previsto -->
                           <!--
                           <td><?php echo $data['id']; ?></td>
                            <td><?php echo $data['nome']; ?></td>-->
                            <td>cod:<?php echo $e2?></td>  <!-- índice da ação -->
                            
                            <td><?php echo $ep2; ?></td>  <!-- empresa -->
                            <td>R$<?php echo ' '.$va2; ?></td> <!-- cotação -->
                            <td><?php echo $v2 ?>%</td>
                            <td><?php echo $qt2; ?></td>
                            
                            <td>R$<?php echo ' '. $qt2*$va2 ?></td> 
                        </tr>    <!-- % previsto -->
                        <tr><td ></td><!--
                            <td><?php echo $data['id']; ?></td>
                            <td><?php echo $data['nome']; ?></td> -->
                            <td>cod:<?php echo $e3 ?></td>  <!-- índice da ação -->
                            
                            <td><?php echo $ep3; ?></td>  <!-- empresa -->
                            <td>R$<?php echo ' '.$va3; ?></td> <!-- cotação -->
                            <td><?php echo $v3 ?>%</td>
                            <td><?php echo $qt3; ?></td>
                           
                            <td>R$<?php echo ' '. $qt3*$va3 ?></td> 
                        </tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td>Investido: </td><td>R$ <?php echo ''. $total; ?></td><td></td><td></td></tr>
                         </tbody>
    </table>  
                    

                  </div>
                  </div>
                </div>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="assets/js/bootstrap.min.js"></script>

    </div>    
                    <div  style="align:center;">
                        <?php $_GET['id']=$data['id']; ?>
                        <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                        <a href="createLance.php?id=<?php echo $_GET['id']?>" class="btn btn-success">Consultar</a>
                    </div>
    </body>

</html>
