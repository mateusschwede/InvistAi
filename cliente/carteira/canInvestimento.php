<?php
    require_once '../../conexao.php';
    session_start();
    if(!isset($_SESSION['logado'])){header('Location: ../../acessoNegado.php');}

    //Remover investimento da table 'investimento' e 'investimento_acao' vinculados

    unset($_SESSION['idCarteira']);
    unset($_SESSION['idInvestimento']);
    unset($_SESSION['valorInvestimento']);
    header("location: ../index.php");
?>