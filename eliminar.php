<?php
session_start();
	if(!isset($_SESSION['usuario_nombre'])){
	header("Location: ../login/acceso.php");
	}
include_once("menu.php");

//Para seleccionar el cliente
$query="SELECT * FROM `usuario` WHERE id_usuario='".$_GET['id']."'";   
$usuario=mysql_query($query) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
mysql_query("SET NAMES 'utf8'");

//Para los departamentos
$query="SELECT * FROM `departamento` ORDER BY nombre ASC";   
$departamento=mysql_query($query) or die(mysql_error());
$row_departamento = mysql_fetch_assoc($departamento);
mysql_query("SET NAMES 'utf8'");
$numero_filas = mysql_num_rows($departamento);



?>
<div class="span9">
<center>

<!-- Formulario de baja usuario -->



<form class="form-inline" action="index.php">
<table class="table table-hover">
<tr>
<input type="hidden" name="id" class="span4" value="<? echo $row_usuario['id_usuario'];?>">


<tr>
<td>Nombre</td>
<td><input type="text" name="nombre" class="span4" value="<? echo $row_usuario['nombre'];?>" disabled></td>
</tr>

<tr>
<td>Legajo</td>
<td><input type="text" name="legajo" class="span4" onkeypress="return isNumberKey(event)" value="<? echo $row_usuario['legajo'];?>" disabled></td>
</tr>

<tr>
<td>Estado</td>
<td>
<input type="radio" name="estado" id="alta" value="0" checked>
 Baja
</td>
</tr>

<tr>
<td>Departamento</td>
<td><select class="span4" name="departamento" disabled>
	<!-- Busca los departamentos y selecciona el que es del cliente -->
	<? 	do{ 
		if ($row_usuario['id_departamento']==$row_departamento['id_departamento']){?>	
		 <option value="<? echo $row_departamento['id_departamento'];?>" selected><? echo $row_departamento['nombre'];?></option>
	<?	 }else{ ?>
	  <option value="<? echo $row_departamento['id_departamento'];?>"><? echo $row_departamento['nombre'];?></option>
	<? }
		}while ($row_departamento = mysql_fetch_array($departamento))?>
	</select>
</td>
</tr>  

<tr>
<td></td>
<td>
<button type="submit" onclick="return confirm('Esta seguro de eliminar este item?');" class="btn btn-primary" name="eliminar" value="1" title="Dar de baja al usuario <? echo $row_usuario['nombre'];?>"><i class="icon-minus-sign"></i> Eliminar</button>
<A class="btn btn-danger"  HREF="index.php" title="Cancelar la baja"> <i class="icon-ban-circle"></i> Cancelar</A>
</td>
</tr>  


</table>
</form>

<div id="dialog" title="Eliminar usuario">
	<p>El usuario eliminado no se mostrara más en las planillas de horarios.<p> 
	<p>El usuario no se borra de la base de datos solo se cambia su estado, se puede recuperar el usuario si se elimina.</p>
</div>

<button id="opener" class="btn"><i class="icon-question-sign"></i></button>
 



</center>
</div>


<? include_once("footer.php");?>