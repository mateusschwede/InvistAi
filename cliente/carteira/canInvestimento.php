<?php
    require_once '../../conexao.php';
    session_start();
    if(!isset($_SESSION['logado'])){header('Location: ../../acessoNegado.php');}

    unset($_SESSION['idCarteira']);
    unset($_SESSION['valorInvestimento']);
    header("location: ../index.php");
?>