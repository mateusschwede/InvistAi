<?php
    require_once '../../conexao.php';
    session_start();
    if(!isset($_SESSION['clienteLogado'])){header('Location: ../../acessoNegado.php');}

    $totPatrAtualizado = 0;
    $totInvestimentoReal = 0;
    $r = $db->prepare("SELECT * FROM carteira_acao WHERE idCarteira=?");
    $r->execute(array($_SESSION['idCarteira']));
    $linhas3 = $r->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($linhas3 as $l3) {                                    
        $r = $db->prepare("SELECT * FROM acao WHERE ativo=?");
        $r->execute(array($l3['ativoAcao']));
        $linhas4 = $r->fetchAll(PDO::FETCH_ASSOC);
        foreach($linhas4 as $l4) {$cotacaoAtualAcao = $l4['cotacaoAtual'];}
        $totPatrAtualizado += $l3['qtdAcao'] * $cotacaoAtualAcao;
    }

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
        
        if($totPatrAtualizado==0) {$partAtual=0;}
        else {$partAtual = ($patrAtualizado * 100) / $totPatrAtualizado;}
        $distObjetivo = $partAtual - $l['objetivo'];

        //ATUALIZAR QTDACOES NA AÇÃO DA CARTEIRA
        if($distObjetivo >= 0) {$qtdAcoesComprar = 0;}
        else {$qtdAcoesComprar = ($l['objetivo']*( ($_SESSION['valorInvestimento']+$totPatrAtualizado) / 100)) / $cotacaoAtual;}
        
        if($qtdAcoesComprar!=0) {$totInvestimentoReal += ((int)$qtdAcoesComprar*$cotacaoAtual);}
        
        if($qtdAcoes==0 and $qtdAcoesComprar!=0) {$qtdAcoesBD=(int)$qtdAcoesComprar;}
        else {$qtdAcoesBD = (int)$qtdAcoes + ((int)$qtdAcoesComprar);}

        if((int)$qtdAcoesComprar!=0) {
            $r = $db->prepare("UPDATE carteira_acao SET qtdAcao=? WHERE idCarteira=? AND ativoAcao=?");
            $r->execute(array((int)$qtdAcoesBD,$_SESSION['idCarteira'],$l['ativoAcao']));
        
            //INSERIR OPERACAO DE COMPRA
            $r = $db->prepare("INSERT INTO operacao(qtdAcoes,idCarteira,ativoAcao) VALUES (?,?,?)");
            $r->execute(array((int)$qtdAcoesComprar,$_SESSION['idCarteira'],$l['ativoAcao']));
        }
    }

    //INSERIR SOBRA APORTES ($totSobraAportes + $sobraAportesBD)
    $totSobraAportes = $_SESSION['valorInvestimento']-$totInvestimentoReal;
    $r = $db->prepare("SELECT totalSobraAportes FROM pessoa WHERE cpf=?");
    $r->execute(array($_SESSION['cpf']));
    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
    foreach($linhas as $l) {$sobraAportesBD = $l['totalSobraAportes'];}
    $r = $db->prepare("UPDATE pessoa SET totalSobraAportes=? WHERE cpf=?");
    $r->execute(array($totSobraAportes+$sobraAportesBD,$_SESSION['cpf']));   

    unset($_SESSION['idCarteira']);
    unset($_SESSION['valorInvestimento']);
    header("location: ../index.php");
?>
