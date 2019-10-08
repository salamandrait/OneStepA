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
if ($_SESSION['cuenta']==1)
{
?>
<!--Contenido-->   
<div class="content-wrapper"><!-- Content Wrapper. Contains page content -->
  <section class="content"><!-- Main content -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h1 class="box-title"> Cuentas Bancarias</h1>
            <button class="btn btn-success btn-sm" id="btnagregar" onclick="mostrarform(true)">
            <i class="fa fa-plus-circle"></i> Agregar</button>
              <a href="../reportes/rptCuenta.php" target="_blank">
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
              <th style="text-align:center; width:350px;">Descripción</th>
              <th style="text-align:center; width:200px;">Numero</th>
              <th style="text-align:center; width:100px;">Banco</th>
              <th style="text-align:center; width:130px;" class="nd">Saldo</th>
              <th style="width:100px; text-align:center;" class="nd">Estado</th>
            </thead>
            </table>   
        </div>
        <!-- Fromulario de Muestra y Edicion -->
        <div class="panel-body table-responsive" id="formularioregistros">
          <form name="formulario" id="formulario" method="POST">
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <label>Codigo:</label>
              <input hidden name="idcuenta" id="idcuenta">
              <input type="textc" class="form-control" name="cod_cuenta" id="cod_cuenta" maxlength="50" 
              placeholder="Codigo" required rel="tooltip" data-original-title="Campo Obligatorio" required>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
              <label> Tipo de Cuenta:</label>
              <select class="form-control" name="tipo" id="tipo" required>
                <option value="Corriente">Corriente</option>
                <option value="Ahorro">Ahorro</option>
                <option value="Palzo Fijo">Palzo Fijo</option>
                <option value="Credito">Credito</option>
                <option value="Otros">Otros</option>
            </select>
            </div>
            <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
              <label> Descripción:</label>
              <input text class="form-control" name="desc_cuenta" id="desc_cuenta" 
              maxlength="250" placeholder="Descripción" required>
            </div>
            <div class="form-group date col-lg-2 col-md-2 col-sm-12 col-xs-12">
              <label> Fecha de Registro:</label>
              <div class="input-group datetime">
                <input type="text" class="form-control ffechareg" name="fechareg" id="fechareg">
                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
              </div>
            </div>
            <div class="form-group col-lg-2 col-md-5 col-sm-12 col-xs-12">
              <input type="text" name="cod_banco" id="cod_banco" class="form-control" placeholder="Cod. Banco" required readonly>
              <input name="idbanco" id="idbanco" type="hidden">
            </div>
            <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
              <input type="text" name="desc_banco" id="desc_banco"
              class="form-control" placeholder="Banco" required>
            </div>
            <div class="form-group col-lg-1 col-md-1 col-sm-12 col-xs-12">
              <input type="text" name="cod_moneda" id="cod_moneda" class="form-control" placeholder="Moneda" readonly required>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <input type="text" class="form-control" name="numcuenta" id="numcuenta" placeholder="Numero de Cuenta" required>
            </div>
            <div class="col-lg-11 col-md-11 col-sm-12 col-xs-12">
              <div class="box box-primary box-solid">
                <div class="box box-header box-primary box-solid" style="padding:5px">
                  <B><span> Agencia Bancaria</span></B>
                            </div>
                              <div class="box-body">
                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                  <input type="text" class="form-control" name="ejecutivo" id="ejecutivo" placeholder="Ejecutivo">
                                </div>
                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                  <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Telefono">
                                </div>
                                <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                  <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                                </div>
                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                  <input type="text" class="form-control" name="agencia" id="agencia" 
                                  placeholder="Agencia">
                                </div>
                                <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                  <input type="text" class="form-control" name="direccion" id="direccion" 
                                  placeholder="Direccion">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-11 col-md-11 col-sm-12 col-xs-12">
                            <div class="box box-primary box-solid">
                            <div class="box box-header box-primary box-solid" style="padding:5px; margin-bottom:2px;">
                              <B><span>        Saldos de Cuenta</span></B>
                            </div>
                              <div class="box-body">
                                <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                  <label>saldo Disponible:</label>
                                  <input type="text" class="form-control numberf" name="saldod" id="saldod" 
                                  placeholder="0.00" style="text-align:right;" readonly>
                                </div>
                                <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                  <label>Saldo Diferido:</label>
                                  <input type="text" class="form-control numberf" name="saldoh" id="saldoh" 
                                  placeholder="0.00" style="text-align:right;" readonly>
                                </div>
                                <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                  <label>Saldo Total:</label>
                                  <input type="text" class="form-control numberf" name="saldot" id="saldot" 
                                  placeholder="0.00" style="text-align:right;" readonly>
                                </div>
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

<div class="modal fade" tabindex="-1" role="dialog" id="ModalAddBanco">
  <div class="modal-dialog" role="document" style="width:65% !important;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Seleccionar Banco</h4>
      </div>
      <div class="modal-body">
          <table id="tblistadobanco" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100%">
            <thead class="bg-gray-active">
              <th style="width:20px; text-align:center;" class="nd">Add</th>
              <th style="width:120px; text-align:center;">Codigo</th>
              <th style="width:400px; text-align:center; ">Descripción</th>
              <th style="width:100px; text-align:center;" class="nd">Moneda</th>
            </thead>
          </table>   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Cerrar</button>
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
<script type="text/javascript" src="scripts/cuenta.js"></script>
<?php 
}
ob_end_flush();
?>