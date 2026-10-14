<?php
  include('config/conexion.php');
  include('config/variables.php');
  include('header.php');
  include ('menu.php');

  $idWorker = isset($_GET['id']) ? intval($_GET['id']) : 0;
  $rowGetWorker = null;
  if($idWorker > 0){
    $stmt = $con->prepare("SELECT id, nombre, ap, am, rfc, telefono, url_img, estatus, created FROM trabajadores WHERE id = ? LIMIT 1");
    if($stmt){
      $stmt->bind_param('i', $idWorker);
      $stmt->execute();
      $res = $stmt->get_result();
      if($res && $res->num_rows > 0) $rowGetWorker = $res->fetch_assoc();
      $stmt->close();
    }
  }

  if(!$rowGetWorker){
    echo '<div class="container"><div class="row"><div class="col-sm-12 text-center"><h2>No existe el trabajador</h2></div></div></div>';
    include('footer.php');
    exit;
  }

  // assets
  $bgRel = 'assets/img/fondo.jpg';
  $iconRel = 'assets/img/ico.png';
  $logo3Rel = 'assets/img/logo_3.jpg';
  $logo2Rel = 'assets/img/logo_2.jpg';

  $bg = file_exists(__DIR__ . '/' . $bgRel) ? $bgRel : '';
  $icon = file_exists(__DIR__ . '/' . $iconRel) ? $iconRel : '';
  $logo = file_exists(__DIR__ . '/' . $logo3Rel) ? $logo3Rel : (file_exists(__DIR__ . '/' . $logo2Rel) ? $logo2Rel : '');

  $photo = '';
  if(!empty($rowGetWorker['url_img']) && file_exists(__DIR__ . '/' . $rutaImgWorkers . $rowGetWorker['url_img'])){
    $photo = $rutaImgWorkers . $rowGetWorker['url_img'];
  } else {
    $defaultPhoto = 'assets/img/default_worker.png';
    if(file_exists(__DIR__ . '/' . $defaultPhoto)) $photo = $defaultPhoto;
  }

  // format created date
  $createdDate = '';
  if(!empty($rowGetWorker['created'])){
    $ts = strtotime($rowGetWorker['created']);
    if($ts !== false) $createdDate = date('d/m/Y', $ts);
  }

  // estatus label
  $estatusMap = [1=>'Activo', 0=>'Inactivo', -1=>'Eliminado'];
  $estatusLabel = isset($estatusMap[$rowGetWorker['estatus']]) ? $estatusMap[$rowGetWorker['estatus']] : 'Desconocido';
?>

  <!-- Cambio dinamico -->
  <div class="cred-wrap">
    <div class="cred-card-vertical" style="background-image: url('<?php echo $bg; ?>')">
      <div class="cred-top">
        <?php if($logo): ?>
          <img src="<?php echo $logo; ?>" class="cred-logo-top" alt="logo">
        <?php endif; ?>
      </div>

      <div class="cred-main">
        <div class="photo-col">
          <?php if($photo): ?>
            <img src="<?php echo $photo; ?>" class="worker-photo-vertical" alt="foto trabajador">
          <?php else: ?>
            <div class="no-photo-vert">Sin foto</div>
          <?php endif; ?>
        </div>
        <div class="info-col">
          <h1 class="worker-name"><?php echo htmlspecialchars($rowGetWorker['nombre'] . ' ' . $rowGetWorker['ap'] . ( !empty($rowGetWorker['am']) ? ' ' . $rowGetWorker['am'] : '' )); ?></h1>
          <p class="worker-role">TRABAJADOR</p>
          <div class="worker-data">
            <div><strong>ID:</strong> <?php echo htmlspecialchars($rowGetWorker['id']); ?></div>
            <div><strong>RFC:</strong> <?php echo htmlspecialchars($rowGetWorker['rfc']); ?></div>
            <div><strong>Tel:</strong> <?php echo htmlspecialchars($rowGetWorker['telefono']); ?></div>
            <div><strong>Alta:</strong> <?php echo htmlspecialchars($createdDate); ?></div>
            <div><strong>Estatus:</strong> <?php echo htmlspecialchars($estatusLabel); ?></div>
          </div>
        </div>
      </div>

      <div class="cred-bottom">
        <div class="bottom-left">
          <?php if($icon): ?>
            <img src="<?php echo $icon; ?>" class="cred-icon-bottom" alt="icono">
          <?php endif; ?>
        </div>
        <div class="bottom-right">
          <small>Soluciones Tecnológicas para el Hogar - ST-HOGAR</small>
        </div>
      </div>
    </div>
  </div>

  <style>
    .cred-wrap{display:flex;justify-content:center;padding:20px}
    .cred-card-vertical{width:360px;max-width:95%;background-size:cover;background-position:center;border-radius:8px;box-shadow:0 8px 24px rgba(0,0,0,.25);overflow:hidden;background-color:#ffffff}
    .cred-top{padding:12px;text-align:center;background:rgba(255,255,255,0.9)}
    .cred-logo-top{max-width:220px;height:auto}
    .cred-main{display:flex;padding:18px;align-items:flex-start}
    .photo-col{flex:0 0 140px;text-align:center}
    .worker-photo-vertical{width:120px;height:160px;object-fit:cover;border-radius:4px;border:3px solid #fff;box-shadow:0 4px 10px rgba(0,0,0,.12)}
    .no-photo-vert{width:120px;height:160px;display:flex;align-items:center;justify-content:center;background:#eee;border-radius:4px}
    .info-col{flex:1;padding-left:14px;color:#07314a}
    .worker-name{margin:0 0 6px 0;font-size:20px;color:#0b3b6b}
    .worker-role{margin:0 0 10px 0;color:#2b6b8a;font-weight:600}
    .worker-data div{margin-bottom:6px;color:#1a3b55}
    .cred-bottom{display:flex;align-items:center;justify-content:space-between;padding:10px 14px;background:rgba(255,255,255,0.9)}
    .cred-icon-bottom{max-width:48px;height:auto}
  </style>

<?php
  include ('footer.php');
?>