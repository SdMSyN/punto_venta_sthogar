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

    // Obtenemos precio mayoreo actual
    $sqlGetPrecioMay = "SELECT 
                            id_baseCtConfig, 
                            config, 
                            valor 
                        FROM basectconfig 
                        WHERE basectconfig.activo = 1
                            AND basectconfig.config = 'PRECIO_MAYOREO' ";
    $resGetPrecioMay = $con->query($sqlGetPrecioMay);
    $rowGetPrecioMay = $resGetPrecioMay->fetch_assoc();
    $precioMay = $rowGetPrecioMay['valor'];
    $idConfig  = $rowGetPrecioMay['id_baseCtConfig'];
    ?>

    <!-- Cambio dinamico -->
    <div class="container">
        <div class="row">
            <div id="loading" >
                <img src="assets/img/loading.gif" height="300" width="400">
            </div>
        </div>
        <div class="row">
            <div class="titulo-crud text-center">
                MAYOREO 
            </div>
            <div class="col-md-12">
                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modalUpdMay">
                    Cambiar mayoreo
                </button>
            </div>	  
        </div>
        <br>
        <!-- datatable -->
        <table id="productos" class="display cell-border " style="width:100%">
        </table>

        <!-- modal precio mayoreo -->
        <div class="modal fade" id="modalUpdMay" tabindex="-1" role="dialog" aria-labellebdy="myModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                        </button>
                        <h4 class="modal-title" id="exampleModalLabel">Cambiar precio mayoreo</h4>
                        <p class="msgModal"></p>
                    </div>
                    <form id="formUpdMay" name="formUpdMay">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="idConfig" value="<?=$idConfig;?>" >
                                <label for="inputName">Precio: </label>
                                <input type="text" class="form-control" id="inputPrecioMay" name="inputPrecioMay" value="<?= $precioMay; ?>">
                                <span id="helpBlock" class="help-block">
                                    Al aplicar el cambio, perjudicarás a TODOS los productos del sistema. 
                                    Ya que se realizará un recálculo sobre el precio raíz para el precio mayoreo. 
                                </span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div><!-- fin container -->

    <script type="text/javascript">
        var ordenar = '';
        var dataSet = [ ];
        $('#loading').hide();
        $(document).ready(function () {

            var mainTable = $('#productos').DataTable( {
                // http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json
                "language":	{
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                },
                "responsive" : true,
                data: dataSet,
                columns: [
                    { title: "ID" },
                    { title: "Categoría" },
                    { title: "Producto" },
                    { title: "Precio raíz" },
                    { title: "Precio mayoreo" },
                    { title: "idCategoria" }
                ],
                columnDefs:[
                    { 
                        "targets" : [5],
                        "visible" : false,
                        "searchable" : false
                    }
                ]
            } );

            init();
            function init() {
                $.ajax({
                    type: "POST",
                    url: "controllers/select_productos_mayoreo.php",
                    success: function (msg) {
                        console.log( msg );
                        let data = jQuery.parseJSON(msg);
                        console.log( data );
                        if(data.error == 0){
                            dataSet = data.dataRes;
                            mainTable.clear().rows.add(dataSet).draw();
                        }
                    }
                });
            }

            $('#formUpdMay').validate({
                rules: {
                    inputPrecioMay: { 
                        required: true,
                        range : [ -1, 2 ]
                    }
                },
                messages: {
                    inputPrecioMay: {
                        required: "Precio mayoreo obligatorio",
                        range: "Número excedido"
                    }
                },
                tooltip_options: {
                    inputPrecioMay: { trigger: "focus", placement: "bottom" }
                },
                submitHandler: function(form){
                    $('#loading').show();
                    $.ajax({
                        type: "POST",
                        url: "controllers/update_precio_mayoreo.php",
                        data: $('form#formUpdMay').serialize(),
                        success: function(msg){
                            let data = jQuery.parseJSON(msg);
                            if( data.error == 0 ){
                                $('#loading').empty();
                                $('#loading').append('<img src="assets/img/success.png" height="300" width="400" >');
                                setTimeout(function () {
                                  location.href = 'mayoreo.php';
                                }, 1500);
                            } else{
                                $('.msgModal').css({color: "#FF0000"});
                                $('.msgModal').html(data.msgErr);
                                $('#loading').empty();
                                $('#loading').append('<img src="assets/img/error.png" height="300" width="400" ><h2>'+data.msgErr+'</h2>');
                                setTimeout(function (){
                                    $('#loading').hide();
                                }, 1500);
                            }
                        }, error: function(){
                            alert("Error al actualizar precio mayoreo");
                        }
                    });
                }
            }); // end añadir nueva materia            
            

        });
    </script>

    <?php
}//fin else sesión
include ('footer.php');
?>
