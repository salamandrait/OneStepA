var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();	
	$('span.numberf').number( true, 2);	

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	//Cargamos los items al select 
	$.post("../ajax/proveedor.php?op=selectTipoProveedor", function(r){
			$("#idtipoproveedor").html(r);
			$('#idtipoproveedor').selectpicker('refresh');
	});

	$.post("../ajax/proveedor.php?op=selectZona", function(r){
			$("#idzona").html(r);
			$('#idzona').selectpicker('refresh');
	});

	$.post("../ajax/proveedor.php?op=selectOperacion", function(r){
			$("#idoperacion").html(r);
			$('#idoperacion').selectpicker('refresh');
	});
}

//Función limpiar
function limpiar()
{
    $("#idtipoproveedor").val("");  
    $('#idtipoproveedor').selectpicker('refresh');  
    $("#idzona").val("");
    $('#idzona').selectpicker('refresh');  	
    $("#idoperacion").val("");
    $('#idoperacion').selectpicker('refresh');

	$("#cod_proveedor").val("");
	$("#desc_proveedor").val("");
	$("#rif").val("");
	$("#direccion").val("");
	$("#ciudad").val("");
	$("#codpostal").val("");
	$("#contacto").val("");
	$("#telefono").val("");
	$("#movil").val("");
	$("#email").val("");
	$("#web").val("");
	$("#diascredito").val("0");
	$("#limite").val("0");
	$("#saldo").val("0");
	$("#montofiscal").val("");
	$("#fechareg").val("");
	$("#aplicareten").val("0");
	$("#aplicacredito").val("0");
	$("#idproveedor").val("");

	$('#aplicacredito').attr('checked', false);
	$('#aplicareten').attr('checked', false);

	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today =  now.getFullYear()+ "-" +(month) + "-" +(day);
	$('#fechareg').val(today);
	
}

function EventoChk()
{	
	$("#aplicareten").show(function() {
		var value =$(this).val();
		if (value==0) {
			$('#aplicareten').prop('checked', false);		
		} else {
			$("#aplicareten").prop('checked', true);
		}
	});

	$("#aplicaretenn").show(function() {
		var value =$(this).val();
		if (value==0) {
			$('#aplicaretenn').prop('checked', false);
		} else {
			$("#aplicaretenn").prop('checked', true);
		}
	});

	$("#aplicacredito").show(function() {
		var value =$(this).val();
		if (value==0) {
			$('#aplicacredito').prop('checked', false);
		} else {
			$("#aplicacredito").prop('checked', true);
		}
	});

	$("#aplicacrediton").show(function() {
		var value =$(this).val();
		if (value==0) {
			$('#aplicacrediton').prop('checked', false);
		} else {
			$("#aplicacrediton").prop('checked', true);
		}
	});
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	EventoChk();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		$("#btnreporte").hide();	
		$("#btnreportelista").hide();
		$("#btnreportecontacto").hide();
		$("#btnreportecuenta").hide();

	}
	else {
		$("#listadoregistros").show();
		$("#formulariocontacto").show();
		$("#formulariosaldo").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
		$("#btnreporte").show();
		$("#btnreportelista").show();
		$("#btnreportecontacto").show();
		$("#btnreportecuenta").show();
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
			exportOptions:{
				columns:[1,2,3,4,5,6,7]
				}},
            {
            extend:'excelHtml5',
            text:'<i class="fa fa-file-excel-o text-green"></i>',
			titleAttr:'Exportar a Excel',
			className:'excelButton',
			exportOptions:{
				columns:[1,2,3,4,5,6,7]
				}},
            {
            extend:'csvHtml5',
            text:'<i class="fa fa-file-text-o text-purple"></i>',
			titleAttr:'Exportar a Texto',
			className:'textButton',
			exportOptions:{
				columns:[1,2,3,4,5,6,7]
				}},
            {
            extend:'pdf',
            text:'<i class="fa fa-file-pdf-o text-red"></i>',
			titleAttr:'Exportar a PDF',
			className:'pdfButton',
			exportOptions:{
				columns:[1,2,3,4,5,6,7]
				}}],
             "ajax":
				{
					url: '../ajax/proveedor.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
				"bDestroy": true,
				"iDisplayLength":8,//Paginación
				"order": [[ 1, "asc" ]],//Ordenar (columna,orden)
				"scrollX":true,
				
	}).DataTable();
	$('span.numberf').number( true, 2);	
}

//Función para guardar o editar
function guardaryeditar(e)
{
	if($("#aplicareten").is(':checked')) {  
		$("#aplicareten").val("1"); 
	} else {  
		$("#aplicareten").val("0");
	}  

	if($("#aplicacredito").is(':checked')) {  
		$("#aplicacredito").val("1");
	} else {  
		$("#aplicacredito").val("0");
	}

	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/proveedor.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos){                    
	          bootbox.alert(datos);	          
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}

function mostrar(idproveedor)
{
	$.post("../ajax/proveedor.php?op=mostrar",{idproveedor : idproveedor}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$("#idzona").val(data.idzona);
		$("#idzona").selectpicker('refresh');
		$("#idtipoproveedor").val(data.idtipoproveedor);
		$("#idtipoproveedor").selectpicker('refresh');	
		$("#idoperacion").val(data.idoperacion);
		$("#idoperacion").selectpicker('refresh');

		$("#cod_proveedor").val(data.cod_proveedor);
		$("#desc_proveedor").val(data.desc_proveedor);
		$("#rif").val(data.rif);
		$("#direccion").val(data.direccion);
		$("#desc_fpago").val(data.desc_fpago);
		$("#plazo").val(data.plazo);
		$("#ciudad").val(data.ciudad);
		$("#codpostal").val(data.codpostal);
		$("#contacto").val(data.contacto);
		$("#telefono").val(data.telefono);
		$("#movil").val(data.movil);
		$("#email").val(data.email);
		$("#web").val(data.web);
		$("#diascredito").val(data.diascredito);
		$("#limite").val(data.limite);
		$("#saldo").val(data.saldo);
		$("#montofiscal").val(data.montofiscal);
		$("#fechareg").val(data.fechareg);
		$("#aplicacredito").val(data.aplicacredito);
		$("#aplicareten").val(data.aplicareten);
		$("#idproveedor").val(data.idproveedor);
		EventoChk();
		$("*[rel=tooltip]").tooltip();
	
 	})
}

function mostrarcontacto(idproveedor)
{
	$.post("../ajax/proveedor.php?op=mostrarcontacto",{idproveedor : idproveedor}, function(data, status)
		{
			data = JSON.parse(data);		
			$("#cod_proveedorm").val(data.cod_proveedor);
			$("#desc_proveedorm").val(data.desc_proveedor);
			$("#contactom").val(data.contacto);
			$("#telefonom").val(data.telefono);
			$("#movilm").val(data.movil);
			$("#emailm").val(data.email);
			$("#webm").val(data.web);
			$("#idproveedorm").val(data.idproveedor);
		});
}

function mostrarsaldo(idproveedor)
{
	$.post("../ajax/proveedor.php?op=mostrarsaldo",{idproveedor : idproveedor}, function(data, status)
		{
			data = JSON.parse(data);		
			$("#cod_proveedorn").val(data.cod_proveedor);
			$("#desc_proveedorn").val(data.desc_proveedor);
			$("#diascrediton").val(data.diascredito);
			$("#limiten").val(data.limite);
			$("#saldon").val(data.saldo);
			$("#montofiscaln").val(data.montofiscal);
			$("#aplicacrediton").val(data.aplicacredito);
			$("#aplicaretenn").val(data.aplicareten);
			$("#idproveedorn").val(data.idproveedor);
			EventoChk();
		});
}

//Función para desactivar registros
function desactivar(idproveedor)
{
	bootbox.confirm({message:"¿Está Seguro de Desactivar el Registro?",
		buttons:{confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/proveedor.php?op=desactivar", {idproveedor : idproveedor}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	}});
}

//Función para activar registros
function activar(idproveedor)
{
	bootbox.confirm({message:"¿Está Seguro de Activar el Registro?",
		buttons:{confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/proveedor.php?op=activar", {idproveedor : idproveedor}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	}});
}

//Función para eliminar registros
function eliminar(idproveedor)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",
		buttons:{confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/proveedor.php?op=eliminar", {idproveedor : idproveedor}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	}});
}

$(document).ready(function(){  
	
	$("*[rel=tooltip]").tooltip();

	$("input[type=textc]").keyup(function() 
	{ 
	$(this).val( $(this).val().toUpperCase());
	});
	
	$(".ffechareg").datepicker ({
		format:"yyyy-mm-dd",
		autoclose:"true",
	});

	$("#aplicareten").on('change', function()
	 {
	 	if( $(this).is(':checked'))
	 	{		
	 		bootbox.alert("Indique el Procentaje de Retencion");
	 		$("#montofiscal").focus(function(){
	 		});
	 		$("#montofiscal").val("");	
	 	} 
	 	else 
	 	{
	 		$("#montofiscal").val("0");	
	 	}
	});

	 $("#aplicacredito").on('change', function()
	 {
	 	if( $(this).is(':checked'))
	 	{	
			bootbox.alert("Indique el Limite y Dias de Credito!");
			$("#limite").focus(function(){
			});
			$("#limite").val("");
			$("#diascredito").val("");	 	 	
	 	} 
	 	else 
	 	{
			$("#limite").val("0");
			$("#diascredito").val("0");	
	 	}
	});
		 

	$('span.numberf').number( true, 2);	
	
	$("#rif").on('click', function(){
		$(this).val("J-"+$("#cod_proveedor").val());
	});
    
});

init();