<?php
	require 'banco.php';
    $nome = $sobrenome = $rg = $cpf = $ender = $cidade = $uf = $cep = $celular = $email = $lg = $ps ="";
	$id = null;
	if ( !empty($_GET['id']))
            {
		$id = $_REQUEST['id'];
            }
	if ( null==$id )
            {
		header("Location: index.php");
            }
	if ( !empty($_POST))
            {
		$nomeErro = null;
		$sobrenomeErro = null;
		$celularErro = null;
                $emailErro = null;
                $cpfErro = null;
		$nome = $_POST['nome'];
		$sobrenome = $_POST['sobrenome'];
		$cpf = $_POST['cpf'];
                $email = $_POST['email'];
                $celular = $_POST['celular'];
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
                    $celular = 'Por favor digite o seu celular!';
                    $validacao = false;
		}
        if (empty($cpf))
                {
                    $cpf = 'Por favor digite o seu CPF!';
                    $validacao = false;
		}
                
		// update data
		if ($validacao)
                {
                    $pdo = Banco::conectar();
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "UPDATE pessoa  set nome = ?, sobrenome = ?, rg = ?, cpf = ?, ender = ?, cidade = ?, 
                    uf = ?, cep = ?, email = ?, celular = ?, lg = ?, ps = ? WHERE id = ?";
                    $q = $pdo->prepare($sql);
                    $q->execute(array($nome,$sobrenome, $rg, $cpf, $ender, $cidade, $uf, $cep, $email,$celular, $_POST['lg'], $_POST['ps'], $id));
                    Banco::desconectar();
                    header("Location: index.php");
		}
	}
        else
            {
                $pdo = Banco::conectar();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM pessoa where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$nome = $data['nome'];
        $sobrenome = $data['sobrenome'];
        $cpf = $data['cpf'];
		$email = $data['email'];
		$celular = $data['celular'];
		Banco::desconectar();
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
        <div class="wrapper" align="center;">

            <div class="span10 offset1">
							<div class="card">
								<div class="card-header">
                    <h3 class="well"> Atualizar dados do Cliente </h3>
                </div>
								<div class="card-body">
                <form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">

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
                    <div >
                            <label class="control-label">Identidade:(RG)</label>
                            <input type="text" name="rg" class="form-control" value="<?php echo $rg; ?>">
                            
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
                    <div >
                            <label class="control-label">Endereço</label>
                            <input type="text" name="ender" class="form-control" value="<?php echo $ender; ?>">
                            
                        </div>
                        <div >
                            <label class="control-label">Cidade</label>
                            <input type="text" name="cidade" class="form-control" value="<?php echo $cidade; ?>">
                            
                        </div>
                        <div >
                            <label class="control-label">UF</label>
                            <input type="text" name="uf" class="form-control" value="<?php echo $uf; ?>">
                            
                        </div>
                        <div >
                            <label class="control-label">CEP</label>
                            <input type="text" name="cep" class="form-control" value="<?php echo $cep; ?>">
                            
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
                     <div >
                            <label class="control-label">Login</label>
                            <input type="text" name="lg" class="form-control" value="<?php echo $lg; ?>">
                            
                        </div>
                         <div  >
                            <label class="control-label">Senha</label>
                            <input type="password" name="ps" class="form-control" value="<?php echo $ps; ?>">
                            
                        </div>
                        <br>

                    <br/>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-warning">Atualizar</button>
                        <a href="teste.php" type="btn" class="btn btn-info">Voltar</a>
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
<br><br><br><br>
</html>
