<?php
    require_once '../../conexao.php';
    session_start();
    if(!isset($_SESSION['clienteLogado'])){header('Location: ../../acessoNegado.php');}

    unset($_SESSION['idCarteira']);
    unset($_SESSION['investimentoReal']);
    unset($_SESSION['valorInvestimento']);
    header("location: ../index.php");
?>