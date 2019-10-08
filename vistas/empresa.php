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
if ($_SESSION['empresa']==1)
{
?>
<!--Contenido-->   
<div class="content-wrapper"><!-- Content Wrapper. Contains page content -->
  <section class="content"><!-- Main content -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h1 class="box-title">Empresas</h1>
            <button class="btn btn-success btn-sm" id="btnagregar" onclick="mostrarform(true)">
            <i class="fa fa-plus-circle"></i> Agregar</button>
            <a href="../reportes/rptEmpresa.php" target="_blank">
            <button class="btn btn-primary btn-sm" id="btnreporte" ><i class="fa fa-print"></i> Reporte</button></a>
            <div class="box-tools pull-right">
            </div>
          </div><!-- /.box-header -->
          <!-- centro Listado de Registros -->
        <div class="panel-body table-responsive" id="listadoregistros">
          <table id="tbllistado" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100%">
            <thead class="bg-gray-active">
              <th style="width:120px; text-align:center;" class="nd">Opciones</th>
              <th style="width:120px; text-align:center;" class="nd">Codigo</th>
              <th style="text-align:center;" class="nd">Descripción</th>
              <th style="width:80px; text-align:center;" class="nd">Fiscal</th>
              <th style="width:80px; text-align:center;" class="nd">Monto</th>
            </thead>
            </table>   
        </div>
        <!-- Fromulario de Muestra y Edicion -->
        <div class="panel-body table-responsive" id="formularioregistros">
          <form name="formulario" id="formulario" method="POST">
            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6">
              <label>Codigo:</label>
              <input type="hidden" name="idempresa" id="idempresa">
              <input type="text" class="form-control" name="cod_empresa" id="cod_empresa" maxlength="50" 
              placeholder="Codigo" required rel="tooltip" data-original-title="Campo Obligatorio">
            </div>
            <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
              <label>Descripción:</label>
              <input type="text" class="form-control" name="desc_empresa" id="desc_empresa" 
              maxlength="250" placeholder="Descripción">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
              <label>Rif:</label>
              <input type="text" class="form-control" name="rif" id="rif" placeholder="Rif">
            </div>
            <div class="form-group col-lg-10 col-md-10 col-sm-12 col-xs-12">
              <label>Direccion Fiscal:</label>
              <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Direccion Fiscal">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
              <label>Codigo Postal:</label>
              <input type="text" class="form-control" name="codpostal" id="codpostal" placeholder="Codigo Postal">
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <label>Representante Legal:</label>
              <input type="text" class="form-control" name="contacto" id="contacto" placeholder="Representante Legal">
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <label>Telefono:</label>
              <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Telefono">
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <label>Movil:</label>
              <input type="text" class="form-control" name="movil" id="movil" placeholder="Telefono Movil">
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <label>Email:</label>
              <input type="text" class="form-control" name="email" id="email" placeholder="Email">
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <label>Web:</label>
              <input type="text" class="form-control" name="web" id="web" placeholder="Pagina Web">
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-8">
              <label>Contribuyente:</label>
              <div class="input-group form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon">
                <label style="margin-bottom:0px; margin-left:10%"> Aplica: 
                <input type="checkbox" name="esfiscal" id="esfiscal">
                </label></span>   
                <input type="text" id="montofiscal" name="montofiscal" class="form-control" 
                placeholder="%" style="text-align:right;">
                </div>
            </div>
            <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <input type="hidden" name="imagen1actual" id="imagen1actual">
                <img src="" width="120px" height="120px" id="imagen1muestra"> 
                <span class="imagen1">
                  <input type="file" class="form-control" name="imagen1" id="imagen1" 
                  style="width:0.1px; height: 0.1px;opacity: 0;overflow: hidden;position: absolute;z-index: -1;">  
                </span>
                <label for="imagen1"><span> Logo</span></label>   
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <input type="hidden" name="imagen2actual" id="imagen2actual">
                <img src="" width="400px" height="120px" id="imagen2muestra"> 
                <span class="imagen2">
                  <input type="file" class="form-control" name="imagen2" id="imagen2" 
                  style="
                  width:0.1px; 
                  height: 0.1px;
                  opacity: 0;
                  overflow: hidden;
                  position: absolute;
                  z-index: -1;
                  ">
                </span>
              <label for="imagen2"><span> Imagen</span></label>
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
<script type="text/javascript" src="scripts/empresa.js"></script>
<?php 
}
ob_end_flush();
?>