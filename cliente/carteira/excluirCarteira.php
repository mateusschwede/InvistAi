<?php
    require_once '../../conexao.php';
    session_start();
    if(!isset($_SESSION['clienteLogado'])){header('Location: ../../acessoNegado.php');}


    //Percorre todas ações da carteira, conferindo regras abaixo
    $r = $db->prepare("SELECT * FROM carteira_acao WHERE idCarteira=?");
    $r->execute(array($_SESSION['idCarteira']));
    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
    foreach($linhas as $l) {

        if($l['qtdAcao']==0) { //Ação não possui quantidades em saldo, pode ser deletada diretamente
            $r = $db->prepare("DELETE FROM carteira_acao WHERE idCarteira=? AND ativoAcao=?");
            $r->execute(array($_SESSION['idCarteira'],$l['ativoAcao']));
        } else {

            //Ação possui quantidades em saldo, então verificar se há outra ação similar na lixeira
            $r = $db->prepare("SELECT ativoAcao,qtdAcao FROM carteira_acao WHERE idCarteira=0 AND cpfCliente=? AND ativoAcao=?");
            $r->execute(array($_SESSION['cpf'],$l['ativoAcao']));

            if($r->rowCount()==0) { //Não há outra ação similar, então somente move pra lixeira
                $r = $db->prepare("UPDATE carteira_acao SET idCarteira=0,objetivo=0 WHERE idCarteira=? AND ativoAcao=?");
                $r->execute(array($_SESSION['idCarteira'],$l['ativoAcao']));
                            
            } else { //Há outra ação similar, então acrescenta qtd origem na ação da lixeira e deleta ação da carteira origem
                $linhas2 = $r->fetchAll(PDO::FETCH_ASSOC);
                foreach($linhas2 as $l2) {$qtdAcoesDestino = $l2['qtdAcao'];}
                $qtdAcoesIncluir = $l['qtdAcao'] + $qtdAcoesDestino;

                $r = $db->prepare("UPDATE carteira_acao SET qtdAcao=? WHERE idCarteira=0 AND ativoAcao=? AND cpfCliente=?");
                $r->execute(array($qtdAcoesIncluir, $l['ativoAcao'], $_SESSION['cpf']));

                $r = $db->prepare("DELETE FROM carteira_acao WHERE idCarteira=? AND ativoAcao=?");
                $r->execute(array($_SESSION['idCarteira'], $l['ativoAcao']));
            }
        }

    }
    

    //Deleta a carteira
    $r = $db->prepare("DELETE FROM carteira WHERE id=?");
    $r->execute(array($_SESSION['idCarteira']));
    
    $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Carteira ".$_SESSION['idCarteira']." removida!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    header("location: ../index.php");
?>