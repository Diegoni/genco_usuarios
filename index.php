<?php
include_once("menu.php");


/*--------------------------------------------------------------------
----------------------------------------------------------------------
			Consulta para traer los usuarios
----------------------------------------------------------------------			
--------------------------------------------------------------------*/
//si no hay busqueda los trae a todos
if(empty($_GET['buscar'])){
$query="SELECT  usuario.idusuario,
				usuario.nombre as u_nombre,
				usuario.legajo,
				usuario.departamento_iddepartamento,
				usuario.activo,
				departamento.nombre as d_nombre
				FROM `usuario` INNER JOIN departamento ON (departamento.iddepartamento=usuario.departamento_iddepartamento) 
				ORDER BY usuario.nombre ASC";   
}
//si no busca por legajo busca por los otros campos
else if(empty($_GET['legajo'])){
			$query="SELECT  usuario.idusuario,
							usuario.nombre as u_nombre,
							usuario.legajo,
							usuario.departamento_iddepartamento,
							usuario.activo,
							departamento.nombre as d_nombre FROM `usuario` 
							INNER JOIN departamento ON (departamento.iddepartamento=usuario.departamento_iddepartamento)
			WHERE 
			usuario.nombre like '%".$_GET['nombre']."%' AND
			departamento.nombre like '%".$_GET['departamento']."%' AND
			activo like '%".$_GET['estado']."%' 
			ORDER BY usuario.nombre ASC"; 
}
//si busca por legajo tiene que ser exacto el legajo que ingresa
else{
			$query="SELECT  usuario.idusuario,
							usuario.nombre as u_nombre,
							usuario.legajo,
							usuario.departamento_iddepartamento,
							usuario.activo,
							departamento.nombre as d_nombre FROM `usuario` 
							INNER JOIN departamento ON (departamento.iddepartamento=usuario.departamento_iddepartamento)
			WHERE 
			usuario.legajo='".$_GET['legajo']."'
			ORDER BY usuario.nombre ASC"; 
	


}			
			$usuario=mysql_query($query) or die(mysql_error());
			$row_usuario = mysql_fetch_assoc($usuario);
			mysql_query("SET NAMES 'utf8'");
			$numero_filas = mysql_num_rows($usuario);


//modifica al usuario segun el formulario de modificar.php
if($_GET['modificar']==1){
	mysql_query("UPDATE `usuario` SET	
				nombre='".$_GET['nombre']."',
				activo='".$_GET['estado']."',
				departamento_iddepartamento='".$_GET['departamento']."',
				legajo='".$_GET['legajo']."'	
			WHERE idusuario='".$_GET['id']."'			
				") or die(mysql_error());
}

//da de baja al usuario segun el formulario de eliminar.php
if($_GET['eliminar']==1){
	mysql_query("UPDATE `usuario` SET	
				activo=0
			WHERE idusuario='".$_GET['id']."'			
				") or die(mysql_error());
}

//seleccion de departamento para formulario de busqueda
$query="SELECT * FROM `departamento` ORDER BY nombre ASC";   
$departamento=mysql_query($query) or die(mysql_error());
$row_departamento = mysql_fetch_assoc($departamento);
mysql_query("SET NAMES 'utf8'");



?>
<div class="span9">
<center>
<!-- si hay modificacion o eliminacion de usuario se da aviso que se realizado exitosamente -->
<? if($_GET['modificar']==1 || $_GET['eliminar']==1){?>
<h4>El usuario: "<? echo $_GET['nombre'];?>" se ha modificado con exito <i class="icon-thumbs-up text-success"></i></h4>
<? } ?>


<!--------------------------------------------------------------------
----------------------------------------------------------------------
			Tabla de usuario
----------------------------------------------------------------------			
--------------------------------------------------------------------->

<b>Cantidad de registros <? echo $numero_filas; ?></b>
<table class="table table-striped table-hover">

<!-- Cabecera -->
.
<tr class="success">
<td>id</td>
<td>Nombre</td>
<td>Legajo</td>
<td>Depar.</td>
<td>Estado</td>
<td>Operación</td>
</tr>

<!-- Formulario de busqueda -->

<form class="form-inline">
<tr class="warning">
<td></td>
<td><input type="text" class="input-small" name="nombre" placeholder="nombre"></td>
<td><input type="text" class="input-small" name="legajo" onkeypress="return isNumberKey(event)" placeholder="legajo"></td>
<td><select class="input-small" name="departamento">
		<option></option>
	<? while ($row_departamento = mysql_fetch_array($departamento)){ ?>	
		<option value="<? echo $row_departamento['nombre'];?>"><? echo $row_departamento['nombre'];?></option>
	<? } ?>
	</select></td>
<td><select class="input-small" name="estado">
		<option></option>
		<option value="1">Alta</option>
		<option value="0">Baja</option>
		</select></td>
<td><button type="submit" class="btn" title="Buscar usuario" name="buscar" value="1"><i class="icon-search" ></i></button>
	<button class="btn" title="Refresh" onclick="location.reload();" ><i class="icon-refresh"></i></button></td>
</tr>

<!-- Usuarios -->

<? do{ ?>
<tr>
<td><? echo $row_usuario['idusuario'];?></td>
<td><? echo $row_usuario['u_nombre'];?></td>
<td><? echo $row_usuario['legajo'];?></td>
<td><? echo $row_usuario['d_nombre'];?></td>
<td><? echo $row_usuario['activo'];?></td>
<td><A class="btn btn-primary" title="Editar usuario" HREF="modificar.php?id=<? echo $row_usuario['idusuario'];?>"><i class="icon-edit"></i></A>
	<?if ($row_usuario['activo']==0) {?>
	<A type="submit" class="btn btn-danger disabled"  title="El usuario ya esta dado de baja"><i class="icon-minus-sign"></i></i></A>
	<? } else { ?>
	<A type="submit" class="btn btn-danger"  title="Dar de baja" HREF="eliminar.php?id=<? echo $row_usuario['idusuario'];?>"><i class="icon-minus-sign"></i></i></A>
	<? } ?>
	</td>
</tr>
<? }while ($row_usuario = mysql_fetch_array($usuario)) ?>

</table>
</center>
</div>
