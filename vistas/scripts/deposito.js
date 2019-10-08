var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	EventoChk();

	$("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	})

}

//Función limpiar
function limpiar(){

	$("#iddeposito").val("");
	$("#cod_deposito").val("");
	$("#desc_deposito").val("");
	$("#responsable").val("");
	$("#direccion").val("");
	$("#solocompra").val("");
	$("#soloventa").val("");
	$("#fechareg").val("");

		//Obtenemos la fecha actual
		var now = new Date();
		var dia = ("0" + now.getDate()).slice(-2);
		var mes = ("0" + (now.getMonth() + 1)).slice(-2);
		var anne = now.getFullYear();
		var today = (anne) +"-"+ (mes) +"-"+ (dia);
		$('#fechareg').val(today);
}

function EventoChk()
{	
	$("#solocompra").show(function() {
		var value =$(this).val();
		if (value==0) {
			$('#solocompra').prop('checked', false);		
		} else {
			$("#solocompra").prop('checked', true);
		}
	});

	$("#soloventa").show(function() {
		var value =$(this).val();
		if (value==0) {
			$('#soloventa').prop('checked', false);
		} else {
			$("#soloventa").prop('checked', true);
		}
	});
}

//Función mostrar formulario
function mostrarform(flag){

	limpiar();
	EventoChk();
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
				columns:[1,2,3,4,5]
				}},
            {
            extend:'excelHtml5',
            text:'<span class="fa fa-file-excel-o text-green"></span>',
			titleAttr:'Exportar a Excel',
			exportOptions:{
				columns:[1,2,3,4,5]
				}},
            {
            extend:'csvHtml5',
            text:'<i class="fa fa-file-text-o text-purple"></i>',
			titleAttr:'Exportar a Texto',
			exportOptions:{
				columns:[1,2,3,4,5]
				}},
            {
            extend:'pdf',
            text:'<i class="fa fa-file-pdf-o text-red"></i>',
			titleAttr:'Exportar a PDF',
			exportOptions:{
				columns:[1,2,3,4,5]
				}}],
            "ajax":
				{
					url: '../ajax/deposito.php?op=listar',
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

	if($("#solocompra").is(':checked')) {  
		$("#solocompra").val("1"); 
	} else {  
		$("#solocompra").val("0");
	}


	if($("#soloventa").is(':checked')) {  
		$("#soloventa").val("1"); 
	} else {  
		$("#soloventa").val("0");
	}

	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/deposito.php?op=guardaryeditar",
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

function mostrar(iddeposito)
{
	$.post("../ajax/deposito.php?op=mostrar",{iddeposito : iddeposito}, function(d)
	{
		d = JSON.parse(d);		
		mostrarform(true);
		$("#iddeposito").val(d.iddeposito);
		$("#cod_deposito").val(d.cod_deposito);
		$("#desc_deposito").val(d.desc_deposito);
		$("#responsable").val(d.responsable);
		$("#direccion").val(d.direccion);
		$("#solocompra").val(d.solocompra);
		$("#soloventa").val(d.soloventa);
		$("#fechareg").val(d.fechareg);
		$("*[rel=tooltip]").tooltip();
		EventoChk();

 	})
}

//Función para desactivar registros
function desactivar(iddeposito)
{
	bootbox.confirm({message:"¿Está Seguro de Desactivar el Registro?",
		buttons:{confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/deposito.php?op=desactivar", {iddeposito : iddeposito}, function(e){
        		bootbox.alert(e);
				listar();
        	});	
        }
	}});
}

//Función para activar registros
function activar(iddeposito)
{
	bootbox.confirm({message:"¿Está Seguro de Activar el Registro?",buttons:{
		confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/deposito.php?op=activar", {iddeposito : iddeposito}, function(e){
        		bootbox.alert(e);
				listar();
        	});	
        }
	}});
}

//Función para activar registros
function eliminar(iddeposito)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/deposito.php?op=eliminar", {iddeposito : iddeposito}, function(e){
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

	$(".ffechareg").datepicker ({
		format:"yyyy-mm-dd",
		autoclose: true,
	});

    
});

init();