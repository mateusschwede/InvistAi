<?php
  require_once '../conexao.php';
  
  if (isset($_GET['cpf']) && empty($_GET['cpf']) == false) {

    $r = $db->prepare("DELETE FROM pessoa WHERE cpf=?");
    $r->execute(array($_GET['cpf']));


		header("Location: ../index.php"); 
    
	} else {
		header("Location: perfil.php");
	}
?>