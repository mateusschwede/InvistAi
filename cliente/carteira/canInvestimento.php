<?php
    require_once '../../conexao.php';
    session_start();
    if(!isset($_SESSION['logado'])){header('Location: ../../acessoNegado.php');}

    //Remover investimento da table 'investimento' e 'investimento_acao' vinculados
    $r = $db->prepare("DELETE FROM investimento_acao WHERE idInvestimento=?");
    $r->execute(array($_SESSION['idInvestimento']));
    $r = $db->prepare("DELETE FROM investimento WHERE id=?");
    $r->execute(array($_SESSION['idInvestimento']));

    unset($_SESSION['idCarteira']);
    unset($_SESSION['idInvestimento']);
    unset($_SESSION['valorInvestimento']);
    header("location: ../index.php");
?>