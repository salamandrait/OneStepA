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
if ($_SESSION['ajuste']==1)
{
?>
<!--Contenido-->   
<div class="content-wrapper"><!-- Content Wrapper. Contains page content -->
  <section class="content"><!-- Main content -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h1 class="box-title">Ajustes</h1>
            <button class="btn btn-success btn-sm" id="btnagregar" onclick="mostrarform(true)">
            <i class="fa fa-plus-circle"></i> Agregar</button>
            <a href="../reportes/rptListadoAjuste.php" target="_blank">
            <button class="btn btn-primary btn-sm" id="btnreporte" ><i class="fa fa-print"></i> Reporte</button></a>
            <div class="box-tools pull-right">
            </div>
          </div><!-- /.box-header -->
          <!-- centro Listado de Registros -->
        <div class="panel-body table-responsive" id="listadoregistros">
          <table id="tbllistado" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100%">
            <thead class="bg-gray-active">
              <th style="width:120px; text-align:center;" class="nd">Opciones</th>
              <th style="width:100px; text-align:center;">Fecha</th>
              <th style="width:120px; text-align:center;">Codigo</th>
              <th style="text-align:center;">Descripción</th>
              <th style="width:100px; text-align:center;">Tipo</th>
              <th style="width:150px; text-align:center;">Total</th>
              <th style="width:100px; text-align:center;" class="nd">Estado</th>  
            </thead>
            </table>   
        </div>
        <!-- Fromulario de Muestra y Edicion -->
        <div class="panel-body table-responsive" id="formularioregistros">
          <form name="formulario" id="formulario" method="POST">
            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6">
              <label>Codigo:</label>
              <input hidden name="idajuste" id="idajuste">
              <B><input type="textc" class="form-control" name="cod_ajuste" id="cod_ajuste" maxlength="50" 
              placeholder="Codigo" required rel="tooltip" data-original-title="Campo Obligatorio" required readonly></B>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-4">
              <label> Estatus:</label>
              <B><input type="textD" class="form-control" name="estatus" id="estatus" readonly></B>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label> Deposito:</label>
            <select name="iddeposito" id="iddeposito" class="form-control"></select>   
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
              <label> Tipo:</label>
                <select class="form-control controldis" name="tipo" id="tipo" 
                required rel="tooltip" data-original-title="Campo Obligatorio">
                <option value="Entrada"> Entrada</option>
                <option value="Salida"> Salida</option>
                <option value="Inventario"> Disponible</option>
              </select>
            </div>
              <div class="form-group date col-lg-2 col-md-2 col-sm-4 col-xs-6">
              <label> Fecha de Registro:</label>
              <div class="input-group date">
               <input type="text" class="form-control controldis ffechareg" name="fechareg" id="fechareg"  required>
                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
              </div>
              </div>
            <div class="form-group col-lg-10 col-md-10 col-sm-12 col-xs-12">
              <input type="text" class="form-control" name="desc_ajuste" id="desc_ajuste" 
              maxlength="250" placeholder="Descripción">
            </div>
            <div class="button-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <a data-toggle="modal" href="#ModalArticulo">           
              <button id="btnagregarart" type="button" class="btn btn-primary btn-sm form-control controldis">
              <i class="fa fa-truck"></i><B>Agregar Artículos</B></button>
              </a>
            </div>
            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive">
              <table id="detalles" class="table compact table-hover table-striped table-condensed table-bordered table-responsive">
                <thead class="btn-primary">
                <th style="text-align:center; width:30px;" class="nd">E</th>
                <th style="text-align:center; width:120px;" class="nd">Codigo</th>
                <th style="text-align:center; width:350px;" class="nd">Artículo</th>
                <th style="text-align:center; width:150px;" class="nd">Deposito</th>
                <th style="text-align:center; width:120px;" class="nd">Cantidad</th>
                <th style="text-align:center; width:120px;" class="nd">Costo</th>
                <th style="text-align:center; width:150px;" class="nd">Total Reng.</th>   
              </thead>
              <tfoot>
                <th></th>
                <th></th>
                <th></th>
                <th></th>         
                <th></th>
                <th><h4 style="text-align:right;"><B>Total:</B></h4></th>
                <th><h4 style="text-align:right;"><B><span id="totalv" class="numberf" onchange="modificarSubtotales();">0.00</span></B></h4>
                </th>  
                </tfoot>                                               
              </table>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">        
            </div>
            <!-- Botones Guardar Editar -->
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <input id="idusuario" type="hidden" value=<?php echo $_SESSION['idusuario'];?>>
              <input name="totalh" id="totalh"  type="hidden">
              <button class="btn btn-primary btn-sm controldis" type="submit" id="btnGuardar"><i class="fa fa-save "></i> Guardar</button>
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
<div class="modal fade" id="ModalArticulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog" style="width:72% !important;">
    <div class="modal-content">
      <div class="modal-header" style="padding:10px 10px;">
        <h4 class="modal-title">Seleccionar Articulos</h4>
      </div><!-- /modal header -->
      <div class="panel-body" style="width:100% !important;">    
      <table id="tbarticulos" class="table table-bordered table-hover table-responsive compact table-condensed" style="width:100% !important;">
        <thead>
          <tr class="bg-gray-active">
            <th style="text-align:center;" class="nd">Add</th>
            <th style="text-align:center;">Cod. Articulo</th>
            <th style="text-align:center;">Descripcion</th>
            <th style="text-align:center;"class="nd">Deposito</th>
            <th style="text-align:center;"class="nd">Unidad</th>
            <th style="text-align:center;" class="nd">Stock</th>
            <th style="text-align:center;" class="nd">Costo</th>
          </tr>
        </thead>
      </table>
      
      </div><!-- /panel body -->
      <div class="modal-footer"> 
      <button type="button" class="btn btn-danger btn-sm"data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Cerrar</button>   
      </div>
    </div><!-- /Modal content -->
  </div><!-- /Modal dialog -->
</div><!-- /Modal fade -->
<?php
}
else
{
  require 'noacceso.php';
}
require 'footer.php';
?>
<script type="text/javascript" src="scripts/ajuste.js"></script>
<?php 
}
ob_end_flush();
?>