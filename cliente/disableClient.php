<?php
    require_once '../conexao.php';
    session_start();

    if(!isset($_SESSION['analistaLogado'])):
        header('Location: ../acessoNegado.php');
    endif;
    
    $r = $db->prepare("UPDATE pessoa SET inativado = 1 WHERE tipo = 2 and cpf=?");
    $r->execute(array($_GET['cpf']));            
    $msgSucesso = true;
    header("Location: ../logout.php");   
?>