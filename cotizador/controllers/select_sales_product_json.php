<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
        $query=$_REQUEST['query'];
        $store=$_GET['store'];
        // Add validation and sanitization on $_POST['query'] here
        // Now set the WHERE clause with LIKE query
        //$sqlGetProduct = "SELECT nombre FROM $tProduct WHERE codigo_barras LIKE '%{$query}%' OR nombre LIKE '%{$query}%' ";
        
        //$sqlGetProduct = "SELECT (SELECT nombre FROM $tProduct WHERE id=$tStock.producto_id) as nombre FROM $tStock, $tProduct WHERE $tStock.tienda_id='$store' AND ($tProduct.nombre LIKE '%{$query}%' OR $tProduct.codigo_barras LIKE '%{$query}%' )  ";
        $sqlGetProduct = "SELECT $tProduct.id, $tProduct.nombre FROM $tProduct WHERE ($tProduct.nombre LIKE '%{$query}%' OR $tProduct.codigo_barras LIKE '%{$query}%' ) AND $tProduct.activo = 1 ";

    
    $resGetProduct = $con->query($sqlGetProduct);
    $array=array();
    if($resGetProduct->num_rows > 0){
        while($rowGetProduct = $resGetProduct->fetch_assoc()){
            $array[]=$rowGetProduct['nombre'];
        }
    }else{
        $array[0] = "";
    }
    echo json_encode($array);
?>
