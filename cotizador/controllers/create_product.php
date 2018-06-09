<?php

include ('../config/conexion.php');
include ('../config/variables.php');

$userId = $_POST['userId'];
$nombre = $_POST['inputNombre'];
$precioRoot = $_POST['inputPrecioRoot'];
$precioFranq = $_POST['inputPrecioFranq'];
$precioCot = $_POST['inputPrecioCot'];
$precioPub = $_POST['inputPrecioPub'];
$cantMin = $_POST['inputCantMin'];
$codBar = $_POST['inputCB'];
$descrip = $_POST['inputDesc'];
$categoria = $_POST['inputCategoria'];
//$subCategoria=$_POST['inputSubCategoria'];
//$nameImg=$_FILES['inputImg']['name'];
//echo $nombre.'--'.$precio.'--'.$descrip.'--'.$categoria.'--'.$subCategoria.'--';

$sqlGetNumProdcuts = "SELECT * FROM $tProduct ";
$resGetNumProducts = $con->query($sqlGetNumProdcuts);
$countNumProducts = $resGetNumProducts->num_rows;
//echo $cadIdUser;
$ext = explode(".", $_FILES['inputImg']['name']);
$ban = false;
$error = "";
$docName = $countNumProducts . "." . $ext[1];
$fileName = $countNumProducts . ".pdf";
//echo "--".$docName."--";
if ($_FILES["inputImg"]["error"] > 0 || $_FILES["InputFile"]["error"] > 0) {
    $error.= "Ha ocurrido un error, desconocido.<br>".$FILES["inputImg"]["error"]."<br>".$_FILES["InputFile"]["error"];
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
        } else {
            $error .= "Ocurrio un error al mover el archivo.";
        }
    } else {
        $error .= "Excede el tamaño de $limite_kb Kilobytes";
    }
}
if ($ban) {
    $sqlInsertProduct = "INSERT INTO $tProduct (nombre, precio_raiz, precio_franquicia, "
            . "precio_cotizador, precio_publico, cant_minima, img, pdf, descripcion, "
            . "activo, codigo_barras, categoria_id, subcategoria_id, created, updated, "
            . "created_by_user_id, updated_by_user_id) "
            . "VALUES ('$nombre', '$precioRoot', '$precioFranq', '$precioCot', '$precioPub', "
            . "'$cantMin', '$docName', '$fileName', '$descrip', '1', '$codBar', '$categoria', "
            . "'0', '$dateNow', '$dateNow', '$userId', '$userId' ) ";
    if ($con->query($sqlInsertProduct) === TRUE) {
        echo "true";
    } else {
        if ($con->errno == "1062")
            echo "Error: Ya existe un producto con éste nombre";
        else
            echo "Error al crear producto<br>" . $con->error;
    }
}else {
    echo $error;
}

?>