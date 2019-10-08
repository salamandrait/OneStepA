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
if ($_SESSION['banco']==1)
{
?>
<!--Contenido-->   
<div class="content-wrapper"><!-- Content Wrapper. Contains page content -->
  <section class="content"><!-- Main content -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h1 class="box-title"> Bancos</h1>
            <button class="btn btn-success btn-sm" id="btnagregar" onclick="mostrarform(true)">
            <i class="fa fa-plus-circle"></i> Agregar</button>
              <a href="../reportes/rptBanco.php" target="_blank">
              <button class="btn btn-primary btn-sm" id="btnreporte" ><i class="fa fa-print"></i> Reporte</button></a>
            <div class="box-tools pull-right">
            </div>
          </div><!-- /.box-header -->
          <!-- centro Listado de Registros -->
        <div class="panel-body table-responsive" id="listadoregistros">
          <table id="tbllistado" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100%">
            <thead class="bg-gray-active">
              <th style="width:120px; text-align:center;" class="nd">Opciones</th>
              <th style="width:120px; text-align:center;">Codigo</th>
              <th style="text-align:center;">Descripción</th>
              <th style="width:100px; text-align:center;" class="nd">Moneda</th>
              <th style="width:100px; text-align:center;" class="nd">Estado</th>
            </thead>
          </table>   
        </div>
        <!-- Fromulario de Muestra y Edicion -->
        <div class="panel-body table-responsive" id="formularioregistros">
          <form name="formulario" id="formulario" method="POST">
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <label>Codigo:</label>
              <input hidden name="idbanco" id="idbanco">
              <input type="textc" class="form-control" name="cod_banco" id="cod_banco" maxlength="50" 
              placeholder="Codigo" required rel="tooltip" data-original-title="Campo Obligatorio" required>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-11 col-md-11 col-sm-11 col-xs-11">
              <label> Descripción:</label>
              <input text class="form-control" name="desc_banco" id="desc_banco" 
              maxlength="250" placeholder="Descripción" required>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-8 col-xs-8">
            <label> Moneda:</label>
              <select class="form-control selectpicker" name="idmoneda" id="idmoneda" 
              required data-live-search="true" required rel="tooltip">
              </select>
            </div>
            <div class="form-group col-lg-3 col-md-4 col-sm-8 col-xs-8">
              <label>Telefono:</label>
              <input type="text" class="form-control" name="telefono" id=telefono" placeholder="Telefono">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <label>Misma Plaza:</label>
              <input type="number" class="form-control" name="plazo1" id="plazo1" placeholder="Plazo">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <label>Otra Plaza:</label>
              <input type="number" class="form-control" name="plazo2" id="plazo2" placeholder="Plazo">
            </div>     
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            </div>
            <!-- Botones Guardar Editar -->
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <button class="btn btn-primary btn-sm" type="submit" id="btnGuardar"><i class="fa fa-save "></i> Guardar</button>
              <button class="btn btn-danger btn-sm" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar
              </button>
            </div>
          </form> 
        </div><!--Fin centro -->
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
<script type="text/javascript" src="scripts/banco.js"></script>
<?php 
}
ob_end_flush();
?>