<html lang="en">
	  <head>
		<?php include ('config/variables.php'); ?>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
			<?= $tit; ?>
		</title>

		<!-- Bootstrap -->
		<link href="assets/css/application.css" rel="stylesheet">
		
		<!-- jQuery -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<!--
			<script src="assets/js/jquery.validate.min.js"></script>
			<script src="assets/js/additional-methods.min.js"></script>
			<script src="assets/js/jquery-validate.bootstrap-tooltip.min.js"></script>
		-->
		

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	  </head>
  
	<body>

		<div class="container">
			<div class="row">
				<div class="col-md-4 text-center logo"></div>	
				<div class="col-md-4 text-center logo"><a href="index.php"><img src="assets/img/logo_v7.jpg" class="img-responsive"></a></div>	
				<div class="col-md-4 text-center logo"></div>	
			</div>
			<div class="row">
				<nav class="navbar navbar-default">
					<div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collpased" data-toggle="collapse" data-target="#menu">
								<span class="sr-only">st-hogar</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a href="index.php" class="navbar-brand">Inicio</a>
						</div>
						<div class="collapse navbar-collapse" id="menu">
							<ul class="nav navbar-nav">
								<li><a href="#">CCTV</a></li>
								<li><a href="#">Automatización</a></li>
								<li><a href="#">Tecnologías comerciales</a></li>
								<li><a href="#">Gadgets</a></li>
								<li><a href="#">Domotica</a></li>
								<li><a href="#">Eléctricas</a></li>
								<li><a href="#">Vidrios</a></li>
							</ul>
						</div>
					</div>
				</nav>
			</div>
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
						<li data-target="#carousel-example-generic" data-slide-to="6"></li>
					  </ol>

				  <!-- Wrapper for slides -->
					<div class="carousel-inner" role="listbox">
						<div class="item active">
							<img src="assets/img/galeria/cctv_2.gif" class="item1">
							<div class="carousel-caption">
								<h3>CCTV</h3>
								<p></p>
							</div>
						</div>
						<div class="item">
							<img src="assets/img/galeria/automatizacion_1.gif" class="item2">
							<div class="carousel-caption">
								<h3>Automatización</h3>
								<p></p>
							</div>
						</div>
						<div class="item">
							<img src="assets/img/galeria/tecnologias_1.jpg" class="item3">
							<div class="carousel-caption">
								<h3>Tecnologías Comerciales</h3>
								<p></p>
							</div>
						</div>
						<div class="item">
							<img src="assets/img/galeria/gadget_2.jpg" class="item4">
							<div class="carousel-caption">
								<h3>Gadgets para el hogar</h3>
								<p></p>
							</div>
						</div>
						<div class="item">
							<img src="assets/img/galeria/domotica_1.jpg" class="item5">
							<div class="carousel-caption">
								<h3>Domotica</h3>
								<p></p>
							</div>
						</div>
						<div class="item">
							<img src="assets/img/galeria/electrica_2.jpg" class="item6">
							<div class="carousel-caption">
								<h3>Eléctricas</h3>
								<p></p>
							</div>
						</div>
						<div class="item">
							<img src="assets/img/galeria/vidrio_1.jpg" class="item7">
							<div class="carousel-caption">
								<h3>Vidrios</h3>
								<p></p>
							</div>
						</div>
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
			
			<div class="row">
				<div class="col-sm-12 textItem0" >
					<h3>
					Soluciones Tecnologicas para el hogar
					</h3>
				</div>
				<div class="col-sm-12 textItem1" style="display: none">
					<h3>
					Soluciones CCTV
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
			</div>
			<div class="footer">
				&copy; <a href="http://softlutions.biz">SOFTLUTIONS</a>, Mayo, 2015.
			</div>
		</div><!-- /container -->   
	
		<div class="contacto">
			<a href="contacto.php">CONTACTO</a>
		</div>
	
	<script>
		$(document).ready(function(){
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
	
	</body>
</html>