<?php
	include ('header.php');
?>

<meta name="author" content="Luigi Pérez Calzada (GianBros)" />
<meta name="description" content="Formulario de contacto de st-hogar.com (Soluciones Tecnologicas)" />
<meta name="keywords" content="formulario,contacto,solucion,tecnologica,st-hogar,soluciones" />

<?php
	include ('menu.php');
?>

<div class="row">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title text-center">Encuéntranos</h3>
		</div>
		<div class="panel-body">
			<div class="col-sm-6 text-right">
				<p>
					<strong>Dirección:</strong></br>
					C. Miguel Hernández 403 Local 2<br>
					Tepetlapa, Chiautempan, Tlax.<br>
					(A la altura de Veana sobre vía corta)<br>
					Horario: 09:00 a 19:00 (L-S)
				</p>
				<p>
					<strong>Teléfonos:</strong></br>
					(Celular) 246-116-3637<br>
					(Celular) 246-177-6355<br>
					(Oficina) 46-4-83-17.
				</p>
				<p>
					<strong>Correo eléctronico:</strong></br>
					<img src="assets/img/correo_2.jpg" class="img-responsive pull-right img-rounded">
				</p>
			</div>
			<div class="col-sm-6">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1882.668175169052!2d-98.20137427534428!3d19.31120569891156!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85cfdebfc012feb7%3A0xfbb6b59be0033803!2sSt-Hogar!5e0!3m2!1ses-419!2smx!4v1522123102450" width="400" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
			</div>
		</div>
	</div>
</div>
<hr>
<div class="row">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title text-center">Encuéntranos también en Apizaco</h3>
		</div>
		<div class="panel-body">
			<div class="col-sm-6 text-right">
				<p>
					<strong>Dirección:</strong></br>
					Blvrd. Francisco I. Madero 12<br>
					Apizaco, Tlax.<br>
					Horario: 09:00 a 19:00 (L-S)
				</p>
				<p>
					<strong>Teléfonos:</strong></br>
					(Celular) 246-116-3637<br>
				</p>
				<p>
					<strong>Correo eléctronico:</strong></br>
					contactoapizaco@st-hogar.com
				</p>
			</div>
			<div class="col-sm-6">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1330.4113976823623!2d-98.14107166877443!3d19.413629374537322!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85cfdfb25c44ce65%3A0x9a291603cad56209!2sPARISINA!5e0!3m2!1ses-419!2smx!4v1522123320907" width="400" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title text-center">Formulario de contacto</h3>
		</div>
		<div class="panel-body">
			<div class="col-md-12 msg"></div>
			<form class="form-horizontal" id="formContact" name="formContact">
				<div class="form-group">
					<label for="inputName" class="col-sm-2 control-label">Nombre</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="inputName" name="inputName">
					</div>
				</div>
				<div class="form-group">
					<label for="inputMail" class="col-sm-2 control-label">Correo</label>
					<div class="col-sm-10">
						<input type="email" class="form-control" id="inputMail" name="inputMail">
					</div>
				</div>
				<div class="form-group">
					<label for="inputTel" class="col-sm-2 control-label">Teléfono</label>
					<div class="col-sm-10">
						<input type="number" class="form-control" id="inputTel" name="inputTel">
					</div>
				</div>
				<div class="form-group">
					<label for="inputComent" class="col-sm-2 control-label">Comentarios, Dudas, Sugerencias, Cotizaciones</label>
					<div class="col-sm-10">
						<textarea class="form-control" rows="4" id="inputComent" name="inputComent"></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary">Contactar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        $('#formContact').validate({
            rules: {
                inputName: {required: true},
                inputMail: {email: true},
                inputTel: {required: true, digits: true},
                inputComent: {required: true}
            },
            messages: {
                inputName: "Es obligatorio tu nombre",
                inputMail: "El formato de correo es incorrecto",
                inputTel: {
                    required: "Teléfono de contacto obligatorio",
                    digits: "Solo se aceptan números"
                },
                inputComent: "Comentario obligatorio"
            },
            tooltip_options: {
                inputName: {trigger: "focus", placement: 'bottom'},
                inputMail: {trigger: "focus", placement: 'bottom'},
                inputTel: {trigger: "focus", placement: 'bottom'},
                inputComent: {trigger: "focus", placement: 'bottom'}
            },
            submitHandler: function (form) {
                $.ajax({
                    type: "POST",
                    url: "proc_contacto.php",
                    data: $('form#formContact').serialize(),
                    success: function (msg) {
                        //alert(msg);
                        if (msg == "true") {
							$('.msg').css({color: "#009900"});
                            $('.msg').html("Se envío el mensaje con éxito.");
                            setTimeout(function () {
                                location.href = 'contacto.php';
                            }, 1500);
                        } else {
                            $('.msg').css({color: "#FF0000"});
                            $('.msg').html(msg);
                        }
                    },
                    error: function () {
                        alert("Error al enviar comentario ");
                    }
                });
            }
        });
    });
  </script>
  
<?php
	include ('footer.php');
?>