<?php
    function isClientEnable($client, $enable){
        try {
            $db = new PDO('mysql:host=localhost;dbname=invistai;charset=utf8','root','');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            header("location: offline.php");
        }
        
        if($enable) {
            $r = $db->query("UPDATE pessoa SET inativado = 0 WHERE tipo = 2 and cpf = $client");            
            $msgSucesso = true;
        } else {
            $r = $db->query("UPDATE pessoa SET inativado = 1 WHERE tipo = 2 and cpf =  $client");             
            $msgSucesso = true;
        }
    }
            
    function removeUnregisteredClient($client) {
        try {
            $db = new PDO('mysql:host=localhost;dbname=invistai;charset=utf8','root','');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            header("location: offline.php");
        }

        $r = $db->prepare("DELETE FROM pessoa WHERE cpf=?");
        $r->execute(array($client));
    }
?>