<?php
require_once '../conexao.php';
$url1 = "https://api-cotacao-b3.labdo.it/api/sysinfo";
$ac = json_decode(file_get_contents($url1));
$ultimaCotacao = $ac->dt_ultimo_pregao;

$url2 = "https://api-cotacao-b3.labdo.it/api/cotacao/dt/".$ultimaCotacao."/02";
$acao2 = json_decode(file_get_contents($url2));
$r = $db->query("SELECT * FROM acao");
$linhas = $r->fetchAll(PDO::FETCH_ASSOC);

foreach($linhas as $l) {
    foreach($acao2 as $a2) {
        if($l['ativo']==$a2->cd_acao) {
            $cotacao = number_format($a2->vl_fechamento,2,".");
            $r = $db->prepare("UPDATE acao SET cotacaoAtual=? WHERE ativo=?");
            $r->execute(array($cotacao,$l['ativo']));
            echo ("Valor ativo: ".$cotacao);
        }
    }