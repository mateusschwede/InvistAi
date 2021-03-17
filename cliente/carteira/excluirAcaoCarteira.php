<?php
    require_once '../../conexao.php';
    session_start();
    if(!isset($_SESSION['clienteLogado'])){header('Location: ../../acessoNegado.php');}
  
    if((!empty($_GET['ativoAcao'])) and (!empty($_GET['qtdAcao']))) {

        if ($_GET['qtdAcao']==0) {
            // Somente remove:
            // DELETE FROM carteira_acao WHERE idCarteira=? AND ativoAcao=?;



        } else {
            


            



            $r = $db->prepare("SELECT ativoAcao,qtdAcao FROM carteira_acao WHERE idCarteira=0 AND cpfCliente=? AND ativoAcao=?");
            $r->execute(array($_SESSION['cpf'],$_GET['ativoAcao']));
            
            if($r->rowCount()==0) {
                //NÃO HÁ AÇÃO SIMILAR NA LISTAGEM DE AÇÕES SEM CARTEIRA
                // Move pra 'acoes sem carteira no momento', trocando o percentual tbm pra zero:
                // UPDATE carteira_acao SET idCarteira=0,objetivo=0 WHERE idCarteira=? AND ativoAcao=?;
            
            
            } else {
                //SE HÁ UMA AÇÃO SIMILAR JÁ EXISTE NA LISTAGEM DE AÇÕES SEM CARTEIRA
                //Acrescenta qtd da ação origem na destino, e remove ação origem
                $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                foreach($linhas as $l) {$qtdAcoesDestino = $l['qtdAcao'];}
                $qtdAcoesIncluir = $_GET['qtdAcao'] + $qtdAcoesDestino;
                
                //UPDATE DA QTD NA AÇÃO DESTINO
                //REMOVE AÇÃO ORIGEM: DELETE FROM carteira_acao WHERE idCarteira=? AND ativoAcao=?;
            }
        }

    }
    header("location: ../index.php");
?>