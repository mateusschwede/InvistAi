<?php
// Include config file
require 'banco.php';

// Define variables and initialize with empty values
$nome = $sobrenome = $rg = $cpf = $ender = $cidade = $uf = $cep = $celular = $email = $lg = $ps ="";
$nomeErro = $sobrenomeErro = $celularErro = $emailErro = $cpfErro = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_nome = ($_POST["nome"]);
    if(empty($input_nome)){
        $nomeErro = "Por favor escreva seu nome.";
    } elseif(!filter_var($input_nome)){
        $nomeErro = "Por favor escreva seu nome com cracteres válidos.";
    } else{
        $nome = $input_nome;
    }
    $input_snome = ($_POST["sobrenome"]);
    if(empty($input_snome)){
        $sobrenomeErro = "Por favor escreva seu sobrenome.";
    } elseif(!filter_var($input_snome)){
        $sobrenomeErro = "Por favor escreva seu sobrenome com cracteres válidos.";
    } else{
        $sobrenome = $input_snome;
    }
    // Validate address
    $input_cpf = trim($_POST["cpf"]);
    if(empty($input_cpf)){
        $cpfErro = "Seu CPF.";     
    } else{
        $cpf = $input_cpf;
    }
    
    // Validate salary
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $emailErro = "Escreva seu email.";     
    } else{
        $email = $input_email;
    }
    $input_celular = trim($_POST["celular"]);
    if(empty($input_celular)){
        $celularErro = "Escreva seu celular.";     
    } else{
        $celular = $input_celular;
    }
    // Check input errors before inserting in database
    if(empty($nomeErro) && empty($cpfErro) && empty($celularErro) && empty($sobrenomeErro) && empty($emailErro)){
        // Prepare an insert statement
        $pdo = Banco::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO pessoa (nome, sobrenome, rg, cpf, ender, cidade, uf, cep, celular, lg, ps, email) VALUES (?,?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
            $q->execute(array($nome,$sobrenome, $rg, $cpf, $ender, $cidade, $uf, $cep, $celular, $_POST['lg'], $_POST['ps'], $email));
            Banco::desconectar();
            header("Location: index.php"); 
        /*if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_nome, $param_sobrenome, $param_cpf, $param_celular, $param_email);
            
            // Set parameters
            $param_nome = $nome;
            $param_sobrenome = $sobrenome;
            $param_cpf = $cpf;
            $param_celular = $celular;
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }*/
        }
         
        // Close statement
        //mysqli_stmt_close($stmt);
    }
    
    // Close connection
    //mysqli_close($link);

/*

    if(!empty($_POST))
    {
        $nomeErro = null;
        $sobrenomeErro = null;
        $celularErro = null;
        $emailErro = null;
        $cpfErro = null;
        
        //Validação
        $validacao = true;
        if (empty($nome))
                {
                    $nomeErro = 'Por favor digite o nome!';
                    $validacao = false;
                }
        if (empty($sobrenome))
                {
                    $sobrenomeErro = 'Por favor digite o seu sobrenome!';
                    $validacao = false;
                }        
        if (empty($email))
                {
                    $emailErro = 'Por favor digite o email!';
                    $validacao = false;
        }
                else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) )
                {
                    $emailErro = 'Por favor digite um email válido!';
                    $validacao = false;
        }
        if (empty($celular))
                {
                    $celularErro = 'Por favor digite o seu celular!';
                    $validacao = false;
        }
        if (empty($cpf))
                {
                    $cpfErro = 'Por favor digite o seu CPF!';
                    $validacao = false;
        }
 
        if($validacao)
        {
         

            $pdo = Banco::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = ("INSERT INTO pessoa (nome, sobrenome, cpf, email, celular) VALUES($nome, $sobrenome, $cpf, $email, $celular)");

                    $q = $pdo->prepare($sql);
                    $q->execute();

                    Banco::desconectar();
                    header("Location: index.php");
        }           
 }


 */   
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 450px;
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
                        <h2>Adicione o seu Registro</h2>
                    </div>
                    <p>Preencha o formulário e registre-se.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($nomeErro)) ? 'has-error' : ''; ?>">
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control" value="<?php echo $nome; ?>">
                            <span class="help-block"><?php echo $nomeErro;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($sobrenomeErro)) ? 'has-error' : ''; ?>">
                            <label>Sobrenome</label>
                            <input type="text" name="sobrenome" class="form-control" value="<?php echo $sobrenome; ?>">
                            <span class="help-block"><?php echo $sobrenomeErro;?></span>
                        </div>
                        <div >
                            <label>Identidade:(RG)</label>
                            <input type="text" name="rg" class="form-control" value="<?php echo $rg; ?>">
                            
                        </div>

                        <div class="form-group <?php echo (!empty($cpfErro)) ? 'has-error' : ''; ?>">
                            <label>CPF</label>
                            <input type="text" name="cpf" class="form-control" value="<?php echo $cpf; ?>">
                            <span class="help-block"><?php echo $cpfErro;?></span>
                        </div>
                        <div >
                            <label>Endereço</label>
                            <input type="text" name="ender" class="form-control" value="<?php echo $ender; ?>">
                            
                        </div>
                        <div >
                            <label>Cidade</label>
                            <input type="text" name="cidade" class="form-control" value="<?php echo $cidade; ?>">
                            
                        </div>
                        <div >
                            <label>UF</label>
                            <input type="text" name="uf" class="form-control" value="<?php echo $uf; ?>">
                            
                        </div>
                        <div >
                            <label>CEP</label>
                            <input type="text" name="cep" class="form-control" value="<?php echo $cep; ?>">
                            
                        </div>
                        
                        <div class="form-group <?php echo (!empty($celularErro)) ? 'has-error' : ''; ?>">
                            <label>Celular</label>
                            <input type="text" name="celular" class="form-control" value="<?php echo $celular; ?>">
                            <span class="help-block"><?php echo $celularErro;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($emailErro)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $emailErro;?></span>
                        </div>
                         <div >
                            <label>Login</label>
                            <input type="text" name="lg" class="form-control" value="<?php echo $lg; ?>">
                            <br>
                        </div>
                         <div >
                            <label>Senha</label>
                            <input type="password" name="ps" class="form-control" value="<?php echo $ps; ?>">
                            
                        </div>
                        <br><br>
                        
                       


                        
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancela</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
<br><br><br><br>
</html>
<?php /*
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
                <title>Incluir dados do Cliente</title>
    </head>

    <body>
        <div class="container">

            <div class="span10 offset1">
                            <div class="card">
                                <div class="card-header">
                    <h3 class="well"> Incluir dados do Cliente </h3>
                </div>
                                <div class="card-body">
                <form class="form-horizontal" action="create.php" method="post">

                    <div class="control-group <?php echo !empty($nomeErro)?'error':'';?>">
                        <label class="control-label">Nome</label>
                        <div class="controls">
                            <input name="nome" class="form-control" size="50" type="text" placeholder="Nome" value="<?php echo !empty($nome)?$nome:'';?>">
                            <?php if (!empty($nomeErro)): ?>
                                <span class="help-inline"><?php echo $nomeErro;?></span>
                                <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($sobrenomeErro)?'error':'';?>">
                        <label class="control-label">sobrenome</label>
                        <div class="controls">
                            <input name="sobrenome" class="form-control" size="30" type="text" placeholder="sobrenome" 
                            value="<?php echo !empty($sobrenome)?$sobrenome:'';?>">
                            <?php if (!empty($sobrenomeErro)): ?>
                                <span class="help-inline"><?php echo $sobrenomeErro;?></span>
                                <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($cpfErro)?'error':'';?>">
                        <label class="control-label">cpf</label>
                        <div class="controls">
                            <input name="cpf" class="form-control" size="15" type="text" placeholder="cpf" 
                            value="<?php echo !empty($cpf)?$cpf:'';?>">
                            <?php if (!empty($cpfErro)): ?>
                                <span class="help-inline"><?php echo $cpfErro;?></span>
                                <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($email)?'error':'';?>">
                        <label class="control-label">Email</label>
                        <div class="controls">
                            <input name="email" class="form-control" size="40" type="text" placeholder="Email"
                             value="<?php echo !empty($email)?$email:'';?>">
                            <?php if (!empty($emailErro)): ?>
                                <span class="help-inline"><?php echo $emailErro;?></span>
                                <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($celularErro)?'error':'';?>">
                        <label class="control-label">celular</label>
                        <div class="controls">
                            <input name="celular" class="form-control" size="11" type="text" placeholder="celular" 
                            value="<?php echo !empty($celular)?$celular:'';?>">
                            <?php if (!empty($celularErro)): ?>
                                <span class="help-inline"><?php echo $celularErro;?></span>
                                <?php endif; ?>
                        </div>
                    </div>

                    <br/>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-warning">Cadastrar</button>
                        <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                    </div>
                </form>
                            </div>
                        </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="assets/js/bootstrap.min.js"></script>
    </body>

</html>*/ ?> 
