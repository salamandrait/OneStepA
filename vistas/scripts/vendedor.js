var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})
}

//Función limpiar
function limpiar()
{
	$("#idvendedor").val("");
	$("#cod_vendedor").val("");
	$("#desc_vendedor").val("");
	$("#rif").val("");
	$("#direccion").val("");
	$("#fechareg").val(""); 
	$("#comisionv").val(""); 
	$("#comisionc").val(""); 
	$("#esvendedor").val("0"); 
	$("#escobrador").val("0");

	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today =  now.getFullYear()+ "-" +(month) + "-" +(day);
	$('#fechareg').val(today);
}

//Función mostrar formulario
function mostrarform(flag)
{
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
function cancelarform()
{
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
				columns:[1,2,3,4,5,6]
				}},
            {
            extend:'excelHtml5',
            text:'<span class="fa fa-file-excel-o text-green"></span>',
			titleAttr:'Exportar a Excel',
			exportOptions:{
				columns:[1,2,3,4,5,6]
				}},
            {
            extend:'csvHtml5',
            text:'<i class="fa fa-file-text-o text-purple"></i>',
			titleAttr:'Exportar a Texto',
			exportOptions:{
				columns:[1,2,3,4,5,6]
				}},
            {
            extend:'pdf',
            text:'<i class="fa fa-file-pdf-o text-red"></i>',
			titleAttr:'Exportar a PDF',
			exportOptions:{
				columns:[1,2,3,4,5,6]
				}}],
            "ajax":
				{
					url: '../ajax/vendedor.php?op=listar',
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
	if($("#escobrador").is(':checked')) {  
		$("#escobrador").val("1"); 
	} else {  
		$("#escobrador").val("0");
	} 

	if($("#esvendedor").is(':checked')) {  
		$("#esvendedor").val("1"); 
	} else {  
		$("#esvendedor").val("0");
	}


	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/vendedor.php?op=guardaryeditar",
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

function mostrar(idvendedor)
{
	$.post("../ajax/vendedor.php?op=mostrar",{idvendedor : idvendedor}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$("#idvendedor").val(data.idvendedor);
		$("#cod_vendedor").val(data.cod_vendedor);
		$("#desc_vendedor").val(data.desc_vendedor);
		$("#rif").val(data.rif);
		$("#direccion").val(data.direccion);
		$("#fechareg").val(data.fechareg); 
		$("#comisionv").val(data.comisionv); 
		$("#comisionc").val(data.comisionc); 
		$("#esvendedor").val(data.esvendedor); 
		$("#escobrador").val(data.escobrador);
		EventoChk();
		$("*[rel=tooltip]").tooltip();

 	})
}

function EventoChk()
{	
	$("#esvendedor").show(function() {
		var value =$(this).val();
		if (value==0) {
			$('#esvendedor').prop('checked', false);
		} else {
			$("#esvendedor").prop('checked', true);
		}
	});

	$("#escobrador").show(function() {
		var value =$(this).val();
		if (value==0) {
			$('#escobrador').prop('checked', false);
		} else {
			$("#escobrador").prop('checked', true);
		}
	});
}

//Función para activar registros
function desactivar(idvendedor)
{
	bootbox.confirm({message:"¿Está Seguro de Desactivar el Registro?",
		buttons:{confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/vendedor.php?op=desactivar", {idvendedor : idvendedor}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	}});
}

//Función para activar registros
function activar(idvendedor)
{
	bootbox.confirm({message:"¿Está Seguro de Activar el Registro?",
		buttons:{confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/vendedor.php?op=activar", {idvendedor : idvendedor}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	}});
}

//Función para activar registros
function eliminar(idvendedor)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",
		buttons:{confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/vendedor.php?op=eliminar", {idvendedor : idvendedor}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	}});
}

$(document).ready(function(){  
	
	$("*[rel=tooltip]").tooltip();

	$("input[type=textc]").keyup(function() { 
	    $(this).val( $(this).val().toUpperCase());
	});	

	$(".ffechareg").datepicker ({
		format:"yyyy-mm-dd",
		autoclose:true,
		
	});
});

init();