<?php
require_once '../conexao.php';
$r = $db->prepare("UPDATE acao SET inativado=0 WHERE ativo=?");
$r->execute(array($_GET['ativo']));
header("location: acoes.php");