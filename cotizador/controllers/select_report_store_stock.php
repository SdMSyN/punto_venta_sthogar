<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $store = $_GET['idStore'];
    $category = $_GET['inputCategory'];
    $sqlWhereCategory = "";
    if( $category != "0" ) 
        $sqlWhereCategory = " AND productos.categoria_id='$category' ";
    
    //fpdf
    require('../fpdf/fpdf.php');
    class PDF extends FPDF{
    // Cabecera de página
      function Header(){
          // Arial bold 15
        $this->SetFont('Arial','B',8);
        // Movernos a la derecha
        $this->Cell(1,1);
        // Título
        $this->Cell( 12, 7, 'ID', 1, 0, 'C' );
        $this->Cell( 80, 7, 'Producto', 1, 0, 'C' );
        $this->Cell( 30, 7, utf8_decode('Categoría'), 1, 0, 'C' );
        $this->Cell( 15, 7, 'C.U.', 1, 0, 'C' );
        $this->Cell( 15, 7, 'Cant.', 1, 0, 'C' );
        $this->Cell( 15, 7, 'C.F.', 1, 0, 'C' );
        $this->Cell( 50, 7, 'Tienda', 1, 0, 'C' );
        $this->Cell( 60, 7, utf8_decode('Fecha de modificación'), 1, 0, 'C' );  								
        // Salto de línea
        $this->Ln(9);
      }
      // Pie de página
      function Footer(){
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell( 100, 10, 'Page '.$this->PageNo().'/{nb}', 0, 0, 'C' );
        $this->Cell( 80, 10, 'Fecha: ' . date("Y-m-d H:i:s"), 0, 0, 'C' );
      }
    }//Fin class PDF
    // Creación del objeto de la clase heredada
    $pdf = new PDF('L', 'mm', 'A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times','',8);
    
    //echo $sqlGetInfoSale.'<br>';
    $cantT = 0;
    $costoFT = 0;
    $sqlGetInfoAlmacen = " SELECT "
        . "     productos.id AS idProd,"
        . "     productos.nombre AS producto,"
        . "     categorias.nombre AS categoria,"
        . "     productos.precio_franquicia AS precio,"
        . "     almacenes.cantidad AS cantidad,"
        . "     tiendas.nombre AS tienda,"
        . "     almacenes.updated AS fm "
        . " FROM almacenes"
        . " INNER JOIN productos ON almacenes.producto_id = productos.id "
        . " INNER JOIN categorias ON productos.categoria_id = categorias.id "
        . " INNER JOIN tiendas ON almacenes.tienda_id = tiendas.id "
        . " WHERE productos.activo = 1"
        . "     AND almacenes.tienda_id = '$store' "
        . $sqlWhereCategory
        . " ORDER BY productos.id";
    $resGetInfoAlmacen = $con->query( $sqlGetInfoAlmacen );
    if( $resGetInfoAlmacen->num_rows > 0 ){
        while($rowGetInfoStock = $resGetInfoAlmacen->fetch_assoc()){
            $costoF=$rowGetInfoStock['cantidad']*$rowGetInfoStock['precio'];
            $pdf->Cell( 12, 7, $rowGetInfoStock['idProd'], 'B', 0, 'C' );
            $pdf->Cell( 80, 7, utf8_decode($rowGetInfoStock['producto']), 'B', 0, 'C' );
            $pdf->Cell( 30, 7, utf8_decode($rowGetInfoStock['categoria']), 'B', 0, 'C' );
            $pdf->Cell( 15, 7, '$'.$rowGetInfoStock['precio'], 'B', 0, 'C' );
            $pdf->Cell( 15, 7, $rowGetInfoStock['cantidad'], 'B', 0, 'C' );
            $pdf->Cell( 15, 7, '$'.$costoF, 'B', 0, 'C' );
            $pdf->Cell( 50, 7, utf8_decode($rowGetInfoStock['tienda']), 'B', 0, 'C' );
            $pdf->Cell( 60, 7, $rowGetInfoStock['fm'], 'B', 1, 'C' );
            $cantT += $rowGetInfoStock['cantidad'];
            $costoFT += $costoF;
        }
    }else{
        $pdf->Cell( 194, 7, 'No hay productos en éste almacén.', 'B', 0, 'C');
    }
    $pdf->Cell( 94, 7, '', 'B', 0, 'C' );
    $pdf->Cell( 183, 7, 'Cantidad: '.$cantT.utf8_decode('   Dinero en almacén: $').$costoFT, 'B', 1 );
 
    $pdf->Output();
?>
