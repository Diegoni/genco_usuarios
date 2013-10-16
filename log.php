<?php
include_once("menu.php");
if(empty($_GET['buscar'])){
$query="SELECT * FROM `log_auditoria_usuario` 
		ORDER BY id_log_usuario DESC 
		LIMIT 0 , 50";   
}
else{
			$query="SELECT * FROM `log_auditoria_usuario` WHERE 
			Accion like '%".$_GET['accion']."%' AND
			Usuario like '%".$_GET['usuario']."%' AND
			Creacion > '".$_GET['fecha']."' AND
			idusuario like '%".$_GET['dato']."%' 
			ORDER BY Creacion DESC"; 
}
$usuario=mysql_query($query) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
mysql_query("SET NAMES 'utf8'");
$numero_filas = mysql_num_rows($usuario);


$query="SELECT * FROM `departamento` ORDER BY nombre ASC";   
$departamento=mysql_query($query) or die(mysql_error());
$row_departamento = mysql_fetch_assoc($departamento);
mysql_query("SET NAMES 'utf8'");



?>
<div class="span9">
<center>
<? if($_GET['modificar']==1){?>
<h4>El usuario: "<? echo $_GET['nombre'];?>" se ha cargado con exito <i class="icon-thumbs-up text-success"></i> </h4>
<? } ?>

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

<? do{ ?>
<tr>
<td><? echo $row_usuario['Accion'];?></td>
<td><? echo $row_usuario['Usuario'];?></td>
<td><? echo date( "d-m-Y", strtotime( $row_usuario['Creacion'] ) );  ?></td>
<td><? echo date( "H:i:s", strtotime( $row_usuario['Creacion'] ) );  ?></td>
<td><? echo $row_usuario['idusuario'];?></td>
<td><A class="btn btn-primary" title="Ver accion" onClick="abrirVentana('edit_cliente.php?id=<?echo $row_usuario['id_log_usuario'];?>')"><i class="icon-circle-arrow-right"></i> </A></td>
</tr>
<? }while ($row_usuario = mysql_fetch_array($usuario)) ?>




</table>
</center>
</div>
