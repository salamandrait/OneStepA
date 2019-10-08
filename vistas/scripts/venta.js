var tabla;
var ftipo=$("#tipo").val();
var iddep="";
var tipoprecio="";
var cont=0;
var detalles=0;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	MostrarModal();
	$('span.numberf').number( true, 2);	

	$("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	})

	$.post('../ajax/venta.php?op=selectDeposito',{},function(datos){	
		$('#iddeposito').html(datos);
		$('#iddeposito').val(datos);
		$('#iddeposito').niceSelect('update');
	});
}

function generarCod(){	

	$.post('../ajax/venta.php?op=generarcodigo&ftipo='+ftipo,function(r){
		$("#cod_venta").val(r);
	});
}

//Función limpiar
function limpiar(){

	$("#idventa").val("");
	$('#iddeposito').val("");
	$('#idvendedor').val("");
	$('#desc_vendedor').val("");
	$('#desc_vendedor').attr('disabled',true);
	$("#tipoprecio").val("");
	$('#iddeposito').niceSelect('update');
	$("#idcliente").val("");
	//$("#idusario").val("");
	$("#cod_venta").val("");
	$("#cod_cliente").val("");
	$("#desc_cliente").val("");
	$("#rif").val("");
	$("#desc_venta").val("");
	$("#numerod").val("");
	$("#numeroc").val("");
	$("#origen").val("");
	$("#estatus").val("Sin Procesar");
	$("#fechareg").val("");
	$("#fechaven").val("");
	$("#subtotalh").val("0.00");
	$("#subtotalt").html("0.00");
	$("#impuestoh").val("0.00");
	$("#impuestot").html("0.00");
	$("#totalh").val("0");
	$("#totalt").html("0.00");
	$("#saldoh").val("0")
	$("#fechareg").val("");
	$("#fechaven").val("");

	
	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today =  now.getFullYear()+ "-" +(month) + "-" +(day);
	$('.ffecha').val(today);
}

function MostrarModal(){
	$("#desc_cliente").click(function () { 
		$("#ModalCliente").modal('show');
		listarCliente();
	});

	$("#desc_vendedor").click(function () { 
		$("#ModalVendedor").modal('show');
		listarVendedor();
	});

	$("#btnagregar_item").click(function () { 
		$("#ModalArticulo").modal('show');
		listarArticulos();;
	});
}

function listarCliente()
{
	tabla=$('#tbltcliente').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
		columnDefs:[{
			"targets":'nd',//clase para definir las columnas a tratar
			"orderable":false,//Definimos no ordenar por esta columna
			"searchable":false,//Definimos no buscar por esta columna
		}],
	    buttons: [		          

		        ],
		"ajax":
				{
					url: '../ajax/venta.php?op=listarCliente',
					type : "get",
					dataType : "json",						
					error: function(e){console.log(e.responseText);}
				},
		"bDestroy": true,
		"iDisplayLength": 8,//Paginación
	    "order": [[ 1, "asc" ]]//Ordenar (columna,orden)
	});
}

function agregarCliente(vidcliente,vcod_cliente,vdesc_cliente,vrif,vdiascredito,vlimite,vidvendedor,vcod_vendedor,vdesc_vendedor)
{

	$("#idcliente").val(vidcliente);
	$("#cod_cliente").val(vcod_cliente);
	$("#desc_cliente").val(vdesc_cliente);
	$("#rif").val(vrif);
	$("#diascredito").val(vdiascredito);
	$("#limite").val(vlimite);
	$("#idvendedor").val(vidvendedor);
	$("#desc_vendedor").val(vcod_vendedor+'-'+vdesc_vendedor);
	
	$("#ModalCliente").modal('toggle');	
	$('#desc_vendedor').attr('disabled',false);
}

function listarVendedor()
{
	tabla=$('#tbltvendedor').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
		columnDefs:[{
			"targets":'nd',//clase para definir las columnas a tratar
			"orderable":false,//Definimos no ordenar por esta columna
			"searchable":false,//Definimos no buscar por esta columna
		}],
	    buttons: [		          

		        ],
		"ajax":
				{
					url: '../ajax/venta.php?op=listarVendedor',
					type : "get",
					dataType : "json",						
					error: function(e){console.log(e.responseText);}
				},
		"bDestroy": true,
		"iDisplayLength": 8,//Paginación
	    "order": [[ 1, "asc" ]]//Ordenar (columna,orden)
	});
}

function agregarVendedor(vidvendedor,vcod_vendedor,vdesc_vendedor)
{

	$("#idvendedor").val(vidvendedor);
	$("#desc_vendedor").val(vcod_vendedor+'-'+vdesc_vendedor);
	
	$("#ModalVendedor").modal('toggle');	
}

function listarArticulos()
{
	tabla=$('#tblarticulo').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
		columnDefs:[{
			"targets":'nd',//clase para definir las columnas a tratar
			"orderable":false,//Definimos no ordenar por esta columna
			"searchable":false,//Definimos no buscar por esta columna
		}],
		"language":{
			"decimal":".",
			"thousands":","
		},
	    buttons: [		          

		        ],
		"ajax":
				{
					url: '../ajax/venta.php?op=listarArticulos&iddep='+iddep+'&tipoprecio='+tipoprecio,
					type : "get",
					dataType : "json",						
					error: function(e){console.log(e.responseText);}
				},
		"bDestroy": true,
		"iDisplayLength": 8,//Paginación
	    "order": [[ 1, "asc" ]]//Ordenar (columna,orden)
	});
}

//Función mostrar formulario
function mostrarform(flag){

	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnagregar").hide();
		$("#btnreporte").hide();
		$("#btnCancelar").show();
		detalles=0;
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
        $("#btnreporte").show();  
	}
}

function SelccionDeposito(){


	$("#iddeposito").change(function () { 
		iddep=$(this).val();
		
		if(iddep!="" && tipoprecio!=""){
			$("#btnagregar_item").attr("disabled",false);	
		}
	});

	$("#tipoprecio").change(function () { 
		tipoprecio=$(this).val();
	
		if(iddep!="" && tipoprecio!=""){
			$("#btnagregar_item").attr("disabled",false);	
		}
	});

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
				columns:[2,3,4,5,6,7,8]
				}},
            {
            extend:'excelHtml5',
            text:'<span class="fa fa-file-excel-o text-green"></span>',
			titleAttr:'Exportar a Excel',
			exportOptions:{
				columns:[2,3,4,5,6,7,8]
				}},
            {
            extend:'csvHtml5',
            text:'<i class="fa fa-file-text-o text-purple"></i>',
			titleAttr:'Exportar a Texto',
			exportOptions:{
				columns:[2,3,4,5,6,7,8]
				}},
            {
            extend:'pdf',
            text:'<i class="fa fa-file-pdf-o text-red"></i>',
			titleAttr:'Exportar a PDF',
			exportOptions:{
				columns:[2,3,4,5,6,7,8]
				}}],
            "ajax":
				{
					url: '../ajax/venta.php?op=listar&ftipo='+ftipo,
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
	var formData = new FormData($("#formulario")[0]);	

	bootbox.confirm({message:"¿Está Seguro de Guardar el Registro?",
	buttons:{confirm:{label: 'Ok',className:'btn-primary btn-sm'},cancel:{label: 'Cancelar',className:'btn-danger btn-sm'}},
	callback:function(result){
		
		if(result)
        {			
			$.ajax({
				url: '../ajax/venta.php?op=guardaryeditar',
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

function mostrar(idventa)
{
	$.post('../ajax/venta.php?op=mostrar',{idventa : idventa}, function(d)
	{
		d = JSON.parse(d);		
		mostrarform(true);
		$("#idventa").val(d.idventa);
		$("#cod_venta").val(d.cod_venta);
		$("#idvendedor").val(d.idvendedor);
		$("#desc_vendedor").val(d.cod_vendedor+'-'+d.desc_vendedor);
		$("#cod_venta").val(d.cod_venta);
		$("#desc_venta").val(d.desc_venta)
		$("#idusuario").val(d.idusuario);
		$("#idcliente").val(d.idcliente);
		$("#cod_cliente").val(d.cod_cliente);
		$("#desc_cliente").val(d.desc_cliente);
		$("#rif").val(d.rif);
		$("#numerod").val(d.numerod);
		$("#numeroc").val(d.numeroc);
		$("#fechareg").val(d.fechareg);
		$("#fechaven").val(d.fechaven);
		$("#totalh").val(d.totalh);
		$("#saldoh").val(d.saldoh);

		$(".oct").hide();

		$.post('../ajax/venta.php?op=listarDetalle&id='+idventa,function(r){
			$("#tbdetalles").html(r);
			$('span.numberf').number( true, 2);

		});
		//mas adelante icluir aqui un datatable

		$(".controld").attr("disabled",true);

		$("*[rel=tooltip]").tooltip();

 	})
}

//Función para activar registros
function anular(idventa,tipo,idcliente,totalh)
{
	bootbox.confirm({message:"¿Está Seguro de Anular el Registro?",buttons:{
		confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post('../ajax/venta.php?op=anular', {idventa : idventa, tipo:tipo, idcliente:idcliente, totalh:totalh}, function(e){
        		bootbox.alert(e);
				listar();
        	});	
        }
	}});
}

//Función para activar registros
function eliminar(idventa)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post('../ajax/venta.php?op=eliminar', {idventa : idventa, tipo:tipo, idcliente:idcliente, totalh:totalh}, function(e){
        		bootbox.alert(e);
	            listar();
        	});	
        }
	}});
}

function evaluar()
{
	if (detalles>0)
  {
	$("#btnGuardar").attr('disabled',false);
  }
  else
  {
	$("#btnGuardar").attr('disabled',true);
	cont=0;
	}
}

function agregarDetalle(vidarticulo,vcod_articulo,vdesc_articulo,viddeposito,tasa,vprecio)
{
	
	var cantidad =1;
	var precio =vprecio;
	var totalt =0;	

	if(idarticulo=!"")
	{
		var subtotal=cantidad*precio;
		var subimp=((precio*tasa)/100)*cantidad;
		totalt =subtotal+subimp;
		var fila='<tr class="filas" id="fila'+cont+'">'+
		'<td><h5 style="width:30px; text-align:center;"><button type="button" class="btn btn-danger btn-xs" rel="tooltip" data-original-title="Eliminar Renglon" onclick="eliminarDetalle('+cont+')"><span class="fa fa-times-circle"></span></button></h5></td>'+
		'<td><input type="hidden" name="idarticulo[]" id="idarticulo[]"value="'+vidarticulo+'"><h5 style="width:115px; padding-left:5px;">'+vcod_articulo+'</h5></td>'+
		'<td><input type="hidden" name="iddeposito[]" id="iddeposito[]"value="'+viddeposito+'"><h5 style="width:350px;">'+vdesc_articulo+'</h5></td>'+
		'<td style="width:65px;"><input type="text" onchange="modificarSubtotales();" style="text-align:right; width:60px;" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
		'<td style="width:130px;"><input class="mod" type="text" onchange="modificarSubtotales(); ModificarPrecio();" style="text-align:right; width:110px; background-color:#d9d3d3;" name="precio[]" id="precio[]" value="'+precio+'"></td>'+
		'<td><h5 id="subtotal'+cont+'" name="subtotal" type="double" class="numberf" style="text-align:right; width:130px;">'+subtotal+'</h5></td>'+
		'<td><input id="tasa[]" name="tasa[]" value="'+tasa+'" type="hidden"><h5 id="subimp'+cont+'" name="subimp" class="numberf" style="text-align:right; width:110px;">'+subimp+'</h5></td>'+
		'<td><h5 id="total" name="total" class="numberf" style="text-align:right; width:130px;">'+totalt+'</h5></td>'+
		'</tr>';
		cont++;
    	detalles=detalles+1;
    	$('#tbdetalles').append(fila);
		modificarSubtotales();
		calcularTotales();

	}
	else{
		alert("Error al Ingeresar el Detalle!");
	}	
}

function modificarSubtotales()
{
		var cant = document.getElementsByName("cantidad[]");
		var prec = document.getElementsByName("precio[]");
		var sub = document.getElementsByName("subtotal");
		var subi = document.getElementsByName("subimp");
		var tasa = document.getElementsByName("tasa[]");
	

		for (var i = 0; i <cant.length; i++) 
		{
			var inpC = cant[i];
			var inpP = prec[i];
			var inpS = sub[i];1.                           
			var Tax = tasa[i];
			var inpI = subi[i];

			inpS.value = inpC.value * inpP.value;
			inpI.value = ((inpP.value * Tax.value)/100) * inpC.value;

			document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
			document.getElementsByName("subimp")[i].innerHTML = inpI.value;
			document.getElementsByName("total")[i].innerHTML =inpI.value + inpS.value;
		}

	calcularSubTotales();
	calcularTotalesIVA();
	calcularTotales();

	$('.numberf').number( true, 2);	
}

function calcularSubTotales()
{
	var subt = document.getElementsByName("subtotal");
	var stotal = 0.0;


		for (var i = 0; i <subt.length; i++) 
		{
			stotal += document.getElementsByName("subtotal")[i].value;
		}

	$("#subtotalt").html(stotal);
	$("#subtotalh").val(stotal);
	evaluar();
}

function calcularTotales()
{
	var sub = document.getElementsByName("subtotal");
	var total = 0.0;

		for (var i = 0; i <sub.length; i++) 
		{
			total += document.getElementsByName("subtotal")[i].value + document.getElementsByName("subimp")[i].value;
		}

	$("#totalt").html(total);
	$("#totalh").val(total);
	$("#saldoh").val(total);

	evaluar();

	$('.numberf').number( true, 2);	

}

function calcularTotalesIVA()
{
	var subi = document.getElementsByName("subtotal");
	var totali = 0.0;

		for (var i = 0; i <subi.length; i++) 
		{
			totali += document.getElementsByName("subimp")[i].value;
		}

	$("#impuestot").html(totali);
	$("#impuestoh").val(totali);

	evaluar();
}

function ModificarPrecio(){

	$("#modprecio").change(function(){

		if($("#modprecio").is(':checked')) {  

			$(".mod").attr('disabled',false)
			$(".mod").css('background-color','#f7ecaa');

		} else {  
			$(".mod").attr('disabled',true)
			$(".mod").css('background-color','#d9d3d3');
		}
	})
}

function eliminarDetalle(indice){

	$("#fila" + indice).remove();
	calcularTotales();
	calcularTotalesIVA();
	calcularSubTotales();
	evaluar();
}

$(document).ready(function(){  
	
	$("*[rel=tooltip]").tooltip();

	$('[data-toggle="tooltip"]').tooltip(); 

	$("input[type=textc]").keyup(function(){ 
		$(this).val( $(this).val().toUpperCase());
	});	

	//desabilitar Tecla Intro al enviar formularios
	$("#formulario").keypress(function(e) {
		if (e.which == 13) {
			return false;
		}
	});

	$("#btnagregar").click(function () { 
		generarCod(ftipo);
		SelccionDeposito();

		$(".controld").attr('disabled',false);
		$("#btnagregar_item").attr("disabled",true);	
		$(".filas").remove();
		$(".oct").show();
		$("#btnGuardar").attr("disabled",true);

	});

	$('.ffecha').datepicker({
		format:"yyyy-mm-dd",
		autoclose:"true"
	});

	modificarSubtotales();
	calcularTotales();

	$('.numberf').number( true, 2);	

	ModificarPrecio();
	
});

init();