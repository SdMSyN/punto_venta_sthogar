<?php

include ('../config/conexion.php');
include ('../config/variables.php');

$userId      = $_POST['userId'];
$nombre      = $_POST['inputNombre'];
$precioRoot  = $_POST['inputPrecioRoot'];
$precioFranq = $_POST['inputPrecioFranq'];
$precioCot   = $_POST['inputPrecioCot'];
$precioPub   = $_POST['inputPrecioPub'];
$precioMay   = $_POST['inputPrecioMay'];
$cantMin     = $_POST['inputCantMin'];
$codBar      = $_POST['inputCB'];
$codSat      = $_POST['inputSAT'];
$descrip     = $_POST['inputDesc'];
$categoria   = $_POST['inputCategoria'];
//$subCategoria=$_POST['inputSubCategoria'];
//$nameImg=$_FILES['inputImg']['name'];
//echo $nombre.'--'.$precio.'--'.$descrip.'--'.$categoria.'--'.$subCategoria.'--';

$sqlGetNumProdcuts = "SELECT id FROM productos ";
$resGetNumProducts = $con->query($sqlGetNumProdcuts);
$countNumProducts = $resGetNumProducts->num_rows;
//echo $cadIdUser;
$ext       = explode(".", $_FILES['inputImg']['name']);
$ban       = false;
$banInsert = false;
$msgErr    = "";
$error     = "";
$docName   = $countNumProducts . "." . $ext[1];
$fileName  = $countNumProducts . ".pdf";
//echo "--".$docName."--";
if ($_FILES["inputImg"]["error"] > 0 || $_FILES["InputFile"]["error"] > 0) {
    $msgErr.= "Ha ocurrido un error, desconocido.<br>".$FILES["inputImg"]["error"]."<br>".$_FILES["InputFile"]["error"];
} else {
    $limite_kb = 1000;
    if ($_FILES['inputImg']['size'] <= $limite_kb * 1024 && $_FILES['InputFile']['size'] <= $limite_kb * 1024) {
        //$ruta = "doc_user/" . $_FILES['inputDoc']['name'];
        $ruta = "../" . $rutaImgProd . $docName;
        $resultado = @move_uploaded_file($_FILES["inputImg"]["tmp_name"], $ruta);
        $rutaFile = "../" . $rutaImgProd . $fileName;
        $resultado2 = @move_uploaded_file($_FILES["InputFile"]["tmp_name"], $rutaFile);
        if ($resultado && $resultado2) {
            //echo "el archivo ha sido movido exitosamente";
            $ban = true;
            $banInsert = true;
        } else {
            $msgErr .= "Ocurrio un error al mover el archivo.";
        }
    } else {
        $msgErr .= "Excede el tamaño de $limite_kb Kilobytes";
    }
}
if ($ban) {
    $sqlInsertProduct = "INSERT INTO productos (nombre, precio_raiz, precio_franquicia, "
            . "precio_cotizador, precio_publico, precio_mayoreo, cant_minima, img, pdf, descripcion, "
            . "activo, codigo_barras, categoria_id, subcategoria_id, codigo_sat, created, updated, "
            . "created_by_user_id, updated_by_user_id) "
            . "VALUES ('$nombre', '$precioRoot', '$precioFranq', '$precioCot', '$precioPub', '$precioMay',"
            . "'$cantMin', '$docName', '$fileName', '$descrip', '1', '$codBar', '$categoria', "
            . "0, '$codSat', '$dateNow', '$dateNow', '$userId', '$userId' ) ";
    if ($con->query($sqlInsertProduct) === TRUE) {
        $msgErr = "producto dado de alta con éxito";
        $banInsert = true;
    } else {
        $banInsert = false;
        if ($con->errno == "1062")
            $msgErr .= "Error: Ya existe un producto con éste nombre";
        else
            $msgErr .= "Error al crear producto<br>" . $con->error;
    }
}

if( $banInsert ){
    echo json_encode( array( "error" => 0, "msgErr" => $msgErr ) );
}else{
    echo json_encode( array( "error" => 1, "msgErr" => $msgErr ) );
}

?>