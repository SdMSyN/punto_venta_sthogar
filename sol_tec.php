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
		<h1>Tecnologías comerciales</h1>
		<p>Asesoría, inducción, venta, reparación e investigación en GPS, SMARTFONE, COMPUTADORAS, IMPRESORAS.</p>
		<p>Desarrollo de software y mantenimiento de hardware.</p>
	</div>
	<div class="col-sm-6 table-responsive">
		<table class="table">
			<caption class="text-center">Soluciones en Tecnología</caption>
			<tr>
				<td><img src="img/tecnologias/1.jpg" class="img-responsive img-rounded"></td>
				<td><p class="text-justify">
					<br><b>Sistemas computacionales</b> 
					<br>Asesoría en compra, venta e instalación de sistemas de computo y redes, con uso particular o para negocio.
				</p></td>
			</tr>
			<tr>
				<td><p>
					<br><b>Cursos personales</b>
					<br>Apoyo de manera personalizada para el manejo de computadores.
				</p></td>
				<td><img src="img/tecnologias/cursos.png" class="img-responsive img-rounded"></td>
			</tr>
			<tr>
				<td><img src="img/tecnologias/induccion.jpg" class="img-responsive img-rounded"></td>
				<td><p class="text-justify">
					<br><b>Inducciones en tecnologías comerciales</b>
					<br><ul>
						<li>Aplicaciones para móvil</li>
						<li>Redes sociales</li>
						<li>Bluetooth en carro</li>
						<li>GPS</li>
						<li>Navegadores</li>
						<li>Telefonía</li>
						<li>Portal web, página personal</li>
					</ul>
				</p></td>
			</tr>
			<tr>
				<td><p class="text-justify">
					<br><b>Publicidad Web</b>
				</p></td>
				<td><img src="img/tecnologias/publiciada.jpg" class="img-responsive img-rounded"></td>
			</tr>
			<tr>
				<td><img src="img/tecnologias/reparacion.jpg" class="img-responsive img-rounded"></td>
				<td><p class="text-justify">
					<br><b>Mantenimiento de equipo tecnologico</b>
				</p></td>
			</tr>
		</table>
	</div>
</div>

<?php
	include ('footer.php');
?>