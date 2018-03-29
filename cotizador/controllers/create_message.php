<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $idUser = $_POST['inputIdUser'];
    $message = $_POST['inputMessage'];
    $ban = false;
	$msgErr = '';
    
    $sqlCreateMessage="INSERT INTO $tUsersMess (usuario_id, mensaje, creado) VALUES ('$idUser', '$message', '$dateNow $timeNow') ";
    if($con->query($sqlCreateMessage) === TRUE ){
        $ban = true;
    }else{
        $msgErr .= 'Error al crear mensaje: <br>'.$con->error;
		$ban = false;
    }
      
	if($ban){
		echo json_encode(array("error"=>0, "msgErr"=>$msgErr));
	}else{
		echo json_encode(array("error"=>1, "msgErr"=>$msgErr));
	}
?>