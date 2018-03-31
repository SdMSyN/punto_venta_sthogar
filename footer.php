				
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Iniciar Sesión</h4>
            </div>
            <div class="error"></div>
            <div class="modal-body">
                <form class="popup-form" id="formLogin" method="POST">
                    <input type="text" class="form-control form-white" placeholder="Usuario" id="inputUser" name="inputUser">
                    <input type="password" class="form-control form-white" placeholder="Contraseña" id="inputPass" name="inputPass">
                    <button type="submit" class="btn btn-primary btn-submit">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    </div>
</div>

</div><!-- /container -->   
<div class="footer">
    &copy; <a href="http://st-hogar.com">ST-HOGAR</a>,
    <p>Desarrollado por <a href="http://solucionesynegocios.com.mx" target="_blank" ><b>Software de México: Soluciones y Negocios S.A.S. de C.V.</b></a> 2015</p>
</div>
<div class="contacto text-center">
    <a href="contacto.php">CONTACTO</a><br>
    <i>Cel: 246-116-36-37</i>
</div>

<script type="text/javascript">
    $('#loading').hide();
    $(document).ready(function () {
        $('#formLogin').validate({
            rules: {
                inputUser: {required: true},
                inputPass: {required: true}
            },
            messages: {
                inputUser: "Usuario obligatorio",
                inputPass: "Contraseña obligatoria"
            },
            tooltip_options: {
                inputUser: {trigger: "focus", placement: 'right'},
                inputPass: {trigger: "focus", placement: 'right'}
            },
            beforeSend: function () {
                $('.msg').html('loading...');
            },
            submitHandler: function (form) {
                $('#loading').show();
                $.ajax({
                    type: "POST",
                    url: "cotizador/controllers/login_user.php",
                    data: $('form#formLogin').serialize(),
                    success: function (msg) {
                        console.log(msg);
                        var msg = jQuery.parseJSON(msg);
                        if (msg.error == 0) {
                            if (msg.perfil == 1)//Administrador
                                location.href = "cotizador/index_admin.php";
                            else if (msg.perfil == 2)//Cotizador
                                location.href = "cotizador/form_price.php";
                            else if (msg.perfil == 3)//Vendedor
                                location.href = "cotizador/form_login_store.php";
                            else if (msg.perfil == 4)//Franquicia
                                location.href = "cotizador/form_login_storeA.php";
                            else
                                location.href = "#";
                        } else {
                            $('.error').html(msg.msgErr);
                        }
                    },
                    error: function () {
                        alert("Error al iniciar sesión de usuario");
                    }
                });
            }
        });

    });
</script>

</body>
</html>