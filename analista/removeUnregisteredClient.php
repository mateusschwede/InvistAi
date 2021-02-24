<?php
    require_once '../conexao.php';
    $r = $db->prepare("DELETE FROM pessoa WHERE cpf=?");
    $r->execute(array($_GET['cpf']));        
    $msgSucesso = true;
    header("Location: clientes.php");   
?>