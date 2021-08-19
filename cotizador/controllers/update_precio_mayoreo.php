<?php

include('../config/conexion.php');
include('../config/variables.php');

$idConfig = $_POST['idConfig'];
$precio = $_POST['inputPrecioMay'];
$msg = '';
$ban = true;
$error = -1;

$sqlUpdatePrecioProductos = "UPDATE productos SET precio_mayoreo = ( precio_raiz * $precio ), updated = NOW() WHERE 1 = 1 ";
if( $con->query( $sqlUpdatePrecioProductos ) ===  TRUE ){
    $sqlUpdateValorConfig = "UPDATE basectconfig SET valor = $precio, updated_at = NOW() WHERE id_baseCtconfig = $idConfig  ";
    if( $con->query( $sqlUpdateValorConfig ) ===  TRUE ){
        $msg = "Productos actualizados.";
        $ban = true;
    }else{
        $msg = "Error: al actualizar el valor de la configuración";
        $ban = false;
    }
}else{
    $msg = "No se pudo actualizar el precio de los productos -> ".$con->error;
    $ban = false;
}

$error = ( $ban ) ? 0 : 1;
echo json_encode( array( "error" => $error, "msgErr" => $msg ) );

?>