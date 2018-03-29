<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
	$idUser = $_POST['idUser'];
	$messages = array();
	$ban = true;
	$msgErr = '';
	$sqlGetUserMessages = "SELECT * FROM $tUsersMess WHERE usuario_id='$idUser' ORDER BY creado";
	
	//Ejecutamos query
	$resGetUserMessages = $con->query($sqlGetUserMessages);
	$datos = '';
	if($resGetUserMessages->num_rows > 0){
		while ($rowGetUserMessages = $resGetUserMessages->fetch_assoc()) {
			$mess = $rowGetUserMessages['mensaje'];
			$creado = $rowGetUserMessages['creado'];
			$messages[] = array('mess'=>$mess, 'fecha'=>$creado);
		}
	}else{
		$ban = false;
		$msgErr = "No existen mensajes para éste integrador.";
	}
	
	if($ban){
		$msgErr = 'Mensajes encontrados.';
		echo json_encode(array("error"=>0, "dataRes"=>$messages,"msgErr"=>$msgErr));
	}else{
		echo json_encode(array("error"=>1, "msgErr"=>$msgErr));
	}
    
?>
