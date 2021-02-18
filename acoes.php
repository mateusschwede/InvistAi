<?php require_once 'conexao.php'; ?>

<div class="row">
    <div class="col-sm-12">
        <h1>Ações</h1>
        <?php
            $r = $db->query("SELECT * FROM acao ORDER BY ativo");
            $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
            foreach($linhas as $l) {
                echo "
                <p><b>Ativo:</b> ".strtoupper($l['ativo'])."</p>
                <p><b>Nome:</b> ".$l['nome']."</p>
                <p><b>Setor:</b> ".$l['setor']."</p>";
                if($l['cotacaoAtual']!=0) {echo "<p><b>Cotação:</b> R$ ".number_format($l['cotacaoAtual'],2)."</p>";}
                else {echo "<p class='text-muted'>Sem cotação disponível no momento</p>";}
                echo "<hr>";
            }
        ?>
    </div>
</div>