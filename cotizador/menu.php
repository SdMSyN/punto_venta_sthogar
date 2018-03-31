<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Menu</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <?php
      if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == "1") {
        if (isset($_SESSION['sessA'])) {
          ?>
          <a class="navbar-brand" href="index_admin.php">Inicio</a>
          <?php
        } else {
          ?>
          <!-- <a class="navbar-brand" href="form_sales.php">Inicio</a>
          <a class="navbar-brand" href="form_orders.php">Pedidos</a>
          <a class="navbar-brand" href="form_orders_est.php">Seguimiento de pedidos</a> -->
          <a class="navbar-brand" href="form_price.php">Inicio</a>
          <?php
        }
      } elseif (isset($_SESSION['perfil']) && $_SESSION['perfil'] == "3" && isset($_SESSION['sess'])) {
        ?>
          <a class="navbar-brand" href="../index.php">Inicio</a>
        <?php
      } else {
        ?>
        <a class="navbar-brand" href="../index.php">Inicio</a>
        <?php
      }
      ?>      
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <?php
        if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == "1" && isset($_SESSION['sessA'])) {
          ?>
          <li><a href="form_select_stock.php">Almacen</a></li>
          <li><a href="form_select_product.php">Productos</a></li>
          <li><a href="form_select_product_missing.php">Faltantes</a></li>
          <li><a href="form_select_user.php">Usuarios</a></li>
          <li><a href="form_select_store.php">Tiendas</a></li>
          <li><a href="form_select_category.php">Categorías</a></li>
          <!-- <li><a href="form_select_subcategory.php">Subcategorías</a></li> -->
          <li><a href="form_select_report.php">Reportes</a></li>
          <!-- <li><a href="form_select_report_order.php">Pedidos</a></li> -->
          <li><a href="form_select_client.php">Clientes</a></li>
          <li><a href="#.php">Cotizaciones</a></li>
          <?php
        }else if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == "4" && isset($_SESSION['sessA'])) {
          ?>
          <li><a href="form_select_product_missing.php">Faltantes</a></li>
          <li><a href="form_select_report.php">Reportes</a></li>
          <li><a href="form_select_client.php">Clientes</a></li>
          <li><a href="#.php">Cotizaciones</a></li>
          <?php
        } 
        elseif (isset($_SESSION['perfil']) && $_SESSION['perfil'] == "3" && isset($_SESSION['sess'])) {
          ?>
          <li><a href="form_orders.php">Pedidos</a></li>
          <li><a href="form_orders_est.php">Seguimiento de pedidos</a></li>
          <?php
        }
        ?>


      </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php
        if (isset($_SESSION['perfil']) && ($_SESSION['perfil'] == "1" || $_SESSION['perfil'] == 4) ) {
          echo '<li class="no-a user-name">Bienvenido ' . $_SESSION['userName'] . '</li>';
          echo '<li><a href="controllers/proc_destroy_login_admin.php">Cerrar Sesión</a></li>';
        }else if(isset($_SESSION['perfil']) && $_SESSION['perfil'] != "1"){
          echo '<li class="no-a user-name">Bienvenido ' . $_SESSION['userName'] . '</li>';
          echo '<li><a href="controllers/proc_destroy_login.php">Cerrar Sesión</a></li>';
        }else{
          //echo '<li class="no-a user-name">Bienvenido ' . $_SESSION['userName'] . '</li>';
          //echo '<li><a href="controllers/proc_destroy_login_admin.php">Cerrar Sesión</a></li>';
            echo '<li><a href="#">Invitado</a></li>';
        }
        ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
