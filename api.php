
<?php
    function getlastprice($sig){
        $url =  "https://api-cotacao-b3.labdo.it/api/cotacao/cd_acao/".$sig;
        $acao = json_decode(file_get_contents($url));
        return $acao[0]->vl_fechamento;
      }
      ///exemplo de uso: getlastprice("pomo4")
?>
