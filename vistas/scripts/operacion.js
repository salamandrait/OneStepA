var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	})
}

//Función limpiar
function limpiar(){
	$("#idoperacion").val("");
	$("#cod_operacion").val("");
	$("#desc_operacion").val("");
	$("#escompra").val("");
	$("#esventa").val("");
	$("#esinventario").val("");
	$("#esbanco").val("");
	$("#esconfig").val("");
	
}

//Función mostrar formulario
function mostrarform(flag){

	EventoChk();
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
				columns:[1,2,3,4,5,6,7,8]
				}},
            {
            extend:'excelHtml5',
            text:'<span class="fa fa-file-excel-o text-green"></span>',
			titleAttr:'Exportar a Excel',
			exportOptions:{
				columns:[1,2,3,4,5,6,7,8]
				}},
            {
            extend:'csvHtml5',
            text:'<i class="fa fa-file-text-o text-purple"></i>',
			titleAttr:'Exportar a Texto',
			exportOptions:{
				columns:[1,2,3,4,5,6,7,8]
				}},
            {
            extend:'pdf',
            text:'<i class="fa fa-file-pdf-o text-red"></i>',
			titleAttr:'Exportar a PDF',
			exportOptions:{
				columns:[1,2,3,4,5,6,7,8]
				}}],
            "ajax":
				{
					url: '../ajax/operacion.php?op=listar',
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
}

//Función para guardar o editar
function guardaryeditar(e)
{
	if($("#esventa").is(':checked')) {  
		$("#esventa").val("1"); 
	} else {  
		$("#esventa").val("0");
	}  

	if($("#escompra").is(':checked')) {  
		$("#escompra").val("1"); 
	} else {  
		$("#escompra").val("0");
	} 

	if($("#esconfig").is(':checked')) {  
		$("#esconfig").val("1"); 
	} else {  
		$("#esconfig").val("0");
	} 

	if($("#esinventario").is(':checked')) {  
		$("#esinventario").val("1"); 
	} else {  
		$("#esinventario").val("0");
	} 

	if($("#esbanco").is(':checked')) {  
		$("#esbanco").val("1"); 
	} else {  
		$("#esbanco").val("0");
	} 

	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/operacion.php?op=guardaryeditar",
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

function mostrar(idoperacion)
{
	$.post("../ajax/operacion.php?op=mostrar",{idoperacion : idoperacion}, function(data)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$("#idoperacion").val(data.idoperacion);
		$("#cod_operacion").val(data.cod_operacion);
		$("#desc_operacion").val(data.desc_operacion);
		$("#escompra").val(data.escompra);
		$("#esventa").val(data.esventa);
		$("#esinventario").val(data.esinventario);
		$("#esbanco").val(data.esbanco);
		$("#esconfig").val(data.esconfig);
		$("*[rel=tooltip]").tooltip();
		EventoChk();

 	})
}

//Función para desactivar registros
function desactivar(idoperacion)
{
	bootbox.confirm({message:"¿Está Seguro de Desactivar el Registro?",
		buttons:{confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/operacion.php?op=desactivar", {idoperacion : idoperacion}, function(e){
        		bootbox.alert(e);
				listar();
        	});	
        }
	}});
}

//Función para activar registros
function activar(idoperacion)
{
	bootbox.confirm({message:"¿Está Seguro de Activar el Registro?",buttons:{
		confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/operacion.php?op=activar", {idoperacion : idoperacion}, function(e){
        		bootbox.alert(e);
				listar();
        	});	
        }
	}});
}

//Función para activar registros
function eliminar(idoperacion)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/operacion.php?op=eliminar", {idoperacion : idoperacion}, function(e){
        		bootbox.alert(e);
	            listar();
        	});	
        }
	}});
}

function EventoChk()
{	
	$("#escompra").show(function() {
		var value =$(this).val();
		if (value==0) {
			$('#escompra').prop('checked', false);
		} else {
			$("#escompra").prop('checked', true);
		}
	});

	$("#esventa").show(function() {
		var value =$(this).val();
		if (value==0) {
			$('#esventa').prop('checked', false);
		} else {
			$("#esventa").prop('checked', true);
		}
	});

	$("#esinventario").show(function() {
		var value =$(this).val();
		if (value==0) {
			$('#esinventario').prop('checked', false);
		} else {
			$("#esinventario").prop('checked', true);
		}
	});

	$("#esbanco").show(function() {
		var value =$(this).val();
		if (value==0) {
			$('#esbanco').prop('checked', false);
		} else {
			$("#esbanco").prop('checked', true);
		}
	});

	$("#esconfig").show(function() {
		var value =$(this).val();
		if (value==0) {
			$('#esconfig').prop('checked', false);
		} else {
			$("#esconfig").prop('checked', true);
		}
	});
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

	EventoChk();
    
});

init();