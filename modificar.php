<?php
session_start();
	if(!isset($_SESSION['usuario_nombre'])){
	header("Location: ../login/acceso.php");
	}
include_once("menu.php");

//seleccion del usuario
$query="SELECT * FROM `usuario` WHERE id_usuario='".$_GET['id']."'";   
$usuario=mysql_query($query) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);


//para departamentos
$query="SELECT * FROM `departamento` ORDER BY nombre ASC";   
$departamento=mysql_query($query) or die(mysql_error());
$row_departamento = mysql_fetch_assoc($departamento);
$numero_filas = mysql_num_rows($departamento);

//para empresa
$query="SELECT * FROM `empresa` ORDER BY empresa ASC";   
$empresa=mysql_query($query) or die(mysql_error());
$row_empresa = mysql_fetch_assoc($empresa);
$numero_empresas = mysql_num_rows($empresa);



?>
<div class="span9">
<center>

<!-- formulario de modificacion-->
<form class="form-inline" action="index.php">
<table class="table table-hover">
<tr>
<input type="hidden" name="id" class="span4" value="<? echo $row_usuario['id_usuario'];?>">


<tr>
<td>Usuario</td>
<td><input type="text" name="usuario" class="span4" value="<? echo $row_usuario['usuario'];?>" required></td>
</tr>

<tr>
<td>Nombre</td>
<td><input type="text" name="nombre" class="span4" value="<? echo $row_usuario['nombre'];?>" required></td>
</tr>

<tr>
<td>Apellido</td>
<td><input type="text" name="apellido" class="span4" value="<? echo $row_usuario['apellido'];?>" required></td>
</tr>

<tr>
<td>DNI</td>
<td><input type="text" name="dni" onkeypress="return isNumberKey(event)" maxlength="8" class="span4" value="<? echo $row_usuario['dni'];?>" required></td>
</tr>

<tr>
<td>Cuil</td>
<td>
	<input type="text" name="cuil1" onkeypress="return isNumberKey(event)" maxlength="2" class="span1" value="<? echo substr($row_usuario['cuil'], 0, 2);?>" required>-
	<input type="text" name="cuil2" onkeypress="return isNumberKey(event)" maxlength="8" class="span2" value="<? echo substr($row_usuario['cuil'], 3, 8);?>" required>-
	<input type="text" name="cuil3" onkeypress="return isNumberKey(event)" maxlength="1" class="span1" value="<? echo substr($row_usuario['cuil'], 12, 1);?>" required>
</td>
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
<td>Empresa</td>
<td><select class="span4" name="empresa">
	<? 	do{ 
		if ($row_usuario['id_empresa']==$row_empresa['id_empresa']){?>	
		 <option value="<? echo $row_empresa['id_empresa'];?>" selected><? echo $row_empresa['empresa'];?></option>
	<?	 }else{ ?>
	  <option value="<? echo $row_empresa['id_empresa'];?>"><? echo $row_empresa['empresa'];?></option>
	<? }?>
	<? } while ($row_empresa = mysql_fetch_array($empresa))?>
	</select>
</td>
</tr>  

<tr>
<td>Departamento</td>
<td><select class="span4" name="departamento">
	<? 	do{ 
		if ($row_usuario['id_departamento']==$row_departamento['id_departamento']){?>	
		 <option value="<? echo $row_departamento['id_departamento'];?>" selected><? echo $row_departamento['nombre'];?></option>
	<?	 }else{ ?>
	  <option value="<? echo $row_departamento['id_departamento'];?>"><? echo $row_departamento['nombre'];?></option>
	<? }?>
	<? } while ($row_departamento = mysql_fetch_array($departamento))?>
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


<? include_once("footer.php");?>