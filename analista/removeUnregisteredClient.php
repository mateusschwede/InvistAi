<?php
    require_once '../conexao.php';
    session_start();

    if(!isset($_SESSION['analistaLogado'])):
        header('Location: ../acessoNegado.php');
    endif;
    
    $r = $db->prepare("DELETE FROM pessoa WHERE cpf=?");
    $r->execute(array($_GET['cpf']));        
    $msgSucesso = true;
    header("Location: clientes.php");   
?>