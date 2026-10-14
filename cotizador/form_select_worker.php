<?php
session_start();
include('config/conexion.php');
include('config/variables.php');
include('header.php');
include ('menu.php');
if (!isset($_SESSION['sessA']))
  echo '<div class="row"><div class="col-sm-12 text-center"><h2>No ha iniciado sesión de Administrador</h2></div></div>';
else if ($_SESSION['perfil'] != "1")
  echo '<div class="row><div class="col-sm-12 text-center"><h2>No tienes permiso para entrar a esta sección</h2></div></div>';
else {
  $userId = $_SESSION['userId'];

  ?>

  <!-- Cambio dinamico -->
  <div class="container">
    <div class="row">
      <div class="titulo-crud text-center">
        TRABAJADORES
      </div>
      <div class="col-md-12">
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalAdd">
          Nuevo trabajador
        </button>
      </div>	  
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Nuevo Trabajador</h4>
          </div>
          <div class="error"></div>
          <form id="formAddWorker" name="formAddWorker" method="POST">
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
                <label>RFC</label>
                <input type="text" id="inputRFC" name="inputRFC" class="form-control">
              </div>
              <div class="form-group">
                <label>Teléfono</label>
                <input type="number" id="inputTel" name="inputTel" class="form-control">
              </div>
              <div class="form-group">           
                  <label for="exampleInputFile">Footografía</label>
                  <input type="file" id="inputImg" name="inputImg" >
                  <p class="help-block">Tamaño Máximo 1MB</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" >Crear trabajador</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>

    <!-- Modal Actualizar -->
    <div class="modal fade" id="myModalUpd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Modificar Trabajador</h4>
          </div>
          <div class="error"></div>
          <form id="formUpdWorker" name="formAddWorker" method="POST">
            <input type="hidden" id="idWorker" name="idWorker" value="">
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
                <label>RFC</label>
                <input type="text" id="inputRFC" name="inputRFC" class="form-control">
              </div>
              <div class="form-group">
                <label>Teléfono</label>
                <input type="number" id="inputTel" name="inputTel" class="form-control">
              </div>
              <div class="form-group">
                <label>Fotografía</label>
                <img src="" id="imgPreview" width="150" height="150" alt="Previsualización">
              </div>
              <div class="form-group">           
                  <label for="exampleInputFile">Cambiar fotografía</label>
                  <input type="file" id="inputImg" name="inputImg" >
                  <p class="help-block">Tamaño Máximo 1MB</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" >Actualizar trabajador</button>
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
          <th class="t-head-first"><span title="id">Id</span></th>
          <th class="t-head"><span title="nombre">Nombre</span></th>
          <th class="t-head"><span title="rfc">RFC</span></th>
          <th class="t-head"><span title="created">Fecha de creación</span></th>
          <th class="t-head"><span title="activo">Estatus</span></th>
          <th class="t-head-last">Acciones</th>
      </tr>
    </thead>
    <tbody></tbody>    
  </table>
  </table>

	
  </div><!-- fin container -->

  <script type="text/javascript">
		
    var ordenar = '';
    var workersImgPath = <?php echo json_encode($rutaImgWorkers); ?>;

    $(document).ready(function () {
        filtrar();
        function filtrar(){
            $.ajax({
                type: "POST",
                data: $("#frm_filtro").serialize()+ordenar,
                url: "controllers/workers.php?action=listar",
                success: function(msg){
                    console.log(msg);
                    let data = jQuery.parseJSON(msg);
                        if(data.error == 0){
                          console.log(data);
                            $("#data tbody").html("");
                            $.each(data.dataRes, function(i, item){
                                let newRow = `<tr>
                                  <td>${data.dataRes[i].id}</td>
                                  <td>${data.dataRes[i].nombre}</td>
                                  <td>${data.dataRes[i].rfc}</td>
                                  <td>${data.dataRes[i].created}</td>
                                  <td>${data.dataRes[i].estatus == 1 ? "Activo" : "Inactivo"}</td>
                                  <td>
                                    <button 
                                      type="button" 
                                      class="btn btn-default" 
                                      data-whatever="${data.dataRes[i].id}"
                                      data-toggle="modal" data-target="#myModalUpd"
                                    >
                                     <span class="glyphicon glyphicon-pencil"></span>
                                    </button> 
                                    <button type="button"
                                      class='${data.dataRes[i].estatus == 0 ? "btn btn-default activate" : "btn btn-default delete"}'
                                      data-id="${data.dataRes[i].id}">
                                        ${data.dataRes[i].estatus == 0 ? '<span class="glyphicon glyphicon-plus"></span>' : '<span class="glyphicon glyphicon-minus"></span>'}
                                    </button>
                                    <a href="credential_worker.php?id=${data.dataRes[i].id}"
                                      class="btn btn-default" 
                                    >
                                     <span class="glyphicon glyphicon-eye-open"></span>
                                    </a>
                                    <button type="button" class="btn btn-default qr-btn" data-id="${data.dataRes[i].id}" title="QR">
                                      <span class="glyphicon glyphicon-qrcode"></span>
                                    </button>
                                  </td>
                                </tr>`;
                                $(newRow).appendTo("#data tbody");
                           });
                           
                        }else{
                            let newRow = `<tr>
                                            <td></td><td>'+data.msgErr+'</td>
                                          </tr>`;
                            $("#data tbody").html(newRow);
                        }
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
            if(confirm("¿Está seguro(a) que desea dar de baja este registro?") == true){
                $.ajax({
                    type: 'POST',
                    url: 'controllers/workers.php?action=change_status',
                    data: {userDel: idUserDel, est: 0},
                    success: function(msg){
                      console.log(msg);
                      var msg = jQuery.parseJSON(msg);
                      if (msg.error == 0) {
                        $('.error').css({color: "#77DD77"});
                        $('.error').html("Se dio de baja el usuario con éxito.");
                            setTimeout(function () {
                              location.href = 'form_select_worker.php';
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
            if(confirm("¿Está seguro(a) que desea activar el registro?") == true){
                $.ajax({
                    type: 'POST',
                    url: 'controllers/workers.php?action=change_status',
                    data: {userDel: idUserDel, est: 1},
                    success: function(msg){
                        console.log(msg);
                        var msg = jQuery.parseJSON(msg);
                        if (msg.error == 0) {
                            $('.error').css({color: "#77DD77"});
                            $('.error').html("Se activo el usuario con éxito.");
                                setTimeout(function () {
                                  location.href = 'form_select_worker.php';
                                }, 3000);
                        } else {
                            $('.error').css({color: "#77dd77"});
                            $('.error').html(msg);
                        }
                    }
		              });
            }//end if confirm
        });

      $('#formAddWorker').validate({
        rules: {
          inputNombre:  { required: true },
          inputAP:      { required: true },
		      inputRFC:     { maxlength: 13 },
          inputTel:     { digits: true },
          inputImg:     { required: true, extension: "jpg|png|bmp|jpeg|gif" }
        },
        messages: {
          inputNombre : "Nombre obligatorio",
          inputAP     : "Apellido paterno obligatorio",
		      inputRFC    : "Número máximo de caracteres, 13",
          inputTel    : "Solo se aceptan dígitos",
          inputImg    : {
              required  : "Imagen obligatoria",
              extension : "Formato de imagen no valido"
          }
        },
        tooltip_options: {
          inputNombre : {trigger: "focus", placement: 'bottom'},
          inputAP     : {trigger: "focus", placement: 'bottom'},
          inputRFC    : {trigger: "focus", placement: 'bottom'},
          inputTel    : {trigger: "focus", placement: 'bottom'},
          inputImg    : {trigger: "focus", placement: 'bottom'}
        },
        submitHandler: function (form) {
          $.ajax({
            type: "POST",
            url: "controllers/workers.php?action=create",
            // data: $('form#formAddWorker').serialize(),
            data: new FormData($("form#formAddWorker")[0]),
            contentType: false,
            processData: false,
            success: function (msg) {
              //alert(msg);
              if (msg == "true") {
                $('.error').css({color: "#77DD77"});
                $('.error').html("Se creo el trabajador con éxito.");
                setTimeout(function () {
                  location.href = 'form_select_worker.php';
                }, 3000);
              } else {
                $('.error').css({color: "#FF0000"});
                $('.error').html(msg);
              }
            },
            error: function () {
              alert("Error al crear trabajador ");
            }
          });
        }
      });

      $('#myModalAdd').on('shown.bs.modal', function () {
        $('#inputNombre').focus()
      });

      $('#myModalUpd').on('shown.bs.modal', function (event) {
        $('#inputNombre').focus()
        var button = $(event.relatedTarget);
        var idWorker = button.data('whatever');
        $.ajax({
          type: "POST",
          url: "controllers/workers.php?action=get",
          data: {id: idWorker},
          success: function (msg) {
            console.log(msg);
            var msg = jQuery.parseJSON(msg);
            if (msg.error == 0) {
              let data = msg.data;
              console.log(data);
              $('#myModalUpd #idWorker').val(data.id);
              $('#myModalUpd #inputNombre').val(data.nombre);
              $('#myModalUpd #inputAP').val(data.ap);
              $('#myModalUpd #inputAM').val(data.am);
              $('#myModalUpd #inputRFC').val(data.rfc);
              $('#myModalUpd #inputTel').val(data.telefono);
              if(data.url_img){
                $('#myModalUpd #imgPreview').attr('src', workersImgPath + data.url_img);
              } else {
                $('#myModalUpd #imgPreview').attr('src', '');
              }
            } else {
              var newRow = '<div class="row">' + msg.msgErr + '</div>';
              $("#myModalUpd .modal-body").html(newRow);
            }
          }
        })
      });

      // QR modal handler (use api.qrserver.com to avoid issues with some environments)
      $(document).on('click', '.qr-btn', function(){
        var id = $(this).data('id');
        var target = 'https://st-hogar.com/cotizador/credential_worker.php?id=' + encodeURIComponent(id);
        // prefer QRServer API which works well from localhost
        var qrSrc = 'https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=' + encodeURIComponent(target);
        console.log('QR src:', qrSrc);
        $('#qrModalImg').attr('src', qrSrc).on('error', function(){
          console.error('Error loading QR image');
          $(this).attr('alt','Error al generar QR');
        });
        // update download href
        $('#qrSaveLink').attr('href', qrSrc);
        $('#qrModal').modal('show');
      });


      $('#formUpdWorker').validate({
        rules: {
          inputNombre:  { required: true },
          inputAP:      { required: true },
		      inputRFC:     { maxlength: 13 },
          inputTel:     { digits: true },
          inputImg:     {  extension: "jpg|png|bmp|jpeg|gif" }
        },
        messages: {
          inputNombre : "Nombre obligatorio",
          inputAP     : "Apellido paterno obligatorio",
		      inputRFC    : "Número máximo de caracteres, 13",
          inputTel    : "Solo se aceptan dígitos",
          inputImg    : {
              extension : "Formato de imagen no valido"
          }
        },
        tooltip_options: {
          inputNombre : {trigger: "focus", placement: 'bottom'},
          inputAP     : {trigger: "focus", placement: 'bottom'},
          inputRFC    : {trigger: "focus", placement: 'bottom'},
          inputTel    : {trigger: "focus", placement: 'bottom'},
          inputImg    : {trigger: "focus", placement: 'bottom'}
        },
        submitHandler: function (form) {
          $.ajax({
            type: "POST",
            url: "controllers/workers.php?action=update",
            data: new FormData($("form#formUpdWorker")[0]),
            contentType: false,
            processData: false,
            success: function (msg) {
              //alert(msg);
              if (msg == "true") {
                $('.error').css({color: "#77DD77"});
                $('.error').html("Se actualizó el trabajador con éxito.");
                setTimeout(function () {
                  location.href = 'form_select_worker.php';
                }, 3000);
              } else {
                $('.error').css({color: "#FF0000"});
                $('.error').html(msg);
              }
            },
            error: function () {
              alert("Error al actualizar trabajador ");
            }
          });
        }
      });



	  
    });
  </script>

  <!-- QR Modal -->
  <div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="qrModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="qrModalLabel">QR - Credencial</h4>
        </div>
        <div class="modal-body text-center">
          <img id="qrModalImg" src="" alt="QR" style="max-width:100%;height:auto">
          <p class="help-block">Escanea o guarda la imagen para abrir la credencial.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <a id="qrSaveLink" href="#" download="qr.png" class="btn btn-primary">Descargar</a>
        </div>
      </div>
    </div>
  </div>

  <?php
}//fin else sesión
include ('footer.php');
?>