<?php
    global $db;
    $db = new PDO('mysql:host=localhost;dbname=240874;charset=utf8','240874','7aylor');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    class Controller
    { 
public function validarUsuario($cpf, $senha){
             global $db, $cpfUsuario;
            $cpfUsuario =  $_POST['seunr'];

            if (!empty($cpf) && !empty($senha)) {
            
                //$consulta = $db->query("SELECT * FROM cliente WHERE login ='".$cpf."' AND senha ='".$senha."'");
                $consulta = $db->prepare("SELECT * FROM pessoa WHERE lg ='".$cpf."' AND ps ='".$senha."'");
                $consulta->execute();
                $result = $consulta->fetch(PDO::FETCH_ASSOC);
                if(!empty($result)){
                    session_start();
                    $_SESSION['id']             = isset($result['id']) && !empty($result['id']) ? $result['id'] : null;
                    
                    
                    
                    
                return true;
                }else{
                    return false;
                }

               // echo '<pre>'; var_dump( $result);die;
            }
               
            }
}