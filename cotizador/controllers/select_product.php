<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');

    $ban = false;
    $msg = "";
    $productos = array();
    
    if($_GET['action'] == 'listar'){
        //$sqlGetProducts = "SELECT id, nombre, (SELECT nombre FROM $tCategory WHERE id=$tProduct.categoria_id) as categoria, (SELECT nombre FROM $tSubCategory WHERE id=$tProduct.subcategoria_id) as subcategoria, precio, img, (SELECT nombre FROM $tEst WHERE id=$tProduct.activo) as activoN, activo  FROM $tProduct  ";
        $sqlGetProducts = "SELECT productos.id as id, 
                    productos.nombre as nombre, 
                    categorias.nombre as categoria, 
                    productos.precio_raiz as precioRoot, 
                    productos.precio_franquicia as precioFranq, 
                    productos.precio_cotizador as precioCot, 
                    productos.precio_publico as precioPub, 
                    productos.precio_mayoreo as precioMay, 
                    productos.img as img, 
                    productos.pdf as pdf, 
                    estatus.nombre as activoN, 
                    productos.activo as activo, 
                    categorias.id as categoryId, 
                    productos.codigo_sat AS sat 
                FROM productos 
                INNER JOIN categorias ON productos.categoria_id=categorias.id 
                INNER JOIN estatus ON productos.activo=estatus.id  ";
        
        // Ordenar por
	    $est = ( isset( $_POST['estatus'] ) ) ? $_POST['estatus'] - 1 : 0;
        if($est >= 0) $sqlGetProducts .= " WHERE productos.activo='$est' ";
        
        //Ordenar ASC y DESC
	$vorder = (isset($_POST['orderby'])) ? $_POST['orderby'] : "";
	if($vorder != ''){
        $sqlGetProducts .= " ORDER BY ".$vorder;
	} else{
        $sqlGetProducts .= " ORDER BY categoryId, nombre ";
    }
        
        //Ejecutamos query
        $resGetProducts = $con->query($sqlGetProducts);
        // $datos = '';
        if( $resGetProducts->num_rows > 0 ){
            while ($rowGetProducts = $resGetProducts->fetch_assoc()) {
                // $datos .= '<tr>';
                // $datos .= '<td>'.$rowGetProducts['id'].'</td>';
                // $datos .= '<td><img src="' . $rutaImgProd . $rowGetProducts['img'] . '" class="img-product-list"></td>';
                // $datos .= '<td><a href="' . $rutaImgProd . $rowGetProducts['pdf'] . '" >Descargar</a></td>';
                // $datos .= '<td>'.$rowGetProducts['nombre'].'</td>';
                // $datos .= '<td>'.$rowGetProducts['categoria'].'</td>';
                // //$datos .= '<td>'.$rowGetProducts['subcategoria'].'</td>';
                // $datos .= '<td>'.$rowGetProducts['precioRoot'].'</td>';
                // $datos .= '<td>'.$rowGetProducts['precioFranq'].'</td>';
                // $datos .= '<td>'.$rowGetProducts['precioCot'].'</td>';
                // $datos .= '<td>'.$rowGetProducts['precioPub'].'</td>';
                // $datos .= '<td>'.$rowGetProducts['sat'].'</td>';
                // $datos .= '<td>'.$rowGetProducts['activoN'].'</td>';
                // $datos .= '<td><a href="form_update_product.php?id=' . $rowGetProducts['id'] . '" target="_blanck">Modificar</a></td>';
                // if($rowGetProducts['activo']==0)
                //     $datos .= '<td><a class="activate" data-id="' . $rowGetProducts['id'] . '" >Dar de alta</a></td>';
                // else
                //     $datos .= '<td><a class="delete" data-id="' . $rowGetProducts['id'] . '" >Dar de baja</a></td>';
                // $datos .= '</tr>';
                $productos[] = array( 
                    'id'          => $rowGetProducts['id'],
                    'img'         => $rowGetProducts['img'],
                    'pdf'         => $rowGetProducts['pdf'],
                    'nameProd'    => $rowGetProducts['nombre'],
                    'nameCat'     => $rowGetProducts['categoria'],
                    'precioRoot'  => $rowGetProducts['precioRoot'],
                    'precioFranq' => $rowGetProducts['precioFranq'],
                    'precioCot'   => $rowGetProducts['precioCot'],
                    'precioPub'   => $rowGetProducts['precioPub'],
                    'precioMay'   => $rowGetProducts['precioMay'],
                    'sat'         => $rowGetProducts['sat'],
                    'activo'      => $rowGetProducts['activo'],
                    'activoN'     => $rowGetProducts['activoN']
                );
                $ban = true;
            }
        } else{
            $ban = false;
            $msg = "Error: no existen productos." . $con->error;
        }
        // echo $datos;
        if( $ban ){
            echo json_encode( array( "error" => 0, "msg" => $msg, "dataRes" => $productos ) );
        } else{
            echo json_encode( array( "error" => 1, "msg" => $msg ) );
        }
    }
    
?>
