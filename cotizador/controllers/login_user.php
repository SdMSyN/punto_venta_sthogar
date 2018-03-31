<?php
    session_start();
    include ('../config/conexion.php');
    $user = $_POST['inputUser'];
    $pass = $_POST['inputPass'];
    
    $cadErr = '';
    $ban =false;
    $perfil = 0;
	
    $sqlGetUser="SELECT * FROM $tUser WHERE BINARY user='$user' AND BINARY password='$pass' AND activo='1' ";
    $resGetUser=$con->query($sqlGetUser);
    if($resGetUser->num_rows > 0){
        $rowGetUser=$resGetUser->fetch_assoc();
       
        $_SESSION['sessU'] = true;
        $_SESSION['sessA'] = true;
        $_SESSION['userId'] = $rowGetUser['id'];
        $_SESSION['userName'] = $rowGetUser['ap']." ".$rowGetUser['am']." ".$rowGetUser['nombre'];
        $_SESSION['perfil'] = $rowGetUser['perfil_id'];
        $perfil = $rowGetUser['perfil_id'];
        $ban = true;
        
    }
    else{
        $_SESSION['sessU']=false;
        //echo "Error en la consulta<br>".$con->error;
        $cadErr .= "Usuario incorrecto";
        $ban = false;
    }
    
    if($ban){
        echo json_encode(array("error"=>0, "perfil"=>$perfil));
    }else{
        echo json_encode(array("error"=>1, "msgErr"=>$cadErr));
    }
	
?>