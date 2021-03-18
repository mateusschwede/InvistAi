<?php
    require_once '../../conexao.php';
  //  session_start();
     unset($_SESSION['conf']);
    echo '<div class="alert alert-success">
  <strong>Registrado!</strong> <a href=" ../index.php?"class="btn btn-success" id="submitWithEnter" name="conf" style="text-align: center;" target="_top">Voltar</a>
</div>';
?>
