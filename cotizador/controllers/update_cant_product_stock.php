<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $idStock = $_GET['idStock'];
    $cantStock = $_GET['cant'];
    $i = 0;
    $ban = false;
    
    $sqlGetCantProductStock = "SELECT cantidad FROM $tStock WHERE id='$idStock' ";
    $resGetCantProductStock = $con->query($sqlGetCantProductStock);
    $rowGetCantProductStock = $resGetCantProductStock->fetch_assoc();
    $cant = $rowGetCantProductStock['cantidad'] + $cantStock;
        
    $sqlUpdateStock = "UPDATE $tStock SET cantidad = '$cant', updated = '$dateNow' WHERE id = '$idStock'  ";
    if($con->query($sqlUpdateStock) === TRUE){
        $ban = true;
    }else{
        $ban = false;
    }
    if($ban)
        echo "true";
    else
        echo "Error al actualizar cantidad en almacen.";
      
?>