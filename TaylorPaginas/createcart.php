<?php
session_start();
//Include 'banco.php';
$id=$_SESSION['id'];
//$id=$_GET['id'];
$data = date('Y/m/d'); 
require 'banco.php';
$pdo = Banco::conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Define variables and initialize with empty values
$tipo = $perc = "";
$tipoErro = $percErro = "";

        $sql7= "SELECT * FROM carteira WHERE idcli=$id";
        foreach($pdo->query($sql7) as $ct)
          
          {
            $t=$ct['tipo']; $perc=$ct['perc'];
            if($t=="Aposentadoria") {$t1=$t;$p1=$perc;}
            if($t=="Estudos")       {$t2=$t;$p2=$perc;}
            if($t=="Imóvel")        {$t3=$t;$p3=$perc;}
            if($t=="Veículo")       {$t4=$t;$p4=$perc;}
            if($t=="Viagem")        {$t5=$t;$p5=$perc;}
          }

       $sql1= "SELECT * FROM carteira WHERE idcli=$id";
       $q4 = $pdo->prepare($sql1);
      $q4->execute(array($id));
      $data4 = $q4->fetch(PDO::FETCH_ASSOC);

      if(!empty($data4)){
      $tp=$data4['tipo'];  
      $e1=$data4['a1'];  //dados da configuração
      $e2=$data4['a2'];
      $e3=$data4['a3'];
      $e4=$data4['a4'];
      $e5=$data4['a5'];
      $vv1=$data4['v1'];
      $vv2=$data4['v2']; 
      $vv3=$data4['v3'];
      $vv4=$data4['v4'];
      $vv5=$data4['v5'];}
      else {$perc=0;} 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
      $perc = $a1=$a2=$a3=$a4=$a5=$v1=$v2=$v3=$v4=$v5=0;
      $msg='';
    $perc = ($_POST["perc"]);
    $a1=$_POST['a1'];
    $a2=$_POST['a2'];
    $a3=$_POST['a3'];
    $a4=$_POST['a4'];
    $a5=$_POST['a5'];
    $v1=$_POST['v1'];
    $v2=$_POST['v2'];
    $v3=$_POST['v3'];
    $v4=$_POST['v4'];
    $v5=$_POST['v5'];
    $input_tipo = ($_POST["tipo"]);
    if(($input_tipo==$t1 || $input_tipo==$t2 || $input_tipo==$t3 || $input_tipo==$t4 || $input_tipo==$t5))
      {$tipoErro = "Carteira já definida.";
    echo $tipoErro.'<br>';} 
    if(empty($input_tipo)){
        $tipoErro = "Por favor escolha seu objetivo.";
    echo $tipoErro.'<br>';
    }  else{
        $tipo = $input_tipo;
    }
    $y=(100-$_POST['perc']);
    if($p2=0){


                    $sql5 = "UPDATE carteira set perc = $y WHERE id = $id and tipo= $t1 ";
                    $q = $pdo->prepare($sql5);
                    $q->execute();
                    
       
    }


     
   
    
    // Check input errors before inserting in database
   
    if(empty($tipoErro) && empty($percErro)) {
       // Prepare an insert statement
   

    $sql = "INSERT INTO carteira (idcli, tipo, perc, a1, v1, a2, v2, a3, v3, a4, v4, a5, v5, datac) VALUES (?,?,?,?,?,?,?,?,?,?, ?, ?, ?, ?)";
    $q = $pdo->prepare($sql);
    $q->execute(array($id, $tipo,$perc, $a1, $v1,  $a2, $v2, $a3, $v3, $a4, $v4, $a5, $v5, $data));
           Banco::desconectar();
           header("Location: teste.php"); 
   }   
}

  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Criar Carteira</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Adicione a Carteira</h2>
                    </div>
                    <p>Escolha o seu "Objetivo de Longo Prazo"</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($tipoErro)) ? 'has-error' : ''; ?>">                                              
                            
                        <label for="tipo">Meta da Carteira :</label>
                        <select id="tipo" name="tipo">
                            <option value="Aposentadoria">Aposentadoria</option>
                            <option value="Estudos">Estudos</option>
                            <option value="Imóvel">Imóvel</option>
                            <option value="Veículo">Veículo</option>
                            <option value="Viagem">Viagem</option>
                        </select> 
                        </div>

                        
                        <div class="form-group <?php echo (!empty($percErro)) ? 'has-error' : ''; ?>">
                            
                            
                              <label>Percentual da Carteira</label>
                            <input type="number" id="perc"  name="perc" value="100" step="10" min="10" max="100" size="4">% 
                             
                                                   
                            
                        </div>
                       
                       
                        <label class="control-label">Ação 1 -</label>
                        
    
                        <select id="a1" name="a1" value="'.$acao['ide'].'">
<?php
$rows='';

$pdo = Banco::conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $consulta = $pdo->prepare("SELECT * FROM empresa");
            $consulta->execute();
            $result = $consulta->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $acao) { 
            $rows .= '            
              <option value="'.$acao['ide'].'" name="a1">'.$acao['codigo'].'-'. $acao['emp'].': R$ '.$acao['valor'].' </option> '       
              ;}
              
              $row.='<label for="acao" name="a1">'.$acao['ide'].' -'.'</label>
              </select><br><br>';
                 
                echo $rows;
                echo '';
                echo '';
                ?>
                    
                    <input type="number" id="v1"  name="v1" value="10" step="10" min="10" max="100" size="4" >% 
                    <br>
               
         </div>   
        </div>
        <br>
                    <label class="control-label">Ação 2 -</label>
                    
                    

                        <select id="a2" name="a2" value="<?php echo $acao['ide'] ?>" >
                            <?php echo $rows; ?>
                            
                            <input type="number" id="v2"  name="v2" value="0" step="10" min="0" max="100" size="4">% 
                    <br>    
                            
                        
                    
        <br>
         
                    <label class="control-label">Ação 3 -</label>
                    


                        <select id="a3" name="a3" value="'.$acao['ide'].'">
                            <?php echo $rows; ?>
                            
                            
                            <input type="number" id="v3"  name="v3" value="0" step="10" min="0" max="100" size="4">% 
                    <br>
                        
                    
          
         <br>
                    <label class="control-label">Ação 4 -</label>
                    


                        <select id="a4" name="a4" value="'.$acao['ide'].'">
                            <?php echo $rows; ?> 
                            
                            
                            <input type="number" id="v4"  name="v4" value="0" step="10" min="0" max="100" size="4">% 
                    <br>
                        
                    
        <br>
                    <label class="control-label">Ação 5 -</label>
                    


                        <select id="a5" name="a5" value="'.$acao['ide'].'">
                            <?php echo $rows; ?>
                            
                            
                            <input type="number" id="v5"  name="v5" value="0" step="10" min="0" max="100" size="4">% 
                    <br><br>
                        
                    
              
                
                        
                        <input type="submit" class="btn btn-primary" value="Cadastrar">
                        <a href="teste.php" class="btn btn-default">Cancela</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js">> 

  
</html>

