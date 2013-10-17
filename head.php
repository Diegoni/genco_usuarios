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
<!-- Para el datapicker, es una funcion de jquery ui -->
<script>
  $(function() {
    $( "#datepicker" ).datepicker({dateFormat: 'dd-mm-yy'});
  });
</script>
<!-- Deteccion del navegador -->
<script>
function comprobarnavegador() {
        /* Variables para cada navegador, la funcion indexof() si no encuentra la cadena devuelve -1, 
        las variables se quedaran sin valor si la funcion indexof() no ha encontrado la cadena. */
        var is_safari = navigator.userAgent.toLowerCase().indexOf('safari/') > -1;
        var is_chrome= navigator.userAgent.toLowerCase().indexOf('chrome/') > -1;
        var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox/') > -1;
        var is_ie = navigator.userAgent.toLowerCase().indexOf('msie ') > -1;
 
        /* Detectando  si es Safari, vereis que en esta condicion preguntaremos por chrome ademas, esto es porque el 
        la cadena de texto userAgent de Safari es un poco especial y muy parecida a chrome debido a que los dos navegadores
        usan webkit. */
 
        if (is_safari && !is_chrome ) {
 
            /* Buscamos la cadena 'Version' para obtener su posicion en la cadena de texto, para ello
            utilizaremos la funcion, tolowercase() e indexof() que explicamos anteriormente */
            //var posicion = navigator.userAgent.toLowerCase().indexOf('Version/');
 
            /* Una vez que tenemos la posición de la cadena de texto que indica la version capturamos la
            subcadena con substring(), como son 4 caracteres los obtendremos de 9 al 12 que es donde 
            acaba la palabra 'version'. Tambien podraimos obtener la version con navigator.appVersion, pero
            la gran mayoria de las veces no es la version correcta. */
            //var ver_safari = navigator.userAgent.toLowerCase().substring(posicion+9, posicion+12);
 
            // Convertimos la cadena de texto a float y mostramos la version y el navegador
            //ver_safari = parseFloat(ver_safari);
            //alert('Su navegador es Safari, Version: ' + ver_safari);
        }
 
        //Detectando si es Chrome
        if (is_chrome ) {
            //var posicion = navigator.userAgent.toLowerCase().indexOf('chrome/');
            //var ver_chrome = navigator.userAgent.toLowerCase().substring(posicion+7, posicion+11);
            //Comprobar version
            //ver_chrome = parseFloat(ver_chrome);
            //alert('Su navegador es Google Chrome, Version: ' + ver_chrome);
        }
 
        //Detectando si es Firefox
        if (is_firefox ) {
            //var posicion = navigator.userAgent.toLowerCase().lastIndexOf('firefox/');
            //var ver_firefox = navigator.userAgent.toLowerCase().substring(posicion+8, posicion+12);
            //Comprobar version
            //ver_firefox = parseFloat(ver_firefox); 
            //alert('Su navegador es Firefox, Version: ' + ver_firefox);
        }
 
        //Detectando Cualquier version de IE
        if (is_ie ) {
            var posicion = navigator.userAgent.toLowerCase().lastIndexOf('msie ');
            var ver_ie = navigator.userAgent.toLowerCase().substring(posicion+5, posicion+8);
            //Comprobar version
            ver_chrome = parseFloat(ver_ie);
            alert('Está usando Internet Explorer, la aplicación no funciona correctamente con este navegador: ' + ver_ie);
        }
    }
 
//Llamamos al funcion que comprueba el nagedaor al cargarse la página
window.onload = comprobarnavegador();
</script>



</head>

<center>