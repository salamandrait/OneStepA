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
if ($_SESSION['usuario']==1)
{
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->

      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                    <h1 class="box-title"> Usuarios <button class="btn btn-success btn-sm" id="btnagregar" onclick="mostrarform(true)">
                    <i class="fa fa-plus-circle"></i> Agregar </button>
                    <a href="../reportes/rptUsuarios.php" target="_blank">
                    <button class="btn btn-info btn-sm" id="btnreporte" ><i class="fa fa-print"></i> Reporte </button></a></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                    <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover compact" style="width:100%;">
                        <thead class="bg-gray-active">
                            <th style="width: 100px; text-align:center" class="nd">Opciones</th>
                            <th style="width: 150px; text-align:center;">Codigo</th>
                            <th style="width: 300px; text-align:center;">Nombre</th>
                            <th style="width: 120px; text-align:center;">Departamento</th>
                            <th style="width: 80px; text-align:center;" class="nd">Estado</th>
                          </thead>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                        <div class="form-group col-lg-9 col-md-9 col-sm-12 col-xs-12">
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-6">
                            <label> Codigo:</label>
                            <input type="hidden" name="idusuario" id="idusuario">
                            <input type="textc" class="form-control" name="cod_usuario" id="cod_usuario" maxlength="20" 
                            placeholder="Login" rel="tooltip" data-original-title="Campo Obligatorio" required>
                        </div>
                        <div class="form-group col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <label> Descripcion:</label>
                            <input type="text" class="form-control" name="desc_usuario" id="desc_usuario" maxlength="150" 
                            placeholder="Nombre" data-original-title="Campo Obligatorio" required>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                          <label> Clave:</label>
                          <input type="password" class="form-control" name="clave" id="clave" 
                          maxlength="64" placeholder="Clave" required>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <label> Departamento:</label>
                            <select class="form-control" name="departamento" id="departamento" required>
                              <option value="ADMINISTRACION">Administracion</option>
                              <option value="GERENCIA">Gerencia</option>
                              <option value="COMPRAS">Compras</option>
                              <option value="VENTAS">Ventas</option>
                              <option value="TESORERIA">Tesoreria</option>
                              <option value="SOPORTE">Soporte</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                          <label> Teléfono:</label>
                          <input type="text" class="form-control" name="telefono" id="telefono" maxlength="20" placeholder="Teléfono">
                        </div>
                        <div class="form-group date col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <label> Fecha de Registro:</label>
                          <div class="input-group date">
                            <input type="text" class="form-control ffechareg" name="fechareg" id="fechareg">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                          </div>
                        </div>
                        <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
                          <label> Dirección:</label>
                          <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Dirección" maxlength="70">
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Email:</label>
                            <input type="email" class="form-control" name="email" id="email" maxlength="50" placeholder="Email">
                        </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-2 col-sm-12 col-xs-12">
                        <input hidden name="imagenactual" id="imagenactual">
                            <img src="" width="145px" height="145px" id="imagenmuestra"> 
                          <span class="imagen">
                            <input type="file" class="form-control" name="imagen" id="imagen" 
                            style="width:0.1px; height: 0.1px;opacity: 0;overflow: hidden;position: absolute;z-index: -1;">
                          </span>
                          <label for="imagen">
                            <span>Cargar Imagen</span>
                          </label>
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        </div>
                        <div class="row form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="box box-primary box-solid collapsed-box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Accesos Configuracion</h3>
                                    <div class="box-tools pull-right">
                                      <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                      <i class="fa fa-minus"></i></button>
                                    </div>                     
                                  </div><!-- /.box-tools -->
                                    <!-- /.box-header -->
                                  <div class="box-body">  
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                      <ul style="list-style:none;" id="accesoscf" class="col-md-12"></ul>
                                    </div>
                                  </div><!-- /.box-body -->
                                </div><!-- /.box -->   
                          </div><!-- /.box --> 
                          <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="box box-warning box-solid collapsed-box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Accesos Escritorio</h3>
                                    <div class="box-tools pull-right">
                                      <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                      <i class="fa fa-minus"></i></button>
                                    </div>             
                                  </div><!-- /.box-tools -->
                                    <!-- /.box-header -->
                                  <div class="box-body">  
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                      <ul style="list-style:none;" id="accesosg" class="col-md-12"></ul>
                                    </div>
                                  </div><!-- /.box-body -->
                                </div><!-- /.box -->   
                          </div><!-- /.box -->
                          <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="box box-success box-solid collapsed-box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Accesos Inventario</h3>
                                    <div class="box-tools pull-right">
                                      <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                      <i class="fa fa-minus"></i></button>
                                    </div>              
                                  </div><!-- /.box-tools -->
                                    <!-- /.box-header -->
                                  <div class="box-body">  
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                      <ul style="list-style:none;" id="accesosi" class="col-md-12"></ul>
                                    </div>
                                  </div><!-- /.box-body -->
                                </div><!-- /.box -->   
                          </div><!-- /.box -->     
                        </div>   
                        <div class="row form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="box box-danger box-solid collapsed-box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Accesos Compras</h3>
                                    <div class="box-tools pull-right">
                                      <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                      <i class="fa fa-minus"></i></button>
                                    </div>              
                                  </div><!-- /.box-tools -->
                                    <!-- /.box-header -->
                                  <div class="box-body">  
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                      <ul style="list-style:none;" id="accesosc" class="col-md-12"></ul>
                                    </div>
                                  </div><!-- /.box-body -->
                                </div><!-- /.box -->   
                          </div><!-- /.box --> 
                          <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="box box-success box-solid collapsed-box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Accesos Ventas</h3>
                                    <div class="box-tools pull-right">
                                      <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                      <i class="fa fa-minus"></i></button>
                                    </div>              
                                  </div><!-- /.box-tools -->
                                    <!-- /.box-header -->
                                  <div class="box-body">  
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                      <ul style="list-style:none;" id="accesosv" class="col-md-12"></ul>
                                    </div>
                                  </div><!-- /.box-body -->
                                </div><!-- /.box -->   
                          </div><!-- /.box -->  
                          <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="box box-primary box-solid collapsed-box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Accesos Bancos</h3>
                                    <div class="box-tools pull-right">
                                      <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                      <i class="fa fa-minus"></i></button>
                                    </div>              
                                  </div><!-- /.box-tools -->
                                    <!-- /.box-header -->
                                  <div class="box-body">  
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                      <ul style="list-style:none;" id="accesosb" class="col-md-12"></ul>
                                    </div>
                                  </div><!-- /.box-body -->
                                </div><!-- /.box -->   
                          </div><!-- /.box --> 
                        </div>  

                          <!-- Botones Guardar Editar -->
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">                
                        <button class="btn btn-primary btn-sm" type="submit" id="btnGuardar">
                          <i class="fa fa-save "></i> Guardar</button>
                          <button class="btn btn-danger btn-sm" onclick="cancelarform()" type="button">
                          <i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                        </div>
                      </form>
                    </div>
                    <!--Fin centro -->
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
<script type="text/javascript" src="scripts/usuario.js"></script>
<?php 
}
ob_end_flush();
?>


