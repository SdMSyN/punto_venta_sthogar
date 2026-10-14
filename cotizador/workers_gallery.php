<?php
  // Minimal gallery page (no header/footer) — embed in iframe
  include('config/conexion.php');
  include('config/variables.php');

  $workers = [];
  $sql = "SELECT id, nombre, ap, am, rfc, telefono, url_img, estatus, created FROM trabajadores WHERE estatus != -1 ORDER BY nombre";
  $res = $con->query($sql);
  if($res){
    while($r = $res->fetch_assoc()) $workers[] = $r;
  }
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Galería Trabajadores</title>
  <style>
    :root{--card-bg:#ffffff;--accent:#ff8b00;--muted:#6b7a86}
    html,body{height:100%;margin:0;font-family:Inter,system-ui,Arial,sans-serif;background:#f4f6f8}
    .carousel{max-width:920px;margin:20px auto;padding:12px;box-sizing:border-box}
    .viewport{position:relative;overflow:hidden;border-radius:12px}
    .slides{display:flex;transition:transform 450ms cubic-bezier(.22,.9,.3,1)}
    .slide{min-width:100%;box-sizing:border-box;padding:18px;display:flex;gap:18px;align-items:center;background:var(--card-bg);box-shadow:0 10px 30px rgba(15,23,42,0.06)}
    .slide-photo{width:300px;height:380px;object-fit:cover;border-radius:10px;background:#e9eef2;flex:0 0 300px}
    .slide-info{flex:1;padding:6px}
    .name{font-weight:700;color:#0b3b6b;margin:6px 0;font-size:20px}
    .meta{color:var(--muted);font-size:14px;margin-bottom:6px}
    .status{display:inline-block;padding:6px 10px;border-radius:999px;font-size:12px;font-weight:600}
    .status.activo{background:#e6fbf0;color:#137a3b}
    .status.inactivo{background:#fff3e6;color:#b25a00}
    .controls{display:flex;justify-content:space-between;align-items:center;margin-top:10px}
    .btn{border:0;padding:8px 12px;border-radius:8px;background:#eef2f6;color:#0b3b6b;cursor:pointer;font-weight:600}
    .btn.primary{background:var(--accent);color:#fff}
    .nav{display:flex;gap:8px}
    .dot{width:10px;height:10px;border-radius:50%;background:#d7e0e6;cursor:pointer}
    .dot.active{background:var(--accent)}

    @media(max-width:800px){
      .slide{flex-direction:column;align-items:center}
      .slide-photo{width:100%;height:280px;flex:0 0 auto}
      .slide-info{width:100%}
    }
  </style>
</head>
<body>
  <div class="carousel" id="carousel">
    <div class="viewport">
      <div class="slides" id="slides">
        <?php foreach($workers as $w):
          $photo = (!empty($w['url_img']) && file_exists(__DIR__ . '/' . $rutaImgWorkers . $w['url_img'])) ? $rutaImgWorkers . $w['url_img'] : 'assets/img/default_worker.png';
          $fullName = htmlspecialchars($w['nombre'] . ' ' . $w['ap'] . (!empty($w['am']) ? ' ' . $w['am'] : ''));
          $statusClass = ($w['estatus']==1) ? 'activo' : 'inactivo';
          $created = !empty($w['created']) ? date('d/m/Y', strtotime($w['created'])) : '-';
        ?>
          <section class="slide" data-id="<?= $w['id'] ?>">
            <img src="<?= $photo ?>" alt="<?= $fullName ?>" class="slide-photo" loading="lazy">
            <div class="slide-info">
              <div class="name"><?= $fullName ?></div>
              <div class="meta">RFC: <?= htmlspecialchars($w['rfc']) ?></div>
              <div class="meta">Tel: <?= htmlspecialchars($w['telefono']) ?></div>
              <div class="meta">Fecha ingreso: <?= htmlspecialchars($created) ?></div>
              <div style="margin-top:10px"><span class="status <?= $statusClass ?>"><?= $w['estatus']==1 ? 'Activo' : 'Inactivo' ?></span></div>
            </div>
          </section>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="controls">
      <div>
        <button id="prevBtn" class="btn">◀ Anterior</button>
        <button id="nextBtn" class="btn">Siguiente ▶</button>
      </div>
      <div class="nav" id="dots"></div>
    </div>
  </div>

  <script>
    (function(){
      const slidesEl = document.getElementById('slides');
      const slides = Array.from(slidesEl.children);
      const prev = document.getElementById('prevBtn');
      const next = document.getElementById('nextBtn');
      const dotsBox = document.getElementById('dots');
      let index = 0;
      let timer = null;
      const interval = 4000;

      function goTo(i){
        if(i < 0) i = slides.length - 1;
        if(i >= slides.length) i = 0;
        index = i;
        slidesEl.style.transform = 'translateX(' + (-index * 100) + '%)';
        updateDots();
      }

      function prevSlide(){ goTo(index - 1); }
      function nextSlide(){ goTo(index + 1); }

      function play(){ timer = setInterval(nextSlide, interval); }
      function stop(){ if(timer){ clearInterval(timer); timer = null; } }

      function updateDots(){
        const dots = dotsBox.children;
        for(let i=0;i<dots.length;i++) dots[i].classList.toggle('active', i===index);
      }

      // create dots
      slides.forEach((s, i)=>{
        const d = document.createElement('div'); d.className = 'dot' + (i===0? ' active':'');
        d.addEventListener('click', ()=>{ goTo(i); stop(); play(); });
        dotsBox.appendChild(d);
      });

      prev.addEventListener('click', ()=>{ prevSlide(); stop(); play(); });
      next.addEventListener('click', ()=>{ nextSlide(); stop(); play(); });

      // pause on hover
      const carousel = document.getElementById('carousel');
      carousel.addEventListener('mouseenter', stop);
      carousel.addEventListener('mouseleave', play);

      // keyboard
      document.addEventListener('keydown', function(e){ if(e.key==='ArrowLeft') prevSlide(); else if(e.key==='ArrowRight') nextSlide(); });

      // start
      if(slides.length > 0) goTo(0);
      play();
    })();
  </script>

</body>
</html>
