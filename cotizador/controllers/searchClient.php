<?php

include ('../config/conexion.php');
include ('../config/variables.php');
$descuento = array();
$query = $_REQUEST['query'];
$idPerfil = $_REQUEST['idPerfil'];
$ban = false;
$msgErr = '';

if($idPerfil == 3){
    $sqlGetDesc = "SELECT nombre, ap, am FROM $tClients WHERE (rfc LIKE '%{$query}%' "
        . "OR nombre LIKE '%{$query}%' OR ap LIKE '%{$query}%' OR am LIKE '%{$query}%') AND franq != '1'  ";
}else{
    $sqlGetDesc = "SELECT nombre, ap, am FROM $tClients WHERE rfc LIKE '%{$query}%' "
        . "OR nombre LIKE '%{$query}%' OR ap LIKE '%{$query}%' OR am LIKE '%{$query}%' ";
}
$resGetDesc = $con->query($sqlGetDesc);
if ($resGetDesc->num_rows > 0) {
    while ($rowGetDesc = $resGetDesc->fetch_assoc()) {
        $name = $rowGetDesc['nombre'];
        $ap = $rowGetDesc['ap'];
        $am = $rowGetDesc['am'];
        //$descuento[] = array('id' => $id, 'desc' => $porc_desc, 'rfc' => $rfc);
        $descuento[] = $name . ' ' . $ap . ' ' . $am;
    }
    $ban = true;
} else {
    $ban = false;
    $msgErr .= 'Error: No existe el cliente.';
}

/* if ($ban) {
  echo json_encode(array("error" => 0, "dataRes" => $descuento, "sql"=>$sqlGetDesc));
  } else {
  echo json_encode(array("error" => 1, "msgErr" => $msgErr, "sql"=>$sqlGetDesc));
  } */
echo json_encode($descuento);
?>