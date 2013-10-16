<html>
<head>
<? 
//configuracion de base de datos
include_once("config/database.php"); 

$subtotal=0;
$total=0;
?>
<!--BEGIN META TAGS-->
<META NAME="keywords" CONTENT="">
<META NAME="description" CONTENT="Conciliador de BD Mutual San Cayetano by TMS Group">
<META NAME="rating" CONTENT="General">
<META NAME="ROBOTS" CONTENT="ALL">
<!--END META TAGS-->

<!-- Charset tiene que estar en utf-8 para que tome ñ y acentos -->
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>Genco usuarios</title>

<!-- Iconos -->
<link type="image/x-icon" href="imagenes/favicon.ico" rel="icon" />
<link type="image/x-icon" href="imagenes/favicon.ico" rel="shortcut icon" />

<!-- Necesario para que funcione Jquery UI y Bootstrap -->
<script src="bootstrap/js/jquery.js"></script>

<!--------------------------------------------------------------------
----------------------------------------------------------------------
						Css y Js creados 
----------------------------------------------------------------------
--------------------------------------------------------------------->

<link rel="stylesheet" type="text/css" href="css/main.css" media="screen" />
<script src="js/main.js"></script>

<!--------------------------------------------------------------------
----------------------------------------------------------------------
						JQuery UI
----------------------------------------------------------------------
--------------------------------------------------------------------->

<link rel="stylesheet" href="ui/jquery-ui.css" />
<script src="ui/jquery-ui.js"></script>

<!--------------------------------------------------------------------
----------------------------------------------------------------------
						Bootstrap
----------------------------------------------------------------------
--------------------------------------------------------------------->

<link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet" media="screen">
<link href="font/css/font-awesome.css" rel="stylesheet">

<script src="bootstrap/js/bootstrap.js"></script>
	
<!--------------------------------------------------------------------
----------------------------------------------------------------------
						Funciones
----------------------------------------------------------------------
--------------------------------------------------------------------->	
<!-- Funcion que controla que no sean mas de 3 caracteres en el input buscar -->
<script>
function control(){
		var cliente = buscar.cliente.value;
			if (cliente.length < 3){
			alert('Debes escribir por lo menos 3 caracteres')
			buscar.cliente.focus()
			return false 
			}

		}
function controlDNi(){
		var cliente = conciliados.dninput.value;
			if (cliente.length < 3){
			alert('Debes escribir por lo menos 3 caracteres')
			conciliados.dninput.focus()
			return false 
			}

		}		
		
<!-- Funcion solo permite ingresar numeros, controla el ascii ingresado -->
function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
		 <!--Solo numero hasta el 31, con espacios en blanco hasta el 33 -->
         if (charCode > 33 && (charCode < 48 || charCode > 57))
            return false;
 
         return true;
      }		
	
</script>

<!-- Funcion esconder o mostrar un div mediante un href, utilizado para ver facturas -->
<script type="text/javascript">
 $(document).ready(function(){
 
        $(".slidingDiv").hide();
        $(".show_hide").show();
 
    $('.show_hide').click(function(){
    $(".slidingDiv").slideToggle();
    });
 
});
</script>

<!-- Funcion para abrir y cerrar ventana -->
<script type="text/javascript">
function abrirVentana(url) {
    window.open(url, "nuevo", "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=500, height=400");
};

function cerrarse(){ 
window.close() 
} 
</script>

<!-- Consulta que trae todos los clientes para usar en el autocomplete -->
<? 
	$query="SELECT * FROM `clientes` GROUP BY apellido ASC ";
	mysql_query("SET NAMES 'utf8'");
	$result=mysql_query($query);
	
	$query="SELECT * FROM `log_clientes_conciliados` GROUP BY dni ASC";
	mysql_query("SET NAMES 'utf8'");
	$DNI=mysql_query($query);
		
?>

<!-- Funcion que llena el array de Autocomplete -->
<script>

  $(function() {
		var availableTags = new Array();
		var i=0;
		
	"<? do {?> "
		availableTags[i] = "<? echo $resultado['apellido']; ?>";
		i =i+1
	"<? } while ($resultado= mysql_fetch_array($result));?>"

    
    $( "#tags" ).autocomplete({ 
    source: function(request, response) {
		//esta function permite limitar los resultados de la consulta para que muestre solo 10 resultados, 
		//de otra manera quedaria muy extenso
        var results = $.ui.autocomplete.filter(availableTags, request.term);
        response(results.slice(0, 10));
    }
	});
	});
  
    $(function() {
		var DNIconciliados = new Array();
		var i=0;
		
	"<? do {?> "
		DNIconciliados[i] = 
		{
        value: "<? echo $DNIs['dni']; ?>",
        desc: "<? echo $DNIs['nombre']; ?> <? echo $DNIs['apellido']; ?>"
		}
		i =i+1
	"<? } while ($DNIs= mysql_fetch_array($DNI));?>"
    
    $( "#dninput" ).autocomplete({
      source: DNIconciliados
    });
	
	//esto permite mostrar mas de un valor en el autocomplete, de esta manera mostramos el dni a que persona le corresponde
	$( "#dninput" ).autocomplete({
      minLength: 0,
      source: DNIconciliados,
      focus: function( event, ui ) {
        $( "##dninput" ).val( ui.item.label );
        return false;
      },
     
    })
    .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
        .appendTo( ul );
    };
	});
</script>
 <script>
 //para el datapicker, es una funcion de jquery ui
  $(function() {
    $( "#datepicker" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>



</head>

<center>