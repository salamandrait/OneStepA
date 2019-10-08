$("#frmAcceso").on('submit',function(e)
{
	e.preventDefault();
    cod_usuarioa=$("#cod_usuarioa").val();
    clavea=$("#clavea").val();

    $.post("../ajax/usuario.php?op=verificar",
        {"cod_usuarioa":cod_usuarioa,"clavea":clavea},
        function(data)
    {
        if (data!="null")
        {
            $(location).attr("href","zona.php");            
        }
        else
        {
            bootbox.alert("Usuario y/o Password incorrectos");
        }
    });
});