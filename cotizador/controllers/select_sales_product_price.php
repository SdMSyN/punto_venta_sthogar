<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $product_id=$_POST['idProduct'];
    $idPerfil = $_POST['idPerfil'];
    
	if ($idPerfil == 0 || $idPerfil == 3)
            $sqlGetProduct="SELECT id, nombre, precio_publico as precio FROM $tProduct WHERE id='$product_id' ";
        else if ($idPerfil == 2 )
            $sqlGetProduct="SELECT id, nombre, precio_cotizador as precio FROM $tProduct WHERE id='$product_id' ";
	else
            $sqlGetProduct="SELECT id, nombre, precio_cotizador as precio FROM $tProduct WHERE id='$product_id' ";
    //echo $sqlGetProduct;
    $resGetProduct = $con->query($sqlGetProduct);
    $optProduct='';
    if($resGetProduct->num_rows > 0){
        while($rowGetProduct = $resGetProduct->fetch_assoc()){
            $optProduct .= '<tr>';
            $optProduct .= '<td><input type="hidden" name="id[]" value="'.$rowGetProduct['id'].'">'.$rowGetProduct['nombre'].'</td>';
            $optProduct .= '<td><input type="hidden" value="'.$rowGetProduct['precio'].'"  id="inputPrecioU" name="inputPrecioU[]">'.$rowGetProduct['precio'].'</td>';
            $optProduct .= '<td><input type="number" id="inputCant" name="inputCant[]" class="form-control cant" min="1" value="1"></td>';
            $optProduct .= '<td><input type="text" id="inputPrecioF" name="inputPrecioF[]" value="'.$rowGetProduct['precio'].'" readonly class="form-control"></td>';
            $optProduct .= '<td><a class="deleteItem"><i class="fa fa-times"></i></td>';
            $optProduct .= '</tr>';
        }
    }else{
        $optProduct = "Error al introducir producto";
    }
    echo $optProduct;
?>
