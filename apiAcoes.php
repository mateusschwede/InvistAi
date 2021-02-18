<?php
require_once 'conexao.php';

$url1 = "https://api-cotacao-b3.labdo.it/api/sysinfo";
$ac = json_decode(file_get_contents($url1));
$ultimaCotacao = $ac->dt_ultimo_pregao;

$url = "https://api-cotacao-b3.labdo.it/api/empresa";
$acao = json_decode(file_get_contents($url));
$c = 1;


foreach($acao as $a):
    $ativo = explode(",",$a->cd_acao);
    if($ativo[0]!="") {
        $ativoBD = $ativo[0];
        $nome = strtolower($a->nm_empresa);
        $setor = strtolower($a->segmento);

        $r = $db->prepare("INSERT INTO acao(ativo,nome,setor) VALUES (?,?,?)");
        $r->execute(array($ativoBD,$nome,$setor));

        echo "Ativo: ".$ativo[0]."<br>Nome: $a->nm_empresa<br>Setor: $a->segmento<hr>";
    }
    if($c==20){break;} else{$c++;}
endforeach;


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
        }
    }

}