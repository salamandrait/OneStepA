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
if ($_SESSION['pcompra']==1)
{
?>
<!--Contenido-->   
<div class="content-wrapper"><!-- Content Wrapper. Contains page content -->
  <section class="content"><!-- Main content -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h1 class="box-title">Factura de Compras</h1>
            <button class="btn btn-success btn-sm" id="btnagregar" onclick="mostrarform(true)">
            <i class="fa fa-plus-circle"></i> Agregar</button>
              <a href="../reportes/rptCompra.php" target="_blank">
              <button class="btn btn-primary btn-sm" id="btnreporte" ><i class="fa fa-print"></i> Reporte</button></a>
            <div class="box-tools pull-right">
            </div>
          </div><!-- /.box-header -->
          <!-- centro Listado de Registros -->
        <div class="panel-body table-responsive" id="listadoregistros">
          <table id="tbllistado" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100%">
            <thead class="bg-gray-active"> 
              <th style="width: 100px; text-align:center;" class="nd">Opciones</th>
              <th style="width: 50px; text-align:center;"  class="nd">Procesos</th>
              <th style="width: 90px; text-align:center;">F.Emision</th>
              <th style="width: 80px; text-align:center;">Codigo</th>
              <th style="width: 250px; text-align:center;">Proveedor</th>
              <th style="width: 100px; text-align:center;">Rif</th>
              <th style="width: 90px; text-align:center;">Factura N°</th>
              <th style="width: 120px; text-align:center;">Total</th>
              <th style="width: 60px; text-align:center;"class="nd">Estado</th>
            </thead>
          </table>   
        </div>
        <!-- Fromulario de Muestra y Edicion -->

        <!-- <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <label> Fecha :</label>
        <input type="text" name="" id="" class="form-control">
        </div> -->
        
        <div class="panel-body table-responsive" id="formularioregistros">
          <form name="formulario" id="formulario" method="POST">
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <label>Codigo</label>
              <input hidden name="idcompra" id="idcompra">
              <B><input type="textc" class="form-control" name="cod_compra" id="cod_compra" maxlength="50" 
              placeholder="Codigo" required rel="tooltip" data-original-title="Campo Obligatorio" readonly required></B>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <label> Estatus </label>
              <B><input type="text" name="estatus" id="estatus" class="form-control" readonly></B>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <label> Origen </label>
              <input type="text" name="origen" id="origen" class="form-control" readonly>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <label> Fecha de Registro </label>
              <div class="input-group">
                <input type="text" name="fechareg" id="fechareg" class="form-control ffecha controld">
                <div class="input-group-addon"><span class="fa fa-calendar"></span></div>  
              </div>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <label> Fecha de Venc. </label>
              <div class="input-group">
                <input type="text" name="fechaven" id="fechaven" class="form-control ffecha controld">
                <div class="input-group-addon"><span class="fa fa-calendar"></span></div>  
              </div>
            </div>
            <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
              <input text class="form-control controld" name="desc_proveedor" id="desc_proveedor" 
              maxlength="250" placeholder="Proveedor" required>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <input type="text" name="cod_proveedor" id="cod_proveedor" class="form-control" placeholder="Codigo" readonly>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <input type="text" name="rif" id="rif" class="form-control" readonly placeholder="Rif" required>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <input type="text" name="numerod" id="numerod" class="form-control controld" placeholder="N° de Factura" required>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <input type="text" name="numeroc" id="numeroc" class="form-control controld" placeholder="N° de Control">
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">      
            </div>
            <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
              <div class="input-group oct">
                <span class="input-group-addon"><label style="margin-bottom:0px;"> Deposito:</label></span>
                <select name="iddeposito" id="iddeposito" class="form-control controld" required></select>
              </div>  
            </div>
            <div class="form-group col-lg-10 col-md-10 col-sm-12 col-xs-12">
              <input text class="form-control controld" name="desc_compra" id="desc_compra" 
              maxlength="250" placeholder="Descripción">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">      
              <button type="button" class="btn btn-sm btn-block btn-primary controld" id="btnagregar_item">
              <i class="fa fa-truck"></i><B> Agregar Item</B></button>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">     
              <table id="tbdetalles" class="table compact table-hover table-striped table-condensed table-bordered table-responsive" >
                <thead class="bg-blue">
                  <th style="text-align:center; width:30px;" class="nd">E</th>
                  <th style="text-align:center; width:120px;">Codigo</th>
                  <th style="width:430px; text-align:center;">Artículo</th>
                  <th style="width:60px; text-align:center;">Cant.</th>
                  <th style="text-align:right; width:120px;">Costo Und</th>
                  <th style="text-align:right; width:140px;">Sub Total</th>
                  <th style="text-align:right; width:130px;">Impuesto</th>
                  <th style="text-align:right; width:140px;">Total Reng.</th>         
                </thead>
                <tfoot>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>         
                  <th></th>
                  <th>     
                  <h4 style="text-align:right;">Sub Total:</h4>
                  <h4 style="text-align:right;">I.V.A.:</h4>
                  <h4 style="text-align:right;"><B>Total:</B></h4>                
                  </th>
                  <th>
                  <h4 style="text-align:right;"><span id="subtotalt" class="numberf"></span></h4>
                  <h4 style="text-align:right;"><span id="impuestot" class="numberf" onchange="modificarSubtotales();"></span></h4>
                  <h4 style="text-align:right;"><B><span id="totalt" class="numberf"></span></B></h4>
                  </th>  
                </tfoot>
                <input type="hidden" name="subtotalh" id="subtotalh">
                <input type="hidden" name="impuestoh" id="impuestoh">
                <input name="totalh" id="totalh">
                <input name="saldoh" id="saldoh">
              </table>
            </div>
            <input type="hidden" name="tipo" id="tipo" value='Factura'>
            <input type="hidden" name="idproveedor"" id="idproveedor">
            <input type="hidden" name="diascredito" id="diascredito">
            <input type="hidden" name="limite" id="limite">
            <input type="hidden" id="idusuario" name="idusuario" value=<?php echo $_SESSION['idusuario'];?>>
            <!-- Botones Guardar Editar -->
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <button class="btn btn-primary btn-sm controld" type="submit" id="btnGuardar"><i class="fa fa-save "></i> Guardar</button>
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

<div class="modal fade" id="ModalProveedor" tabidex="-1">
  <div class="modal-dialog" style="width:65%">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Agregar Proveedor</h4>
      </div>
      <div class="modal-body">
      <table id="tbltproveedor" class="table compact table-bordered table-condensed table-hover table-dark table-responsive table-primary" style="width:100%">
        <thead class="btn-primary">
          <th style="text-align:center; width:10%;" class="nd">Add</th>
          <th style="width:80px; text-align:center;">Codigo</th>
          <th style="text-align:center; width:300px;">Descripción</th>
          <th style="width:110px; text-align:center;">Rif</th>
        </thead>
      </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalArticulo" tabidex="-1">
  <div class="modal-dialog" style="width:80%">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Agregar Articulos</h4>
      </div>
      <div class="modal-body">
      <table id="tblarticulo" class="table compact table-bordered table-condensed table-hover table-dark table-responsive table-primary" style="width:100%">
        <thead class="btn-primary">
          <th style="text-align:center; width:30px;" class="nd">Add</th>
          <th style="text-align:center; width:80px; ">Codigo</th>
          <th style="text-align:center; width:350px;">Descripcion</th>
          <th style="text-align:center; width:100px;" class="nd">Ref.</th>
          <th style="text-align:center; width:180px;"class="nd">Deposito</th>   
          <th style="text-align:center; width:80px;" class="nd">Unidad</th>
          <th style="text-align:center; width:50px;">Stock</th>
          <th style="text-align:center; width:120px;">Costo</th>
          <th style="text-align:center; width:40px;" class="nd">IVA</th>
        </thead>
      </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!--Fin-Contenido-->
<?php
}
else
{
  require 'noacceso.php';
}
require 'footer.php';
?>
<script type="text/javascript" src="scripts/compra.js"></script>
<?php 
}
ob_end_flush();
?>