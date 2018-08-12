<?php

include ('../config/conexion.php');
include ('../config/variables.php');

$store = $_POST['inputStore'];
$seller = $_POST['inputSellers'];
$month = $_POST['inputMonth'];
$week = $_POST['inputWeek'];
$day = $_POST['inputDay'];
$category = $_POST['inputCategory'];
//echo $store.'--'.$sellers.'--'.$month.'--'.$week;

$sqlGetInfoSale = "SELECT id, (SELECT nombre FROM $tUser WHERE id=$tSaleInfo.usuario_id) as user, "
        . "(SELECT nombre FROM $tStore WHERE id=$tSaleInfo.tienda_id) as store,"
        . " fecha, hora, pago, total, cambio, descuento, total_desc, cant_desc, cambio_desc " 
        . "FROM $tSaleInfo WHERE tienda_id='$store' ";
if ($seller == "" && $month == "" && $week == "" && $day == "" && $category == "") {
    $sqlGetInfoSale .= " AND fecha='$dateNow' ";
} else if ($seller != "" && $month == "" && $week == "" && $day == "") {
    $sqlGetInfoSale .= " AND usuario_id='$seller' AND fecha='$dateNow' ";
} else {
    if (isset($_POST['inputSellers']) && $seller != "") {
        $sqlGetInfoSale .= " AND usuario_id='$seller' ";
    }
    if (isset($_POST['inputMonth']) && $month != "") {
        $mes = ($month{5} . $month{6});
        $sqlGetInfoSale .= " AND month(fecha)='$mes' ";
    }
    if (isset($_POST['inputWeek']) && $week != "") {
        $sema = ($week{6} . $week{7}) - 1;
        $sqlGetInfoSale .= " AND week(fecha)='$sema' ";
    }
    if (isset($_POST['inputDay']) && $day != "") {
        $sqlGetInfoSale .= " AND fecha='$day' ";
    }
}

//fpdf
require('../fpdf/fpdf.php');

class PDF extends FPDF {

    // Cabecera de página
    function Header() {
        // Arial bold 15
        $this->SetFont('Arial', 'B', 8);
        // Movernos a la derecha
        $this->Cell(1, 1);
        // Título      
        $this->Cell(10, 7, '#', 1, 0, 'C');
        $this->Cell(20, 7, 'Ticket', 1, 0, 'C');
        $this->Cell(18, 7, 'SubTotal', 1, 0, 'C');
        $this->Cell(18, 7, 'Descuento', 1, 0, 'C');
        $this->Cell(18, 7, 'Total.', 1, 0, 'C');
        $this->Cell(15, 7, utf8_decode('Donación'), 1, 0, 'C');
        $this->Cell(25, 7, 'Vendedor', 1, 0, 'C');
        $this->Cell(25, 7, 'Tienda', 1, 0, 'C');
        $this->Cell(15, 7, 'Fecha', 1, 0, 'C');
        $this->Cell(15, 7, 'Hora', 1, 0, 'C');
        // Salto de línea
        $this->Ln(9);
    }

    // Pie de página
    function Footer() {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

}

//Fin class PDF
// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 7);


//echo $sqlGetInfoSale.'<br>';
$resGetInfoSale = $con->query($sqlGetInfoSale);
if ($resGetInfoSale->num_rows > 0) {
    $i = 1;
    $cantT = 0;
    $costoFT = 0;
    while ($rowGetInfoSale = $resGetInfoSale->fetch_assoc()) {

        $pdf->Cell(10, 7, $i, 'B', 0, 'C');
        $pdf->Cell(20, 7, $rowGetInfoSale['id'], 'B', 0, 'C');
        $pdf->Cell(18, 7, $rowGetInfoSale['total'], 'B', 0, 'C');
        $pdf->Cell(18, 7, $rowGetInfoSale['descuento'], 'B', 0, 'C');
        $pdf->Cell(18, 7, $rowGetInfoSale['total_desc'], 'B', 0, 'C');
        if ($rowGetInfoSale['pago'] == "0.00" && $rowGetInfoSale['cambio'] == "0.00") {
            $pdf->Cell(15, 7, 'Si', 'B', 0, 'C');
        } else {
            $pdf->Cell(15, 7, 'No', 'B', 0, 'C');
        }
        $pdf->Cell(25, 7, $rowGetInfoSale['user'], 'B', 0, 'C');
        $pdf->Cell(25, 7, utf8_decode($rowGetInfoSale['store']), 'B', 0, 'C');
        $pdf->Cell(15, 7, $rowGetInfoSale['fecha'], 'B', 0, 'C');
        $pdf->Cell(15, 7, $rowGetInfoSale['hora'], 'B', 1, 'C');
        $i++;
        $cantT += $rowGetInfoSale['total_desc'];
        if ($rowGetInfoSale['pago'] == "0.00" && $rowGetInfoSale['cambio'] == "0.00")
            $rowGetInfoSale['total_desc'] = 0;
        $costoFT += $rowGetInfoSale['total_desc'];
    }
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 7, '', 'B', 0, 'C');
    $pdf->Cell(20, 7, '', 'B', 0, 'C');
    $pdf->Cell(18, 7, 'Totales', 'B', 0, 'C');
    $pdf->Cell(18, 7, '', 'B', 0, 'C');
    $pdf->Cell(18, 7, $costoFT, 'B', 0, 'C');
    $pdf->Cell(15, 7, '', 'B', 0, 'C');
    $pdf->Cell(25, 7, '', 'B', 0, 'C');
    $pdf->Cell(25, 7, '', 'B', 0, 'C');
    $pdf->Cell(15, 7, '', 'B', 0, 'C');
    $pdf->Cell(15, 7, '', 'B', 1, 'C');
}else {
    $pdf->Cell(223, 7, 'No hay ventas.', 'B', 0, 'C');
}
$pdf->Output();
?>