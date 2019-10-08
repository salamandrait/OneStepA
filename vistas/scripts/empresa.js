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

	$("#idempresa").val("");
	$("#cod_empresa").val("");
	$("#desc_empresa").val("");
	$("#rif").val("");
	$("#direccion").val("");
	$("#codpostal").val("");
	$("#telefono").val("");
	$("#movil").val("");
	$("#contacto").val("");
	$("#email").val("");
	$("#web").val("");
	$("#imagen1").val("");
	$("#imagen2").val("");
	$("#esfiscal").val("");
	$("#montofiscal").val("");
	$("#imagen1muestra").attr("src", "");
	$("#imagen1actual").val("");
	$("#imagen2muestra").attr("src", "");
	$("#imagen2actual").val("");
	$("#imagen1actual").hide();
	$("#imagen1muestra").hide();
	$("#imagen2actual").hide();
	$("#imagen2muestra").hide()

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
		$("#imagen1actual").hide();
		$("#imagen1muestra").hide();
		$("#imagen2actual").hide();
		$("#imagen2muestra").hide();
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
					url: '../ajax/empresa.php?op=listar',
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
	if($("#esfiscal").is(':checked')) { 		 		
		$("#esfiscal").val("1"); 
		
	} else {  
		$("#esfiscal").val("0");

	}

	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/empresa.php?op=guardaryeditar",
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

function mostrar(idempresa)
{
	$.post("../ajax/empresa.php?op=mostrar",{idempresa : idempresa}, function(data)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#cod_empresa").val(data.cod_empresa);
		$("#desc_empresa").val(data.desc_empresa);
		$("#rif").val(data.rif);
		$("#direccion").val(data.direccion);
		$("#codpostal").val(data.codpostal);
		$("#telefono").val(data.telefono);
		$("#movil").val(data.movil);
		$("#contacto").val(data.contacto);
		$("#email").val(data.email);
		$("#web").val(data.web);
		$("#imagen1muestra").show();
		$("#imagen1muestra").attr("src","../files/logo/"+data.imagen1);
		$("#imagen1actual").val(data.imagen1);
		$("#imagen2muestra").show();
		$("#imagen2muestra").attr("src","../files/logo/"+data.imagen2);
		$("#imagen2actual").val(data.imagen2);
		$("#esfiscal").val(data.esfiscal);
		$("#montofiscal").val(data.montofiscal);
		$("#idempresa").val(data.idempresa);
		$("*[rel=tooltip]").tooltip();
		EventoChk();
 	})
}

//Función para desactivar registros
function desactivar(idempresa)
{
	bootbox.confirm({message:"¿Está Seguro de Desactivar el Registro?",
		buttons:{confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/empresa.php?op=desactivar", {idempresa : idempresa}, function(e){
        		bootbox.alert(e);
				listar();
        	});	
        }
	}});
}

//Función para activar registros
function activar(idempresa)
{
	bootbox.confirm({message:"¿Está Seguro de Activar el Registro?",buttons:{
		confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/empresa.php?op=activar", {idempresa : idempresa}, function(e){
        		bootbox.alert(e);
				listar();
        	});	
        }
	}});
}

//Función para activar registros
function eliminar(idempresa)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/empresa.php?op=eliminar", {idempresa : idempresa}, function(e){
        		bootbox.alert(e);
	            listar();
        	});	
        }
	}});
}

function EventoChk()
{	
	$("#esfiscal").show(function() {
		var value =$(this).val();
		if (value==0) {
			$('#esfiscal').prop('checked', false);
			$("#montofiscal").prop('readonly',true);
			$("#montofiscal").val("0");
		} else {
			$("#esfiscal").prop('checked', true);
			$("#montofiscal").prop('readonly',false);
		}
	});
}

jQuery('input[type=file]').change(function(){
	var filename = jQuery(this).val().split('\\').pop();
	var idname = jQuery(this).attr('id');
	console.log(jQuery(this));
	console.log(filename);
	console.log(idname);
	jQuery('span.'+idname).next().find('span').html(filename);
});



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