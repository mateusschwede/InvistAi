<?php
    require 'banco.php';
    $id = $_GET['id'];
    session_start();
    $_SESSION['id']=$id;
    $validacao = true;
    if(!empty($_POST))
    {
	if ( !empty($_GET['id']))   // id do cliente
            {
        $id = $_REQUEST['id'];

            }
	if ( null==$id )
            {
		header("Location: index.php");
            }




            $pdo = Banco::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM carteira WHERE idcli = '$id'";
            foreach($pdo->query($sql)as $row)
                        { }
            if(!empty($row)) {
                $emp1=$row['idac1'];
                $emp1=$row['idac2'];
                $emp1=$row['idac3'];
                $valor1=$row['valor1'];
                $valor2=$row['valor2'];
                $valor3=$row['valor3'];
            }           
            
            Banco::desconectar();
            header("Location: index.php");

              
              
            /*  
                                 
              <input style="color:yellow;background-color:black" type="submit" value="Comprar">
                              </form>
                      </div>';
          $form=  '<div style="text-align:center;" id="divCadMulta" >
          <br><br>
          <h1 style="text-align:center" id="tituloCadMulta">Compra de Ações</h1>
        <form style="text-align:center" id="formCadLance" method="post"  action="lance.php?id_cot">
        <table width="500px" border="0" cellspacing="0">    
        <br>Investimento:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            Companhia:<br>
<input type="text" name="quanto" placeholder="Quanto R$" size="11">
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

<select id="cota" name="cota" value="'.$acao['id_cot'].'">

        <body>
            */
     
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
    <div class="container">
        <div clas="span10 offset1">
          <div class="card">
            <div class="card-header">
                <h3 class="well"> Moldar a carteira do Cliente </h3>
            </div>
            <div class="card-body">
            <form class="form-horizontal" action="moldar.php?id=" method="post">

                <div >
                    <label class="control-label">Empresa 1</label>
                    <div class="controls">
                   <!--      <input size="5" class="form-control" name="idac1" type="text" placeholder="acão 1" required=""
                         > -->
                         <select id="idac1" name="idac1" value="'.$acao['id_cot'].'">
                        <?php 
                            $rows='';
                            $pdo = Banco::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $consulta = $pdo->prepare("SELECT * FROM empresa");
            $consulta->execute();
            $result = $consulta->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $acao) { 
            $rows .= ' 
            
            
              <option value="'.$acao['ide'].'" name="acao">'. $acao['emp'].': R$ '.$acao['valor'].' </option> '       
              ;}
              
              $rows.='<label for="acao" name="acao">'.$acao['ide'].'</label>
              </select><br><br>';
                                    

                Banco::desconectar();
                 
                echo $rows;
                echo '';
                        ?>
                            
                            
                            <input size="2" class="form-control" name="valor1" type="text" placeholder="percentual" required=""
                             >
                        
                    </div>
                </div>

                <div >
                    <label class="control-label">Empresa 2</label>
                    <div class="controls">



                   <!--     <input size="5" class="form-control" name="idac2" type="text" placeholder="acão 2" required=""
                         value="<?php echo !empty($idac2)?$idac2: '';?>"> -->
                        <select id="idac2" name="idac2" value="'.$acao['id_cot'].'">
                            <?php echo $rows; ?>
                            
                            
                            <input size="2" class="form-control" name="valor2" type="text" placeholder="percentual" required=""
                             value="<?php echo !empty($valor2)?$valor2: '';?>">
                        
                    </div>
                </div>

                <div >
                    <label class="control-label">Empresa 3</label>
                    <div class="controls">
                    <!--     <input size="5" class="form-control" name="idac3" type="text" placeholder="acão 3" required=""
                         value="<?php echo !empty($idac3)?$idac3: '';?>"> -->
                        <select id="idac3" name="idac3" value="'.$acao['id_cot'].'">
                            <?php echo $rows; ?>
                            
                            
                            <input size="2" class="form-control" name="valor3" type="text" placeholder="percentual" required=""
                             value="<?php echo !empty($valor3)?$valor3: '';?>">
                        
                    </div>
                </div>


                <div class="form-actions">
                    <br/>

                    <button type="submit" class="btn btn-success">Adicionar</button>
                    <a href="index.php" type="btn" class="btn btn-default">Voltar</a>

                </div>
            </form>
          </div>
        </div>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>


