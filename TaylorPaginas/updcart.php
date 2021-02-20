<?php
	require 'banco.php';
    $t1=$t2=$t3=$t4=$t5=$tipo = $perc ="";
    $p1=$p2=$p3=$p4=$p5=0;
	$id = null;
	if ( !empty($_GET['id']))
            {
		$id = $_REQUEST['id'];
            }
	if ( null==$id )
            {
		header("Location: teste.php");
            }
	if ( !empty($_POST))
            {
		$tipoErro = null;
		$percErro = null;

		//Validação
		$validacao = true;
         
              
		// update data
		if ($validacao)
                {
                    $pdo = Banco::conectar();
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $pc=$r=0;
                            $sql3= "SELECT * FROM carteira WHERE idcli=$id ";
                            foreach($pdo->query($sql3) as $ct)
                              {
                                $tipo=$ct['tipo']; $perc=$ct['perc'];
                                if($tipo=="Aposentadoria") {$t1=$tipo;$p1=$ct['perc'];$idc=$perc;}
                                if($tipo=="Estudos")       {$t2=$tipo;$p2=$ct['perc'];$idc=$perc;}
                                if($tipo=="Imóvel")        {$t3=$tipo;$p3=$ct['perc'];$idc=$perc;}
                                if($tipo=="Veículo")       {$t4=$tipo;$p4=$ct['perc'];$idc=$perc;}
                                if($tipo=="Viagem")        {$t5=$tipo;$p5=$ct['perc'];$idc=$perc;}

                              //echo $r.'-'.$ct['tipo'].'-'.$ct['idcli'].'-'.$ct['idc'];
                              $b[$r]=$ct['tipo'];$r++;
                              $b[$r]=$ct['idc'];$r++;
                              $b[$r]=$ct['perc'];$r++;
                              $pc=$_POST['pc'];
                              echo $r.'-'.$ct['tipo'].'-'.$ct['idcli'].'-'.$ct['idc'].'->na matriz:'.$b[1].'-'.$b[0].'<br>';
                              //echo '<h1>perc:'.$pc.'% >> idc:'.$idc.'tipo><'.$b[0].'</h1>';
                              //echo '<h1>perc:'.$pc.'% >> idc:'.$idc.'tipo><'.$b[1].'</h1>';
                                
                              }
            if(($_POST['pc1']==null)) {$pc1=$ct['v1'];} 
            if(($_POST['pc2']==null)) {$pc2=$ct['v2'];} 
            if(($_POST['pc3']==null)) {$pc3=$ct['v3'];} 
            if(($_POST['pc4']==null)) {$pc4=$ct['v4'];} 
            if(($_POST['pc5']==null)) {$pc5=$ct['v5'];}
            if(!empty($_POST['pc1'])) {$pc1=$_POST['pc1'];}
            if(!empty($_POST['pc2'])) {$pc2=$_POST['pc2'];} 
            if(!empty($_POST['pc3'])) {$pc3=$_POST['pc3'];} 
            if(!empty($_POST['pc4'])) {$pc4=$_POST['pc4'];} 
            if(!empty($_POST['pc5'])) {$pc5=$_POST['pc5'];} 
        
           echo $r.'-'.$ct['tipo'].'-'.$ct['idcli'].'-'.$ct['idc'].'::Alteração::'.$pc.'-'.'->na matriz:'.$b[2].'-'.$b[1].'->>>>>:'.$b[3].'-'.$b[4].'<br>';
                    if($pc1==null){$pc1=0;} 
                    if($pc2==null){$pc2=0;}
                    if($pc3==null){$pc3=0;}
                    if($pc4==null){$pc4=0;}
                    if($pc5==null){$pc5=0;}
                    $sql = "UPDATE carteira  set perc = ?, v1 = ?, v2 = ?, v3 = ?, v4 = ?, v5 = ? WHERE idc= $b[1]";
                    $q = $pdo->prepare($sql);
                    $q->execute(array($pc, $pc1, $pc2, $pc3, $pc4, $pc5 ));

                    Banco::desconectar();
                   
                    //header("Location: teste.php");
		}
	}
        else
            {
                
		
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
            width: 450px;
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
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Modifique a sua Carteira</h2>
                    </div>
                    <p></p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]).'?id='.$id ?>" method="post">
                        <div class="form-group <?php echo (!empty($tipoErro)) ? 'has-error' : ''; ?>">                                              
                         <?php 

                        $pdo = Banco::conectar();
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $x=0;
                            $sql7= "SELECT * FROM carteira WHERE idcli=$id";
                            foreach($pdo->query($sql7) as $ct) {
                                $m[$x]=$ct['tipo'];
                                $m[$x+1]=$ct['perc'];
                                $m[$x+2]=$ct['a1'];
                                $m[$x+3]=$ct['v1'];
                                $m[$x+4]=$ct['a2'];
                                $m[$x+5]=$ct['v2'];
                                $m[$x+6]=$ct['a3'];
                                $m[$x+7]=$ct['v3'];
                                $m[$x+8]=$ct['a4'];
                                $m[$x+9]=$ct['v4'];
                                $m[$x+10]=$ct['a5'];
                                $m[$x+11]=$ct['v5'];
                                $x=$x+11;
                            }
                            $e[]='';
                                        $consulta = $pdo->prepare("SELECT * FROM empresa");
                                        $consulta->execute();
                                        $result = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($result as $acao) {
                                            if($m[2]==$acao['ide']) {$e[0]=$acao['emp'];}
                                            if($m[4]==$acao['ide']) {$e[1]=$acao['emp'];}
                                            if($m[6]==$acao['ide']) {$e[2]=$acao['emp'];}
                                            if($m[8]==$acao['ide']) {$e[3]=$acao['emp'];}
                                            if($m[10]==$acao['ide']) {$e[4]=$acao['emp'];}
                                        }

                                        $sql3= "SELECT * FROM carteira WHERE idcli=$id ";
                            foreach($pdo->query($sql3) as $ct)
                              {
                                $tipo=$ct['tipo']; $perc=$ct['perc'];
                                if($tipo=="Aposentadoria") {$t1=$tipo;$p1=$ct['perc'];}
                                if($tipo=="Estudos")       {$t2=$tipo;$p2=$ct['perc'];}
                                if($tipo=="Imóvel")        {$t3=$tipo;$p3=$ct['perc'];}
                                if($tipo=="Veículo")       {$t4=$tipo;$p4=$ct['perc'];}
                                if($tipo=="Viagem")        {$t5=$tipo;$p5=$ct['perc'];}
                              }          
                                                  Banco::desconectar();  
                         echo '<h2>'.$m[0].' - '.$m[1].'%'.'  
                         Percentual :<input type="number" id="pc"  name="pc" value="10" step="10" min="10" max="100" size="3" >% </h2>
                    <br>';
                         echo '<table><thead style border=".5px">
                         <tr>';
                         $w='<th>Tipo   -   %</th>';
                         if(!empty($t2)){$w.="<th>Tipo   -   %</th>";} 
                         if(!empty($t3)){$w.="<th>Tipo   -   %</th>";} 
                         if(!empty($t4)){$w.="<th>Tipo   -   %</th>";} 
                         if(!empty($t5)){$w.="<th>Tipo   -   %</th>";}
                        echo $w.'</tr>
                         </thead>
                         <tbody><tr>';
                         $w1='<td>'.$t1.'-'.$p1.'% -</td>';
                         if(!empty($t2)){$w1.='<td>'.$t2.'-'.$p2.'% - </td>';} 
                         if(!empty($t3)){$w1.='<td>'.$t3.'-'.$p3.'% - </td>';} 
                         if(!empty($t4)){$w1.='<td>'.$t4.'-'.$p4.'% - </td>';} 
                         if(!empty($t5)){$w1.='<td>'.$t5.'-'.$p5.'% - </td>';}
                         echo $w1.' Total do investimento : '.($p1+$p2+$p3+$p4+$p5).'%</tr></tbody>



                         </table>';
                        echo   '<table class="table table-striped">
                         <thead style="text-align: right;">                            
                             <tr>
                                 <th>##</th><th>Ação</th><th>% atual</th><th>novo %</th></tr></thead>
                                 <tbody>

                        <tr><td>'.$m[2].'</td><td>'.$e[0].'</td><td>'.$m[3].'%</td><td>  
                        <input type="number" id="pc1"  name="pc1" step="10" min="10" max="100" size="3" >% </td></tr>';
                        if($m[5]>0) { echo '
                         <tr><td>'.$m[4].'</td><td>'.$e[1].'</td><td>'.$m[5].'%</td><td> 
                        <input type="number" id="pc2"  name="pc2" step="10" min="10" max="100" size="3" >% </td></tr>';}
                        if($m[7]>0) { echo '
                         <tr><td>'.$m[6].'</td><td>'.$e[2].'</td><td>'.$m[7].'%</td><td>'.'  
                        <input type="number" id="pc3"  name="pc3" step="10" min="10" max="100" size="3" >% </td></tr>';}
                        if($m[9]>0) { echo '
                         <tr><td>'.$m[8].'</td><td>'.$e[3].'</td><td>'.$m[9].'%</td><td>'.'  
                        <input type="number" id="pc4"  name="pc4" step="10" min="10" max="100" size="3" >% </td></tr>';}
                        if($m[11]>0) { echo '
                         <tr><td>'.$m[10].'</td><td>'.$e[4].'</td><td>'.$m[11].'%</td><td>'.'  
                        <input type="number" id="pc5"  name="pc5" step="10" min="10" max="100" size="3" >% </td></tr>';}
                        echo '<br><br></tbody></table>';
                        if(!empty($_POST['pc1'])) {$pc1=$_POST['pc1'];}


                        echo '<input type="submit" class="btn btn-primary" value="Cadastrar">
                        <a href="teste.php" class="btn btn-default">Cancela</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"> 

  
</html>';
?>
