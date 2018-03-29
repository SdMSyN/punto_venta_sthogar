<?php
session_start();
include('config/conexion.php');
include('header.php');
include ('menu.php');
if (!isset($_SESSION['sessA']))
  echo '<div class="row"><div class="col-sm-12 text-center"><h2>No ha iniciado sesión de Administrador</h2></div></div>';
else if ($_SESSION['perfil'] != "1")
  echo '<div class="row><div class="col-sm-12 text-center"><h2>No tienes permiso para entrar a esta sección</h2></div></div>';
else {
  $userId = $_SESSION['userId'];

  /* Obtenemos los perfiles */
  $sqlGetPerfils = "SELECT id, perfil FROM $tPerfil ";
  $resGetPerfils = $con->query($sqlGetPerfils);
  $optPerfils = '<option></option>';
  while ($rowGetPerfils = $resGetPerfils->fetch_assoc()) {
    $optPerfils .= '<option value="' . $rowGetPerfils['id'] . '">' . $rowGetPerfils['perfil'] . '</option>';
  }
  ?>

  <!-- Cambio dinamico -->
  <div class="container">
    <div class="row">
      <div class="titulo-crud text-center">
        USUARIOS
      </div>
      <div class="col-md-12">
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalAdd">
          Nuevo Usuario
        </button>
      </div>	  
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Nuevo Usuario</h4>
          </div>
          <div class="error"></div>
          <form id="formAddUser" name="formAddUser" method="POST">
            <div class="modal-body">
              <div class="form-group">
                <label>Nombre</label>
                <input type="text" id="inputNombre" name="inputNombre" class="form-control">
              </div>              
              <div class="form-group">
                <label>Apellido Paterno</label>
                <input type="text" id="inputAP" name="inputAP" class="form-control">
              </div>
              <div class="form-group">
                <label>Apellido Materno</label>
                <input type="text" id="inputAM" name="inputAM" class="form-control">
              </div>
              <div class="form-group">
                <label>Usuario</label>
                <input type="text" id="inputUser" name="inputUser" class="form-control">
              </div>
              <div class="form-group">
                <label>Contraseña</label>
                <input type="text" id="inputPass" name="inputPass" class="form-control">
              </div>
              <div class="form-group">
                <label>Perfil</label>
                <select id="inputPerfil" name="inputPerfil" class="form-control">
                  <?= $optPerfils; ?>
                </select>
              </div>
			  <div class="form-group">
                <label>RFC</label>
                <input type="text" id="inputRFC" name="inputRFC" class="form-control">
              </div>
              <div class="form-group">
                <label>Dirección</label>
                <input type="text" id="inputDir" name="inputDir" class="form-control">
              </div>
              <div class="form-group">
                <label>Número Interior</label>
                <input type="text" id="inputNumInt" name="inputNumInt" class="form-control">
              </div>
              <div class="form-group">
                <label>Número Exterior</label>
                <input type="text" id="inputNumExt" name="inputNumExt" class="form-control">
              </div>
              <div class="form-group">
                <label>Colonia</label>
                <input type="text" id="inputCol" name="inputCol" class="form-control">
              </div>
              <div class="form-group">
                <label>Municipio</label>
                <input type="text" id="inputMun" name="inputMun" class="form-control">
              </div>
              <div class="form-group">
                <label>Teléfono</label>
                <input type="number" id="inputTel" name="inputTel" class="form-control">
              </div>
              <div class="form-group">
                <label>Celular</label>
                <input type="number" id="inputCel" name="inputCel" class="form-control">
              </div>
              <div class="form-group">
                <label>Fecha de nacimiento</label>
                <input type="date" id="inputNacimiento" name="inputNacimiento"  class="form-control">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" >Crear usuario</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <br>
  <div class="col-sm-12">
    <form id="frm_filtro" method="post" action="" class="form-inline">
        <div class="form-group">
          <select id="estatus" name="estatus" class="form-control">
            <option value="0"></option>
            <option value="1">Desactivo</option>
            <option value="2">Activo</option>
          </select>
        </div>
        <button type="button" id="btnfiltrar" class="btn btn-success">Filtrar</button>
        <a href="javascript:;" id="btncancel" class="btn btn-default">Todos</a>

      </form>
  </div>
  <table class="table table-striped" id="data">
    <thead>
      <tr>
          <!--<th class="t-head-first"><span title="id">Id</span></th>-->
          <th class="t-head"><span title="nombre">Nombre</span></th>
          <th class="t-head"><span title="rfc">RFC</span></th>
          <!-- <th class="t-head"><span title="created">Fecha de creación</span></th> -->
          <th class="t-head"><span title="perfil_id">Perfil</span></th>
          <th class="t-head">Mensajes</th>
          <th class="t-head"><span title="activo">Estatus</span></th>
        <th class="t-head">Modificar</th>
        <th class="t-head-last">Eliminar</th>
      </tr>
    </thead>
    <tbody>
      <!--<?= $optUsers; ?>-->
    </tbody>    
  </table>
  </table>

  <!-- Modal addMensaje -->
    <div class="modal fade" id="modalAddMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Nuevo Mensaje</h4>
          </div>
          <div class="error"></div>
          <form id="formAddMessage" name="formAddMessage" method="POST">
			<input type="hidden" id="inputIdUser" name="inputIdUser">
            <div class="modal-body">
              <div class="form-group">
                <label>Mensaje: <p id="countAv"><i>0/999</i></p></label>
                <textarea class="form-control" rows="5" id="inputMessage" name="inputMessage"></textarea>
				<i>Se acepta HTML</i>
              </div>       
            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" >Añadir</button>
              </div>
          </form>
        </div>
      </div>
    </div>
	
	<!-- modal para ver asignaciones -->
	<div class="modal fade" id="modalViewMessage" tabindex="-1" role="dialog" aria-labellebdy="myModal" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
					</button>
					<h4 class="modal-title" id="exampleModalLabel">Asignaciones</h4>
					<p class="msgModal"></p>
				</div>
				<div class="modal-body">
					
				</div>
			</div>
		</div>
	</div>
	
  </div><!-- fin container -->

  <script type="text/javascript">
	/* Script para contar caracteres faltantes:
	http://mysticalpotato.wordpress.com/2012/10/27/contador-de-caracteres-para-textarea-al-estilo-twitter-con-jquery/ */
	init_contadorTa("inputMessage","countAv", 999);
	function init_contadorTa(idtextarea, idcontador, max){
		$("#"+idtextarea).keyup(function(){
				updateContadorTa(idtextarea, idcontador, max);
		});
		$("#"+idtextarea).change(function(){
				updateContadorTa(idtextarea, idcontador, max);
		});
	}
	function updateContadorTa(idtextarea, idcontador, max){
		var contador= $("#"+idcontador);
		var ta= $("#"+idtextarea);
		contador.html("0/"+max);
		contador.html(ta.val().length+"/"+max);
		if(parseInt(ta.val().length) > max){
				ta.val(ta.val().substring(0, max-1));
				contador.html(max+"/"+max);
		}
	}
		
    var ordenar = '';
    $(document).ready(function () {
        filtrar();
        function filtrar(){
            $.ajax({
                type: "POST",
                data: $("#frm_filtro").serialize()+ordenar,
                url: "controllers/select_user.php?action=listar",
                success: function(msg){
                    //$("#data tbody").empty();
                    $("#data tbody").html(msg);
                }
            });
        }
        
        //Ordenar ASC y DESC header tabla
        $("#data th span").click(function(){
            if($(this).hasClass("desc")){
                $("#data th span").removeClass("desc").removeClass("asc");
                $(this).addClass("asc");
                ordenar = "&orderby="+$(this).attr("title")+" asc";
            }else{
                $("#data th span").removeClass("desc").removeClass("asc");
                $(this).addClass("desc");
                ordenar = "&orderby="+$(this).attr("title")+" desc";
            }
            filtrar();
        });
        
        //Ordenar por formulario
        $("#btnfiltrar").click(function(){ 
            filtrar();
            //alert("y ahora?");
        });
        
        // boton cancelar
		$("#btncancel").click(function(){ 
            $("#frm_filtro select").find("option[value='0']").attr("selected",true)
            filtrar() 
	});
        
        
      $("#data tbody").on("click", ".delete", function(){
            var idUserDel = $(this).data('id');
            //alert("Eliminando..." + idUserDel);
            if(confirm("¿Está seguro(a) que desea dar de baja este registro?") == true){
                $.ajax({
                    type: 'POST',
                    url: 'controllers/delete_user.php',
                    data: {userDel: idUserDel, est: 1},
                    success: function(msg){
                        //alert(msg);
                        if (msg == "true") {
                            $('.error').html("Se dio de baja el usuario con éxito.");
                                setTimeout(function () {
                                  location.href = 'form_select_user.php';
                                }, 3000);
                        } else {
                            $('.error').css({color: "#FF0000"});
                            $('.error').html(msg);
                        }
                    }
		});
            }//end if confirm
        });
        $("#data tbody").on("click", ".activate", function(){
            var idUserDel = $(this).data('id');
            //alert("Eliminando..." + idUserDel);
            if(confirm("¿Está seguro(a) que desea activar el registro?") == true){
                $.ajax({
                    type: 'POST',
                    url: 'controllers/delete_user.php',
                    data: {userDel: idUserDel, est: 0},
                    success: function(msg){
                        //alert(msg);
                        if (msg == "true") {
                            $('.error').css({color: "#77DD77"});
                            $('.error').html("Se activo el usuario con éxito.");
                                setTimeout(function () {
                                  location.href = 'form_select_user.php';
                                }, 3000);
                        } else {
                            $('.error').css({color: "#77dd77"});
                            $('.error').html(msg);
                        }
                    }
		});
            }//end if confirm
        });

      $('#formAddUser').validate({
        rules: {
          inputNombre: {required: true},
          inputAP: {required: true},
          inputAM: {required: true},
          //inputUser: {required: true},
          inputPass: {required: true, digits: true},
          inputPerfil: {required: true},
		  inputRFC: {maxlength: 13},
          //inputDir: {required: true},
          //inputNumInt: {required: true},
          //inputNumExt: {required: true},
          //inputCol: {required: true},
          //inputMun: {required: true},
          inputTel: {digits: true},
          inputCel: {digits: true}
          //inputNacimiento: {required: true}
        },
        messages: {
          inputNombre: "Nombre obligatorio",
          inputAP: "Apellido paterno obligatorio",
          inputAM: "Apellido materno obligatorio",
          inputPass: {
            required: "Contraseña obligatoria",
            digits: "La contraseña solo permite dígitos"
          },
          inputPerfil: "Debes seleccionar un perfil para el usuario",
		  inputRFC: "Número máximo de caracteres, 13",
          inputTel: "Solo se aceptan dígitos",
          inputCel: "Solo se aceptan dígitos"
        },
        tooltip_options: {
          inputCategory: {trigger: "focus", placement: 'bottom'},
          inputCategory: {trigger: "focus", placement: 'bottom'},
          inputNombre: {trigger: "focus", placement: 'bottom'},
          inputAP: {trigger: "focus", placement: 'bottom'},
          inputAM: {trigger: "focus", placement: 'bottom'},
          inputPass: {trigger: "focus", placement: 'bottom'},
          inputPerfil: {trigger: "focus", placement: 'bottom'},
          inputRFC: {trigger: "focus", placement: 'bottom'},
          inputTel: {trigger: "focus", placement: 'bottom'},
          inputCel: {trigger: "focus", placement: 'bottom'}
        },
        submitHandler: function (form) {
          $.ajax({
            type: "POST",
            url: "controllers/create_user.php",
            data: $('form#formAddUser').serialize(),
            success: function (msg) {
              //alert(msg);
              if (msg == "true") {
                $('.error').css({color: "#77DD77"});
                $('.error').html("Se creo el usuario con éxito.");
                setTimeout(function () {
                  location.href = 'form_select_user.php';
                }, 3000);
              } else {
                $('.error').css({color: "#FF0000"});
                $('.error').html(msg);
              }
            },
            error: function () {
              alert("Error al crear usuario ");
            }
          });
        }
      });
      $('#myModalAdd').on('shown.bs.modal', function () {
        $('#inputNombre').focus()
      });
      $('#myModalUpd').on('shown.bs.modal', function () {
        $('#inputNombre').focus()
      });
	  
	  $('#data tbody').on('click', ".addMessage", function (event){
		  var idUserM = $(this).data('id');
		  console.log(idUserM);
		  $("#inputIdUser").val(idUserM);
	  });
	  
	  $('#formAddMessage').validate({
        rules: {
          inputMessage: {required: true}
        },
        messages: {
          inputMessage: "Mensaje obligatorio"
        },
        tooltip_options: {
          inputMessage: {trigger: "focus", placement: 'bottom'}
        },
        submitHandler: function (form) {
          $.ajax({
            type: "POST",
            url: "controllers/create_message.php",
            data: $('form#formAddMessage').serialize(),
            success: function (msg) {
			  console.log(msg);
			  var msg = jQuery.parseJSON(msg);
              if (msg.error == 0) {
                $('.error').css({color: "#77DD77"});
                $('.error').html("Se creo el mensaje con éxito.");
                setTimeout(function () {
                  location.href = 'form_select_user.php';
                }, 3000);
              } else {
                $('.error').css({color: "#FF0000"});
                $('.error').html(msg.error);
              }
            },
            error: function () {
              alert("Error al crear mensaje ");
            }
          });
        }
      });
	  
	  $("#modalViewMessage").on('show.bs.modal', function(event){
		  var button = $(event.relatedTarget);
		  var recipient = button.data('whatever');
		  console.log(recipient);
		  $.ajax({
			  type: "POST",
			  data: {idUser: recipient},
			  url: "controllers/view_messages.php",
			  success: function(msg){
				  console.log(msg);
				  var msg = jQuery.parseJSON(msg);
				  console.log(msg);
				  var infoMess = '<table class="table table-hover"><thead>';
				  infoMess += '<tr><th>Mensaje</th><th>Fecha</th></tr>';
				  infoMess += '</thead><tbody>';
				  if(msg.error == 0){
					  $("#modalViewMessage .modal-body").html("");
					  $.each(msg.dataRes, function(i, item){
						  infoMess += '<tr>'
						  + '<td>'+msg.dataRes[i].mess+'</td>'
						  + '<td>'+msg.dataRes[i].fecha+'</td>'
						  + '</tr>';
					  })
				  }else{
					  infoMess += '<tr><td colspan=2>No hay mensajes</td></tr>';
				  }
				  infoMess += '</tbody></table>';
				  $("#modalViewMessage .modal-body").html(infoMess);
			  }
		  })
	  })
	  
    });
  </script>

  <?php
}//fin else sesión
include ('footer.php');
?>