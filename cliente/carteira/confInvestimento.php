<?php
    require_once '../../conexao.php';
    session_start();
    if(!isset($_SESSION['logado'])){header('Location: ../../acessoNegado.php');}

    //Inserir dados na table 'investimento' e atualizar 'carteira_acao' nos dados vinculados

    unset($_SESSION['idCarteira']);
    unset($_SESSION['idInvestimento']);
    unset($_SESSION['valorInvestimento']);
    header("location: ../index.php");
?>