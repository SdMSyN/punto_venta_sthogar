<html>
<head>
	<script src="jquery.min.js"></script>
</head>
<body>

	<form method="post" action="">
		<input type="submit" name="boton_1" id="boton_1" value="Boton 1" dir="accion_1.php" />
		<input type="submit" name="boton_2" id="boton_2" value="Boton 2" dir="accion_2.php" />
	</form>

	<script type="text/javascript">
		$(document).ready(function () {
			$("input[type=submit]").click(function() {
				var accion = $(this).attr('dir');
				var id = $(this).attr('id');
				if(id == "boton_1") $('form').attr('target', '_blank');
				$('form').attr('action', accion);
				$('form').submit();
			});
		});
	</script>
	
</body>
</html>