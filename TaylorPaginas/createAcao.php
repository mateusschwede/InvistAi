<?php
    require 'banco.php';

    if(!empty($_POST))
    {
        //Acompanha os erros de validação
        $empErro = null;

        $valorErro = null;

        $datac = date('Y/m/d');
        


        
        $emp = $_POST['emp'];
     
        $valor = $_POST['valor'];

        
        //Validaçao dos campos:
        $validacao = true;
        if(empty($emp))
        {
            $empErro = 'Por favor digite a Ação!';
            $validacao = false;
        }
        if(empty($valor))
        {
            $valorErro = 'Por favor digite o valor da Ação!';
            $validacao = false;
       }
                //Inserindo no Banco:
        if($validacao)
        {
            $pdo = Banco::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO empresa (emp, valor, datac) VALUES(?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($emp,$valor,$datac));
            Banco::desconectar();
            header("Location: index.php");
        }
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
                <h3 class="well"> Adicionar Ação </h3>
            </div>
            <div class="card-body">
            <form class="form-horizontal" action="createAcao.php" method="post">

                <div class="control-group <?php echo !empty($empErro)?'error ' : '';?>">
                    <label class="control-label">Nome da Empresa</label>
                    <div class="controls">
                        <input size="20" class="form-control" name="emp" type="text" placeholder="Empresa" required=""
                         value="<?php echo !empty($emp)?$emp: '';?>">
                        <?php if(!empty($empErro)): ?>
                            <span class="help-inline"><?php echo $empErro;?></span>
                            <?php endif;?>
                            <input size="5" class="form-control" name="valor" type="text" placeholder="valor" required=""
                             value="<?php echo !empty($valor)?$valor: '';?>">
                        <?php if(!empty($valorErro)): ?>
                            <span class="help-inline"><?php echo $valorErro;?></span>
                            <?php endif;?>
                    </div>
                </div>

                

                <div class="form-actions">
                    <br/>

                    <button type="submit" class="btn btn-success">Adicionar</button>
                    <a href="index.php" type="btn" class="btn btn-default">Voltar</a>

                </div>
            </form>
            <?php 
            $pdo = Banco::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql1 = 'SELECT * FROM empresa ORDER BY emp ASC';
            echo '<table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">empresa</th>
                            <th scope="col">Cotação</th>
                            <th scope="col">Data</th>

                        </tr>
                    </thead>
                    <tbody>';
                        foreach($pdo->query($sql1)as $row){
                            echo '<tr>';
                                  echo '<th scope="row">'. $row['ide'] . '</th>';
                            echo '<td>'. $row['emp'] . '</td>';
                            echo '<td>'. $row['valor'] . '</td>';
                            echo '<td>'. $row['datac'] . '</td>';
                             echo '</td>';
                            echo '</tr>';
                        }
                        Banco::desconectar();?>
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
</body>

</html>


