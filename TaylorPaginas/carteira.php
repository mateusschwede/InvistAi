<?php
    require 'banco.php';
    $id = null;
    if(!empty($_GET['id']))
    {
        $id = $_REQUEST['id'];
    }
    if(null==$id)
    {
        header("Location: index.php");
    }

       $pdo = Banco::conectar();

       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $sql = "SELECT * FROM pessoa where id = ?";
       $q = $pdo->prepare($sql);
       $q->execute(array($id));
       $data = $q->fetch(PDO::FETCH_ASSOC);
       echo '<table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Sobrenome</th>
                            <th scope="col">CPF</th>
                            <th scope="col">Email</th>
                            <th scope="col">Celular</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody>';
         
			                echo '<th scope="row">'. $data['id'] . '</th>';
                            echo '<td>'. $data['nome'] . '</td>';
                            echo '<td>'. $data['sobrenome'] . '</td>';
                            echo '<td>'. $data['cpf'] . '</td>';
                            echo '<td>'. $data['email'] . '</td>';
                            echo '<td>'. $data['celular'] . '</td>';
                            echo '<td width=280></td>
               <br><br><br>';

       $sql1 = "SELECT * FROM carteira where idcli = $id";
       $q1 = $pdo->prepare($sql1);
       //$q1->execute(array($id));

                        foreach($pdo->query($sql1)as $row)
                        {
                            echo '<tr>';
			                echo '<th scope="row">'. $row['idcli'] . '</th>';
                            echo '<td>'. $row['idac1'] . '</td>';
                            echo '<td>'. $row['valor1'] . '</td>';
                            echo '<td>'. $row['idac2'] . '</td>';
                            echo '<td>'. $row['valor2'] . '</td>';
                            echo '<td>'. $row['idac3'] . '</td>';
                            echo '<td>'. $row['valor3'] . '</td>';
                            echo '<td>'. $row['data'] . '</td>';
                            echo '<td width=280></td></tr><br><br><br>';
                            
                        }
                        Banco::desconectar();
                        
                       ' </tbody>
                </table>'

    
?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <title>Informações do Contato</title>
    </head>

    <body>
        <div class="container">
            <div class="span10 offset1">
                  <div class="card">
    								<div class="card-header">
                    <h3 class="well">Informações do Contato</h3>
                </div>
                <div class="container">
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Nome</label>
                        <div class="controls">
                            <label class="carousel-inner">
                                <?php echo $data['nome'];?>
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Sobrenome</label>
                        <div class="controls">
                            <label class="carousel-inner">
                                <?php echo $data['sobrenome'];?>
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">CPF</label>
                        <div class="controls">
                            <label class="carousel-inner">
                                <?php echo $data['cpf'];?>
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Celular</label>
                        <div class="controls">
                            <label class="carousel-inner">
                                <?php echo $data['celular'];?>
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Email</label>
                        <div class="controls">
                            <label class="carousel-inner">
                                <?php echo $data['email'];?>
                            </label>
                        </div>
                    </div>

                    
                    <br/>
                    <div class="form-actions">
                        <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                    </div>
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
