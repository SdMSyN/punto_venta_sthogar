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
    $productId = $_GET['id'];
    $userId = $_SESSION['userId'];

    /* obtenemos el producto */
    $sqlGetProduct = "SELECT * FROM productos WHERE id='$productId' ";
    $resGetProduct = $con->query($sqlGetProduct);
    $rowGetProduct = $resGetProduct->fetch_assoc();

    /* Obtenemos las categorias */
    $sqlGetCategories = "SELECT id, nombre FROM categorias ";
    $resGetCategories = $con->query($sqlGetCategories);
    $optCategories = '<option></option>';
    while ($rowGetCategories = $resGetCategories->fetch_assoc()) {
        if ($rowGetCategories['id'] == $rowGetProduct['categoria_id'])
            $optCategories .= '<option value="' . $rowGetCategories['id'] . '" selected>' . $rowGetCategories['nombre'] . '</option>';
        else
            $optCategories .= '<option value="' . $rowGetCategories['id'] . '">' . $rowGetCategories['nombre'] . '</option>';
    }

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

    // Obtenemos valor del dolar
    $sqlGetPrecioDolar = "SELECT 
            id_baseCtConfig, 
            config, 
            valor 
        FROM basectconfig 
        WHERE basectconfig.activo = 1
            AND basectconfig.config = 'PRECIO_DOLAR' ";
    $resGetPrecioDolar = $con->query($sqlGetPrecioDolar);
    $rowGetPrecioDolar = $resGetPrecioDolar->fetch_assoc();
    $precioDolar       = $rowGetPrecioDolar['valor'];
    $idConfigDolar     = $rowGetPrecioDolar['id_baseCtConfig'];

    ?>

    <!-- Cambio dinamico -->
    <div class="container">
        <div class="row">
            <form role="form" id="formUpdProduct" name="formUpdProduct" method="POST" >
                <legend>Modificación de datos de: <b><?= $rowGetProduct['nombre']; ?></b></legend>
                <div class="error"></div>
                <input type="hidden" name="productId" value="<?= $productId; ?>" >
                <input type="hidden" name="userId" value="<?= $userId; ?>" >
                <div class="form-group">
                    <label>Nombre: </label>
                    <input type="text" id="inputNombre" name="inputNombre" class="form-control" value="<?= $rowGetProduct['nombre']; ?>">
                </div> 
                <div class="form-group">
                    <label>Precio Base en dólares (Valor Dolar = $<?= $precioDolar; ?>)</label>
                    <input type="number" step="any" id="inputPrecioBase" name="inputPrecioBase" class="form-control" value="<?= $rowGetProduct['precio_base']; ?>">
                </div>
                <div class="form-group">
                    <label>Precio Raíz: </label>
                    <input type="number" step="any" id="inputPrecioR" name="inputPrecioR" class="form-control" value="<?= $rowGetProduct['precio_raiz']; ?>">
                </div>
                <div class="form-group">
                    <label>Precio Franquicia: </label>
                    <input type="number" step="any" id="inputPrecioFranq" name="inputPrecioFranq" class="form-control" value="<?= $rowGetProduct['precio_franquicia']; ?>">
                </div>
                <div class="form-group">
                    <label>Precio Cotizador: </label>
                    <input type="number" step="any" id="inputPrecioCot" name="inputPrecioCot" class="form-control" value="<?= $rowGetProduct['precio_cotizador']; ?>">
                </div>
                <div class="form-group">
                    <label>Precio público: </label>
                    <input type="number" step="any" id="inputPrecioPub" name="inputPrecioPub" class="form-control" value="<?= $rowGetProduct['precio_publico']; ?>">
                </div>
                <div class="form-group">
                    <label>Precio mayorista (<?= $precioMay; ?>)</label>
                    <input type="number" step="any" id="inputPrecioMay" name="inputPrecioMay" class="form-control" value="<?= $rowGetProduct['precio_mayoreo']; ?>">
                </div>
                <div class="form-group">
                    <label>Cantidad Mínima en Almacen: </label>
                    <input type="number" step="any" id="inputCantMin" name="inputCantMin" class="form-control" value="<?= $rowGetProduct['cant_minima']; ?>">
                </div>
                <div class="form-group">
                    <label>Código de Barras: </label>
                    <input type="number" id="inputCB" name="inputCB" class="form-control" value="<?= $rowGetProduct['codigo_barras']; ?>">
                </div>
                <div class="form-group">
                    <label>Código SAT: </label>
                    <input type="text" id="inputSAT" name="inputSAT" class="form-control" value="<?= $rowGetProduct['codigo_sat']; ?>">
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <label>Imagen actual</label>
                        <img src="<?= $rutaImgProd . $rowGetProduct['img']; ?>" class="img-rounded img-responsive" width="100px" >
                    </div>
                    <div class="col-sm-10">
                        <div class="form-group">           
                            <label for="exampleInputFile">Imagen: </label>
                            <input type="file" id="inputImg" name="inputImg" >
                            <p class="help-block">Tamaño Máximo 1Mb</p>
                        </div>
                    </div>
                </div><!-- end row -->
                <div class="row">
                    <div class="col-sm-2">
                        <label>PDF actual</label>
                        <a href="<?= $rutaImgProd . $rowGetProduct['pdf']; ?>" target="_blank">
                            <img src="assets/img/pdf.png" width="100px" ><br>Ver
                        </a>
                    </div>
                    <div class="col-sm-10">
                        <div class="form-group">           
                            <label for="inputPDF">PDF: </label>
                            <input type="file" id="inputPDF" name="inputPDF" >
                            <p class="help-block">Tamaño Máximo 1Mb</p>
                        </div>
                    </div>
                </div><!-- end row -->
                <div class="form-group">
                    <label>Descripción: </label>
                    <input type="text" id="inputDesc" name="inputDesc" class="form-control" value="<?= $rowGetProduct['descripcion']; ?>">
                </div>
                <div class="form-group">
                    <label>Categoría: </label>
                    <select id="inputCategoria" name="inputCategoria" class="form-control" >
                        <?= $optCategories; ?>
                    </select>
                </div>

                <a href="form_select_product.php" class="btn btn-default"><i class="fa fa-mail-reply"></i> Atras</a>
                <button type="submit" class="btn btn-primary" >Modificar producto</button>
            </form>

        </div>

    </div><!-- fin container -->

    <script type="text/javascript">
        $(document).ready(function () {

            $('#formUpdProduct').submit(function (e) {
                if ($("#inputNombre").val() == "") {
                    //alert("No puede ser vacio");
                    $("#inputNombre").tooltip({title: "Nombre del producto obligatorio", trigger: "focus", placement: 'bottom'});
                    $("#inputNombre").tooltip('show');
                    return false;
                }
                if ($("#inputPrecioBase").val() == "") {
                    //alert("No puede ser vacio");
                    $("#inputPrecio").tooltip({title: "Precio base del producto obligatorio", trigger: "focus", placement: 'bottom'});
                    $("#inputPrecio").tooltip('show');
                    return false;
                }
                if (!$("#inputPrecioBase").val().match(/^-?[0-9]+([\.][0-9]*)?$/)) {
                    // inputted file path is not an image of one of the above types
                    $("#inputPrecio").tooltip({title: "Formato de precio incorrecto", trigger: "focus", placement: 'bottom'});
                    $("#inputPrecio").tooltip('show');
                    return false;
                }
                if ($("#inputPrecioR").val() == "") {
                    //alert("No puede ser vacio");
                    $("#inputPrecio").tooltip({title: "Precio del producto obligatorio", trigger: "focus", placement: 'bottom'});
                    $("#inputPrecio").tooltip('show');
                    return false;
                }
                if (!$("#inputPrecioR").val().match(/^-?[0-9]+([\.][0-9]*)?$/)) {
                    // inputted file path is not an image of one of the above types
                    $("#inputPrecio").tooltip({title: "Formato de precio incorrecto", trigger: "focus", placement: 'bottom'});
                    $("#inputPrecio").tooltip('show');
                    return false;
                }
                if ($("#inputPrecioCot").val() == "") {
                    $("#inputPrecio").tooltip({title: "Precio del producto obligatorio", trigger: "focus", placement: 'bottom'});
                    $("#inputPrecio").tooltip('show');
                    return false;
                }
                if (!$("#inputPrecioCot").val().match(/^-?[0-9]+([\.][0-9]*)?$/)) {
                    $("#inputPrecio").tooltip({title: "Formato de precio incorrecto", trigger: "focus", placement: 'bottom'});
                    $("#inputPrecio").tooltip('show');
                    return false;
                }
                if ($("#inputDesc").val() == "") {
                    //alert("No puede ser vacio");
                    $("#inputDesc").tooltip({title: "Descripción obligatoria", trigger: "focus", placement: 'bottom'});
                    $("#inputDesc").tooltip('show');
                    return false;
                }
                if ($("#inputCategoria").val() == "") {
                    //alert("No puede ser vacio");
                    $("#inputCategoria").tooltip({title: "Debes de seleccionar una categoría", trigger: "focus", placement: 'bottom'});
                    $("#inputCategoria").tooltip('show');
                    return false;
                }
                var data = new FormData(this); //Creamos los datos a enviar con el formulario
                $.ajax({
                    url: 'controllers/update_product.php', //URL destino
                    data: data,
                    processData: false, //Evitamos que JQuery procese los datos, daría error
                    contentType: false, //No especificamos ningún tipo de dato
                    type: 'POST',
                    beforeSend: function () {
                        //$('#exampleModalLabel').append("Loading...");
                    },
                    success: function (resultado) {
                        //alert(resultado);
                        if (resultado == "true") {
                            $('.error').html("Se modifico el producto con éxito.");
                            /*setTimeout(function () {
                             location.href = 'form_select_product.php';
                             }, 3000);*/
                        } else {
                            $('.error').html(resultado);
                        }
                    }
                });
                e.preventDefault(); //Evitamos que se mande del formulario de forma convencional
            });

            $("#inputCategoria").change(function () {
                var category = $("#inputCategoria option:selected").val();
                //alert(category);
                $.ajax({
                    url: 'controllers/select_sub_from_category.php',
                    type: 'POST',
                    data: {categoryId: category},
                    success: function (res) {
                        //alert(res);
                        $("#inputSubCategoria").html("");
                        $("#inputSubCategoria").html(res);
                    }
                })
            });

            // Proponer precios a partir del precio base con el valor del dolar
            $("#inputPrecioBase").change(function(){
                let precioBase = $(this).val();
                console.log( precioBase );
                let precioRoot = precioBase * <?= $precioDolar; ?>;
                console.log(precioRoot);
                let precioFranq = precioRoot * 1.4;
                precioFranq = Number( precioFranq.toFixed( 2 ) );
                let precioCot = precioRoot * 1.6;
                precioCot = Number( precioCot.toFixed( 2 ) );
                let precioPub = precioRoot * 2.3;
                precioPub = Number( precioPub.toFixed( 2 ) );
                let precioMay = precioRoot * <?= $precioMay; ?>;
                precioMay = Number( precioMay.toFixed( 2 ) );
                $("#inputPrecioR").val(precioRoot);
                $("#inputPrecioFranq").val(precioFranq);
                $("#inputPrecioCot").val(precioCot);
                $("#inputPrecioPub").val(precioPub);
                $("#inputPrecioMay").val( precioMay );
            })

            //Proponer precios a partir del precio raíz
            $("#inputPrecioR").change(function(){
                var precioRoot = $(this).val();
                console.log(precioRoot);
                var precioFranq = precioRoot * 1.4;
                precioFranq = Number(precioFranq.toFixed(2));
                var precioCot = precioRoot * 1.6;
                precioCot = Number(precioCot.toFixed(2));
                var precioPub = precioRoot * 2.3;
                precioPub = Number(precioPub.toFixed(2));
                let precioMay = precioRoot * <?= $precioMay; ?>;
                precioMay = Number( precioMay.toFixed(2) );
                $("#inputPrecioFranq").val(precioFranq);
                $("#inputPrecioCot").val(precioCot);
                $("#inputPrecioPub").val(precioPub);
                $("#inputPrecioMay").val( precioMay );
            })

        });
    </script>

    <?php
}//fin else sesión
include ('footer.php');
?>