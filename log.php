<?php
session_start();
	if(!isset($_SESSION['usuario_nombre'])){
	header("Location: ../login/acceso.php");
	}
include_once("menu.php");

//si no hay busqueda traemos los ultimos 50 movimientos
if(empty($_GET['buscar'])){
$query="SELECT * FROM `log_auditoria_usuario` 
		ORDER BY id_log_usuario DESC";   
}

//con busqueda
else if(empty($_GET['fecha'])){
			$query="SELECT * FROM `log_auditoria_usuario` WHERE 
			Accion like '%".$_GET['accion']."%' AND
			Usuario like '%".$_GET['usuario']."%' AND
			idusuario like '%".$_GET['dato']."%' 
			ORDER BY Creacion DESC"; 
}
else{
//cambiamos el formato de la fecha y le sumamos un dia a la fecha para hacer el intervalo de tiempo
			$fecha_americana=	date( "Y-m-d 00:00:00", strtotime( $_GET['fecha'] ) );
			$nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha_americana ) ) ;
			$nuevafecha = date ( 'Y-m-d 00:00:00' , $nuevafecha );
			
			$query="SELECT * FROM `log_auditoria_usuario` WHERE 
			Accion like '%".$_GET['accion']."%' AND
			Usuario like '%".$_GET['usuario']."%' AND
			Creacion>'".$fecha_americana."' AND
			Creacion<'".$nuevafecha."' AND
			idusuario like '%".$_GET['dato']."%' 
			ORDER BY Creacion DESC"; 

}
$usuario=mysql_query($query) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
mysql_query("SET NAMES 'utf8'");
$numero_filas = mysql_num_rows($usuario);
?>

<div class="span9">
<center>

<div ALIGN=left>
<a href="javascript:imprSelec('muestra')" class='btn'><i class="icon-print"></i> Imprimir</a>
<button class="btn" onclick="tableToExcel('example', 'W3C Example Table')"><i class="icon-download-alt"></i> Excel</button>
</div>
<br>


<div id="muestra">
<table border="1" class="table table-hover" id="example">
<thead>
<tr class="success">
	<td>Fecha</td>
	<td>Hora</td>
	<td>Acción</td>
	<td>Usuario</td>
	<td title="número que identifica al usuario en base de datos">ID</td>
	<td>Operación</td>
	</tr>
<thead>

<tbody>
<? do{ ?>
<tr>
<?
if($row_usuario['Accion']=="Insert"){
	$action="Alta";
}else if($row_usuario['Accion']=="Delete"){
	$action="Borrar";
}else if($row_usuario['Accion']=="Update"){
	$action="Modificar";
}


?>
<td><? echo date( "d-m-Y", strtotime( $row_usuario['Creacion'] ) );  ?></td><!-- Cambio de formato de fecha -->
<td><? echo date( "H:i:s", strtotime( $row_usuario['Creacion'] ) );  ?></td><!-- Cambio de formato de hora  -->
<td><? echo $action;?></td>
<td><? echo $row_usuario['Usuario'];?></td>
<td><? echo $row_usuario['idusuario'];?></td>
<td><A class="btn btn-primary" title="Ver accion" onClick="abrirVentana('edit_cliente.php?id=<?echo $row_usuario['id_log_usuario'];?>')"><i class="icon-circle-arrow-right"></i> </A></td>
</tr>
<? }while ($row_usuario = mysql_fetch_array($usuario)) ?>
</tbody>

</table>
</div>
</center>
</div>


<? include_once("footer.php");?>