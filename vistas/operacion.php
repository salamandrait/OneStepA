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
if ($_SESSION['operacion']==1)
{
?>
<!--Contenido-->   
<div class="content-wrapper"><!-- Content Wrapper. Contains page content -->
  <section class="content"><!-- Main content -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h1 class="box-title">Tipos de Operaciones</h1>
            <button class="btn btn-success btn-sm" id="btnagregar" onclick="mostrarform(true)">
            <i class="fa fa-plus-circle"></i> Agregar</button>
            <a href="../reportes/rptOperacion.php" target="_blank">
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
              <th style="width:60px; text-align:center;" class="nd">Inventario</th>
              <th style="width:60px; text-align:center;" class="nd">Compras</th>
              <th style="width:60px; text-align:center;" class="nd">Ventas</th>
              <th style="width:60px; text-align:center;" class="nd">Bancos</th>
              <th style="width:60px; text-align:center;" class="nd">Config.</th>
              <th style="width:100px; text-align:center;" class="nd" class="nd">Estado</th>
            </thead>
          </table>   
        </div>
        <!-- Fromulario de Muestra y Edicion -->
        <div class="panel-body table-responsive" id="formularioregistros">
          <form name="formulario" id="formulario" method="POST">
            <div class="form-group col-lg-3 col-md-3 col-sm-8 col-xs-8">
              <label>Codigo:</label>
              <input hidden name="idoperacion" id="idoperacion">
              <input type="textc" class="form-control" name="cod_operacion" id="cod_operacion" maxlength="50" 
              placeholder="Codigo" required rel="tooltip" data-original-title="Campo Obligatorio" required>
            </div>
            <div class="form-group col-lg-10 col-md-10 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
              <label> Descripción:</label>
              <input text class="form-control" name="desc_operacion" id="desc_operacion" 
              maxlength="250" placeholder="Descripción" required>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <label>
                <div class="checkbox">                    
                  <input name="esinventario" id="esinventario" class="ace ace-checkbox-2" type="checkbox">        
                  Aplica a Operaciones de Inventario
                </div>
                <div class="checkbox">
                  <input name="escompra" id="escompra" class="ace ace-checkbox-2" type="checkbox">        
                  Aplica a Operaciones de Compra
                </div>
                <div class="checkbox">                         
                  <input name="esventa" id="esventa" class="ace ace-checkbox-2" type="checkbox">        
                   Aplica a Operaciones de Venta
                </div>
                <div class="checkbox">                       
                  <input name="esbanco" id="esbanco" class="ace ace-checkbox-2" type="checkbox">        
                  Aplica a Operaciones de Banca y Finanzas
                </div>
                <div class="checkbox">                           
                  <input name="esconfig" id="esconfig" class="ace ace-checkbox-2" type="checkbox">        
                  Aplica a Operaciones de Configuracion
                </div>
              </label>
            </div>
            </div>
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
<script type="text/javascript" src="scripts/operacion.js"></script>
<?php 
}
ob_end_flush();
?>