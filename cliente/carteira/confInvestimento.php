<?php
    require_once '../../conexao.php';
    session_start();
    if(!isset($_SESSION['clienteLogado'])){header('Location: ../../acessoNegado.php');}


    if(!empty($_POST['confInvestimento'])) {

        $totPatrAtualizado = 0;        
        $r = $db->prepare("SELECT * FROM carteira_acao WHERE idCarteira=?");
        $r->execute(array($_SESSION['idCarteira']));
        $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($linhas as $l) {
            $r = $db->prepare("SELECT * FROM acao WHERE ativo=?");
            $r->execute(array($l['ativoAcao']));
            $linhas2 = $r->fetchAll(PDO::FETCH_ASSOC);
            
            foreach($linhas2 as $l2) {
                $ativo = $l2['ativo'];
                $setor = $l2['setor'];
                $cotacaoAtual = $l2['cotacaoAtual'];
            }

            $qtdAcoes = $l['qtdAcao'];
            $patrAtualizado = $qtdAcoes * $cotacaoAtual;                                    
            
            
            
            //Pegar totalPatrimonioAtualizado da carteira
            $r2 = $db->prepare("SELECT * FROM carteira_acao WHERE idCarteira=?");
            $r2->execute(array($_SESSION['idCarteira']));
            $linhas3 = $r2->fetchAll(PDO::FETCH_ASSOC);
            foreach($linhas3 as $l3) {                                    
                $r3 = $db->prepare("SELECT * FROM acao WHERE ativo=?");                
                $r3->execute(array($l3['ativoAcao']));
                $linhas4 = $r3->fetchAll(PDO::FETCH_ASSOC);
                foreach($linhas4 as $l4) {$cotacaoAtualAcao = $l4['cotacaoAtual'];}
                $totPatrAtualizado += $l3['qtdAcao'] * $cotacaoAtualAcao;
            }
            $participacaoAtual = $patrAtualizado / $totPatrAtualizado;





            
            
            $distObjetivo = $participacaoAtual - $l['objetivo'];
                        
            $qtdAcoesComprar = ($l['objetivo']*( ($_SESSION['valorInvestimento']+$totPatrAtualizado) /100)) / $cotacaoAtual;
            if($distObjetivo >= 0) {$qtdAcoesComprar = 0;}


            //Atualiza as quantidades de ações para cada ação na carteira
            $qtdAcoesBD = $qtdAcoes + (int)$qtdAcoesComprar;
            $r = $db->prepare("UPDATE carteira_acao SET qtdAcao=? WHERE idCarteira=? AND ativoAcao=?");
            $r->execute(array($qtdAcoesBD,$_SESSION['idCarteira'],$l['ativoAcao']);

            //Inserir dados de ação na tabela operacao
            $r = $db->prepare("INSERT INTO operacao(qtdAcoes,idCarteira,ativoAcao) VALUES (?,?,?)");
            $r->execute(array($qtdAcoes,$_SESSION['idCarteira'],$l['ativoAcao']));
        }


        
        
        
        //Atualizar o valor do saldo de sobra de aportes do cliente
        $sobraAportesAtual = $_SESSION['valorInvestimento']-$totPatrAtualizado;
        $r = $db->prepare("SELECT totalSobraAportes FROM pessoa WHERE cpf=?");
        $r->execute(array($_SESSION['cpf']));
        $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
        foreach($linhas as $l) {$totalSobraAportes = $l['totalSobraAportes'] + $sobraAportesAtual;}
        $r = $db->prepare("UPDATE pessoa SET totalSobraAportes=? WHERE cpf=?");
        $r->execute(array($totalSobraAportes,$_SESSION['cpf']));
    
    }
    unset($_SESSION['idCarteira']);
    unset($_SESSION['valorInvestimento']);
    header("location: ../index.php");
?>