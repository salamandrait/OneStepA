<?php
if (strlen(session_id()) < 1) 
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> One Step || Admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 4.3.1 -->
    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap.min.css">
    
    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="../public/css/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="../public/css/jquery-ui.theme.min.css">
    <link rel="stylesheet" type="text/css" href="../public/css/jquery-ui.structure.min.css">
        <!-- Theme style -->
    <link rel="stylesheet" type="text/css" href="../public/AdminLTE/AdminLTE.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="../public/css/font-awesome.css">
      <!-- Ionicons -->
    <link rel="stylesheet" type="text/css" href="../public/Ionicons/css/ionicons.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->

    <link rel="stylesheet"       type="text/css" href="../public/css/_all-skins.min.css">
    <link rel="apple-touch-icon" type="text/css" href="../public/img/apple-touch-icon.png">
    <link rel="shortcut icon"    type="text/css" href="../public/img/favicon.ico">
    
    <link rel="stylesheet"       type="text/css" href="../public/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet"       type="text/css" href="../public/css/bootstrap-select.min.css">
    <link rel="stylesheet"       type="text/css" href="../public/css/vex.css">
    <link rel="stylesheet"       type="text/css" href="../public/css/vex-theme-os.css">
    <link rel="stylesheet"       type="text/css" href="../public/css/alertify.min.css">
    <link rel="stylesheet"       type="text/css" href="../public/css/themes/semantic.rtl.min.css">

    <link rel="stylesheet"       type="text/css" href="../public/css/nice-select.css">
    <link rel="stylesheet"       type="text/css" href="../public/css/select2.min.css">
    <link rel="stylesheet"       type="text/css" href="../public/css/select2.css">

    <!-- DATATABLES -->
    <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">    
    <link rel="stylesheet" type="text/css" href="../public/datatables/buttons.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="../public/datatables/responsive.dataTables.min.css" />

  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header"><!-- Logo -->
        <a href="escritorio.php" class="logo"><!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>O</b>S Admin</span><!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>One Step Administrativo</b></span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation"><!-- Header Navbar: style can be found in header.less -->   
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"><!-- Sidebar toggle button-->
            <span class="sr-only">Navegación</span>    
          </a>
          <div class="navbar-custom-menu"><!-- Navbar Right Menu -->
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->       
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../files/usuarios/<?php echo $_SESSION['imagen'];?>" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo $_SESSION['desc_usuario'];?></span>
                </a>
                <ul class="dropdown-menu">       
                  <li class="user-header"> <!-- User image -->
                    <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
                    <p><a href="http://wwww.salamandrair.com" class="text-yellow" target="_blank">wwww.salamandrair.com</a><small>Software Development Study</small>
                    <i class="fa fa-youtube-square"></i><a href="http://www.youtube.com/sit" class="text-red" target="_blank"> www.youtube.com/sit</a>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="../ajax/usuario.php?op=salir" class="btn btn btn-warning btn-sm btn-flat"><i class="fa fa-close"></i> Cerrar</a>
                </div>
                <div class="pull-left">
                  <button type="cancel" class="btn btn-danger btn-sm btn-flat" data-dismiss=""><i class="fa fa-arrow-circle-o-left"></i> Cancelar</button>          
                </div>

                
              </li>
            </ul>
            </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">       
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"></li>
          <li>
              <a href="escritorio.php">
                <i class="fa fa-desktop text-yellow"></i> <span>Escritorio</span>
                </a>
          </li>

          <li class="treeview">
          <a href="#">
              <i class="fa fa-cogs text-orange"></i><span>Configuracion</span>
              <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <?php if ($_SESSION['empresa']==1){echo'<li><a href="empresa.php"><i class="fa fa-circle-o text-orange"></i> Datos Empresa</a></li>';}?> 
                  <?php if ($_SESSION['usuario']==1){echo'<li><a href="usuario.php"><i class="fa fa-circle-o text-orange"></i> Usuarios</a></li>';}?> 
                  <?php if ($_SESSION['pais']==1){echo'<li><a href="pais.php"><i class="fa fa-circle-o text-orange"></i> Pais</a></li>';}?> 
                  <?php if ($_SESSION['moneda']==1){echo'<li><a href="moneda.php"><i class="fa fa-circle-o text-orange"></i> Monedas</a></li>';}?> 
                  <?php if ($_SESSION['correlativo']==1){echo'<li><a href="correlativo.php"><i class="fa fa-circle-o text-orange"></i> Series de Operaciones</a></li>';}?> 
                  <?php if ($_SESSION['operacion']==1){echo'<li><a href="operacion.php"><i class="fa fa-circle-o text-orange"></i> Tipos de Operaciones</a></li>';}?> 
                  <?php if ($_SESSION['impuesto']==1){echo'<li><a href="impuesto.php"><i class="fa fa-ticket text-orange"></i> Impuestos</a></li>';}?> 
                </ul>
            </li>
            <li class="treeview">
            <?php if ($_SESSION['inventario']==1){echo'<a href="#">
                <i class="fa fa-cubes text-aqua"></i>
                <span>Inventario</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>';}?>
                  <ul class="treeview-menu">
                    <?php if ($_SESSION['articulo']==1){echo'<li><a href="articulo.php"><i class="fa fa-circle-o text-aqua"></i>  Artículos</a></li>';}?>         
                    <?php if ($_SESSION['categoria']==1){echo'<li><a href="categoria.php"><i class="fa fa-circle-o text-aqua"></i> Categorías</a></li>';}?>
                    <?php if ($_SESSION['unidad']==1){echo'<li><a href="unidad.php"><i class="fa fa-circle-o text-aqua"></i> Unidades</a></li>';}?>
                    <?php if ($_SESSION['deposito']==1){echo'<li><a href="deposito.php"><i class="fa fa-circle-o text-aqua"></i> Depositos</a></li>';}?>
                  </ul>
          </li>
          <li class="treeview">
          <?php if ($_SESSION['opinventario']==1){echo'<a href="#">
            <i class="fa fa-bar-chart text-yellow"></i><span> Op. de Inventario</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>';}?>
              <ul class="treeview-menu">
              <?php if ($_SESSION['ajuste']==1){echo'<li><a href="ajuste.php"><i class="fa fa-circle-o"></i> Ajuste de Inventario</a></li>';}?>
              <?php if ($_SESSION['reportesi']==1){echo'<li><a href="reportesi.php"><i class="fa fa-circle-o text-aqua"></i> Reportes</a></li>';}?>           
              </ul>
             </li>

             <li class="treeview">
             <?php if ($_SESSION['compras']==1){echo'<a href="#">
                <i class="fa fa-truck text-red"></i>
                <span>Compras</span>
                 <i class="fa fa-angle-left pull-right"></i>
                  </a>';}?>
                  <ul class="treeview-menu">
                  <?php if ($_SESSION['proveedor']==1){echo'<li><a href="proveedor.php"><i class="fa fa-circle-o text-red"></i> Proveedores</a></li>';}?>
                  <?php if ($_SESSION['tipoproveedor']==1){echo'<li><a href="tipoproveedor.php"><i class="fa fa-circle-o text-red"></i> Tipo de Proveedores</a></li>';}?>
                  <?php if ($_SESSION['usuario']==1){echo'<li><a href="zona.php"><i class="fa fa-circle-o text-red"></i> Zonas</a></li>';}?>
                  <li><a href="reportesc.php"><i class="fa fa-circle-o text-red"></i> Reportes</a></li>
                  </ul>
             </li>
             <li class="treeview">
             <?php if ($_SESSION['opcompras']==1){echo'<a href="#">
                <i class="fa fa-bar-chart text-yellow"></i><span> Operaciones de Compras</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>';}?>  
              <ul class="treeview-menu">
                <?php if ($_SESSION['ccompra']==1){echo'<li><a href="ccompra.php"><i class="fa fa-circle-o text-red"></i> Cotizacion de Compra</a></li>';}?>  
                <?php if ($_SESSION['pcompra']==1){echo'<li><a href="pcompra.php"><i class="fa fa-circle-o text-red"></i> Pedido de Compra</a></li>';}?>  
                <?php if ($_SESSION['fcompra']==1){echo'<li><a href="fcompra.php"><i class="fa fa-circle-o text-red"></i> Factura de Compra</a></li>';}?>  
              </ul>
             </li>

            <li class="treeview">
            <?php if ($_SESSION['ventas']==1){echo'<a href="#">
              <i class="fa fa-shopping-cart text-lime"></i>
                <span>Ventas</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>';}?> 
              <ul class="treeview-menu">
                <?php if ($_SESSION['cliente']==1){echo'<li><a href="cliente.php"><i class="fa fa-circle-o text-green"></i> Clientes</a></li>';}?>
                <?php if ($_SESSION['tipocliente']==1){echo'<li><a href="tipocliente.php"><i class="fa fa-circle-o text-green"></i> Tipos de Clientes</a></li>';}?>
                <?php if ($_SESSION['vendedor']==1){echo'<li><a href="vendedor.php"><i class="fa fa-circle-o text-green"></i> Vendedores</a></li>';}?>          
                <?php if ($_SESSION['zona']==1){echo'<li><a href="zona.php"><i class="fa fa-circle-o text-green"></i> Zonas</a></li>';}?>
                <li><a href="reportesv.php"><i class="fa fa-circle-o text-green"></i> Reportes</a></li>
              </ul>
             </li>
             <li class="treeview">
             <?php if ($_SESSION['opventas']==1){echo'<a href="#">
                <i class="fa fa-bar-chart text-yellow"></i> <span> Operaciones de Ventas</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>';}?> 
              <ul class="treeview-menu">
                <?php if ($_SESSION['cventa']==1){echo'<li><a href="cventa.php"><i class="fa fa-circle-o text-lime"></i> Cotizacion de Ventas</a></li>';}?> 
                <?php if ($_SESSION['pventa']==1){echo'<li><a href="pventa.php"><i class="fa fa-circle-o text-lime"></i> Pedido de Ventas</a></li>';}?> 
                <?php if ($_SESSION['fventa']==1){echo'<li><a href="fventa.php"><i class="fa fa-circle-o text-lime"></i> Factura de Ventas</a></li>';}?>
                <?php if ($_SESSION['fventa']==1){echo'<li><a href="cuentac.php"><i class="fa fa-circle-o text-lime"></i> Cuentas Por Cobrar</a></li>';}?> 
                <?php if ($_SESSION['cliente']==1){echo'<li><a href="tventafecha.php"><i class="fa fa-circle-o text-lime"></i> Ventas por Fecha</a></li>';}?>      
                <?php if ($_SESSION['cliente']==1){echo'<li><a href="tventafechacl.php"><i class="fa fa-circle-o text-lime"></i> Ventas por Cliente</a></li>';}?>         
              </ul>
             </li>
             <li>

            <li class="treeview">
            <?php if ($_SESSION['bancos']==1){echo'<a href="#">
                <i class="fa fa-bank text-purple"></i><span> Banca y Finazas</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>';}?> 
              <ul class="treeview-menu">
                <?php if ($_SESSION['banco']==1){echo'<li><a href="banco.php"><i class="fa fa-circle-o"></i> Bancos</a></li>';}?>          
                <?php if ($_SESSION['caja']==1){echo'<li><a href="caja.php"><i class="fa fa-circle-o"></i> Cajas</a></li>';}?> 
                <?php if ($_SESSION['cuenta']==1){echo'<li><a href="cuenta.php"><i class="fa fa-circle-o"></i> Cuentas</a></li>';}?>        
             </ul>
            </li>
            <li class="treeview">
            <?php if ($_SESSION['opbancos']==1){echo'<a href="#">
                <i class="fa fa-bar-chart text-yellow"></i> <span> Operaciones de Banco</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>';}?> 
              <ul class="treeview-menu">
                <?php if ($_SESSION['movcaja']==1){echo'<li><a href="movcaja.php"><i class="fa fa-circle-o"></i> Movimiento de Caja</a></li>';}?> 
                <?php if ($_SESSION['movbanco']==1){echo'<li><a href="movbanco.php"><i class="fa fa-circle-o"></i> Movimiento de Banco</a></li>';}?> 
              </ul>
             </li>
             <li>
            <li class="treeview">  
              <a href="#">
                <i class="fa fa-plus-square"></i> <span>Ayuda</span>
                <small class="label pull-right bg-red">PDF</small>
              </a>
             </li>
             <li>
             <a data-toggle="modal" href="#AboutME">
                <i class="fa fa-info-circle"></i> <span>Acerca De...</span>
                <small class="label pull-right bg-yellow">IT</small>
              </a>
            </li>
                        
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

         <!--Modal Pendiente-->
   <!--Modal Pendiente-->
   <div class="modal fade" tabindex="-1" role="dialog" id="AboutME">
    <div class="modal-dialog modal-dialog-centered" role="document" style="width:45% !important;">
      <div class="modal-content">
        <div class="modal-header">
          </div>
          <div class="panel-body" id="formulariosaldo">
            <form name="formulariosaldo" id="formulariosaldo" method="POST">
            <p>
            wwww.salamandrair.com.ve - Software Development Study
            <small><i class="fa fa-youtube-square"></i> www.youtube.com/sit</small>
           </p>
          </form>
        </div>
      
      </div>
    </div>
  </div>

    <!-- Bootstrap 4.3.1 -->
  <script src="../public/js/bootstrap.min.js"></script>