<?php

	$name=$_POST['inputName']; //nombre del remitente
	$mail=$_POST['inputMail']; //correo del remitente
	$phone=$_POST['inputTel']; //teléfono del remitente
	$coment=$_POST['inputComent']; //Comentario
	$para="contacto@st-hogar.com"; //MODIFICAR para colocar correo del destinatario
	$asunto="Comentario en página"; //MODIFICAR para cambiar el asunto del correo
	
	$bHayFicheros = 0;
	$sCabeceraTexto = "";
	$sAdjuntos = "";

	if ($mail)$sCabeceras = "From:".$mail."\n";
	else $sCabeceras = "";
	$sCabeceras .= "Cc:".$mail."\n";
	$sCabeceras .= "MIME-version: 1.0\n";

	$sTexto = "

	--------------------------------------------------------
	Envio de comentario a través de página Web
	-------------------------------------------------------
	\nDe: ".$name."
	\nTeléfono: ".$phone."\n
	".$coment." ";
	
	if(mail($para, $asunto, $sTexto, $sCabeceras)){
		echo 'true';
	}else{
		echo "Error al enviar correo";
	}
?>