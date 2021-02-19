
<?php
	require 'banco.php';
	$pdo = Banco::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            

    session_start();
    $id = $_SESSION['id'];
    $idcli = $id;
    $idac1 = $_POST['idac1'];
    $idac2 = $_POST['idac2'];
    $idac3 = $_POST['idac3'];
    $valor1 = $_POST['valor1'];
    $valor2 = $_POST['valor2'];
    $valor3 = $_POST['valor3'];
    $data = date('Y-m-d');
	


    $sql =   "INSERT INTO carteira (
        idcli, 
        idac1, 
        idac2, 
        idac3,
        valor1, 
        valor2, 
        valor3, 
        data
        ) 
        VALUES(
            '$idcli',
            '$idac1',
            '$idac2',
            '$idac3',
            '$valor1',
            '$valor2',
            '$valor3',
            '$data'
            
            )";
 

 $q = $pdo->prepare($sql);
 $q->execute(array());
 $sql1 = "UPDATE pessoa  set a1 = ?, a2 = ?, a3 = ?,
                            p1 = ?, p2 = ?, p3 = ?,
                            dt = ? WHERE id = ?";
                    $q1 = $pdo->prepare($sql1);
                    $q1->execute(array($idac1,$idac2,$idac3,
                        $valor1,$valor2,$valor3,$data,$id));  
    Banco::desconectar(); 
    if(!empty($q1)){

                header('Location:index.php');
            }else{
                echo('ERRADO');
            }
?>