<?php
include ('../config/conexion.php');
include ('../config/variables.php');

$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');

if ($action == 'listar'){
    $ban = true;
    $msg = "";
    $trabajadores = array();

    $sqlGetWorkers = "SELECT 
            id, 
            CONCAT(nombre,' ',ap,' ',IFNULL(am,'')) as nombre, 
            rfc, 
            created, 
            estatus,
            url_img
        FROM trabajadores";

    // filtro estatus
    $est = ( isset( $_POST['estatus'] ) ) ? intval($_POST['estatus']) - 1 : -1;
    if($est > -1) $sqlGetWorkers .= " WHERE trabajadores.estatus=".$est;

    // orden seguro: permitir solo columnas conocidas
    $allowed = ['id','nombre','rfc','created'];
    $vorder = (isset($_POST['orderby'])) ? $_POST['orderby'] : '';
    if($vorder != ''){
        // basic sanitization
        $parts = explode(' ', $vorder);
        $col = $parts[0];
        $dir = (isset($parts[1]) && strtolower($parts[1]) === 'asc') ? 'ASC' : 'DESC';
        if(in_array($col, $allowed)){
            $sqlGetWorkers .= " ORDER BY " . $col . " " . $dir;
        }
    } else {
        $sqlGetWorkers .= " ORDER BY id, nombre";
    }

    $res = $con->query($sqlGetWorkers);
    if($res && $res->num_rows > 0){
        while($r = $res->fetch_assoc()){
            $trabajadores[] = array(
                'id' => $r['id'],
                'nombre' => $r['nombre'],
                'rfc' => $r['rfc'],
                'estatus' => $r['estatus'],
                'created' => $r['created']
            );
        }
    } else {
        $ban = false;
        $msg = "Error: no existen trabajadores." . $con->error;
    }

    if($ban) echo json_encode(array("error"=>0, "msg"=>$msg, "dataRes"=>$trabajadores, "sql"=>$sqlGetWorkers));
    else echo json_encode(array("error"=>1, "msg"=>$msg, "sql"=>$sqlGetWorkers));
    exit;
}

if ($action == 'create'){
    // crear trabajador con subida de imagen
    $name = isset($_POST['inputNombre']) ? trim($_POST['inputNombre']) : '';
    $ap   = isset($_POST['inputAP']) ? trim($_POST['inputAP']) : '';
    $am   = isset($_POST['inputAM']) ? trim($_POST['inputAM']) : null;
    $rfc  = isset($_POST['inputRFC']) ? trim($_POST['inputRFC']) : '';
    $tel  = isset($_POST['inputTel']) ? trim($_POST['inputTel']) : null;

    $docName = null;
    if(isset($_FILES['inputImg']) && $_FILES['inputImg']['error'] == 0){
        $file = $_FILES['inputImg'];
        $limite_kb = 1000; // 1MB
        if($file['size'] <= $limite_kb * 1024){
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $safeName = ($rfc != '') ? preg_replace('/[^A-Za-z0-9_-]/', '_', $rfc) : time();
            $docName = $safeName . '.' . $ext;
            $dest = __DIR__ . '/../' . $rutaImgWorkers . $docName;
            if(!is_dir(dirname($dest))) @mkdir(dirname($dest), 0755, true);
            if(!move_uploaded_file($file['tmp_name'], $dest)){
                echo 'Error: no se pudo mover la imagen.'; exit;
            }
        } else {
            echo 'Error: excede tamaño de '.$limite_kb.'KB'; exit;
        }
    }

    // insertar
    $stmt = $con->prepare("INSERT INTO trabajadores (nombre, ap, am, rfc, telefono, url_img, estatus, created, updated) VALUES (?,?,?,?,?,?,1,NOW(),NOW())");
    if(!$stmt){ echo 'Error prepare: '.$con->error; exit; }
    $stmt->bind_param('ssssss', $name, $ap, $am, $rfc, $tel, $docName);
    if($stmt->execute()){
        echo 'true';
    } else {
        echo 'Error al crear trabajador<br>'.$con->errno;
    }
    $stmt->close();
    exit;
}

if ($action == 'get'){
    $id = isset($_POST['id']) ? intval($_POST['id']) : (isset($_GET['id']) ? intval($_GET['id']) : 0);
    if($id <= 0){ echo json_encode(array('error'=>1,'msg'=>'Id inválido')); exit; }
    $stmt = $con->prepare("SELECT id, nombre, ap, am, rfc, telefono, url_img, estatus, created, updated FROM trabajadores WHERE id = ? LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if($res && $res->num_rows > 0){
        $row = $res->fetch_assoc();
        echo json_encode(array('error'=>0,'data'=>$row));
    } else {
        echo json_encode(array('error'=>1,'msg'=>'No encontrado'));
    }
    $stmt->close();
    exit;
}

if ($action == 'update'){
    $id   = isset($_POST['idWorker']) ? intval($_POST['idWorker']) : 0;
    if($id <= 0){ echo 'Error: id inválido'; exit; }

    $name = isset($_POST['inputNombre']) ? trim($_POST['inputNombre']) : '';
    $ap   = isset($_POST['inputAP']) ? trim($_POST['inputAP']) : '';
    $am   = isset($_POST['inputAM']) ? trim($_POST['inputAM']) : null;
    $rfc  = isset($_POST['inputRFC']) ? trim($_POST['inputRFC']) : '';
    $tel  = isset($_POST['inputTel']) ? trim($_POST['inputTel']) : null;

    // obtener imagen previa
    $oldImg = null;
    $stmtOld = $con->prepare("SELECT url_img FROM trabajadores WHERE id = ? LIMIT 1");
    if($stmtOld){
        $stmtOld->bind_param('i', $id);
        $stmtOld->execute();
        $resOld = $stmtOld->get_result();
        if($resOld && $resOld->num_rows > 0){
            $rowOld = $resOld->fetch_assoc();
            $oldImg = $rowOld['url_img'];
        }
        $stmtOld->close();
    }

    $docName = null;
    if(isset($_FILES['inputImg']) && isset($_FILES['inputImg']['error']) && $_FILES['inputImg']['error'] === UPLOAD_ERR_OK){
        $file = $_FILES['inputImg'];
        $limite_kb = 1000; // 1MB
        if($file['size'] <= $limite_kb * 1024){
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $safeName = ($rfc != '') ? preg_replace('/[^A-Za-z0-9_-]/', '_', $rfc) : time();
            $docName = $safeName . '_' . $id . '.' . $ext;
            $dest = __DIR__ . '/../' . $rutaImgWorkers . $docName;
            if(!is_dir(dirname($dest))) @mkdir(dirname($dest), 0755, true);
            if(!move_uploaded_file($file['tmp_name'], $dest)){
                echo 'Error: no se pudo mover la imagen.'; exit;
            }
        } else {
            echo 'Error: excede tamaño de '.$limite_kb.'KB'; exit;
        }
    }

    // preparar update
    if($docName !== null){
        $stmtUpd = $con->prepare("UPDATE trabajadores SET nombre=?, ap=?, am=?, rfc=?, telefono=?, url_img=?, updated=NOW() WHERE id=?");
        if(!$stmtUpd){ echo 'Error prepare: '.$con->error; exit; }
        $stmtUpd->bind_param('ssssssi', $name, $ap, $am, $rfc, $tel, $docName, $id);
    } else {
        $stmtUpd = $con->prepare("UPDATE trabajadores SET nombre=?, ap=?, am=?, rfc=?, telefono=?, updated=NOW() WHERE id=?");
        if(!$stmtUpd){ echo 'Error prepare: '.$con->error; exit; }
        $stmtUpd->bind_param('sssssi', $name, $ap, $am, $rfc, $tel, $id);
    }

    if($stmtUpd->execute()){
        // borrar imagen antigua si se reemplazó
        if($docName !== null && $oldImg && $oldImg != $docName){
            $oldPath = __DIR__ . '/../' . $rutaImgWorkers . $oldImg;
            if(is_file($oldPath)) @unlink($oldPath);
        }
        echo 'true';
    } else {
        echo 'Error al actualizar trabajador<br>'.$con->errno;
    }
    $stmtUpd->close();
    exit;
}

if($action == 'change_status'){
    $idWorker   = $_POST['userDel'];
    $estatus    = $_POST['est'];
    $stmtUpd    = $con->prepare("UPDATE trabajadores SET estatus=?, updated=NOW() WHERE id=?");
    if(!$stmtUpd){ echo 'Error prepare: '.$con->error; exit; }
    $stmtUpd->bind_param('si', $estatus, $idWorker);
    if($stmtUpd->execute()){
        echo json_encode(array('error'=>0));
    } else {
        echo json_encode(array('error'=>1,'msg'=>'Error al actualizar trabajador<br>'.$con->errno));
    }
    $stmtUpd->close();
    exit;

}

// Other actions (update, delete) may be added here later following same pattern.

echo json_encode(array('error'=>1,'msg'=>'Acción no válida'));

?>
