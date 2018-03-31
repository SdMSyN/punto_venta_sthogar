<?php

include ('../config/conexion.php');
include ('../config/variables.php');

if ($_POST['tarea'] == "subProduct")
    $category_id = $_POST['idSubCategory'];
else if ($_POST['tarea'] == "catProduct")
    $category_id = $_POST['idCategory'];
else
    $category_id = "";

$idPerfil = $_POST['idPerfil'];
$idStore = $_POST['idStore'];

//$idStore=$_POST['idStore'];

if ($_POST['tarea'] == "catProduct"){
    if ($idPerfil == 3){//vendedor
        $sqlGetProducts = "SELECT $tProduct.img, $tProduct.id, $tProduct.nombre, "
                . "$tProduct.pdf, $tProduct.descripcion, $tProduct.precio_publico as precio "
                . "FROM $tProduct, $tStock WHERE $tStock.tienda_id='$idStore' AND  "
                . "$tStock.producto_id=$tProduct.id AND $tProduct.categoria_id='$category_id' AND "
                . "$tProduct.activo='1' ORDER BY $tProduct.nombre ";
    }else if ($idPerfil == 2 ){//cotizador
        $sqlGetProducts = "SELECT $tProduct.img, $tProduct.id, $tProduct.nombre, "
                . "$tProduct.pdf, $tProduct.descripcion, $tProduct.precio_cotizador as precio "
                . "FROM $tProduct WHERE $tProduct.categoria_id='$category_id' AND "
                . "$tProduct.activo='1' ORDER BY $tProduct.nombre ";
    }else{
        $sqlGetProducts = "SELECT $tProduct.img, $tProduct.id, $tProduct.nombre, $tProduct.pdf, $tProduct.descripcion, $tProduct.precio_publico as precio FROM $tProduct WHERE $tProduct.categoria_id='$category_id' AND $tProduct.activo='1' ORDER BY $tProduct.nombre "; 
    }
}else
//$sqlGetProducts="SELECT * FROM $tProduct WHERE subcategoria_id='$category_id' AND activo='1' ";
    $sqlGetProducts = "SELECT $tProduct.img, $tProduct.id, $tProduct.nombre FROM $tProduct WHERE $tProduct.subcategoria_id='$category_id' AND $tProduct.activo='1' ORDER BY $tProduct.nombre ";

$resGetProducts = $con->query($sqlGetProducts);
$optProducts = '';
if ($resGetProducts->num_rows > 0) {
    $i = 0;
    while ($rowGetProducts = $resGetProducts->fetch_assoc()) {
        /* $optProducts .= '<div class="col-md-2 div-img-sales"><img src="./uploads/'.$rowGetProducts['img'].'" class="clickProduct img-sales" title="'.$rowGetProducts['id'].'" width="100%">'.$rowGetProducts['nombre'].'</div>'; */
        if ($i == 0) {
            $optProducts .= '<div class="row">';
        }
        $optProducts .= '<div class="col-sm-2 div-img-sales"><img src="./uploads/' . $rowGetProducts['img'] . '" class="clickProduct img-sales" title="' . $rowGetProducts['id'] . '" width="100%"></div>'
                . '<div class="col-sm-4 text-left">'
                . '<p><b>' . $rowGetProducts['nombre'] . '</b></p>'
                . '<p>' . $rowGetProducts['descripcion'] . '<br>'
                . '<b>$ ' . $rowGetProducts['precio'] . '</b></p>'
                . '<a href="./uploads/' . $rowGetProducts['pdf'] . '" target="_blank">Informe Técnico</a>'
                . '</div>';
        $i++;
        if ($i == 2) {
            $optProducts .= '</div>';
            $i = 0;
        }
    }
} else {
    $optProducts .= '<h3>No hay productos en el almacén para esta categoría o subcategoria.</h3>';
}
echo $optProducts;
?>
