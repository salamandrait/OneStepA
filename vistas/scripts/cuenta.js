var tabla;
var tablap;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	MostrarModal();
	listarBanco();

	$('span.numberf').number( true, 2);

	$("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	})
}

//Función limpiar
function limpiar(){

	$('#idbanco').val("");
	$('#tipo').val("Corriente");
	$('#tipo').niceSelect('update');
	$("#idcuenta").val("");
	$("#cod_cuenta").val("");
	$("#desc_cuenta").val("");
	$("#numcuenta").val("");
	$("#agencia").val("");
	$("#ejecutivo").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#saldod").val("");
	$("#saldoh").val("");
	$("#saldot").val("");
	$("#fechareg").val("");

	//Obtenemos la fecha actual
	var now = new Date();
	var dia = ("0" + now.getDate()).slice(-2);
	var mes = ("0" + (now.getMonth() + 1)).slice(-2);
	var anne = now.getFullYear();
	var today = (anne) +"-"+ (mes) +"-"+ (dia);
	$('#fechareg').val(today);
}

//Función mostrar formulario
function mostrarform(flag){

	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
        $("#btnreporte").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
        $("#btnreporte").show();  
	}
}

//Función cancelarform
function cancelarform(){

	limpiar();
	mostrarform(false);
	listar();
}

//Función Listar
function listar(){

	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        columnDefs:[{
			"targets":'nd',//clase para definir las columnas a tratar
			"orderable":false,//Definimos no ordenar por esta columna
			"searchable":false,//Definimos no buscar por esta columna
		}],

	    buttons : [
            {extend:'copyHtml5',
			text:'<i class="fa fa-file-archive-o text-blue"></i>',
			titleAttr:'Copiar al Portapapeles',
			exportOptions:{
				columns:[1,2,3]
				}},
            {
            extend:'excelHtml5',
            text:'<span class="fa fa-file-excel-o text-green"></span>',
			titleAttr:'Exportar a Excel',
			exportOptions:{
				columns:[1,2,3]
				}},
            {
            extend:'csvHtml5',
            text:'<i class="fa fa-file-text-o text-purple"></i>',
			titleAttr:'Exportar a Texto',
			exportOptions:{
				columns:[1,2,3]
				}},
            {
            extend:'pdf',
            text:'<i class="fa fa-file-pdf-o text-red"></i>',
			titleAttr:'Exportar a PDF',
			exportOptions:{
				columns:[1,2,3]
				}}],
            "ajax":
				{
					url: '../ajax/cuenta.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
				"bDestroy": true,
				"iDisplayLength":8,//Paginación
				"order": [[ 1, "asc" ]],//Ordenar (columna,orden)
				"scrollX":true
	});
	
	$('span.numberf').number( true, 2);
}

//Función para guardar o editar
function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/cuenta.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarform(false);
			  listar();
	    }
	});
	limpiar();
}

function mostrar(idcuenta)
{
	$.post("../ajax/cuenta.php?op=mostrar",{idcuenta : idcuenta}, function(data)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$("#idbanco").val(data.idbanco);
		$("#cod_banco").val(data.cod_banco);
		$("#desc_banco").val(data.desc_banco);
		$("#cod_moneda").val(data.cod_moneda);
		$("#tipo").val(data.tipo);
		$('#tipo').niceSelect('update');
		$("#cod_cuenta").val(data.cod_cuenta);
		$("#desc_cuenta").val(data.desc_cuenta);
		$("#numcuenta").val(data.numcuenta);
		$("#agencia").val(data.agencia);
		$("#ejecutivo").val(data.ejecutivo);
		$("#direccion").val(data.direccion);
		$("#telefono").val(data.telefono);
		$("#email").val(data.email);
		$("#saldod").val(data.saldod);
		$("#saldoh").val(data.saldoh);
		$("#saldot").val(data.saldot);
		$("#fechareg").val(data.fechareg);
		$("#idcuenta").val(data.idcuenta);
		$("*[rel=tooltip]").tooltip();

 	})
}

//Función para desactivar registros
function desactivar(idcuenta)
{
	bootbox.confirm({message:"¿Está Seguro de Desactivar el Registro?",
		buttons:{confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/cuenta.php?op=desactivar", {idcuenta : idcuenta}, function(e){
        		bootbox.alert(e);
				listar();
        	});	
        }
	}});
}

//Función para activar registros
function activar(idcuenta)
{
	bootbox.confirm({message:"¿Está Seguro de Activar el Registro?",buttons:{
		confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/cuenta.php?op=activar", {idcuenta : idcuenta}, function(e){
        		bootbox.alert(e);
				listar();
        	});	
        }
	}});
}

//Función para activar registros
function eliminar(idcuenta)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/cuenta.php?op=eliminar", {idcuenta : idcuenta}, function(e){
        		bootbox.alert(e);
	            listar();
        	});	
        }
	}});
}

function MostrarModal(){

	$('#desc_banco').click(function(){
		$("#ModalAddBanco").modal('show');

	});
}

function listarBanco(){
	tablap==$('#tblistadobanco').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [],
             "ajax":
				{
					url: '../ajax/cuenta.php?op=listarBanco',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
				"bDestroy": true,
				"iDisplayLength":8,//Paginación
				"order": [[ 1, "asc" ]]//Ordenar (columna,orden)

	}).dataTable();
}

function agregarBanco(idbanco,cod_banco,desc_banco,cod_moneda){
	
	$("#idbanco").val(idbanco);
	$("#cod_banco").val(cod_banco);
	$("#desc_banco").val(desc_banco);
	$("#cod_moneda").val(cod_moneda);
	
	$("#ModalAddBanco").modal('toggle');		
}

$(document).ready(function(){  
	
	$("*[rel=tooltip]").tooltip();

	$("input[type=textc]").keyup(function(){ 
		$(this).val( $(this).val().toUpperCase());
	});	

	//desabilitar Tecla Intro al enviar formularios
	$("#formulario").keypress(function(e) {
		if (e.which == 13) {
			return false;
		}
	});

	$(".ffechareg").datepicker ({
		format:"yyyy-mm-dd",
		autoclose: true,
	});

	$('span.numberf').number( true, 2);
  
});

init();