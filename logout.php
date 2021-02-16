<?php
    session_start();
    unset($_SESSION['cpf']);
    unset($_SESSION['tipo']);
    unset($_SESSION['nome']);
    session_destroy();
    header("location: index.php");
?>