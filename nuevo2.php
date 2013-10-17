<?php
include_once("menu.php");

$query="SELECT * FROM `usuario` ORDER BY idusuario DESC";   
$idusuario=mysql_query($query) or die(mysql_error());
$row_idusuario = mysql_fetch_assoc($idusuario);

$query="SELECT * FROM `departamento` ORDER BY nombre ASC";   
$departamento=mysql_query($query) or die(mysql_error());
$row_departamento = mysql_fetch_assoc($departamento);
mysql_query("SET NAMES 'utf8'");
$numero_filas = mysql_num_rows($departamento);

?>

<?php 

$nombre = $_GET['nombre']; 

// Comprobamos si el usuario esta registrado 

$nuevo_usuario=mysql_query("select nombre from usuario where nombre='$nombre'"); 
if(mysql_num_rows($nuevo_usuario)>0) 
{ 
echo " 
<p class='avisos'>El nombre de usuario ya esta registrado</p> 
<p class='avisos'><A class='btn btn-danger'  href='javascript:history.go(-1)'><i class='icon-arrow-left'></i> Volver</A></p> 
"; 
}else{ 

?>
<div class="span9">
<center>
<?

//Buscamos el ultimo id registrado y le sumamos uno
//Hacemos esto porque la tabla de usuario no tiene id autoincrement

$ultimoid=$row_idusuario['idusuario'];
$ultimoid=$ultimoid+1;
$estado=1;

//Creamos el usuario

	mysql_query("INSERT INTO `usuario` (
				idusuario,
				nombre,
				activo,
				departamento_iddepartamento,
				legajo)
			VALUES (
				'".$ultimoid."',
				'".$_GET['nombre']."',
				'".$estado."',
				'".$_GET['departamento']."',
				'".$_GET['legajo']."')	
			") or die(mysql_error());
?>

<!-- Cartel de ok -->
<h4>El usuario: "<? echo $_GET['nombre'];?>" se ha cargado con exito <i class="icon-thumbs-up text-success"></i> </h4>

<!-- Formulario de alta usuario -->
<form class="form-inline" action="nuevo2.php">
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
<td><select class="span4" name="departamento">
	<? do{ ?>	
	  <option value="<? echo $row_departamento['iddepartamento'];?>"><? echo $row_departamento['nombre'];?></option>
	<? }while ($row_departamento = mysql_fetch_array($departamento)) ?>
	</select>
</td>
</tr>  

<tr>
<td></td>
<td>
<button type="submit" class="btn btn-primary" value="alta" value="1">Alta</button>
<A class="btn btn-danger"  HREF="index.php">Cancelar</A></td>
</tr>  


</table>
</form>

</center>
</div>
<? } //cierra el else?>
