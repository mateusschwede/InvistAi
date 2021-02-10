<?php
    session_start();
    unset($_SESSION['cpf']);
    session_destroy();
    header("location: index.php");
?>