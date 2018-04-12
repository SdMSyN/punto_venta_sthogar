<?php

include ('../config/conexion.php');
include ('../config/variables.php');
$descuento = array();
$query = $_POST['queryClient'];
$ban = false;
$msgErr = '';

$sqlGetDesc = "SELECT id, rfc, porc_desc "
        . "FROM $tClients "
        . "WHERE CONCAT_WS(' ',nombre,ap,am) LIKE '%$query%' ";
$resGetDesc = $con->query($sqlGetDesc);
if ($resGetDesc->num_rows > 0) {
    while($rowGetDesc = $resGetDesc->fetch_assoc()){
        $id = $rowGetDesc['id'];
        $rfc = $rowGetDesc['rfc'];
        $desc = $rowGetDesc['porc_desc'];
        $descuento[] = array('id' => $id, 'desc' => $desc, 'rfc' => $rfc);
    }
    $ban = true;
} else {
    $ban = false;
    $msgErr .= 'Error: No existe el cliente.';
}

if ($ban) {
    echo json_encode(array("error" => 0, "dataRes" => $descuento, "sql"=>$sqlGetDesc));
} else {
    echo json_encode(array("error" => 1, "msgErr" => $msgErr, "sql"=>$sqlGetDesc));
}

?>