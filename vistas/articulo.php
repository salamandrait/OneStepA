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
if ($_SESSION['articulo']==1)
{
?>
<!--Contenido-->   
<div class="content-wrapper"><!-- Content Wrapper. Contains page content -->
  <section class="content"><!-- Main content -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h1 class="box-title"> Articulos</h1>
            <button class="btn btn-success btn-sm" id="btnagregar" onclick="mostrarform(true)">
            <i class="fa fa-plus-circle"></i> Agregar</button>
            <a href="../reportes/rptArticulo.php" target="_blank">
            <button class="btn btn-primary btn-sm" id="btnreporte" ><i class="fa fa-print"></i> Reporte</button></a>
            <div class="box-tools pull-right">
            </div>
          </div><!-- /.box-header -->
          <!-- centro Listado de Registros -->
        <div class="panel-body table-responsive" id="listadoregistros">
          <table id="tbllistado" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100%">
            <thead class="bg-gray-active">
              <th style="width:130px; text-align:center;" class="nd">Opciones</th>
              <th style="width:150px; text-align:center;">Codigo</th>
              <th style="width:420px; text-align:center;">Descripción</th>
              <th style="width:300px; text-align:center;">Categoria</th>
              <th style="width:150px; text-align:center;">Ref.</th>
              <th style="width:80px;  text-align:center;" class="nd">Stock</th>
              <th style="width:100px; text-align:center;" class="nd">Estado</th>
              <th style="width:100px; text-align:center;" class="nv">Costo 1</th>
              <th style="width:100px; text-align:center;" class="nv">Precio 1</th>
            </thead>
          </table> 
        </div>
        <!-- Fromulario de Muestra y Edicion -->
        <div class="panel-body table-responsive" id="formularioregistros">
          <form name="formulario" id="formulario" method="POST">
            <div class="form-group col-lg-3 col-md-3 col-sm-8 col-xs-8">
              <label>Codigo:</label>
              <input hidden name="idarticulo" id="idarticulo">
              <input type="textc" class="form-control" name="cod_articulo" id="cod_articulo" maxlength="50" 
              placeholder="Codigo" required rel="tooltip" data-original-title="Campo Obligatorio" required value="2500">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <label>Tipo:</label>
              <select name="tipo" id="tipo" class="form-control">
                <option value="General">General</option>
                <option value="Servicio">Servicio</option>
                <option value="Uso Interno">Uso Interno</option>
                <option value="Produccion">Produccion</option>
                <option value="Otro">Otro</option>
              </select>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <label>Categoria:</label>
              <select name="idcategoria" id="idcategoria" class="form-control" data-live-search="true" required rel="tooltip" data-original-title="Campo Obligatorio">
              </select>
            </div>
            <div class="form-group col-lg-1 col-md-1 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-2 col-md-3 col-sm-8 col-xs-8">
            <label> Fecha de Registro:</label>
              <div class="input-group date">
                <input type="text" class="form-control ffechareg" name="fechareg" id="fechareg" required>
                <span class="input-group-addon"><span class="fa fa-calendar"></span>
              </div>
            </div>   
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <input text class="form-control" name="desc_articulo" id="desc_articulo" 
              maxlength="250" placeholder="Descripción" required>
            </div>

            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon"><label>Costo 1:</label></span>
                <input type="text" id="costo1" name="costo1" class="form-control numberf" 
                placeholder="0.00" style="text-align:right;" required>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              </div>
              <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon"><label>Costo 2:</label></span>
                <input type="text" id="costo2" name="costo2" class="form-control numberf" 
                placeholder="0.00" style="text-align:right;" required>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              </div>
              <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon"><label>Costo 3:</label></span>
                <input type="text" id="costo3" name="costo3" class="form-control numberf" 
                placeholder="0.00" style="text-align:right;" required>
              </div>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon"><label>Precio 1:</label></span>
                <input type="text" id="precio1" name="precio1" class="form-control numberf" 
                placeholder="0.00" style="text-align:right;" required>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              </div>
              <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon"><label>Precio 2:</label></span>
                <input type="text" id="precio2" name="precio2" class="form-control" 
                placeholder="0.00" style="text-align:right;" required>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              </div>
              <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon"><label>Precio 3:</label></span>
                <input type="text" id="precio3" name="precio3" class="form-control" 
                placeholder="0.00" style="text-align:right;" required>
              </div>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon"><label>Origen:</label></span>
                <select id="origen" name="origen" class="form-control" data-live-search="true" required>
                  <option value="Nacional">Nacional</option>
                  <option value="Importado">Importado</option>
                  <option value="Produccion">Produccion</option>
                </select>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              </div>
              <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon"><label>Unidad:</label></span>
                <select id="idunidad" name="idunidad" class="form-control selectpicker" data-live-search="true" required>
                </select>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              </div>
              <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon"><label>Unidad:</label></span>
                <select id="idimpuesto" name="idimpuesto" class="form-control selectpicker" data-live-search="true" required>
                </select>
              </div>
            </div>

            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12"><!--/Deposoto-->        
              <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label> Depositos:</label>  
                  <select id="iddeposito" name="iddeposito" class="form-control selectpicker" data-live-search="true" required>
                </select>           
                </div>
              </option>
              </select> 
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              </div>     
              <table id="tblListadoDep" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100%">
                <thead class="bg-gray-active">
                <th style="width:50px; text-align:center;" class="nd">Reng</th>
                <th style="width:200px; text-align:center;" class="nd">Deposito</th>
                <th style="width:100px; text-align:center;" class="nd">Stock</th>
                </thead>
              </table>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">    
              </div>
              <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <button type="button" class="btn btn-primary" rel="tooltip" 
                data-original-title="Agregar Depositos Adicionales" onclick="addDeposito();">
                <i class="fa fa-cubes"></i> Add Deposito</button>
              </div>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12"><!--/Codigo de Barras--> 
              <label> Codigo de Barras:</label>
              <input type="textc" class="form-control" name="artref" id="artref"  placeholder="Codigo de Barras" rel="tooltip" data-original-title="Codigo de Barras" maxlength="50">
              <div  id="print" width="20px;" height="50%"><svg id="barcode" style="width:90%;"></svg></div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              </div>
              <button class="btn btn-success btn-sm" type="button" onclick="generarbarcode()"><i class="fa fa-tasks"></i> Generar</button>
              <button class="btn btn-primary btn-sm" type="button" onclick="imprimir()"><i class="fa fa-print"></i> Imprimir</button>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <label style="color:#fff;">Costo 2:</label>
              <div class="small-box">       
                  <input hidden name="imagenactual" id="imagenactual">
                  <img src="" width="145px" height="145px" id="imagenmuestra"> 
                  <span class="imagen"><input type="file" class="form-control" name="imagen" id="imagen" 
                  style="width:0.1px; height:0.1px; opacity:0; overflow:hidden; position:absolute; z-index:-1;"></span>
                  <label for="imagen" style="width:100%; height:40px;"><span>Cargar Imagen</span></label> 
                  <div class="icon"><i class="fa fa-image"></i></div>
              </div>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <button class="btn btn-primary btn-sm" type="submit" id="btnGuardar"><i class="fa fa-save "></i> Guardar</button>
              <button class="btn btn-danger btn-sm" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
            </div>
          </form> 
        </div><!--Fin centro -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
 </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<!--Fin-Contenido-->

<!-- Modal -->
<div class="modal fade" id="modal-costo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog" style="width:50% !important;">
    <div class="modal-content">
      <div class="modal-header" style="padding:10px 10px 1px 10px;">
        <h4 class="modal-title"> Costos</h4>
        <div class="form-group col-lg-4 col-md-3 col-sm-8 col-xs-8">
          <span><input class="form-control" name="cod_articuloc" id="cod_articuloc" style="border-color:#fff; text-align:right; margin-bottom:0px !important;"></span>
        </div>
        <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
          <span><input class="form-control" name="desc_articuloc" id="desc_articuloc" style="border-color:#fff"></span>
        </div>
      </div><!-- /modal header -->
      <div class="panel-body">
      <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <label> Impuesto:</label>   
        <input type="text" name="" id="desc_impuestoc" class="form-control ro">
      </div>
      <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
        <label> Tasa %:</label>   
        <input type="text" name="" id="tasac" class="form-control ro" style="text-align:right;">
      </div>
      <div class="form-group col-lg-2 col-md-4 col-sm-12 col-xs-12">
      </div>
      <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <label> Stock Disponible:</label>   
        <input type="text" class="form-control ro" name="stockc" id="stockc" style="text-align:right;">  
      </div>
      <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
          <label> Costo 1:</label>   
          <input type="text" class="form-control ro numberf" name="costo1" id="costo1m" style="text-align:right;">
          <label> Costo 2:</label>
          <input type="text" class="form-control ro numberf" name="costo2" id="costo2m" style="text-align:right;">
          <label> Costo 3:</label>
          <input type="text" class="form-control ro numberf" name="costo3" id="costo3m" style="text-align:right;">            
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
          <label> Impuesto:</label>   
          <input type="text" class="form-control ro numberf" name="impc1" id="impc1m" style="text-align:right;">
          <label> Impuesto:</label>
          <input type="text" class="form-control ro numberf" name="impc2" id="impc2m" style="text-align:right;">
          <label> Impuesto:</label>
          <input type="text" class="form-control ro numberf" name="impc3" id="impc3m" style="text-align:right;">            
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
          <label> Total Costo 1 + Imp.:</label>   
          <input type="text" class="form-control ro numberf" name="totalc1" id="totalc1m" style="text-align:right;">
          <label> Total Costo 2 + Imp.:</label>
          <input type="text" class="form-control ro numberf" name="totalc2" id="totalc2m" style="text-align:right;">
          <label> Total Costo 3 + Imp.:</label>
          <input type="text" class="form-control ro numberf" name="totalc3" id="totalc3m" style="text-align:right;">            
        </div>
      </div><!-- /panel body -->
      <div class="modal-footer"> 
      <button type="button" class="btn btn-danger btn-sm"data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Cerrar</button>   
      </div>
    </div><!-- /Modal content -->
  </div><!-- /Modal dialog -->
</div><!-- /Modal fade -->

<div class="modal fade" id="modal-precio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog" style="width:50% !important;">
    <div class="modal-content">
      <div class="modal-header" style="padding:10px 10px 1px 10px;">
        <h4 class="modal-title"> Precios</h4>
        <div class="form-group col-lg-4 col-md-3 col-sm-8 col-xs-8">
          <span><input class="form-control" name="cod_articulop" id="cod_articulop" style="border-color:#fff; text-align:right; margin-bottom:0px !important;"></span>
        </div>
        <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
          <span><input class="form-control" name="desc_articulop" id="desc_articulop" style="border-color:#fff"></span>
        </div>
      </div><!-- /modal header -->
      <div class="panel-body">
      <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <label> Impuesto:</label>   
        <input type="text" id="desc_impuestop" class="form-control ro">
      </div>
      <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
        <label> Tasa %:</label>   
        <input type="text" id="tasap" class="form-control ro" style="text-align:right;">
      </div>
      <div class="form-group col-lg-2 col-md-4 col-sm-12 col-xs-12">
      </div>
      <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <label> Stock Disponible:</label>   
        <input type="text" class="form-control ro" id="stockp" style="text-align:right;">  
      </div>       
        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
          <label> Precio 1:</label>   
          <input type="text" class="form-control ro numberf" name="precio1" id="precio1m" style="text-align:right;">
          <label> Precio 2:</label>
          <input type="text" class="form-control ro numberf" name="precio2" id="precio2m" style="text-align:right;">
          <label> Precio 3:</label>
          <input type="text" class="form-control ro numberf" name="precio3" id="precio3m" style="text-align:right;">            
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
          <label> Impuesto:</label>   
          <input type="text" class="form-control ro numberf" name="impp1" id="impp1m" style="text-align:right;">
          <label> Impuesto:</label>
          <input type="text" class="form-control ro numberf" name="impp2" id="impp2m" style="text-align:right;">
          <label> Impuesto:</label>
          <input type="text" class="form-control ro numberf" name="impp3" id="impp3m" style="text-align:right;">            
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
          <label> Total Precio + Imp.:</label>   
          <input type="text" class="form-control ro numberf" name="total1" id="totalp1m" style="text-align:right;">
          <label> Total Precio + Imp.:</label>
          <input type="text" class="form-control ro numberf" name="total2" id="totalp2m" style="text-align:right;">
          <label> Total Precio + Imp.:</label>
          <input type="text" class="form-control ro numberf" name="total3" id="totalp3m" style="text-align:right;">            
        </div>
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
<script type="text/javascript" src="scripts/articulo.js"></script>
<?php 
}
ob_end_flush();
?>