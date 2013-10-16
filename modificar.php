<?php
include_once("menu.php");

$query="SELECT * FROM `usuario` WHERE idusuario='".$_GET['id']."'";   
$usuario=mysql_query($query) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
mysql_query("SET NAMES 'utf8'");


$query="SELECT * FROM `departamento` ORDER BY nombre ASC";   
$departamento=mysql_query($query) or die(mysql_error());
$row_departamento = mysql_fetch_assoc($departamento);
mysql_query("SET NAMES 'utf8'");
$numero_filas = mysql_num_rows($departamento);



?>
<div class="span9">
<center>


<form class="form-inline" action="index.php">
<table class="table table-hover">
<tr>
<input type="hidden" name="id" class="span4" value="<? echo $row_usuario['idusuario'];?>">


<tr>
<td>Nombre</td>
<td><input type="text" name="nombre" class="span4" value="<? echo $row_usuario['nombre'];?>" required></td>
</tr>

<tr>
<td>Legajo</td>
<td><input type="text" name="legajo" class="span4" onkeypress="return isNumberKey(event)" value="<? echo $row_usuario['legajo'];?>" required></td>
</tr>

<tr>
<td>Estado</td>
<td>
<input type="radio" name="estado" id="alta" value="1" checked>
 Alta
<input type="radio" name="estado" id="baja" value="0">
 Baja
</td>
</tr>

<tr>
<td>Departamento</td>
<td><select class="span4" name="departamento">
	<? 	while ($row_departamento = mysql_fetch_array($departamento)){ 
		if ($row_usuario['departamento_iddepartamento']==$row_departamento['iddepartamento']){?>	
		 <option value="<? echo $row_departamento['iddepartamento'];?>" selected><? echo $row_departamento['nombre'];?></option>
	<?	 }else{ ?>
	  <option value="<? echo $row_departamento['iddepartamento'];?>"><? echo $row_departamento['nombre'];?></option>
	<? }
		}?>
	</select>
</td>
</tr>  

<tr>
<td></td>
<td>
<button type="submit" class="btn btn-primary" name="modificar" value="1" title="Editar usuario al usuario <? echo $row_usuario['nombre'];?>"><i class="icon-edit"></i> Editar</button>
<A class="btn btn-danger"  title="Cancelar la edición" HREF="index.php"><i class="icon-ban-circle"></i> Cancelar</A></td>
</tr>  


</table>
</form>



</center>
</div>
