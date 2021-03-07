<?php
$url1 = "https://api-cotacao-b3.labdo.it/api/sysinfo";
$ac = json_decode(file_get_contents($url1));
$ultimaCotacao = $ac->dt_ultimo_pregao;

$r = $db->query("SELECT ativo FROM acao");
if($r->rowCount()==0) {
    $url = "https://api-cotacao-b3.labdo.it/api/empresa";
    $acao = json_decode(file_get_contents($url));

    foreach($acao as $a):
        $ativo = explode(",",$a->cd_acao);
        if($ativo[0]!="") {
            $ativoBD = $ativo[0];
            $nome = strtolower($a->nm_empresa);
            $setor = mb_convert_case($a->segmento, MB_CASE_LOWER, "UTF-8");

            $r = $db->prepare("INSERT INTO acao(ativo,nome,setor,dtUltimaCotacao) VALUES (?,?,?,?)");
            $r->execute(array($ativoBD,$nome,$setor,$ultimaCotacao));
        }            
    endforeach;  
}
?>