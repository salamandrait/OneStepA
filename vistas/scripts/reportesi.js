var tabla;
var lista;
var tipotabla;

//Función que se ejecuta al inicio
function init(){
	MostrarCampos();
	$("#listado1").hide();
	$("#listado2").hide();


	$("#formulario").on("submit",function(e){

	})
}

function MostrarCampos(){
	
	$("#rptlistado").change(function(){
			var optval = $("#rptlistado").val();

		if (optval=="rptCategoria") {
			lista="categoria";
			tipotabla="#tbllistado1";
			$("#listado1").show();
			$("#listado2").hide();
		} else if (optval=="rptUnidad") {
			lista="unidad";
			tipotabla="#tbllistado1";
			$("#listado1").show();
			$("#listado2").hide();
		} else if (optval=="rptArticulo") {
			lista="articulo";
			tipotabla="#tbllistado2";
			$("#listado2").show();
			$("#listado1").hide();
		}	
	});
}

//Función limpiar
function limpiar(){

	$("#idreportesi").val("");
	$("#cod_reportesi").val("");
	$("#desc_reportesi").val("");
}

//Función mostrar formulario
function mostrarform(flag){

	limpiar();
	if (flag)
	{
		//$("#listadoregistros").hide();
		//$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
        $("#btnreporte").hide();
	}
	else
	{
		//$("#listadoregistros").show();
		//$("#formularioregistros").hide();
		$("#btnagregar").show();
        $("#btnreporte").show();  
	}
}

//Función cancelarform
function cancelarform(){

	limpiar();
	mostrarform(false);
}

//Función Listar
function listar(){
	

	tabla=$(tipotabla).dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    //"aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        columnDefs:[{
			"targets":'nd',//clase para definir las columnas a tratar
			"orderable":false,//Definimos no ordenar por esta columna
			"searchable":false,//Definimos no buscar por esta columna
		}],

	    buttons : [],
            "ajax":
				{
					url: '../ajax/'+lista+'.php?op=listarrpt',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
			},
			"bDestroy": true,
			"iDisplayLength":8,//Paginación
			"order": [[ 1, "asc" ]]//Ordenar (columna,orden)
	});   
	
	$("input[type=search]").show(function(){
		$(this).addClass('hidden');
	});
}

//Función para guardar o editar
function Reporte()
{
	if (optval=="rptCategoria") {
		$.ajax({
			url: "../reportes/rptCategoria.php",
		});
	} 
}

//Función para guardar o editar
function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/reportesi.php?op=guardaryeditar",
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

function mostrar(idreportesi)
{
	$.post("../ajax/reportesi.php?op=mostrar",{idreportesi : idreportesi}, function(d)
	{
		d = JSON.parse(d);		
		mostrarform(true);
		$("#idreportesi").val(d.idreportesi);
		$("#cod_reportesi").val(d.cod_reportesi);
		$("#desc_reportesi").val(d.desc_reportesi)
		$("*[rel=tooltip]").tooltip();

 	})
}

//Función para desactivar registros
function desactivar(idreportesi)
{
	bootbox.confirm({message:"¿Está Seguro de Desactivar el Registro?",
		buttons:{confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/reportesi.php?op=desactivar", {idreportesi : idreportesi}, function(e){
        		bootbox.alert(e);
				listar();
        	});	
        }
	}});
}

//Función para activar registros
function activar(idreportesi)
{
	bootbox.confirm({message:"¿Está Seguro de Activar el Registro?",buttons:{
		confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/reportesi.php?op=activar", {idreportesi : idreportesi}, function(e){
        		bootbox.alert(e);
				listar();
        	});	
        }
	}});
}

//Función para activar registros
function eliminar(idreportesi)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/reportesi.php?op=eliminar", {idreportesi : idreportesi}, function(e){
        		bootbox.alert(e);
	            listar();
        	});	
        }
	}});
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

	MostrarCampos();   
});

init();