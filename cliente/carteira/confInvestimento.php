<?php
    require_once '../../conexao.php';
    session_start();
    if(!isset($_SESSION['clienteLogado'])){header('Location: ../../acessoNegado.php');}

    //Inserir dados na table 'investimento' e atualizar 'carteira_acao' nos dados vinculados
    if(!empty($_POST['confInvestimento'])) {

        //Atualiza saldoTotal de investimento do cliente
        $r = $db->prepare("SELECT totalInvestido FROM pessoa WHERE cpf=?");
        $r->execute(array($_SESSION['cpf']));
        $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
        foreach($linhas as $l) {$totalInvestido = $l['totalInvestido'] + $_SESSION['valorInvestimento'];}
        $r = $db->prepare("UPDATE pessoa SET totalInvestido=? WHERE cpf=?");
        $r->execute(array($totalInvestido,$_SESSION['cpf']));

        //Insere cabeçalho do investimento na tabela investimento
        $r = $db->prepare("INSERT INTO investimento(idCarteira,totValorPrevisao) VALUES (?,?)");
        $r->execute(array($_SESSION['idCarteira'],$_SESSION['valorInvestimento']));

        //Pegar id do investimento que foi criado acima
        $r = $db->prepare("SELECT id FROM investimento WHERE idCarteira=? ORDER BY id DESC LIMIT 1");
        $r->execute(array($_SESSION['idCarteira']));
        $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
        foreach($linhas as $l) {$idInvestimento = $l['id'];}
        $totPatrAtualizado = 0; //Essa var quer dizer, no BD, campo totValorInvestimento
        $sobraAportes = 0;
        

        //Pegar dados das ações da Carteira para inserir variáveis de investimento
        $r = $db->prepare("SELECT * FROM carteira_acao WHERE idCarteira=?");
        $r->execute(array($_SESSION['idCarteira']));
        $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($linhas as $l) {
            //Pegar dados específicos da ação citada
            $r = $db->prepare("SELECT * FROM acao WHERE ativo=?");
            $r->execute(array($l['ativoAcao']));
            $linhas2 = $r->fetchAll(PDO::FETCH_ASSOC);
            
            foreach($linhas2 as $l2) {
                $ativo = $l2['ativo'];
                $setor = $l2['setor'];
                $cotacaoAtual = $l2['cotacaoAtual'];
            }

            //Programar variáveis de balanceamento aqui
            $quantidadeAcoes = $l['qtdAcao'] + $qtdAcoesComprar;
            $qtdAcoesComprar = ($l['objetivo']*($_SESSION['investimentoReal']/100)) / $cotacaoAtual;
            $patrimonioAtualizado = $quantidadeAcoes * $cotacaoAtual;
            $participacaoAtual = ($patrimonioAtualizado / $_SESSION['investimentoReal']) * 100;                                
            $distanciaDoObjetivo = $participacaoAtual -  $l['objetivo'];
            if($distanciaDoObjetivo >= 0) {$qtdAcoesComprar = 0;}

            //Somar o total dos patrimonio atualizado
            $totPatrAtualizado += $patrimonioAtualizado;
            $sobraAportes = $_SESSION['investimentoReal']-$totPatrAtualizado;


            //Inserir, para cada ação da carteira, dados na tabela 'carteira_acao' (Update)
            $r = $db->prepare("UPDATE carteira_acao SET qtdAcao=?, patrAtualizado=?, partAtual=?, distObjetivo=?, qtdAcoesComprar=? WHERE idCarteira=?");
            $r->execute(array($quantidadeAcoes, $patrimonioAtualizado, $participacaoAtual, $distanciaDoObjetivo, $qtdAcoesComprar,$_SESSION['idCarteira']));

            //Inserir totais, dados restantes, na tabela 'investimento', do investimento criado lá acima
            $r = $db->prepare("UPDATE investimento SET totValorInvestimento=?, sobraAportes=? WHERE id=?");
            $r->execute(array($totPatrAtualizado,$sobraAportes,$idInvestimento));
        }

    }
    unset($_SESSION['idCarteira']);
    unset($_SESSION['investimentoReal']);
    unset($_SESSION['valorInvestimento']);
    header("location: ../index.php");
?>