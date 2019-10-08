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
if ($_SESSION['caja']==1)
{
?>
<!--Contenido-->   
<div class="content-wrapper"><!-- Content Wrapper. Contains page content -->
  <section class="content"><!-- Main content -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h1 class="box-title"> Cajas</h1>
            <button class="btn btn-success btn-sm" id="btnagregar" onclick="mostrarform(true)">
            <i class="fa fa-plus-circle"></i> Agregar</button>
              <a href="../reportes/rptCaja.php" target="_blank">
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
              <th style="width:200px; text-align:center;" class="nd">Moneda</th>
              <th style="width:120px; text-align:center;">Saldo</th> 
              <th style="width:100px; text-align:center;" class="nd">Estado</th>
            </thead>
            </table>   
        </div>
        <!-- Fromulario de Muestra y Edicion -->
        <div class="panel-body table-responsive" id="formularioregistros">
          <form name="formulario" id="formulario" method="POST">
            <div class="form-group col-lg-3 col-md-3 col-sm-8 col-xs-8">
              <label>Codigo:</label>
              <input hidden name="idcaja" id="idcaja">
              <input type="textc" class="form-control" name="cod_caja" id="cod_caja" maxlength="50" 
              placeholder="Codigo" required rel="tooltip" data-original-title="Campo Obligatorio" required>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-6">
              <label> Moneda:</label>
              <select id="idmoneda" name="idmoneda" class="form-control selectpicker" 
              data-live-search="true" rel="tooltip" data-original-title="Campo Obligatorio">
              </select>
            </div>
              <div class="form-group date col-lg-2 col-md-2 col-sm-4 col-xs-4">
            </div>
            <div class="form-group date col-lg-2 col-md-2 col-sm-4 col-xs-6">
              <label> Fecha de Registro:</label>
                <div class="input-group datetime">
                  <input type="text" class="form-control ffechareg" name="fechareg" id="fechareg">
                  <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                </div>
            </div>
            <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
              <label> Descripción:</label>
              <input text class="form-control" name="desc_caja" id="desc_caja" 
              maxlength="250" placeholder="Descripción" required>
            </div>
            <div class="col-md-10">
              <div class="box box-primary box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Saldos</h3>
                  <div class="box-tools pull-right">
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body" style="">
                  <div class="form-group col-lg-4 col-md-4 col-sm-8 col-xs-8">
                    <label>Efectivo:</label>
                    <input type="text" class="form-control numberf" name="saldoefectivo" id="saldoefectivo" 
                    placeholder="0.00" style="text-align:right;" readonly>
                    </div>
                    <div class="form-group col-lg-4 col-md-2 col-sm-8 col-xs-8">
                      <label>Documentos:</label>
                      <input type="text" class="form-control numberf" name="saldodocumento" id="saldodocumento" 
                      placeholder="0.00" style="text-align:right;"  readonly>
                    </div>
                    <div class="form-group col-lg-4 col-md-2 col-sm-8 col-xs-8">
                      <label>Total:</label>
                      <input type="text" class="form-control numberf" name="saldototal" id="saldototal" 
                      placeholder="0.00" style="text-align:right;"  readonly>
                    </div>
                  </div> <!-- /.box-body -->
                </div><!-- /.box -->
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
<script type="text/javascript" src="scripts/caja.js"></script>
<?php 
}
ob_end_flush();
?>