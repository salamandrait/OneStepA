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
if ($_SESSION['correlativo']==1)
{
?>
<!--Contenido-->   
<div class="content-wrapper"><!-- Content Wrapper. Contains page content -->
  <section class="content"><!-- Main content -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h1 class="box-title"> Series de Operaciones</h1>
            <button class="btn btn-success btn-sm" id="btnagregar" onclick="mostrarform(true)">
            <i class="fa fa-plus-circle"></i> Agregar</button>
            <a href="../reportes/rptCorrelativo.php" target="_blank">
            <button class="btn btn-primary btn-sm" id="btnreporte" ><i class="fa fa-print"></i> Reporte</button></a>
            <div class="box-tools pull-right">
            </div>
          </div><!-- /.box-header -->
          <!-- centro Listado de Registros -->
        <div class="panel-body table-responsive" id="listadoregistros">
          <table id="tbllistado" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100%">
            <thead class="bg-gray-active">
              <th style="width:120px; text-align:center;" class="nd">Opciones</th>
              <th style="width:100px; text-align:center;">Grupo</th>
              <th style="text-align:center;">Descripción</th>
              <th style="width:100px; text-align:center;">Tabla</th>
              <th style="width:80px; text-align:center;" class="nd">Prefijo</th>  
              <th style="width:80px; text-align:center;" class="nd">Cadena</th>
              <th style="width:80px; text-align:center;">Codigo</th>
              <th style="width:50px; text-align:center;" class="nd">Largo</th>
              <th style="width:100px; text-align:center;" class="nd">Estado</th>
            </thead>
          </table>   
        </div>
        <!-- Fromulario de Muestra y Edicion -->
        <div class="panel-body table-responsive" id="formularioregistros">
          <form name="formulario" id="formulario" method="POST">
          <div class="form-group col-lg-2 col-md-10 col-sm-10 col-xs-10">
              <label>Grupo:</label>
              <select name="grupo" id="grupo" class="form-control">
              <option value="inventario">Inventario</option>
              <option value="compras">Compras</option>
              <option value="ventas">Ventas</option>
              <option value="banco">Banco</option>
              <option value="configuracion">Configuracion</option>
              </select>
            </div> 
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <label>Operacion:</label>
              <input hidden name="idcorrelativo" id="idcorrelativo">
              <input type="text" class="form-control" name="desc_correlativo" id="desc_correlativo" maxlength="50" 
              placeholder="Operacion" required rel="tooltip" data-original-title="Campo Obligatorio" required>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-10 col-xs-10">
              <label>Tabla:</label>
              <input type="text" id="tabla" name="tabla" class="form-control" placeholder="Tabla">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6">
              <label>Prefijo:</label>
              <input type="text" id="precadena" name="precadena" class="form-control" placeholder="Prefijo">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6">
              <label>Cadena:</label>
              <input type="text" id="cadena" name="cadena" class="form-control">
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-10 col-xs-10">
              <label>Codigo:</label>
              <input type="text" id="cod_num" name="cod_num" class="form-control" placeholder="Codigo">
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-10 col-xs-10">
              <label>Largo:</label>
              <input type="text" id="largo" name="largo" class="form-control" placeholder="Largo">
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
<script type="text/javascript" src="scripts/correlativo.js"></script>
<?php 
}
ob_end_flush();
?>