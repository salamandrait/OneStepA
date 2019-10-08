var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	
	//Mostramos los permisos
	$.post("../ajax/usuario.php?op=accesosg&id=",function(r){
		$("#accesosg").html(r);
	});

	$.post("../ajax/usuario.php?op=accesoscf&id=",function(r){
		$("#accesoscf").html(r);
	});

	$.post("../ajax/usuario.php?op=accesosi&id=",function(r){
		$("#accesosi").html(r);
	});

	$.post("../ajax/usuario.php?op=accesosc&id=",function(r){
		$("#accesosc").html(r);
	});

	$.post("../ajax/usuario.php?op=accesosv&id=",function(r){
		$("#accesosv").html(r);
	});

	$.post("../ajax/usuario.php?op=accesosb&id=",function(r){
		$("#accesosb").html(r);
	});
}

//Función limpiar
function limpiar()
{
    $("#cod_usuario").val("");
    $("#desc_usuario").val("");	
	$("#departamento").niceSelect('update');
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
    $("#clave").val("");
    $("#fechareg").val("");
	$("#imagenmuestra").attr("src","");
	$("#imagenactual").hide();
    $("#idusuario").val("");
    
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
		$("#imagenactual").hide();
		$("#imagenmuestra").hide();
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
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        columnDefs:[{
			"targets":'nd',
			"orderable":false,
			"searchable":false,	
		}],
	    buttons : [
            {extend:'copyHtml5',
            text:'<i class="fa fa-file-archive-o text-blue"></i>',
			titleAttr:'Copiar',
			className:'htmlButton'},
            {
            extend:'excelHtml5',
            text:'<i class="fa fa-file-excel-o text-green"></i>',
			titleAttr:'Exportar a Excel',
			className:'excelButton',
			exportOptions:{
				columns:[1,2,3,4]
				}},
            {
            extend:'csvHtml5',
            text:'<i class="fa fa-file-text-o text-purple"></i>',
			titleAttr:'Exportar a Texto',
			className:'textButton',
			exportOptions:{
				columns:[1,2,3,4]
				}},
            {
            extend:'pdf',
            text:'<i class="fa fa-file-pdf-o text-red"></i>',
			titleAttr:'Exportar a PDF',
			className:'pdfButton',
			exportOptions:{
				columns:[1,2,3,4]
				}}],
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/usuario.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 8,//Paginación
	    "order": [[ 1, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}

//Función para guardar o editar
function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

    bootbox.confirm({message:"¿Está Seguro de Guardar el Registro?, Recuerde que debe Salir e Ingresar Nuevamente para hacer Efectivo los cambios de Acceso!",
	buttons:{confirm:{label: 'Ok',className:'btn-primary btn-sm'},cancel:{label: 'Cancelar',className:'btn-danger btn-sm'}},
	callback:function(result){
		if(result){

			$.ajax({
				url: "../ajax/usuario.php?op=guardaryeditar",
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
		
				success: function(datos)
				{                    
					bootbox.alert(datos);	          
					mostrarform(false);
					listar();
					Salir();
				}
			
			});
		limpiar();
		}
	}});
}

function Salir(){

	$.ajax({
		url: "../ajax/usuario.php?op=salir",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function()
	    {                            
			  tabla.ajax.reload();		
	    }
		
	});
}

function mostrar(idusuario)
{
	$.post("../ajax/usuario.php?op=mostrar",{idusuario : idusuario}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#desc_usuario").val(data.desc_usuario);
		$("#departamento").val(data.departamento);
		$("#departamento").niceSelect('update');
		$("#fechareg").val(data.fechareg);
		$("#direccion").val(data.direccion);
		$("#telefono").val(data.telefono);
		$("#email").val(data.email);
		$("#cod_usuario").val(data.cod_usuario);
		$("#clave").val("");
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/usuarios/"+data.imagen);
		$("#imagenactual").val(data.imagen);
		$("#idusuario").val(data.idusuario);

	 });

	$.post("../ajax/usuario.php?op=accesoscf&id="+idusuario,function(r){	
		$("#accesoscf").html(r);		
	});
	 
 	$.post("../ajax/usuario.php?op=accesosg&id="+idusuario,function(r){
		$("#accesosg").html(r);	
	});

	$.post("../ajax/usuario.php?op=accesosi&id="+idusuario,function(r){	
		$("#accesosi").html(r);		
	});

	$.post("../ajax/usuario.php?op=accesosc&id="+idusuario,function(r){
		$("#accesosc").html(r);	
	});

	$.post("../ajax/usuario.php?op=accesosv&id="+idusuario,function(r){	
		$("#accesosv").html(r);		
	});

	$.post("../ajax/usuario.php?op=accesosb&id="+idusuario,function(r){	
		$("#accesosb").html(r);		
	});

}

//Función para desactivar registros
function desactivar(idusuario)
{
	bootbox.confirm({message:"¿Está Seguro de Desactivar el Registro?",
	buttons:{confirm:{label: 'Ok',className:'btn-primary btn-sm'},cancel:{label: 'Cancelar',className:'btn-danger btn-sm'}},
	callback:function(result){
		if(result)
        {
        	$.post("../ajax/usuario.php?op=desactivar", {idusuario : idusuario}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	}})
}

//Función para activar registros
function activar(idusuario)
{
	bootbox.confirm({message:"¿Está Seguro de Activar el Registro?",
	buttons:{confirm:{label: 'Ok',className:'btn-primary btn-sm'},cancel:{label: 'Cancelar',className:'btn-danger btn-sm'}},
	callback:function(result){
		if(result)
        {
        	$.post("../ajax/usuario.php?op=activar", {idusuario : idusuario}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	}});
}

//Función para eliminar registros
function eliminar(idusuario)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",
	buttons:{confirm:{label: 'Ok',className:'btn-primary btn-sm'},cancel:{label: 'Cancelar',className:'btn-danger btn-sm'}},
	callback:function(result){
		if(result)
        {
        	$.post("../ajax/usuario.php?op=eliminar", {idusuario : idusuario}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	}});
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

	$("input[type=textc]").keyup(function() 
	{ 
		$(this).val( $(this).val().toUpperCase());
	});	



	$(".ffechareg").datepicker ({
		format:"yyyy-mm-dd",
		autoclose:true,
	});

	$("#btnagregar").click( function(){
		
	});


});

init();