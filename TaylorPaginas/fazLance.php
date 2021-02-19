<?php
    require 'banco.php';
        $idcli=$_GET['id'];

    session_start();
    $t=$_SESSION['a'];
    $qt1=$_SESSION['qt1'];
    $qt2=$_SESSION['qt2'];
    $qt3=$_SESSION['qt3'];
    $qt4=$_SESSION['qt4'];
    $qt5=$_SESSION['qt5'];
    $ac1=$_SESSION['ac1'];
    $ac2=$_SESSION['ac2'];
    $ac3=$_SESSION['ac3'];
    $ac4=$_SESSION['ac4'];
    $ac5=$_SESSION['ac5'];
    $ass=$_SESSION['ass'];
    $y=0;
    
        if($qt1>0){$y++;}
        if($qt2>0){$y++;}
        if($qt3>0){$y++;}
        if($qt4>0){$y++;}
        if($qt5>0){$y++;}

    
    $asobra=$ass/$y;
//Acompanha os erros de validação
        $empErro = null;

        $valorErro = null;

        $dat = date('Y/m/d');

        $validacao = true;
        if(empty($emp))
        {
            $empErro = 'Por favor digite a Ação!';
            $validacao = false;
        }
        if(empty($valor))
        {
            $valorErro = 'Por favor digite o valor da Ação!';
            $validacao = false;
       }
                //Inserindo no Banco:
       $pdo = Banco::conectar();
       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            $x=0;
        
            while ($x<$y) 
            {
                $ida=$quant=0;
                if($x==0){
                    if($qt1>0){
                    $ida = $ac1;
                    $quant = $qt1;  
                    }

                }
                if($x==1){
                    if($qt2>0){    
                    $ida=$ac2;
                    $quant=$qt2;
                    }
                }
                if($x==2){
                    if($qt3>0){    
                    $ida=$ac3;
                    $quant=$qt3;
                    }
                }
                 if($x==3){
                    if($qt4>0){    
                    $ida=$ac4;
                    $quant=$qt4;
                    }
                }
                 if($x==4){
                    if($qt5>0){    
                    $ida=$ac5;
                    $quant=$qt5;
                    }
                }
             $x++;
             if($quant>0){   
            $sql = "INSERT INTO lance (idcli, tipo, idct, quant, datac, sobra) VALUES(?,?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($idcli, $t, $ida, $quant, $dat, $asobra));
                }
           
           
            
            
            }

        Banco::desconectar();
            header("Location: teste.php?id=$idcli");
    
?>
