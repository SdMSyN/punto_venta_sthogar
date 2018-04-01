<?php

include ('../config/conexion.php');
include ('../config/variables.php');

$userId = $_POST['userId'];
$productId = $_POST['productId'];
$nombre = $_POST['inputNombre'];
$precioR = $_POST['inputPrecioR'];
$precioF = $_POST['inputPrecioFranq'];
$precioC = $_POST['inputPrecioCot'];
$precioP = $_POST['inputPrecioPub'];
$cantMin = $_POST['inputCantMin'];
$codBar = $_POST['inputCB'];
$descrip = $_POST['inputDesc'];
$categoria = $_POST['inputCategoria'];
$subCategoria = 0;
$nameImg = $_FILES['inputImg']['name'];
$namePdf = $_FILES['inputPDF']['name'];

//echo $nombre.'--'.$precio.'--'.$descrip.'--'.$categoria.'--'.$panFrio.'--'.$nameImg;

$sqlGetNumProdcuts = "SELECT * FROM $tProduct WHERE id='$productId' ";
$resGetNumProducts = $con->query($sqlGetNumProdcuts);
$countNumProducts = $resGetNumProducts->num_rows;
$rowGetNumProducts = $resGetNumProducts->fetch_assoc();
//echo $cadIdUser;
if ($_FILES['inputPDF']['name'] != "" && $_FILES['inputImg']['name'] != "") {
    $ext = explode(".", $_FILES['inputImg']['name']);
    $ban = false;
    $error = "";
    $docName = $rowGetNumProducts['categoria_id'] . "_" . $rowGetNumProducts['subcategoria_id'] . "_" . $rowGetNumProducts['id'] . "." . $ext[1];
    $docNamePdf = $rowGetNumProducts['categoria_id'] . "_" . $rowGetNumProducts['subcategoria_id'] . "_" . $rowGetNumProducts['id'] . ".pdf";
    if ($_FILES["inputPDF"]["error"] > 0 || $_FILES["inputImg"]["error"] > 0) {
        $error .= "Ha ocurrido un error";
    } else {
        $limite_kb = 1000;
        if ($_FILES['inputPDF']['size'] <= $limite_kb * 1024 && $_FILES['inputImg']['size'] <= $limite_kb * 1024) {
            $ruta = "../" . $rutaImgProd . $docName;
            $resultado = @move_uploaded_file($_FILES["inputImg"]["tmp_name"], $ruta);
            $rutaFile = "../" . $rutaImgProd . $docNamePdf;
            $resultado2 = @move_uploaded_file($_FILES["inputPDF"]["tmp_name"], $rutaFile);
            if ($resultado && $resultado2) {
                $ban = true;
            } else {
                $error .= "Ocurrio un error al mover el pdf o la imagen.";
            }
        } else {
            $error .= "Se excede el tamaño de $limite_kb Kilobytes";
        }
    }
    if ($ban) {
        $sqlUpdateProduct = "UPDATE $tProduct SET nombre='$nombre', precio_raiz='$precioR', precio_franquicia='$precioF', precio_cotizador='$precioC', precio_publico='$precioP', cant_minima='$cantMin', codigo_barras='$codBar', img='$docName', pdf='$docNamePdf', descripcion='$descrip', categoria_id='$categoria', subcategoria_id='$subCategoria', updated='$dateNow', updated_by_user_id='$userId' WHERE id='$productId' ";
        if ($con->query($sqlUpdateProduct) === TRUE) {
            echo "true";
        } else {
            echo "Error al modificar producto<br>" . $con->error;
        }
    } else {
        echo $error;
    }
} else if ($_FILES['inputImg']['name'] != "") {
    $ext = explode(".", $_FILES['inputImg']['name']);
    $ban = false;
    $error = "";
    $docName = $rowGetNumProducts['categoria_id'] . "_" . $rowGetNumProducts['subcategoria_id'] . "_" . $rowGetNumProducts['id'] . "." . $ext[1];
    if ($_FILES["inputImg"]["error"] > 0) {
        $error .= "Ha ocurrido un error";
    } else {
        $limite_kb = 1000;
        if ($_FILES['inputImg']['size'] <= $limite_kb * 1024) {
            $ruta = "../" . $rutaImgProd . $docName;
            $resultado = @move_uploaded_file($_FILES["inputImg"]["tmp_name"], $ruta);
            if ($resultado) {
                $ban = true;
            } else {
                $error .= "Ocurrio un error al mover el archivo.";
            }
        } else {
            $error .= "Excede el tamaño de $limite_kb Kilobytes";
        }
    }
    if ($ban) {
        $sqlUpdateProduct = "UPDATE $tProduct SET nombre='$nombre', precio_raiz='$precioR', precio_franquicia='$precioF', precio_cotizador='$precioC', precio_publico='$precioP', cant_minima='$cantMin', codigo_barras='$codBar', img='$docName', descripcion='$descrip', categoria_id='$categoria', subcategoria_id='$subCategoria', updated='$dateNow', updated_by_user_id='$userId' WHERE id='$productId' ";
        if ($con->query($sqlUpdateProduct) === TRUE) {
            echo "true";
        } else {
            echo "Error al modificar producto<br>" . $con->error;
        }
    } else {
        echo $error;
    }
} else if ($_FILES['inputPDF']['name'] != "") {
    $ext = explode(".", $_FILES['inputPDF']['name']);
    $ban = false;
    $error = "";
    $docName = $rowGetNumProducts['categoria_id'] . "_" . $rowGetNumProducts['subcategoria_id'] . "_" . $rowGetNumProducts['id'] . "." . $ext[1];
    if ($_FILES["inputPDF"]["error"] > 0) {
        $error .= "Ha ocurrido un error";
    } else {
        $limite_kb = 1000;
        if ($_FILES['inputPDF']['size'] <= $limite_kb * 1024) {
            $ruta = "../" . $rutaImgProd . $docName;
            $resultado = @move_uploaded_file($_FILES["inputPDF"]["tmp_name"], $ruta);
            if ($resultado) {
                $ban = true;
            } else {
                $error .= "Ocurrio un error al mover el pdf.";
            }
        } else {
            $error .= "PDF Excede el tamaño de $limite_kb Kilobytes";
        }
    }
    if ($ban) {
        $sqlUpdateProduct = "UPDATE $tProduct SET nombre='$nombre', precio_raiz='$precioR', precio_franquicia='$precioF', precio_cotizador='$precioC', precio_publico='$precioP', cant_minima='$cantMin', codigo_barras='$codBar', pdf='$docName', descripcion='$descrip', categoria_id='$categoria', subcategoria_id='$subCategoria', updated='$dateNow', updated_by_user_id='$userId' WHERE id='$productId' ";
        if ($con->query($sqlUpdateProduct) === TRUE) {
            echo "true";
        } else {
            echo "Error al modificar producto<br>" . $con->error;
        }
    } else {
        echo $error;
    }
} else {
    $sqlUpdateProduct = "UPDATE $tProduct SET nombre='$nombre', precio_raiz='$precioR', precio_franquicia='$precioF', precio_cotizador='$precioC', precio_publico='$precioP', cant_minima='$cantMin', codigo_barras='$codBar', descripcion='$descrip', categoria_id='$categoria', subcategoria_id='$subCategoria', updated='$dateNow', updated_by_user_id='$userId' WHERE id='$productId' ";
    if ($con->query($sqlUpdateProduct) === TRUE) {
        echo "true";
    } else {
        echo "Error al modificar producto<br>" . $con->error;
    }
}
?>