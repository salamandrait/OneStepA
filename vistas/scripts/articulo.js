var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();


	$("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	});

	//Cargamos los items al select categoria
	$.post("../ajax/articulo.php?op=selectCategoria", function (r) {
		$("#idcategoria").html(r);
		$('#idcategoria').selectpicker('update');
	});
	
	//Cargamos los items al select unidad
	$.post("../ajax/articulo.php?op=selectUnidad", function (r) {
		$("#idunidad").html(r);
		$('#idunidad').selectpicker('refresh');
	});

	//Cargamos los items al select deposito
	$.post("../ajax/articulo.php?op=selectDeposito", function (r) {
		$("#iddeposito").html(r);
		$('#iddeposito').selectpicker('refresh');
	});


	//Cargamos los items al select impuesto
	$.post("../ajax/articulo.php?op=selectImpuesto", function (r) {
		$("#idimpuesto").html(r);
		$('#idimpuesto').selectpicker('update');
	});
	
}

//Función limpiar
function limpiar(){
	$("#idarticulo").val("");
	$("#iddeposito").val("");
	$('#iddeposito').selectpicker('refresh');
	$('#idcategoria').selectpicker('refresh');
	$('#idunidad').selectpicker('refresh');
	$("#idimpuesto").selectpicker('refresh');
	$("#tipo").val("General");
	$("#tipo").niceSelect('update');
	$("#origen").val('Nacional');
	$("#origen").niceSelect('update');
    $("#cod_articulo").val("");
    $("#desc_articulo").val("");
    $("#artref").val("");
    $("#stock").val("0");
    $("#costo1").val("0");
    $("#costo2").val("0");
    $("#costo3").val("0");
    $("#precio1").val("0");
    $("#precio2").val("0");
	$("#precio3").val("0");
    $("#fechareg").val(""); 
	$("#imagenmuestra").attr("src", "");
	$("#print").hide();
	$("#lbtotalstock").val("0");
	$("#lbtotalstock").html("0.00");

	$(".filas").remove();

	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today =  now.getFullYear()+ "-" +(month) + "-" +(day);
		
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
		},{
			"targets":'nv',//clase para definir las columnas a tratar
			"orderable":false,//Definimos no ordenar por esta columna
			"searchable":false,//Definimos no buscar por esta columna
			"visible":false,
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
					url: '../ajax/articulo.php?op=listar',
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

	//$('.numberf').number( false, 2);	


	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/articulo.php?op=guardaryeditar",
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

function mostrar(idarticulo)
{
	
	$.post("../ajax/articulo.php?op=mostrar",{idarticulo : idarticulo}, function(data,status)
	{		
		mostrarform(true);
		data = JSON.parse(data);
		$("#idarticulo").val(data.idarticulo);
		$('#iddeposito').selectpicker('refresh');
		$("#cod_articulo").val(data.cod_articulo);
        $("#desc_articulo").val(data.desc_articulo);
        $("#idcategoria").val(data.idcategoria);
        $('#idcategoria').selectpicker('refresh');
        $("#idunidad").val(data.idunidad);
        $('#idunidad').selectpicker('refresh');
        $("#idimpuesto").val(data.idimpuesto);
        $('#idimpuesto').selectpicker('refresh');
        $("#origen").val(data.origen);
        $('#origen').niceSelect('update');
        $("#tipo").val(data.tipo);
        $('#tipo').niceSelect('update');
        $("#stock").val(data.stock);
        $("#artref").val(data.artref);
		$("#costo1").val(data.costo1);
        $("#costo2").val(data.costo2);
        $("#costo3").val(data.costo3);
        $("#precio1").val(data.precio1);
        $("#precio2").val(data.precio2);
        $("#precio3").val(data.precio3);
        $("#fechareg").val(data.fechareg);
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/articulos/"+data.imagen);
		$("#imagenactual").val(data.imagen);


		$.post("../ajax/articulo.php?op=listardepositoStock&idart="+idarticulo,function(r){
			$("#tblListadoDep").html(r);

			//$('span.numberf').number( true, 2);			
		});
		
        
        generarbarcode();
		$("*[rel=tooltip]").tooltip();
		
		
 	})
}


function mostrarcosto(idarticulo) {

    $.post("../ajax/articulo.php?op=mostrarcosto", { idarticulo: idarticulo}, function (data, status) {

		data = JSON.parse(data);
		var imp=data.tasa;
		var c1=data.costo1;
		var c2=data.costo2;
		var c3=data.costo3;
		var impc1=imp*c1/100;
		var impc2=imp*c2/100;
		var impc3=imp*c3/100;
		var totalc1=+impc1 + +c1;
		var totalc2=+impc2 + +c2;
		var totalc3=+impc3 + +c3;


		$("#cod_articuloc").val(data.cod_articulo);
		$("#desc_articuloc").val(data.desc_articulo);
		$("#tasac").val(data.tasa);
		$("#desc_impuestoc").val(data.desc_impuesto);
		$("#stockc").val(data.stock);

		$("#costo1m").val(data.costo1);
        $("#costo2m").val(data.costo2);
		$("#costo3m").val(data.costo3);
		$("#impc1m").val(impc1);
        $("#impc2m").val(impc2);
		$("#impc3m").val(impc3);
		$("#totalc1m").val(totalc1);
		$("#totalc2m").val(totalc2);
		$("#totalc3m").val(totalc3);

		$('.numberf').number(true, 2);;
		$('.ro').attr('readonly', true);	
	
	});
}

function mostrarprecio(idarticulo) {

    $.post("../ajax/articulo.php?op=mostrarprecio", { idarticulo: idarticulo}, function (data, status) {

		data = JSON.parse(data);
		var imp=data.tasa;
		var p1=data.precio1;
		var p2=data.precio2;
		var p3=data.precio3;
		var impp1=imp*p1/100;
		var impp2=imp*p2/100;
		var impp3=imp*p3/100;
		var totalp1=+impp1 + +p1;
		var totalp2=+impp2 + +p2;
		var totalp3=+impp3 + +p3;

		$("#cod_articulop").val(data.cod_articulo);
		$("#desc_articulop").val(data.desc_articulo);
		$("#tasap").val(data.tasa);
		$("#desc_impuestop").val(data.desc_impuesto);
		$("#stockp").val(data.stock);

		$("#precio1m").val(data.precio1);
        $("#precio2m").val(data.precio2);
		$("#precio3m").val(data.precio3);
		$("#impp1m").val(impp1);
        $("#impp2m").val(impp2);
		$("#impp3m").val(impp3);
		$("#totalp1m").val(totalp1);
		$("#totalp2m").val(totalp2);
		$("#totalp3m").val(totalp3);
		$('.numberf').number(true, 2);;
		$('.ro').attr('readonly', true);	
	
	});
}


//Función para desactivar registros
function desactivar(idarticulo)
{
	bootbox.confirm({message:"¿Está Seguro de Desactivar el Registro?",
		buttons:{confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/articulo.php?op=desactivar", {idarticulo : idarticulo}, function(e){
        		bootbox.alert(e);
				listar();
        	});	
        }
	}});
}

//Función para activar registros
function activar(idarticulo)
{
	bootbox.confirm({message:"¿Está Seguro de Activar el Registro?",buttons:{
		confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/articulo.php?op=activar", {idarticulo : idarticulo}, function(e){
        		bootbox.alert(e);
				listar();
        	});	
        }
	}});
}

//Función para activar registros
function eliminar(idarticulo)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'Ok',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post('../ajax/articulo.php?op=eliminar', {idarticulo : idarticulo}, function(e){
        		bootbox.alert(e);
	            listar();
        	});	
        }
	}});
}



//función para generar el código de barras
function generarbarcode() {
    artref = $("#artref").val();
    JsBarcode("#barcode", artref);
    $("#print").show();
}

//Función para imprimir el Código de barras
function imprimir() {
	$("#print").printArea();
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

	$(".ffechareg").datepicker({
		format:"yyyy-mm-dd",
		autoclose: true,
	});

	$('#costo1').change(function (){
        var valuea =$(this).val();

		$('#costo1').val(valuea);
		$('#costo2').val(valuea);
		$('#costo3').val(valuea);
    });
    
    $('#precio1').show(function (){
        var valuea =$(this).val();
		$('#precio1').val(valuea);
		$('#precio2').val(valuea);
        $('#precio3').val(valuea);
	});

	$(".numberf").number(true,2);
	
});

init();