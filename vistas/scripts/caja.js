var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	$('span.numberf').number( true, 2);

	$("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	})

	$.post("../ajax/caja.php?op=selectMoneda", function(r){
		$("#idmoneda").html(r);
		$('#idmoneda').selectpicker('refresh');
	});
}

//Función limpiar
function limpiar(){

	$("#idcaja").val("");
	$("#idmoneda").val("");
	$('#idmoneda').selectpicker('refresh');
	$("#cod_caja").val("");
	$("#desc_caja").val("");
	$("#saldoefectivo").val("");
	$("#saldodocumento").val("");
	$("#saldototal").val("");
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
					url: '../ajax/caja.php?op=listar',
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
	$('span.numberf').number( true, 2);       
}

//Función para guardar o editar
function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/caja.php?op=guardaryeditar",
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

function mostrar(idcaja)
{
	$.post("../ajax/caja.php?op=mostrar",{idcaja : idcaja}, function(d)
	{
		d = JSON.parse(d);		
		mostrarform(true);
		$("#idcaja").val(d.idcaja);
		$('#idmoneda').val(d.idmoneda);
		$('#idmoneda').selectpicker('refresh');
		$("#cod_caja").val(d.cod_caja);
		$("#desc_caja").val(d.desc_caja);
		$("#saldoefectivo").val(d.saldoefectivo);
		$("#saldodocumento").val(d.saldodocumento);
		$("#saldototal").val(d.saldototal);
		$("#fechareg").val(d.fechareg);
		$("*[rel=tooltip]").tooltip();

 	})
}

//Función para desactivar registros
function desactivar(idcaja)
{
	bootbox.confirm({message:"¿Está Seguro de Desactivar el Registro?",
		buttons:{confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/caja.php?op=desactivar", {idcaja : idcaja}, function(e){
        		bootbox.alert(e);
				listar();
        	});	
        }
	}});
}

//Función para activar registros
function activar(idcaja)
{
	bootbox.confirm({message:"¿Está Seguro de Activar el Registro?",buttons:{
		confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/caja.php?op=activar", {idcaja : idcaja}, function(e){
        		bootbox.alert(e);
				listar();
        	});	
        }
	}});
}

//Función para activar registros
function eliminar(idcaja)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/caja.php?op=eliminar", {idcaja : idcaja}, function(e){
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

	$('span.numberf').number( true, 2);
    
});

init();