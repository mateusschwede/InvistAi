<?php
    require_once '../conexao.php';
    session_start();

    if(!isset($_SESSION['clienteLogado'])):
        header('Location: ../acessoNegado.php');
    endif;    

    if (isset($_GET['cpf']) && empty($_GET['cpf']) == false) {
        $r = $db->prepare("UPDATE pessoa SET inativado = 1 WHERE tipo = 2 and cpf=?");
        $r->execute(array($_GET['cpf']));            
        $msgSucesso = true;
        header("Location: ../index.php"); 
    } else {
        header("Location: perfil.php");
    }
?>