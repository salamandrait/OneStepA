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
if ($_SESSION['reportesi']==1)
{
?>
<!--Contenido-->   
<div class="content-wrapper"><!-- Content Wrapper. Contains page content -->
  <section class="content"><!-- Main content -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h1 class="box-title"> Reportes de Inventario</h1>
            <div class="box-tools pull-right">
            </div>
          </div><!-- /.box-header -->
          <!-- centro Listado de Registros -->
          <div class="form-group col-lg-12 col-md- col-sm-12 col-xs-12">
          </div>
          <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <select id="rptlistado" name="rptlistado" class="form-control" >
              <option value="rptArticulo">Listado de Articulos</option>
              <option value="rptArticulop">Listado de Articulos (P)</option>
              <option value="rptCategoria">Listado de Categorias</option>
              <option value="rptUnidad">Listado de Unidades</option>
              <option value="rptArtculoCosto">Articulos con sus Costos</option>
              <option value="rptArtculoPrecio">Articulos con sus Precios</option>
              <option value="rptArtculoCYP">Articulos con sus Costos y Precios</option>
            </select>
          </div>
          <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <input type="text" id="cod_desde" class="form-control" placeholder="Desde">
          </div>
          <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <input type="text" id="cod_hasta" class="form-control" placeholder="Hasta">
          </div>
          <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
            <button class="form-control btn btn-success" type="submit" onclick="Reporte()"><i class="fa fa-search-plus"></i> Mostrar</button>
          </div>
          <div class="panel-body table-responsive" id="listado1">
            <table id="tbllistado1" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100%">
              <thead class="bg-gray-active">
                <th style="width:50px; text-align:center;" class="nd ver">Reng.</th>
                <th style="width:100px; text-align:center;">Codigo</th>
                <th style="text-align:center;">Descripción</th>
                <th style="width:100px; text-align:center;" class="nd">Estado</th>
              </thead>
            </table>
          </div>
        </div><!-- /.box -->
      </div><!-- /.col -->
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
<script type="text/javascript" src="scripts/reportesi.js"></script>
<?php 
}
ob_end_flush();
?>