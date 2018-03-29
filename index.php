<?php
	include ('header.php');
?>

<title><?= $tit; ?></title>
<meta name="author" content="Luigi Pérez Calzada (GianBros)" />
<meta name="description" content="Formulario de contacto de st-hogar.com (Soluciones Tecnologicas)" />
<meta name="keywords" content="formulario,contacto,solucion,tecnologica,st-hogar,soluciones" />

<?php
	include ('menu.php');
?>

			<div class="row">
				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
					  <!-- Indicators -->
					  <ol class="carousel-indicators">
						<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
						<li data-target="#carousel-example-generic" data-slide-to="1"></li>
						<li data-target="#carousel-example-generic" data-slide-to="2"></li>
						<li data-target="#carousel-example-generic" data-slide-to="3"></li>
						<li data-target="#carousel-example-generic" data-slide-to="4"></li>
						<li data-target="#carousel-example-generic" data-slide-to="5"></li>
						<!-- <li data-target="#carousel-example-generic" data-slide-to="6"></li>
						<li data-target="#carousel-example-generic" data-slide-to="7"></li> -->
					  </ol>

				  <!-- Wrapper for slides -->
					<div class="carousel-inner" role="listbox">
						<div class="item active">
							<a href="#">
								<img src="assets/img/galeria/logo_v7.jpg" class="item0">
								<div class="carousel-caption">
									<h3></h3>
									<p></p>
								</div>
							</a>
						</div>
						<div class="item">
							<a href="cctv.php">
								<img src="assets/img/galeria/cctv_2.gif" class="item1">
								<div class="carousel-caption">
									<h3>CCTV</h3>
									<p>Circuito cerrado de cámaras por cable o inalámbrico, revisa desde tu teléfono lo que acontece en tu hogar.</p>
								</div>
							</a>
						</div>
						<div class="item">
							<a href="pagina_construccion.php">
								<img src="assets/img/galeria/automatizacion_1.gif" class="item2">
								<div class="carousel-caption">
									<h3>Automatización</h3>
									<p>Controla ventanas, persianas , puertas y más desde tu smartphone sin moverte de tu asiento</p>
								</div>
							</a>
						</div>
						<div class="item">
							<a href="sol_tec.php">
								<img src="assets/img/galeria/tecnologias_1.jpg" class="item3">
								<div class="carousel-caption">
									<h3>Soluciones tecnologicas</h3>
									<p>Desarrollo de software y mantenimiento de hardware </p>
								</div>
							</a>
						</div>
						<div class="item">
							<a href="pagina_construccion.php">
								<img src="assets/img/galeria/gadget_2.jpg" class="item4">
								<div class="carousel-caption">
									<h3>Gadgets para el hogar</h3>
									<p>Venta y soporte para dispositivos del hogar como: interphone, video portero, audio residencial, alarmas, sensores, chapas biometrícas, control de acceso</p>
								</div>
							</a>
						</div>
						<div class="item">
							<a href="pagina_construccion.php">
								<img src="assets/img/galeria/domotica_1.jpg" class="item5">
								<div class="carousel-caption">
									<h3>Domótica</h3>
									<p>Maneja  tu casa desde tu Smartphone. Controla ventanas, persianas, focos y más desde cualquier parte</p>
								</div>
							</a>
						</div>
						<!-- <div class="item">
							<a href="pagina_construccion.php">
								<img src="assets/img/galeria/electrica_2.jpg" class="item6">
								<div class="carousel-caption">
									<h3>Eléctricas</h3>
									<p>Instalaciones eléctricas completas, sistema de tierras y manejo  de corrientes </p>
								</div>
							</a>
						</div>
						<div class="item">
							<a href="pagina_construccion.php">
								<img src="assets/img/galeria/vidrio_1.jpg" class="item7">
								<div class="carousel-caption">
									<h3>Vidrios</h3>
									<p>venta y mantenimiento de aluminio y vidrio en diferentes formatos (vitrales, templado, reflecta y más)</p>
								</div>
							</a>
						</div> -->
					</div>

				  <!-- Controls -->
					<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div><!-- /row -->
			
			<!--<div class="row descrip">
				<div class="col-sm-12 textItem0" >
					<h3>
					Soluciones Tecnologicas para el Hogar
					</h3>
				</div>
				<div class="col-sm-12 textItem1" style="display: none">
					<h3>
					Soluciones CCTV</br>
					</h3>
				</div>
				<div class="col-sm-12 textItem2" style="display: none">
					<h3>
					Soluciones en automatización
					</h3>
				</div>
				<div class="col-sm-12 textItem3" style="display: none">
					<h3>
					Soluciones en tecnologías comerciales
					</h3>
				</div>
				<div class="col-sm-12 textItem4" style="display: none">
					<h3>
					Soluciones en gadgets para el hogar
					</h3>
				</div>
				<div class="col-sm-12 textItem5" style="display: none">
					<h3>
					Domotica
					</h3>
				</div>
				<div class="col-sm-12 textItem6" style="display: none">
					<h3>
					Soluciones eléctricas
					</h3>
				</div>
				<div class="col-sm-12 textItem7" style="display: none">
					<h3>
					Soluciones en vidrios
					</h3>
				</div>
			</div>-->
	
	<script>
		$(document).ready(function(){
			$(".item0").click(function(){
				$(".textItem7").hide();
				$(".textItem6").hide();
				$(".textItem5").hide();
				$(".textItem4").hide();
				$(".textItem3").hide();
				$(".textItem2").hide();
				$(".textItem1").hide();
				$(".textItem0").show();
			});
			$(".item1").click(function(){
				$(".textItem7").hide();
				$(".textItem6").hide();
				$(".textItem5").hide();
				$(".textItem4").hide();
				$(".textItem3").hide();
				$(".textItem2").hide();
				$(".textItem0").hide();
				$(".textItem1").show();
			});
			$(".item2").click(function(){
				$(".textItem7").hide();
				$(".textItem6").hide();
				$(".textItem5").hide();
				$(".textItem4").hide();
				$(".textItem3").hide();
				$(".textItem1").hide();
				$(".textItem0").hide();
				$(".textItem2").show();
			});
			$(".item3").click(function(){
				$(".textItem7").hide();
				$(".textItem6").hide();
				$(".textItem5").hide();
				$(".textItem4").hide();
				$(".textItem2").hide();
				$(".textItem1").hide();
				$(".textItem0").hide();
				$(".textItem3").show();
			});
			$(".item4").click(function(){
				$(".textItem7").hide();
				$(".textItem6").hide();
				$(".textItem5").hide();
				$(".textItem2").hide();
				$(".textItem3").hide();
				$(".textItem1").hide();
				$(".textItem0").hide();
				$(".textItem4").show();
			});
			$(".item5").click(function(){
				$(".textItem7").hide();
				$(".textItem6").hide();
				$(".textItem2").hide();
				$(".textItem4").hide();
				$(".textItem3").hide();
				$(".textItem1").hide();
				$(".textItem0").hide();
				$(".textItem5").show();
			});
			$(".item6").click(function(){
				$(".textItem7").hide();
				$(".textItem2").hide();
				$(".textItem5").hide();
				$(".textItem4").hide();
				$(".textItem3").hide();
				$(".textItem1").hide();
				$(".textItem0").hide();
				$(".textItem6").show();
			});
			$(".item7").click(function(){
				$(".textItem2").hide();
				$(".textItem6").hide();
				$(".textItem5").hide();
				$(".textItem4").hide();
				$(".textItem3").hide();
				$(".textItem1").hide();
				$(".textItem0").hide();
				$(".textItem7").show();
			});
		})
	</script>

<?php
	include ('footer.php');
?>