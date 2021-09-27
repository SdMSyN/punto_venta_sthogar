<?php

include('../config/conexion.php');
include('../config/variables.php');

$idConfig = $_POST['idConfig'];
$precio = $_POST['inputPrecioDolar'];
$msg = '';
$ban = true;
$error = -1;
$idsProducts = "";

try{
    mysqli_autocommit( $con, FALSE );

    // Buscamos id de los productos con precio_base
    $sqlGetIDProductosPrecioBase = "SELECT id FROM productos WHERE precio_base IS NOT NULL";
    $resGetIDProductosPrecioBase = $con->query( $sqlGetIDProductosPrecioBase );
    if( $resGetIDProductosPrecioBase->num_rows < 1 )
        throw new Exception( "Error: no hay productos con precio base." );

    // Recorremos para obtener los IDs
    while ( $rowGetIDProductosPrecioBase = $resGetIDProductosPrecioBase->fetch_assoc() ) {
        $idsProducts .= ", " . $rowGetIDProductosPrecioBase["id"];
    }
    $idsProducts = ltrim( $idsProducts, "," );
        
    // actualizamos el precio raíz
    $sqlUpdatePrecioProductos = "UPDATE productos SET precio_raiz = ( precio_base * $precio ), updated = NOW() WHERE id IN ( $idsProducts ) ";
    if( $con->query( $sqlUpdatePrecioProductos ) !==  TRUE )
        throw new Exception( "Error: no se pudo actualizar el precio raíz de los productos." );

    // actualizamos el valor del dolar
    $sqlUpdateValorConfig = "UPDATE basectconfig SET valor = $precio, updated_at = NOW() WHERE id_baseCtconfig = $idConfig  ";
    if( $con->query( $sqlUpdateValorConfig ) !==  TRUE )
        throw new Exception( "Error: no se pudo actualizar el valor del dolar." );

    // guardamos
    mysqli_commit( $con );
    echo json_encode( array( "error" => 0, "msgErr" => $msg, "data" => $idsProducts ) );

}catch( Exception $e ){
    mysqli_rollback( $con );
    echo json_encode( array( "error" => 1, "msgErr" => $e->getMessage() ) );
}

?>