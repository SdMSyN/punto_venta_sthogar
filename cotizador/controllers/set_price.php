<?php
  include ('../config/conexion.php');
  include ('../config/variables.php');

  $idStore = 12;
  $idUser = $_POST['idUser'];

  $total = $_POST['inputTotal'];
  //$totalDesc = $_POST['inputTotal2'];
  //$descuentoDesc = $_POST['inputDesc'];
  //$cantDesc = $_POST['inputCantDesc'];
  
  $inputName = (isset($_POST['inputNombre'])) ? $_POST['inputNombre'] : null;
  $inputTel = (isset($_POST['inputTel'])) ? $_POST['inputTel'] : null;
  $inputDir = (isset($_POST['inputDir'])) ? $_POST['inputDir'] : null;
  
  $cad = '';
  $ban = true; 
  $msgErr = '';
  
  //fpdf
  require('../fpdf/fpdf.php');
  require('../PHPMailer_5.2.4/class.phpmailer.php');
	
	
    class PDF extends FPDF{
	  // Cabecera de página
      function Header(){
		
		$this->Image('../assets/img/fondo.jpg', 0, 0, $this->w, $this->h);
        
		$this->SetFont('Arial','B',8);
        // Movernos a la derecha
        $this->Cell(1,1);
        // Título      
        $this->Cell(120, 25, '', 0, 0, 'C', $this->Image('../assets/img/logo_3.jpg', 10, 12, 100));
		$this->Cell(0, 35, utf8_decode('COTIZACIÓN'), 0, 1, 'C');							
        // Salto de línea
        //$this->Ln(9);
      }
      // Pie de página
      function Footer(){
		  include ('../config/conexion.php');
		  $idStore = 12;
		  //Obtenemos información de la tienda
			$sqlGetStore = "SELECT * FROM $tStore WHERE id='$idStore' ";
			$resGetStore = $con->query($sqlGetStore);
			$rowGetStore = $resGetStore->fetch_assoc();
			$nameStore = $rowGetStore['nombre'];
			$addressStore = $rowGetStore['direccion'];
			$rfcStore = $rowGetStore['rfc'];
			$telStore = $rowGetStore['tel'];
        
		//linea
		$this->SetFillColor(153, 0, 0);
		$this->Rect(10, 265, 190, 1, 'F');
		$this->Rect(10, 267, 190, 0, 'F');

		// Posición: a 3,5 cm del final
        $this->SetY(-35);
        $this->SetFont('Arial','I',8);
		$this->Cell(180, 3, utf8_decode('Siempre a tu lado con las mejores soluciones tecnológicas.'), 0, 1, 'R');
        $this->Cell(10, 3, utf8_decode(''), 0, 1, 'L');
		$this->SetFont('Arial','',8);
        $this->Cell(0, 3, utf8_decode('Soluciones Tecnológicas para el Hogar - www.st-hogar.com'), 0, 1, 'C');
        //$this->Cell(180, 3, utf8_decode('Siempre a tu lado con las mejores soluciones tecnológicas.'), 0, 1, 'R');
        $this->Cell(100, 3, utf8_decode('Sucursal: Chiautempan'), 0, 0, 'L');
        $this->Cell(10, 3, utf8_decode('Sucursal: Apizaco'), 0, 1, 'L');
        $this->Cell(100, 3, utf8_decode('Correo: contacto@st-hogar.com'), 0, 0, 'L');
        $this->Cell(10, 3, utf8_decode('Correo: contactoapizaco@st-hogar.com'), 0, 1, 'L');
        $this->Cell(100, 3, utf8_decode('Dirección: C. Miguel Hernández No. 403 - Local 2, Tepetlapa, Tlax.'), 0, 0, 'L');
        $this->Cell(10, 3, utf8_decode('Dirección: Blvrd. Francisco I. Madero No. 12, Apizaco, Tlax.'), 0, 1, 'L');
        $this->Cell(100, 3, utf8_decode('Cel: 246-116-3637 | Cel: 246-177-6355 | Oficina ST-Store: 246-464-8317'), 0, 0, 'L');
        $this->Cell(10, 3, utf8_decode('Cel: 246-116-3637 '), 0, 1, 'L');
        $this->Cell(0, 3,'Pag. '.$this->PageNo().'/{nb}', 0, 1, 'R');
      }
    }//Fin class PDF
    // Creación del objeto de la clase heredada
    $pdf = new PDF('P', 'mm', 'A4');
	#Establecemos los márgenes izquierda, arriba y derecha: 
	//$pdf->SetMargins(30, 25, 30); 
	#Establecemos el margen inferior: 
	$pdf->SetAutoPageBreak(true, 45); 
	
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times','B',12);
	$pdf->Cell(20, 10, utf8_decode('Cliente: '), 0, 0, 'L');
	$pdf->SetFont('Times','',12);
	$pdf->Cell(100, 10, utf8_decode($inputName), 0, 0, 'L');
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(20, 10, utf8_decode('Fecha: '), 0, 0, 'R');
	$pdf->SetFont('Times','',12);
	$pdf->Cell(20, 10, utf8_decode($dateNow), 0, 1, 'R');
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(20, 5, utf8_decode('Ubicación: '), 0, 0, 'L');
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(100, 5, utf8_decode($inputDir), 0, 'L', 0);
	$pdf->SetXY(136, 52);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(20, 10, utf8_decode('Teléfono:  '), 0, 0, 'R');
	$pdf->SetFont('Times','',12);
	$pdf->Cell(20, 10, utf8_decode($inputTel), 0, 1, 'R');
    
	//$pdf->SetFillColor(210, 234, 241); //fondo azul
	//$pdf->SetTextColor(0, 0, 0); //letra color negro
	$pdf->SetFillColor(255, 255, 255); //fondo azul
	$pdf->SetTextColor(0, 0, 0); //letra color negro
	$pdf->SetFont('Times','B',10);
	
	$pdf->SetDrawColor(75, 172, 198);
	$pdf->SetLineWidth(0.5);
	$pdf->Cell(10, 7, utf8_decode('No.'), 1, 0, 'C', true);
	$pdf->Cell(40, 7, utf8_decode('Imagen'), 1, 0, 'C', true);
	$pdf->Cell(70, 7, utf8_decode('Concepto'), 1, 0, 'C', true);
	$pdf->Cell(20, 7, utf8_decode('Cantidad'), 1, 0, 'C', true);
	$pdf->Cell(20, 7, utf8_decode('P. Unitario'), 1, 0, 'C', true);
	$pdf->Cell(20, 7, utf8_decode('Importe'), 1, 1, 'C', true);
  
  $pdf->SetFont('Times','',10);
  //Insertamos Cotizador
  $sqlInsertPricer = "INSERT INTO $tPricer (nombre, direccion, telefono, creado) VALUES ('$inputName', '$inputDir', '$inputTel', '$dateNow $timeNow' ) ";
  if($con->query($sqlInsertPricer) === TRUE){
	  $idPricer = $con->insert_id;
	  //Insertamos cotizacion_info
	  if($idUser == 0){
		$sqlInsertPriceInfo = "INSERT INTO $tPriceInfo (folio, fecha, total, cotizador_id) VALUES ('$dateNow', '$dateNow $timeNow', '$total', '$idPricer' ) ";
	  }else{
		  $sqlInsertPriceInfo = "INSERT INTO $tPriceInfo (folio, usuario_id, fecha, total, cotizador_id) VALUES ('$dateNow', '$idUser', '$dateNow $timeNow',  '$total', '$idPricer' ) ";
	  }
	  if($con->query($sqlInsertPriceInfo) === TRUE){
		  $idPriceInfo = $con->insert_id;
		  $pdf->SetFillColor(210, 234, 241);
		  $pdf->SetTextColor(3, 3, 3);
		  $banColor = true;
		  //Insertamos los productos de la cotización
		  for($i = 0; $i < count($_POST['id']); $i++){
			$idProduct = $_POST['id'][$i];
            $cant = $_POST['inputCant'][$i];
            $costoU = $_POST['inputPrecioU'][$i];
            $costoF = $_POST['inputPrecioF'][$i];
			$sqlInsertProductPrice = "INSERT INTO $tPriceProd (producto_id, cotizacion_id, cantidad, costo_unitario, costo_total) VALUES ('$idProduct', '$idPriceInfo', '$cant', '$costoU', '$costoF') ";
			if($con->query($sqlInsertProductPrice) === TRUE){
				$sqlGetProductInfo = "SELECT img, nombre, descripcion FROM $tProduct WHERE id='$idProduct' ";
				$resGetProductInfo = $con->query($sqlGetProductInfo);
				$rowGetProductInfo = $resGetProductInfo->fetch_assoc();
				$pdf->Cell(10, 30, $i+1, 1, 0, 'C', $banColor);
				$pdf->Cell(40, 30, '', 1, 0, 'C', $pdf->Image('../uploads/'.$rowGetProductInfo['img'], $pdf->GetX()+5, $pdf->GetY()+5, 30, 25));
				$pdf->Cell(70, 30, utf8_decode($rowGetProductInfo['nombre']), 1, 0, 'C', $banColor);
				$pdf->Cell(20, 30, utf8_decode($cant), 1, 0, 'C', $banColor);
				$pdf->Cell(20, 30, utf8_decode("$ ".$costoU), 1, 0, 'C', $banColor);
				$pdf->Cell(20, 30, utf8_decode("$ ".$costoF), 1, 1, 'C', $banColor);
				$banColor = !$banColor;
				//continue;
			}else{
				$ban = false;
				$msgErr .= 'Error: No se pude insertar el producto de la cotización. '.$con->error;
				break;
			}
		  }
		  //Insertamos total
			$pdf->SetFont('Times','B',10);
		    $pdf->Cell(10, 7, '', 1, 0, 'C');
			$pdf->Cell(40, 7, '', 1, 0, 'C');
			$pdf->Cell(70, 7, '', 1, 0, 'C');
			$pdf->Cell(20, 7, '', 1, 0, 'C');
			$pdf->Cell(20, 7, 'Total: ', 1, 0, 'C');
			$pdf->Cell(20, 7, "$ ".$total, 1, 1, 'C');
			
			//Insertamos firmas
			$pdf->SetXY(10, 247);
			//linea
			$pdf->SetFillColor(1, 1, 1);
			$pdf->Rect(10, $pdf->GetY(), 50, 0, 'F');
			$pdf->Rect(70, $pdf->GetY(), 50, 0, 'F');
			$pdf->Rect(130, $pdf->GetY(), 50, 0, 'F');
			
			$pdf->SetXY(10, 247);
			$pdf->SetFont('Times','',10);
			$pdf->Cell(60, 3, utf8_decode('ST-Hogar'), 0, 0, 'C');
			$pdf->Cell(50, 3, utf8_decode('Responsable de Venta'), 0, 0, 'C');
			$pdf->Cell(70, 3, utf8_decode('Cliente'), 0, 0, 'C');
			
	  }else{
		  $ban = false;
		  $msgErr .= 'Error: No se pudo insertar la información de la cotización.<br>'.$con->error.'<br>'.$sqlInsertPriceInfo;
	  }
  }else{
	  $ban = false;
	  $msgErr .= 'Error: No se pudo insertar cotizador.<br>'.$con->error;
  }
  //$pdf->Output('cotizacion_'.$dateNow.'-'.$timeNow.'.pdf', 'D');
  //$archivo = "";
  //$pdf->Output("F", $archivo);
  //$pdf->Output();
  
  if($ban){
	  $namePdf = 'cotizacion_'.$dateNow.'-'.$timeNow.'.pdf';
	  $contenido = $pdf->Output($namePdf, 'S');
	  $bodyMsg = '<h1>Cotización de '.$inputName.'</h1>';
	  $bodyMsg .= '<p>Envío de cotización de: <b>'.$inputName.'</b></<p>';
	  $bodyMsg .= '<p>Fecha: '.$dateNow.' - '.$timeNow.'</p>';

	  $mail = new PHPMailer();
	  $mail->setFrom('cotizaciones@st-hogar.com', 'ST-Hogar');
	  $mail->addReplyTo('cotizaciones@st-hogar.com', 'ST-Hogar');
	  $mail->addAddress('cotizaciones@st-hogar.com', 'Cotizaciones');
	  $mail->Subject = 'Cotización';
	  $mail->msgHTML($bodyMsg);
	  $mail->AddStringAttachment($contenido, $namePdf);
	  $mail->IsHTML(true);
	  $mail->CharSet = 'UTF-8';

	  $pdf->Output();
	  //send the message, check for errors
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			echo "Message sent!";
		}
  }else{
	  echo $msgErr;
  }
  
  
?>