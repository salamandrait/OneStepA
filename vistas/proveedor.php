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
if ($_SESSION['proveedor']==1)
{
?>
<!--Contenido-->   
<div class="content-wrapper"><!-- Content Wrapper. Contains page content -->
  <section class="content"><!-- Main content -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h1 class="box-title"> Proveedores</h1>
            <button class="btn btn-success btn-sm" id="btnagregar" onclick="mostrarform(true)">
            <i class="fa fa-plus-circle"></i> Agregar</button>
            <a href="../reportes/rptProveedor.php" target="_blank">
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
              <th style="width:100px; text-align:center;">Rif</th>
              <th style="width:250px;">Tipo de Proveedor</th>
              <th style="width:150px; text-align:center;" class="nd">Saldo</th>
              <th style="width:100px; text-align:center;" class="nd">Estado</th>
            </thead>
            </table>   
        </div>
        <!-- Fromulario de Muestra y Edicion -->
        <div class="panel-body table-responsive" id="formularioregistros">
          <form name="formulario" id="formulario" method="POST">
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <label>Codigo:</label>
              <input hidden name="idproveedor" id="idproveedor">
              <input type="textc" class="form-control" name="cod_proveedor" id="cod_proveedor" maxlength="50" 
              placeholder="Codigo" required rel="tooltip" data-original-title="Campo Obligatorio" required>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <label> Tipo Proveedor:</label>
              <select id="idtipoproveedor" name="idtipoproveedor" class="form-control" 
              data-live-search="true" required>
            </select>
            </div> 
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
            <label> Fecha de Registro:</label>
              <div class="input-group date">
                <input type="text" class="form-control ffechareg" name="fechareg" id="fechareg" required>
                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
              </div>
            </div>   
            <div class="form-group col-lg-1 col-md-1 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <label>Rif:</label>
              <input type="textc" class="form-control" name="rif" id="rif" maxlength="10" 
              placeholder="Rif" required rel="tooltip" data-original-title="Campo Obligatorio" required>
            </div>
            <div class="form-group col-lg-9 col-md-9 col-sm-12 col-xs-12">
              <label>Descripcion:</label>
              <input text class="form-control" name="desc_proveedor" id="desc_proveedor" 
              maxlength="250" placeholder="Descripción" required>
            </div>
            <div class="form-group col-lg-11 col-md-11 col-sm-12 col-xs-12">
              <label>Direccion:</label>
              <input class="form-control" name="direccion" id="direccion" rows="4"   
              maxlength="250" placeholder="Direccion" required>
            </div>
            <div class="form-group col-lg-1 col-md-1 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-6">
              <label> Zona:</label>
              <select id="idzona" name="idzona" class="form-control selectpicker" 
              data-live-search="true" required>
            </select>
            </div> 
            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-6">
              <label> Ciudad:</label>
              <input type="text" class="form-control" name="ciudad" id="ciudad" maxlength="50" placeholder="Ciudad">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6">
              <label> Codigo Postal:</label>
              <input type="text" class="form-control" name="codpostal" id="codpostal" maxlength="50" placeholder="Codigo Postal">
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-6">
              <label> Tipo de Operacion:</label>
              <select id="idoperacion" name="idoperacion" class="form-control selectpicker" 
              data-live-search="true" required>
            </select>
            </div>
            <div class="form-group col-lg-1 col-md-1 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
              <label> Persona de Contacto:</label>
              <input type="text" class="form-control" name="contacto" id="contacto" placeholder="Contacto">
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-8">
              <label> Telefono Movil:</label>
              <input type="text" class="form-control" name="movil" id="movil" maxlength="50" placeholder="Telefono Movil">
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-8">
              <label> Telefonos:</label>
              <input type="text" class="form-control" name="telefono" id="telefono" maxlength="50" placeholder="Telefonos">
            </div>       
            <div class="form-group col-lg-4 col-md-4 col-sm-5 col-xs-12">
              <label> Email:</label>
              <input type="textr" class="form-control" name="email" id="email" maxlength="50" placeholder="Email">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-6">
              <label> Sitio Web:</label>
              <input type="textr" class="form-control" name="web" id="web" 
              maxlength="50" placeholder="Sitio Web">
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-6">
              <label> Saldo por Pagar:</label>
              <input type="text" class="form-control numberf" name="saldo" id="saldo" placeholder="0" style="text-align:right;" disabled>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-8">
              <label> Credito:</label>
              <div class="input-group">
                <span class="input-group-addon">
                  <label>Aplica:</label>
                  <input type="checkbox" name="aplicacredito" id="aplicacredito">
                  </span>
                  <input type="text" class="form-control col-lg-2 col-md-2 col-sm-2 col-xs-2" 
                  style="width:160px; text-align:right;" placeholder="Limite" name="limite" id="limite">
              </div>        
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-8">
              <label>Dias de Credito:</label>
              <input type="text" class="form-control" name="diascredito" id="diascredito" 
              placeholder="0" style="text-align:right;">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-8">
              <label>Contributente:</label>
              <div class="input-group">
                <span class="input-group-addon">
                  <label>Aplica:</label>
                  <input type="checkbox" name="aplicareten" id="aplicareten">
                </span>
                <input type="text" class="form-control" style="text-align:right;" 
                placeholder="%" name="montofiscal" id="montofiscal">
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
<script type="text/javascript" src="scripts/proveedor.js"></script>
<?php 
}
ob_end_flush();
?>