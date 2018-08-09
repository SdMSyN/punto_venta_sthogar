<?php
session_start();
include('config/conexion.php');
include('header.php');
include ('menu.php');
if (!isset($_SESSION['sessA']))
    echo '<div class="row"><div class="col-sm-12 text-center"><h2>No ha iniciado sesión de Administrador</h2></div></div>';
else if ($_SESSION['perfil'] == "2")
    echo '<div class="row><div class="col-sm-12 text-center"><h2>No tienes permiso para entrar a esta sección</h2></div></div>';
else if ($_SESSION['perfil'] == "3")
    echo '<div class="row><div class="col-sm-12 text-center"><h2>No tienes permiso para entrar a esta sección</h2></div></div>';
else {
    $userId = $_SESSION['userId'];
    if ($_SESSION['perfil'] == 4) {//es franquicia
        $idStore = $_SESSION['storeId'];
    } else {
        $idStore = 0;
    }

    /* Obtenemos las tiendas */
    $sqlGetStores = "SELECT id, nombre FROM $tStore ";
    if ($idStore != 0)
        $sqlGetStores .= "WHERE id = '$idStore' ";
    $resGetStores = $con->query($sqlGetStores);
    $optStores = '<option></option>';
    if ($resGetStores->num_rows > 0) {
        while ($rowGetStores = $resGetStores->fetch_assoc()) {
            $optStores .= '<option value="' . $rowGetStores['id'] . '">' . $rowGetStores['nombre'] . '</option>';
        }
    } else {
        $optStores = '<option>No existen tiendas aún</option>';
    }
    ?>

    <!-- Cambio dinamico -->
    <div class="container">
        <div class="row">
            <div class="titulo-crud text-center">REPORTES</div>  
            <form class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Seleccione una tienda</label>
                    <div class="col-sm-4">
                        <select id="inputStore" class="form-control">
                            <?= $optStores; ?>
                        </select>
                    </div>
                </div>
            </form>
            <div class="row stock-title" >
                <div class="col-md-12 text-center" id="stockName"></div>
            </div>
            <div class="msg"></div>
            <div class="col-md-12 btnFiltros">

            </div>
            <div class="col-md-12 report" id="myPrintArea">
                <table class="table table-striped" id="tableReport">
                    <thead></thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        
        <!-- modal para ver descripción del producto -->
        <div class="modal fade bs-example-modal-lg" id="modalViewTicket" tabindex="-1" role="dialog" aria-labellebdy="myModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                        </button>
                        <h4 class="modal-title" id="exampleModalLabel">Ticket</h4>
                        <p class="msgModal"></p>
                    </div>
                        <div class="modal-body">
                            <table class="table table-striped" id="tableReport">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Producto</td>
                                        <td>Cantidad</td>
                                        <td>C.U.</td>
                                        <td>C.T.</td>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                </div>
            </div>
        </div>
    </div><!-- fin container -->

    <script type="text/javascript">
        $(document).ready(function () {

            $('#inputStore').focus();
            var selectStore = "";
            $('#inputStore').change(function () {
                selectStore = $('#inputStore').val();
                //alert(selectStore);
                $.ajax({
                    type: 'POST',
                    url: 'controllers/select_report_filter.php',
                    data: {storeId: selectStore, tarea: "filter"},
                    success: function (msg) {
                        //alert(msg);
                        $('.btnFiltros').html(msg);
                        $.ajax({
                            type: 'POST',
                            url: 'controllers/select_report_store_3.php?action=day',
                            data: $('form#formSelectReport').serialize(),
                            success: function (msg) {
                                //alert(msg);
                                //$('.report #tableReport thead').html('<tr><th>#</th><th>Producto</th><th>Categoría</th><th>C.U.</th><th>Cant.</th><th>C.F.</th><th>Donación</th><th>Vendedor</th><th>Tienda</th><th>Fecha</th><th>Hora</th></tr>');
                                $('.report #tableReport thead').html('<tr><th>#</th><th>Ticket</th><th>SubTotal</th><th>Descuento</th><th>Total</th><th>Donación</th><th>Vendedor</th><th>Tienda</th><th>Fecha</th><th>Hora</th></tr>');
                                $('.report #tableReport tbody').html(msg);
                            }
                        });//end ajax
                    }
                });//end ajax
                if (selectStore == "") {
                    $('.btnFiltros').empty();
                } else {
                    //$('.btnFiltros').html('<button onClick="'+selectStore+'">Store</button>');
                    //$('#saveButton').html('<button type="submit" class="btn btn-primary" >Guardar</button>');
                }

                $.ajax({
                    type: 'POST',
                    url: 'controllers/select_stock_name.php',
                    data: {storeId: selectStore},
                    success: function (msg) {
                        //alert(msg);
                        if (msg == "false") {
                            $('#stockName').empty();
                        } else {
                            $('#stockName').html(msg);
                        }
                    }
                });//end ajax
            });

            $('.btnFiltros').on("change", "#inputCategory", function () {
                var idCategory = $('#inputCategory').val();
                $('#printStock').attr("href", "controllers/select_report_store_stock.php?idStore=" + selectStore + "&inputCategory=" + idCategory);
            });

            $(".btnFiltros").on("click", "#generateReport", function () {
                $('body').removeClass('loaded');
                $.ajax({
                    type: 'POST',
                    url: 'controllers/select_report_store_3.php?action=filter',
                    data: $('form#formSelectReport').serialize(),
                    success: function (msg) {
                        //alert(msg);
                        $('.report #tableReport thead').html('<tr><th>#</th><th>Ticket</th><th>SubTotal</th><th>Descuento</th><th>Total</th><th>Donación</th><th>Vendedor</th><th>Tienda</th><th>Fecha</th><th>Hora</th></tr>');
                        $('.report #tableReport tbody').html(msg);
                        $('body').addClass('loaded');
                    }
                });//end ajax
            });

            $(".btnFiltros").on("click", ".reportStock", function () {
                $('body').removeClass('loaded');
                $.ajax({
                    type: 'POST',
                    url: 'controllers/select_report_stock_2.php',
                    data: $('form#formSelectReport').serialize(),
                    success: function (msg) {
                        //alert(msg);
                        $('.report #tableReport thead').html('<tr><th>#</th><th>Producto</th><th>Categoría</th><th>C.U.</th><th>Cant.</th><th>C.F.</th><th>Tienda</th><th>Fecha</th></tr>');
                        $('.report #tableReport tbody').html(msg);
                        $('body').addClass('loaded');
                    }
                });//end ajax
            });

            $(".btnFiltros").on("click", ".cleanReport", function () {
                //alert("limpiando");
                $("#inputSellers").val("");
                $("#inputMonth").val("");
                $("#inputWeek").val("");
                $("#inputDay").val("");
                $("#inputCategory").val("");
            });
            
            $('#modalViewTicket').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var idTicket = button.data('whatever');
                $.ajax({
                    type: "POST",
                    url: "controllers/select_ticket_details.php",
                    data: {idTicket: idTicket},
                    success: function (msg) {
                        console.log(msg);
                        var msg = jQuery.parseJSON(msg);
                        if (msg.error == 0) {
                            $("#modalViewTicket .modal-body tbody").html("");
                                $.each(msg.dataRes, function (i, item) {
                                    var newRow = '<tr>'
                                         + '<td>'+(i+1)+'</td>'
                                         + '<td>'+msg.dataRes[i].nombre+'</td>'
                                         + '<td>'+msg.dataRes[i].cant+'</td>'
                                         + '<td>'+msg.dataRes[i].cu+'</td>'
                                         + '<td>'+msg.dataRes[i].ct+'</td>'
                                         + '</tr>';
                                    $(newRow).appendTo("#modalViewTicket .modal-body tbody");
                                })
                        } else {
                            var newRow = '<tr><td colspan="3">' + msg.msgErr + '</td></tr>';
                            $("#modalViewTicket .modal-body tbody").html(newRow);
                        }
                    }
                })
            })
            
        });

        //$('#imprime').click(function() {
        $(".btnFiltros").on("click", "#imprime", function () {
            $("div#myPrintArea").printArea();
        });
    </script>

    <?php
}//fin else sesión
include ('footer.php');
?>