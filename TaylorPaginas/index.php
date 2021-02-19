<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <!--<link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>PÃ¡gina Inicial</title>

    <meta charset="UTF-8">-->
    <title>Carteira de Investimentos</title>
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
          <div class="jumbotron">
            <div class="row">
                <h2><span class="badge badge-secondary">versão protótipo III</span></h2>
            </div>
          </div>
            </br>
            <div class="row">
                <form style="text-align: center;" name="login" action="index.php" onsubmit="return validateForm()" method="post">
<?php include_once "controller.php";
 $form = '<br><br>                                
                                <input type="text" placeholder="Login" name="seunr"><br><br>
                                
                                <input type="password" placeholder="senha" name="senha"><br><br>
                                <input class="botaoLogin" type="submit" value="Entrar"><br><br>
                                <a href="create.php" type="btn" class="btn btn-default">Cadastrar-se</a>
                            </form>

                    </tbody>
                </table>
            </div>
        </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="assets/js/bootstrap.min.js"></script>
';
            $controlador = new Controller(); 
            if(empty($_POST['seunr']) || empty($_POST['senha'])){
               
echo $form;

}
else {

                $existe = $controlador->validarUsuario($_POST['seunr'],$_POST['senha']);
               
                if($existe){
session_start();
 $id=$_SESSION['id'];
                                       

                   
                    header('Location:teste.php?id='.$id);
                }else{
     echo $form; }
 } ?>
</body>

</html>