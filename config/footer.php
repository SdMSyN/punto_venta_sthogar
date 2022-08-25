<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Sydney
 */
?>
			</div>
		</div>
	</div><!-- #content -->

	<?php do_action('sydney_before_footer'); ?>

	<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
		<?php get_sidebar('footer'); ?>
	<?php endif; ?>

	<?php $container 	= get_theme_mod( 'footer_credits_container', 'container' ); ?>
	<?php $credits 		= sydney_footer_credits(); ?>

	<footer id="colophon" class="site-footer">
		<div class="<?php echo esc_attr( $container ); ?>">
			<div class="site-info">
				<div class="row">
					<div class="col-md-6">
						<?php echo wp_kses_post( $credits ); ?>
					</div>
					<div class="col-md-6">
						<?php sydney_social_profile( 'social_profiles_footer' ); ?>
					</div>					
				</div>
			</div>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->

	<?php do_action('sydney_after_footer'); ?>

<!-- Modal de inicio de sesion -->
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

</div><!-- #page -->

<?php wp_footer(); ?>

<script type="text/javascript">
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
            submitHandler: function (form) {
                $('#loading').show();
                $.ajax({
                    type: "POST",
                    url: "../../../../cotizador/controllers/login_user.php",
                    data: $('form#formLogin').serialize(),
                    success: function (msg) {
                        console.log(msg);
                        var msg = jQuery.parseJSON(msg);
                        if (msg.error == 0) {
                            if (msg.perfil == 1)//Administrador
                                location.href = "../../../../cotizador/index_admin.php";
                            else if (msg.perfil == 2)//Cotizador
                                location.href = "../../../../cotizador/form_price.php";
                            else if (msg.perfil == 3)//Vendedor
                                location.href = "../../../../cotizador/form_login_store.php";
                            else if (msg.perfil == 4)//Franquicia
                                location.href = "../../../../cotizador/form_login_storeA.php";
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
