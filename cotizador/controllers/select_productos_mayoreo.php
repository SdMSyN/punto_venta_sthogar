<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');

    $ban = false;
    $msg = "";
    $productos = array();
    
    $sqlGetProducts = "SELECT productos.id AS id, 
                    productos.nombre AS producto, 
                    categorias.nombre AS categoria, 
                    productos.precio_raiz AS precioRoot, 
                    productos.precio_mayoreo AS precioMay,  
                    categorias.id AS categoryId
                FROM productos 
                INNER JOIN categorias ON productos.categoria_id=categorias.id ";
        
        
        
    //Ejecutamos query
    $resGetProducts = $con->query( $sqlGetProducts );
    if( $resGetProducts->num_rows > 0 ){
        while ( $rowGetProducts = $resGetProducts->fetch_assoc() ) {
            // $productos[] = array( 
            //     'idProducto'  => $rowGetProducts['id'],
            //     'nameProd'    => $rowGetProducts['nombre'],
            //     'nameCat'     => $rowGetProducts['categoria'],
            //     'precioRoot'  => $rowGetProducts['precioRoot'],
            //     'precioMay'   => $rowGetProducts['precioMay'],
            //     'idCategoria' => $rowGetProducts['categoryId']
            // );
            $productos[] = [ 
                $rowGetProducts['id'], 
                utf8_encode( $rowGetProducts['categoria'] ), 
                utf8_encode( $rowGetProducts['producto'] ), 
                $rowGetProducts['precioRoot'], 
                $rowGetProducts['precioMay'], 
                $rowGetProducts['categoryId'] 
            ];

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
    
?>
