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
if ($_SESSION['vendedor']==1)
{
?>
<!--Contenido-->   
<div class="content-wrapper"><!-- Content Wrapper. Contains page content -->
  <section class="content"><!-- Main content -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h1 class="box-title"> Vendedor</h1>
            <button class="btn btn-success btn-sm" id="btnagregar" onclick="mostrarform(true)">
            <i class="fa fa-plus-circle"></i> Agregar</button>
            <a href="../reportes/rptVendedor.php" target="_blank">
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
              <th style="width:80px; text-align:center;">Cobrador</th>
              <th style="width:80px; text-align:center;">Vendedor</th>
              <th style="width:100px; text-align:center;" class="nd">Estado</th>
            </thead>
            </table>   
        </div>
        <!-- Fromulario de Muestra y Edicion -->
        <div class="panel-body table-responsive" id="formularioregistros">
          <form name="formulario" id="formulario" method="POST">
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <label>Codigo:</label>
              <input hidden name="idvendedor" id="idvendedor">
              <input type="textc" class="form-control" name="cod_vendedor" id="cod_vendedor" maxlength="50" 
              placeholder="Codigo" required rel="tooltip" data-original-title="Campo Obligatorio" required>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <label> Fecha de Registro:</label>
                <div class="input-group date">
                  <input type="text" class="form-control ffechareg" name="fechareg" id="fechareg">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <label> Rif:</label>
              <input type="text" class="form-control" name="rif" id="rif" maxlength="150" placeholder="Rif" required>
            </div>
            <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
              <label> Descripción:</label>
              <input type="text" class="form-control" name="desc_vendedor" id="desc_vendedor" placeholder="Descripción" >
            </div>
            <div class="form-group col-lg-10 col-md-10 col-sm-12 col-xs-12">
              <label> Direccion:</label>
              <input type="text" class="form-control" name="direccion" id="rireccion" maxlength="100" placeholder="Direccion">    
            </div>
            <div class="form-group col-lg-10 col-md-10 col-sm-12 col-xs-12">
              <div class="row">
                <div class="col-md-5">
                <div class="box box-primary box-solid">
                  <div class="box-body">
                    <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                      <label>Vendedor: </label>
                      <input type="checkbox" name="esvendedor" id="esvendedor">
                    </div>   
                    <div class="input-group">
                      <div class="input-group-addon">
                        <label>Comision por Ventas:</label>
                      </div>
                      <input type="text" class="form-control" name="comisionv" id="comisionv" style="text-align:right;">
                    </div>
                  </div><!-- /.box-body -->
                </div><!-- /.box -->  
              </div><!-- /.row -->
              <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-1">
              </div>
              <div class="row">
                <div class="col-md-5">
                  <div class="box box-primary box-solid">
                    <div class="box-body">
                      <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <label>Cobrador: </label>
                        <input type="checkbox" name="escobrador" id="escobrador">
                      </div>   
                      <div class="input-group">
                        <div class="input-group-addon">
                          <label>Comision por Cobros:</label>
                        </div>
                          <input type="text" class="form-control" name="comisionc" id="comisionc" style="text-align:right;">
                      </div>
                    </div><!-- /.box-body -->
                  </div><!-- /.box -->  
                </div><!-- /.row -->   
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
<script type="text/javascript" src="scripts/vendedor.js"></script>
<?php 
}
ob_end_flush();
?>