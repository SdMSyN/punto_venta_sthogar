<?php 

include ('../config/variables.php');
require('../fpdf/fpdf.php');

require('../PHPMailer_5.2.4/class.phpmailer.php');


$pdf = new FPDF();
$pdf->AddPage();

$i = 0;
$pdf->SetFont('Times','B',10);
for($i = 1; $i <= 10; $i++){
	$pdf->Cell($i*10, $i*5, $i, 1, 1, 'C');
}

$contenido = $pdf->Output('foo.pdf', 'S');

$bodyMsg = '<h1>Cotización</h1>';
$bodyMsg .= '<p>Envío de cotización, pruebas y error.</<p>';

$mail = new PHPMailer();
$mail->setFrom('contacto@st-hogar.com', 'ST-Hogar');
$mail->addReplyTo('contacto@st-hogar.com', 'ST-Hogar');
$mail->addAddress('downloads@puraslineas.com', 'Downloads');
$mail->Subject = 'Cotización';
$mail->msgHTML($bodyMsg);
$mail->AddStringAttachment($contenido, 'Filename.pdf');
$mail->IsHTML(true);
$mail->CharSet = 'UTF-8';

$pdf->Output();

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}



?>