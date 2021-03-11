<?php require_once 'conexao.php'; ?>

<div class="row">
    <div class="col-sm-12">
        <h1>Ações</h1>    
        <div class="table-responsive">
            <table class='table table-striped'>
                <thead>
                    <tr>
                        <th scope='col'>Ativo</th>
                        <th scope='col'>Nome</th>
                        <th scope='col'>Setor</th>
                        <th scope='col'>Cotação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $r = $db->query("SELECT * FROM acao ORDER BY ativo");
                        $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                        foreach($linhas as $l) {
                        echo "
                            <tr>
                                <th scope='row'>".strtoupper($l['ativo'])."</th>
                                <td class='setn'>".$l['nome']."</td>
                                <td class='set'>".$l['setor']."</td>";
                                if($l['cotacaoAtual']!=0) {echo "<td> R$ ".number_format($l['cotacaoAtual'],2)."</td>";}
                                else {echo "<td class='text-muted'>Sem cotação disponível no momento</td>";}
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>