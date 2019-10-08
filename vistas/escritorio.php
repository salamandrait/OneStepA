<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["cod_usuario"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';
if ($_SESSION['escritorio']==1)
{

  require_once "../modelos/Escritorio.php";
  $escritorio = new Escritorio();

  //TOTAL Pedidos de Ventas
  $rsptapv = $escritorio->TotalPVenta();
  $regpv=$rsptapv->fetch_object();
  $totalgpv=$regpv->totalpv;
  $fechagpv=$regpv->fechapv;

  //TOTAL Facturas de Ventas
  $rsptafv = $escritorio->TotalFVenta();
  $regfv=$rsptafv->fetch_object();
  $totalgfv=$regfv->totalfv;
  $fechagfv=$regfv->fechafv;

  //TOTAL Pedidos de Compras
  $rsptapc = $escritorio->TotalPCompra();
  $regpc=$rsptapc->fetch_object();
  $totalgpc=$regpc->totalpc;
  $fechagpc=$regpc->fechapc;

  //TOTAL Facturas de Compras
  $rsptafc = $escritorio->TotalFCompra();
  $regfc=$rsptafc->fetch_object();
  $totalgfc=$regfc->totalfc;
  $fechagfc=$regfc->fechafc;

  //Datos para mostrar el gráfico de barras de las ventas
  $ventas10 = $escritorio->ventasultimos_10dias();
  $fechav='';
  $totalv='';
  while ($regfechav= $ventas10->fetch_object()) {
  $fechav=$fechav.'"'.$regfechav->fechav .'",';
  $totalv=$totalv.$regfechav->totalv .','; 
  }

  //Datos para mostrar el gráfico de barras de las compras
  $compras10 = $escritorio->comprasultimos_10dias();
  $fechac='';
  $totalc='';
  while ($regfechac= $compras10->fetch_object()) {
  $fechac=$fechac.'"'.$regfechac->fechac .'",';
    $totalc=$totalc.$regfechac->totalc .','; 
  }

  $rsptclie = $escritorio->TotalClientes();
  $regtclie = $rsptclie->fetch_object();
  $totalclie= $regtclie->clie;
  $totaltc=   $regtclie->saldotc;

  $rsptprov = $escritorio->TotalProveedores();
  $regtprov = $rsptprov->fetch_object();
  $totalprov= $regtprov->prov;
  $totaltp  = $regtprov->saldotp;

    //TOTAL INVENTARIO
    $rsptc = $escritorio->TotalCategorias();
    $regtc = $rsptc->fetch_object();
    $totalcat=$regtc->categoria;
    
    $rspta = $escritorio->TotalArticulos();
    $regta=$rspta->fetch_object();
    $totalart=$regta->articulo;
    
    $rspst = $escritorio->TotalStockArticulo();
    $regst=$rspst->fetch_object();
    $totalstock=$regst->stock;

  //Datos para mostrar el gráfico de barras de las ventas
  $ventas12 = $escritorio->ventasultimos_12meses();
  $fechayv='';
  $totalyv='';
  while ($regfechav= $ventas12->fetch_object()) {
  $fechayv=$fechayv.'"'.$regfechav->fechayv .'",';
  $totalyv=$totalyv.$regfechav->totalyv .','; 
  }

  //Datos para mostrar el gráfico de barras de las compras
  $compras12 = $escritorio->comprasultimos_12meses();
  $fechayc='';
  $totalyc='';
  while ($regfechac= $compras12->fetch_object()) {
  $fechayc=$fechayc.'"'.$regfechac->fechayc .'",';
  $totalyc=$totalyc.$regfechac->totalyc .','; 
}

?>
<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"><!-- .content-wrapper -->   
  <section class="content"><!-- .content -->
    <div class="row"><!-- .row -->
      <div class="col-md-12"><!-- .12 -->
        <div class="box"><!-- .box -->
          <div class="box-header with-border">
            <div class="panel-body">

              <!-- Compras 10 dias -->
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <div class="box box-solid box-danger collapsed-box">
                      <div class="box-header with-border">
                        <h4 class="box-title"><i class="fa fa-bar-chart"></i> Compras Ultimos 10 Dias</h4>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                      </div>
                      <div class="box-body">
                        <canvas id="compras10" width="400" ></canvas>
                      </div>
                  </div>
              </div> 
              <!-- Ventas 10 dias -->
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <div class="box box-solid box-info collapsed-box">
                      <div class="box-header with-border">
                        <h4 class="box-title"><i class="fa fa-bar-chart"></i> Ventas Ultimos 10 Dias</h4>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                      </div>
                      <div class="box-body">
                        <canvas id="ventas10" width="400" ></canvas>
                      </div>
                </div>
              </div>
              <!-- Compras 12 meses -->
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <div class="box box-solid box-success collapsed-box">
                      <div class="box-header with-border">
                        <h4 class="box-title"><i class="fa fa-bar-chart"></i> Compras Ultimos 12 Meses</h4>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                      </div>
                      <div class="box-body">
                        <canvas id="compras12" width="400" ></canvas>
                      </div>
                  </div>
              </div>
              <!-- Compras 12 meses -->
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <div class="box box-solid box-primary collapsed-box">
                      <div class="box-header with-border">
                        <h4 class="box-title"><i class="fa fa-bar-chart"></i> Ventas Ultimos 12 Meses</h4>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                      </div>
                      <div class="box-body">
                        <canvas id="ventas12" width="400" ></canvas>
                      </div>
                  </div>
              </div>

              <div class="col-lg-6 col-xs-12">
                  <div class="small-box bg-blue color-palette">
                    <div class="inner"><h3><?php echo $totalart?></h3><p> Articulos</p></div>
                    <div class="icon"><i class="fa fa-shopping-cart"></i></div>
                      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
              </div>
              <!-- Total Stock -->
              <div class="col-lg-6 col-xs-12">
                  <div class="small-box bg-maroon color-palette">
                    <div class="inner">
                      <h3><?php echo number_format($totalstock,0,",",".")?></h3>
                      <p>Total Stock</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-cubes"></i>
                    </div>
                    <a href="articulo.php" class="small-box-footer">
                      More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                  </div>
              </div>
              <!-- pedidos de ventas -->
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="small-box bg-aqua">
                  <div class="inner">
                    <p> Pedidos de Ventas </p>
                    <h4 style="font-size:17px;"><strong>Periodo <span>
                    <?php echo $fechagpv;?></span></strong></h4>
                    <h4 style="font-size:17px;"><strong>Total BsS. <span class="numberf">
                    <h4 style="font-size:17px; text-align:right;">
                    <?php echo number_format($totalgpv,2,",",".");?>
                    </h4>
                    </span></strong></h4>                                
                  </div>
                <div class="icon">
                  <i class="fa fa-cart-plus"></i>
                </div>
                  <a href="pventa.php" class="small-box-footer"> Pedidos de Ventas <i class="fa fa-arrow-circle-right"></i></a>
                </div> 
              </div>
              <!-- Clientes -->
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <div class="small-box bg-yellow">
                  <div class="inner">
                    <p><strong> Clientes Activos : <?php echo $totalclie;?></strong></p>
                    <h4 style="font-size:17px;"><strong>Periodo <span><?php echo $fechagfv;?></span></strong></h4>
                    <h4 style="font-size:17px;">
                    <strong>Cuentas Por Cobrar Bs.
                    <h4 style="font-size:17px; text-align:right;"><?php echo number_format($totalgpv+$totalgfv,2,",",".");?></h4>
                    </strong>
                    </h4>                                
                  </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                  <a href="cliente.php" class="small-box-footer"> Listado de Clientes<i class="fa fa-arrow-circle-right">
                  </i></a>
                </div> 
              </div>
              <!-- Facturas de ventas -->
              <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                <div class="small-box bg-green">
                  <div class="inner">
                    <p> Facturas de Ventas </p>
                    <h4 style="font-size:17px;"><strong>Periodo <span>
                    <?php echo $fechagfv;?></span></strong></h4>
                    <h4 style="font-size:17px;"><strong>Total BsS. <span class="numberf">
                    <h4 style="font-size:17px; text-align:right;">
                    <?php echo number_format($totalgfv,2,",",".");?>
                    </h4>
                    </span></strong></h4>                                
                  </div>
                <div class="icon">
                  <i class="fa fa-cart-plus"></i>
                </div>
                  <a href="fventa.php" class="small-box-footer"> Facturas de Ventas <i class="fa fa-arrow-circle-right"></i></a>
                </div> 
              </div>
              <!-- Facturas de compras -->
              <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                <div class="small-box bg-green">
                  <div class="inner">
                    <p> Facturas de Compras</p>
                    <h4 style="font-size:17px;"><strong>Periodo <span>
                    <?php echo $fechagfc;?></span></strong></h4>
                    <h4 style="font-size:17px;"><strong>Total BsS. <span class="numberf">
                    <h4 style="font-size:17px; text-align:right;">
                    <?php echo number_format($totalgfc,2,",",".");?>
                    </h4>
                    </span></strong></h4>                                
                  </div>
                <div class="icon">
                  <i class="fa fa-cart-arrow-down"></i>
                </div>
                  <a href="fcompra.php" class="small-box-footer"> Facturas de Compras <i class="fa fa-arrow-circle-right"></i></a>
                </div> 
              </div>
              <!-- Proveedores -->
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <div class="small-box bg-primary">
                  <div class="inner">
                    <p><strong> Proveedores Activos : <?php echo $totalprov;?></strong></p>
                    <h4 style="font-size:17px;"><strong>Periodo <span><?php echo $fechagfv;?></span></strong></h4>
                    <h4 style="font-size:17px;">
                    <strong>Cuentas Por Pagar Bs.
                    <h4 style="font-size:17px; text-align:right;"><?php echo number_format($totalgpc+$totalgfc,2,",",".");?></h4>
                    </strong>
                    </h4>                                
                  </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                  <a href="proveedor.php" class="small-box-footer"> Listado de Proveedores<i class="fa fa-arrow-circle-right">
                  </i></a>
                </div> 
              </div>
              <!-- Pedidos de Compras -->
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="small-box bg-aqua">
                  <div class="inner">
                    <p> Pedidos de Compras </p>
                    <h4 style="font-size:17px;"><strong>Periodo <span>
                    <?php echo $fechagpc;?></span></strong></h4>
                    <h4 style="font-size:17px;"><strong>Total BsS. <span class="numberf">
                    <h4 style="font-size:17px; text-align:right;">
                    <?php echo number_format($totalgpc,2,",",".");?>
                    </h4>
                    </span></strong></h4>                                
                  </div>
                <div class="icon">
                  <i class="fa fa-cart-arrow-down"></i>
                </div>
                  <a href="pcompra.php" class="small-box-footer"> Pedidos de Compras <i class="fa fa-arrow-circle-right"></i></a>
                </div> 
              </div>
        </div><!-- /.box -->
      </div><!-- /.12 -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<!--Fin-Contenido-->
<?php
}
else
{
  require 'noacceso.php';
}
require 'footer.php';
?>
<script src="../public/js/chart.min.js"></script>
<script src="../public/js/Chart.bundle.min.js"></script> 
<script type="text/javascript">
var ctx = document.getElementById("compras10").getContext('2d');
var compras10 = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechac; ?>],
        datasets: [{
            label: 'Compras de los últimos 10 Dias',
            data: [<?php echo $totalc; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:false
                }
            }]
        }
    }
});

var ctx = document.getElementById("ventas10").getContext('2d');
var ventas10 = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechav; ?>],
        datasets: [{
            label: 'Ventas de los últimos 10 Dias',
            data: [<?php echo $totalv; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:false
                }
            }]
        }
    }
});

var ctx = document.getElementById("compras12").getContext('2d');
var compras12 = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechayc; ?>],
        datasets: [{
            label: 'Compras de los últimos 12 Meses',
            data: [<?php echo $totalyc; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:false
                }
            }]
        }
    }
});

var ctx = document.getElementById("ventas12").getContext('2d');
var ventas12 = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechayv; ?>],
        datasets: [{
            label: 'Ventas de los últimos 12 Meses',
            data: [<?php echo $totalyv; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:false
                }
            }]
        }
    }
});



</script>
<?php 
}
ob_end_flush();
?>