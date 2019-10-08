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
	$("#idcategoria").val("");
	$("#cod_categoria").val("");
	$("#desc_categoria").val("");
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
			className:''},
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
					url: '../ajax/categoria.php?op=listar',
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
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/categoria.php?op=guardaryeditar",
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

function mostrar(idcategoria)
{
	$.post("../ajax/categoria.php?op=mostrar",{idcategoria : idcategoria}, function(data)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$("#idcategoria").val(data.idcategoria);
		$("#cod_categoria").val(data.cod_categoria);
		$("#desc_categoria").val(data.desc_categoria)
		$("*[rel=tooltip]").tooltip();

 	})
}

//Función para desactivar registros
function desactivar(idcategoria)
{

	bootbox.confirm({message:"¿Está Seguro de Desactivar el Registro?",
		buttons:{confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/categoria.php?op=desactivar", {idcategoria : idcategoria}, function(e){
        		bootbox.alert(e);
				listar();
        	});	
        }
	}});
}

//Función para activar registros
function activar(idcategoria)
{
	bootbox.confirm({message:"¿Está Seguro de Activar el Registro?",buttons:{
		confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/categoria.php?op=activar", {idcategoria : idcategoria}, function(e){
        		bootbox.alert(e);
				listar();
        	});	
        }
	}});
}

//Función para activar registros
function eliminar(idcategoria)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/categoria.php?op=eliminar", {idcategoria : idcategoria}, function(e){
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
    
});

init();