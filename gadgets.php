<?php
	include ('header.php');
?>

<title><?= $tit; ?></title>
<meta name="author" content="Luigi Pérez Calzada (GianBros)" />
<meta name="description" content="Descripción de la página" />
<meta name="keywords" content="etiqueta1, etiqueta2, etiqueta3" />

<?php
	include ('menu.php');
?>

<div class="row">
	<div class="col-sm-6 textContent">
		<h1>Gadgets</h1>
		<p>Venta y soporte para dispositivos en el hogar como: interphone, video portero, audio residencial, alarmas, sensores, chapas biométricas, control de acceso entre otro más. </p>
	</div>
	<div class="col-sm-6 table-responsive">
		<table class="table">
			<tr>
				<td><img src="img/gadgets/gadget_1.jpg" class="img-responsive img-rounded"></td>
				<td><p class="text-justify">
					<br><b>Audio residencial</b><br>
					<ul>
						<li>bluethoo</li>
						<li>wifi</li>
						<li>Teatro en casa</li>
						<li>Instalación y configuración</li>
					</ul>
				</p>
				<p>	Disfruta de la mejor calidad de audio mediante distintos medios auditivos cotiza sin compromiso
				</p></td>
			</tr>
			<tr>
				<td><p>
					<br><b>Video Portero</b>
					<ul>
						<li>Alámbrico</li>
						<li>Inalámbrico</li>
						<li>Equipado con sensores</li>
						<li>Electrochapa</li>
						<li>Contrachapa</li>
						<li>VideoIP</li>
					</ul>
				</p>
				<p>Abre tu puerta de manera remota, teniendo audio y video desde la puerta y mejor aún lo puedes hacerlo desde un teléfono móvil
				</p></td>
				<td><img src="img/gadgets/gadget_2.jpg" class="img-responsive img-rounded"></td>
			</tr>
			<tr>
				<td><img src="img/gadgets/gadget_3.jpg" class="img-responsive img-rounded"></td>
				<td><p class="text-justify">
					<br><b>Chapa Biométrica</b>
					<ul>
						<li>Control de accesos mediante tu huella digital</li>
						<li>Controla el número de personas</li>
						<li>Sin llaves</li>
						<li>Máxima Seguridad</li>
						<li>Distintos equipos y precios</li>
					</ul>
				</p>
				<p>Abre tu puerta con sólo tu huella digital, evita la perdida de llaves
				</p></td>
			</tr>
			<tr>
				<td><p class="text-justify">
					<br><b>Alarmas de </b>
					<ul>
						<li>Impacto</li>
						<li>humedad</li>
						<li>presencia</li>
						<li>apertura</li>
						<li>humedad</li>
						<li>presencia</li>
						<li>apertura</li>
						<li>gas</li>
					</ul>
				</p>
				<p>
				Mantén segura cualquier área con todo tipo de sensores y alarmar
				</p></td>
				<td><img src="img/gadgets/gadget_4.jpg" class="img-responsive img-rounded"></td>
			</tr>
		</table>
	</div>
</div>

<?php
	include ('footer.php');
?>