<?php
include_once("menu.php");
//para departamentos
$query="SELECT * FROM `departamento` ORDER BY nombre ASC";   
$departamento=mysql_query($query) or die(mysql_error());
$row_departamento = mysql_fetch_assoc($departamento);
mysql_query("SET NAMES 'utf8'");
$numero_filas = mysql_num_rows($departamento);

?>

<div class="span9">
<center>

<!-- Formulario de alta usuario -->
<form class="form-inline" action="nuevo2.php" >
<table class="table table-hover">
<tr>
<td>Nombre</td>
<td><input type="text" name="nombre" class="span4" placeholder="Nombre" required></td>
</tr>

<tr>
<td>Legajo</td>
<td><input type="text" name="legajo" class="span4" onkeypress="return isNumberKey(event)" placeholder="Legajo" required></td>
</tr>

<tr>
<td>Departamento</td>
<td><select class="span4" name="departamento" required>
		<option></option>
	<? while ($row_departamento = mysql_fetch_array($departamento)){ ?>	
		<option value="<? echo $row_departamento['iddepartamento'];?>"><? echo $row_departamento['nombre'];?></option>
	<? } ?>
	</select>
</td>
</tr>  

<tr>
<td></td>
<td>
<button type="submit" class="btn btn-primary" value="alta" value="1"><i class="icon-plus-sign-alt"></i> Alta</button>
<A class="btn btn-danger" title="Cancelar el alta" HREF="index.php"><i class="icon-ban-circle"></i> Cancelar</A></td>
</tr>  


</table>
</form>



</center>
</div>
