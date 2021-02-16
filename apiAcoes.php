<?php
    $ontem = date("Ymd",strtotime("yesterday"));

    $url = "https://api-cotacao-b3.labdo.it/api/empresa";
    $acao = json_decode(file_get_contents($url));

    foreach($acao as $a):
        echo "Código: $a->cd_acao <br> $a->nm_empresa <br> Atividade: $a->segmento <br>";
        $url2 = "https://api-cotacao-b3.labdo.it/api/cotacao/cd_acao/$a->cd_acao";
        $acao2 = json_decode(file_get_contents($url2));
        foreach($acao2 as $a2):
            if($a2->dt_pregao == $ontem) {
                echo "Pregão: $a2->vl_fechamento<hr>";
                break;
            }
        endforeach;
    endforeach;
?>