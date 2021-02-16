<?php
    $url = "https://api-cotacao-b3.labdo.it/api/empresa";
    $acao = json_decode(file_get_contents($url));
    $c = 1;

    foreach($acao as $a):
        $ativo = explode(",",$a->cd_acao);
        echo "Ativo: ".$ativo[0]."<br>Nome: $a->nm_empresa<br>Setor: $a->segmento<hr>";

        /* AQUI ENTRARIA O PREÇO, MAS PODE SER EXTERNO TBM, FUNCIONANDO É A CONTA
        $url2 = "https://api-cotacao-b3.labdo.it/api/cotacao/cd_acao/$ativo[0]";
        $acao2 = json_decode(file_get_contents($url2));
        foreach($acao2 as $a2):
            echo "Pregão: $a2->vl_fechamento<hr>";
            break;
        endforeach;
        */

        if($c==20){break;} else{$c++;}
    endforeach;
?>