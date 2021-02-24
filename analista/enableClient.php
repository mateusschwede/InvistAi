<?php
    require_once '../conexao.php';
    $r = $db->prepare("UPDATE pessoa SET inativado = 0 WHERE tipo = 2 and cpf=?");
    $r->execute(array($_GET['cpf']));            
    $msgSucesso = true;
    header("Location: clientes.php");         
?>