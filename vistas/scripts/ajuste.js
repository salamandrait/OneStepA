var tabla;
var iddep;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	$('span.numberf').number( true, 2);	

	$("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	});

	//Cargamos los items al select deposito
	$.post("../ajax/ajuste.php?op=selectDeposito", function (r) {
		$("#iddeposito").html(r);
		$("#iddeposito").val(r);
		$('#iddeposito').niceSelect('update');
	});

}

function generarCod(){	

	$.post("../ajax/ajuste.php?op=generarcodigo", function(r){
		$("#cod_ajuste").val(r);
	});
}

//Función limpiar
function limpiar(){

	$("#iddeposito").val("");
	//$('#iddeposito').selectpicker('refresh');
	$("#idajuste").val("");
	//$("#idusuario").val("");
	//$("#cod_ajuste").val("");
	$("#desc_ajuste").val("");
	$("#estatus").val("Sin Procesar");
	$("#totalstock").html("0.00");
	$("#totalv").val("0.00");
	$("#totalv").html("0.00");
	$("#fechareg").val("");
	$(".filas").remove();

	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day);

	$('#fechareg').val(today);

	$("#tipo").val("Entrada");
	$("#tipo").niceSelect('update');

	$(".controldis").attr("disabled", true);
	
}

function valorDep(){

	$("#iddeposito").change(function () { 
		iddep=$(this).val();	
		listarArticulos();
		$(".controldis").attr("disabled", false);
	});
	
}

//Función mostrar formulario
function mostrarform(flag){

	limpiar();
	if (flag){

		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnagregar").hide();
		$("#btnreporte").hide();

		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		detalles=0;
		$("#btnAgregarArt").attr("disabled",false);
	}
	else {
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
				columns:[1,2,3,3,4,5,6]
				}},
            {
            extend:'excelHtml5',
            text:'<span class="fa fa-file-excel-o text-green"></span>',
			titleAttr:'Exportar a Excel',
			exportOptions:{
				columns:[1,2,3,3,4,5,6]
				}},
            {
            extend:'csvHtml5',
            text:'<i class="fa fa-file-text-o text-purple"></i>',
			titleAttr:'Exportar a Texto',
			exportOptions:{
				columns:[1,2,3,3,4,5,6]
				}},
            {
            extend:'pdf',
            text:'<i class="fa fa-file-pdf-o text-red"></i>',
			titleAttr:'Exportar a PDF',
			exportOptions:{
				columns:[1,2,3,3,4,5,6]
				}}],
            "ajax":
				{
					url: '../ajax/ajuste.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
				"bDestroy": true,
				"iDisplayLength":8,//Paginación
				"select":true,
				"order": [[ 1, "asc" ]]//Ordenar (columna,orden)
	});         
}

//Función para guardar o editar
function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formulario")[0]);	

	var tipom=$("#tipo").val();
	var mensaje="";

	if (tipom=="Inventario") {
		mensaje=" El Ajuste de Inventario de tipo Disponible No puede ser Eliminado o Anulado con respecto a Stock de Inventario! ¿Desea Continuar?";
	} else {
		mensaje="¿Está Seguro de Guardar el Registro?";
	}

	bootbox.confirm({message:mensaje,
	buttons:{confirm:{label: 'Ok',className:'btn-primary btn-sm'},cancel:{label: 'Cancelar',className:'btn-danger btn-sm'}},
	callback:function(result){
		
		if(result)
        {			
			$.ajax({
				url: "../ajax/ajuste.php?op=guardaryeditar",
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
	}});
}

function mostrar(idajuste)
{
	$.post("../ajax/ajuste.php?op=mostrar",{idajuste : idajuste}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$("#tipo").niceSelect('update');
		$("#tipo").attr("disabled",true);
		$("#fechareg").attr("disabled",true);
		$("input[type=text]").attr("readonly",true);
		$("#idajuste").val(data.idajuste);
		$("#idusuario").val(data.idusuario);
		$("#cod_ajuste").val(data.cod_ajuste);
		$("#desc_ajuste").val(data.desc_ajuste);
		$("#tipo").val(data.tipo);
		$("#estatus").val(data.estatus);
		$("#stockajuste").val(data.stockajuste);
		$("#totald").val(data.totald);
		$("#fechareg").val(data.fechareg);

		$(".controldis").attr("disabled", true);

		//Ocultar y mostrar los botones
		$("#guardar").show();
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").attr("disabled",true);
		
		$.post("../ajax/ajuste.php?op=listarDetalle&id="+idajuste,function(r){
			$("#detalles").html(r);

			$('span.numberf').number( true, 2);	
			
		});
		//mas adelante icluir aqui un datatable
		$("*[rel=tooltip]").tooltip();

 	})
}

//Función para anular registros
function anular(idajuste,tipo)
{
	var tipom=$("#tipo").val();
	var mensaje="";

	if (tipom=="Inventario") {
		mensaje=" El Ajuste de Inventario de tipo Disponible No Permite anular los cambios de Stock. Debe verificar el articulo y su Stock Corresondiente! ¿Desea Continuar?";
	} else {
		mensaje="¿Está Seguro de Anular el Registro?";
	}

	bootbox.confirm({message:mensaje,
	buttons:{confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
        {
			$.post("../ajax/ajuste.php?op=anular", {idajuste:idajuste,tipo:tipo}, function(e){
                bootbox.alert(e);									
				mostrarform(false);
				listar();
			});			
        }
	}});
}

//Función para eliminar registros
function eliminar(idajuste,tipo)
{
	var tipom=$("#tipo").val();
	var mensaje="";

	if (tipom=="Inventario") {
		mensaje=" El Ajuste de Inventario de tipo Disponible No Permite Eliminar los cambios de Stock. Debe verificar el articulo y su Stock Corresondiente! ¿Desea Continuar?";
	} else {
		mensaje="¿Está Seguro de Eliminar el Registro?";
	}

	bootbox.confirm({message:mensaje,
	buttons:{confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
        {
			$.post("../ajax/ajuste.php?op=eliminar", {idajuste:idajuste,tipo:tipo}, function(e){
				bootbox.alert(e);									
				mostrarform(false);
				listar();				
        	});	
        }
	}});
}

//Función Listar Articulos
function listarArticulos()
{
	tabla=$('#tbarticulos').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          

				],
				columnDefs:[{
					"targets":'nd',
					"orderable":false,
					"searchable":false,
					
				}],		
		"ajax":
				{
					url: '../ajax/ajuste.php?op=listarArticulos&iddep='+iddep,
					type : "get",
					dataType : "json",						
					error: function(e){console.log(e.responseText);}
				},
		"bDestroy": true,
		"iDisplayLength": 8,//Paginación
	    "order": [[ 1, "asc" ]]//Ordenar (columna,orden)
	}).DataTable();
}

//Declaración de variables necesarias para trabajar con las compras y sus detalles
var impuesto=16;
var cont=0;
var detalles=0;
$("#btnGuardar").hide();

function agregarDetalle(idarticulo,cod_articulo,desc_articulo,iddeposito,desc_deposito,costo1,stock)
{
	var ridarticulo=idarticulo;
	var rcod_articulo=cod_articulo;
	var riddeposito=iddeposito
	var cantidad =stock;
	var costo =costo1;
	var totalt =0;
	
	if(idarticulo=!"")
	{
		var totalt=cantidad*costo;
		var fila='<tr class="filas" id="fila'+cont+'">'+
		'<td style="width:20px; text-align:center;"><button type="button" class="btn btn-danger btn-xs" onclick="eliminarDetalle('+cont+')"><span class="fa fa-times-circle"></span></button></td>'+
		'<td style="text-align:center; width:120px;">'+rcod_articulo+'</td>'+
		'<td style="text-align:left; width:350px;"><input type="hidden" name="idarticulo[]" id="idarticulo" value="'+ridarticulo+'">'+desc_articulo+'</td>'+
		'<td style="text-align:left; width:120px;"><input type="hidden" name="iddeposito[]" id="iddeposito" value="'+riddeposito+'">'+desc_deposito+'</td>'+
		'<td style="text-align:right; width:120px;"><input type="text" onchange="modificarSubtotales();" style="text-align:right; width:120px;" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
		'<td style="text-align:right; width:120px;"><input type="text" onchange="modificarSubtotales();" style="text-align:right; width:120px;" name="costo[]" id="costo[]" value="'+costo+'"></td>'+
		'<td style="text-align:right; width:150px;"><span id="total" name="total" onchange="modificarSubtotales();" class="numberf" style="text-align:right; width:150px;">'+totalt+'</span></td>'+
		'</tr>';
		cont++;
    	detalles=detalles+1;
		$('#detalles').append(fila);
		$('#detalles').addClass('compact');
		modificarSubtotales();
		calcularTotales();

	}
	else
	{
		alert("Error al Ingeresar el Detalle!");
	}	
}

function eliminarDetalle(indice){
	$("#fila" + indice).remove();
	calcularTotales();
	calcularTotalesIVA();
	calcularSubTotales();
	evaluar();
}

function evaluar()
{
	if (detalles>0){
		$("#btnGuardar").show();
	}
	else {
	$("#btnGuardar").hide(); 
	cont=0;
	}
}

function modificarSubtotales()
{
		var cant = document.getElementsByName("cantidad[]");
		var prec = document.getElementsByName("costo[]");
		var sub = document.getElementsByName("total");
	
		for (var i = 0; i <cant.length; i++) 
		{
			var inpC = cant[i];
			var inpP = prec[i];
			var inpS = sub[i];                           

			inpS.value = inpC.value * inpP.value;

			document.getElementsByName("total")[i].innerHTML = inpS.value;
		}

		$('span.numberf').number( true, 2);	

	calcularTotales();
	evaluar();
}

function calcularTotales()
{
	var sub = document.getElementsByName("total");
	var total = 0.0;


		for (var i = 0; i <sub.length; i++) 
		{
			total += document.getElementsByName("total")[i].value;
		}
	$("#totalv").html(total);
	$("#totalh").val(total);


	$('span.numberf').number( true, 2);	

	evaluar();
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
	
	$(".ffechareg").datepicker({
		format:"yyyy-mm-dd",
		clearBtn:false,
		autoclose:true,
	});

	$("#btnagregar").click(function () { 

		$("input[type=text]").attr("readonly",false);
		generarCod();

	});

	$('span.numberf').number( true, 2);	

	valorDep();

});

init();