<?php
    require_once '../../conexao.php';
  //  session_start();
    echo '<div class="alert alert-success">
  <strong>Registrado!</strong> Lançamento em Operacao e soma nas quantidades da carteira_acao.
</div>';
    unset($_SESSION['conf']);
    include "../index.php";
?>
