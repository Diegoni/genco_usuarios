<?php
include_once("menu.php");

//si no hay busqueda traemos los ultimos 50 movimientos
if(empty($_GET['buscar'])){
$query="SELECT * FROM `log_auditoria_usuario` 
		ORDER BY id_log_usuario DESC 
		LIMIT 0 , 50";   
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

<!-- cantidad de registros -->
<b>Últimos <? echo $numero_filas;?> movimientos</b>

<table class="table table-striped table-hover">
<tr class="success">
<td>Accion</td>
<td>Usuario</td>
<td>Fecha</td>
<td>Hora</td>
<td>Dato</td>
<td>Operación</td>
</tr>

<!-- formulario de busqueda -->
<form class="form-inline">
<tr class="warning">

<td><select class="input-small" name="accion">
	 <option value=""></option>
	 <option value="Update"> Update</option>
	 <option value="Insert"> Insert</option>
	 <option value="Delete">Delete</option>
	</select></td>
<td><input type="text" class="input-small" name="usuario" placeholder="usuario"></td>
<td><input type="text" class="input-small" name="fecha" id="datepicker" placeholder="fecha" readonly></td>
<td></td>
<td><input type="text" class="input-small" name="dato" placeholder="dato"></td>
<td><button  class="btn" title="Buscar movimiento de usuarios" name="buscar" value="1"><i class="icon-search" ></i></button></td>
</tr>

<!-- si no hay registros se muestra aviso -->
<? if($numero_filas==0){ ?>
</table>
<b>No hay movimientos</b>
<? } 
else{

// tabla con todos los movimientos
do{ ?>
<tr>
<td><? echo $row_usuario['Accion'];?></td>
<td><? echo $row_usuario['Usuario'];?></td>
<td><? echo date( "d-m-Y", strtotime( $row_usuario['Creacion'] ) );  ?></td><!-- Cambio de formato de fecha -->
<td><? echo date( "H:i:s", strtotime( $row_usuario['Creacion'] ) );  ?></td><!-- Cambio de formato de hora  -->
<td><? echo $row_usuario['idusuario'];?></td>
<td><A class="btn btn-primary" title="Ver accion" onClick="abrirVentana('edit_cliente.php?id=<?echo $row_usuario['id_log_usuario'];?>')"><i class="icon-circle-arrow-right"></i> </A></td>
</tr>
<? }while ($row_usuario = mysql_fetch_array($usuario)) ?>

<? } //cierra el else?>


</table>
</center>
</div>
