<?php
    require_once '../../conexao.php';
    session_start();
    if(!isset($_SESSION['clienteLogado'])){header('Location: ../../acessoNegado.php');}

    $r = $db->prepare("DELETE FROM carteira_acao WHERE idCarteira=?");
    $r->execute(array($_SESSION['idCarteira']));
    $r = $db->prepare("DELETE FROM carteira WHERE id=?");
    $r->execute(array($_SESSION['idCarteira']));

    unset($_SESSION['idCarteira']);
    header("location: ../index.php");
?>