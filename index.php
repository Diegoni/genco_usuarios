<?php
session_start();
	if(!isset($_SESSION['usuario_nombre'])){
	header("Location: ../login/acceso.php");
	}
include_once("menu.php");

/*--------------------------------------------------------------------
----------------------------------------------------------------------
			ABM usuarios
----------------------------------------------------------------------			
--------------------------------------------------------------------*/

//modifica al usuario segun el formulario de modificar.php
if($_GET['modificar']==1){
	$cuil=$_GET['cuil1']."-".$_GET['cuil2']."-".$_GET['cuil3'];
	mysql_query("UPDATE `usuario` SET	
				usuario='".$_GET['usuario']."',
				nombre='".$_GET['nombre']."',
				apellido='".$_GET['apellido']."',
				dni='".$_GET['dni']."',
				cuil='".$cuil."',
				id_estado='".$_GET['estado']."',
				id_empresa='".$_GET['empresa']."',
				id_departamento='".$_GET['departamento']."',
				legajo='".$_GET['legajo']."'	
			WHERE id_usuario='".$_GET['id']."'			
				") or die(mysql_error());
}

//da de baja al usuario segun el formulario de eliminar.php
if(!(empty($_GET['eliminar']))){
	mysql_query("UPDATE `usuario` SET	
				id_estado=0
			WHERE id_usuario='".$_GET['id']."'			
				") or die(mysql_error());
}


if(isset($_GET['nuevo'])){

// Comprobamos si el usuario esta registrado 
$usuario = $_GET['usuario']; 
$legajo = $_GET['legajo']; 

$nuevo_usuario=mysql_query("SELECT usuario FROM usuario where usuario='$usuario' OR legajo='$legajo'"); 
if(mysql_num_rows($nuevo_usuario)>0) 
{ 
echo "
<div class='alert'> 
	<button type='button' class='close' data-dismiss='alert'>&times;</button>
	El nombre o legajo del usuario ya esta registrado
</div>
"; 
}else{ 

//Buscamos el ultimo id registrado y le sumamos uno
//Hacemos esto porque la tabla de usuario no tiene id autoincrement

$query="SELECT * FROM `usuario` ORDER BY id_usuario DESC";   
$idusuario=mysql_query($query) or die(mysql_error());
$row_idusuario = mysql_fetch_assoc($idusuario);

$ultimoid=$row_idusuario['id_usuario'];
$ultimoid=$ultimoid+1;
$estado=1;

//Creamos el usuario
	$cuil=$_GET['cuil1']."-".$_GET['cuil2']."-".$_GET['cuil3'];
	mysql_query("INSERT INTO `usuario` (
				id_usuario,
				usuario,
				legajo,
				nombre,
				apellido,
				dni,
				cuil,
				id_empresa,
				id_departamento,
				id_estado)
			VALUES (
				'".$ultimoid."',
				'".$_GET['usuario']."',
				'".$_GET['legajo']."',
				'".$_GET['nombre']."',
				'".$_GET['apellido']."',
				'".$_GET['dni']."',
				'".$cuil."',
				'".$_GET['empresa']."',
				'".$_GET['departamento']."',
				'".$estado."')	
			") or die(mysql_error());
echo "			
<div class='alert alert-success'>
<button type='button' class='close' data-dismiss='alert'>&times;</button>
El usuario: ".$_GET['nombre']." se ha cargado con éxito <i class='icon-thumbs-up text-success'></i> 
</div>";

}
}


/*--------------------------------------------------------------------
----------------------------------------------------------------------
			Consulta para traer los usuarios
----------------------------------------------------------------------			
--------------------------------------------------------------------*/


//si no hay busqueda los trae a todos
if(empty($_GET['buscar'])){
$query="SELECT  usuario.id_usuario,
				usuario.usuario as usuario,
				usuario.legajo,
				usuario.id_departamento,
				usuario.id_estado,
				estado.estado,
				departamento.nombre as d_nombre
				FROM `usuario` 
				INNER JOIN departamento ON (departamento.id_departamento=usuario.id_departamento) 
				INNER JOIN estado ON (usuario.id_estado=estado.id_estado)
				WHERE usuario.id_estado=1
				ORDER BY usuario.nombre ASC";   
}
//si no busca por legajo busca por los otros campos
else if(empty($_GET['legajo'])){
			$query="SELECT  usuario.id_usuario,
							usuario.usuario as usuario,
							usuario.legajo,
							usuario.id_departamento,
							usuario.id_estado,
							estado.estado,
							departamento.nombre as d_nombre FROM `usuario` 
							INNER JOIN departamento ON (departamento.id_departamento=usuario.id_departamento)
							INNER JOIN estado ON (usuario.id_estado=estado.id_estado)
			WHERE 
			usuario.usuario like '%".$_GET['usuario']."%' AND
			departamento.nombre like '%".$_GET['departamento']."%' AND
			usuario.id_estado like '%".$_GET['estado']."%' 
			ORDER BY usuario.nombre ASC"; 
}
//si busca por legajo tiene que ser exacto el legajo que ingresa
else{
			$query="SELECT  usuario.id_usuario,
							usuario.usuario as usuario,
							usuario.legajo,
							usuario.id_departamento,
							usuario.id_estado,
							estado.estado,
							departamento.nombre as d_nombre FROM `usuario` 
							INNER JOIN departamento ON (departamento.id_departamento=usuario.id_departamento)
							INNER JOIN estado ON (usuario.id_estado=estado.id_estado)
			WHERE 
			usuario.legajo='".$_GET['legajo']."'
			ORDER BY usuario.nombre ASC"; 
	


}			
			$usuario=mysql_query($query) or die(mysql_error());
			$row_usuario = mysql_fetch_assoc($usuario);
			mysql_query("SET NAMES 'utf8'");
			$numero_filas = mysql_num_rows($usuario);



//seleccion de departamento para formulario de busqueda
$query="SELECT * FROM `departamento` ORDER BY nombre ASC";   
$departamento=mysql_query($query) or die(mysql_error());
$row_departamento = mysql_fetch_assoc($departamento);
mysql_query("SET NAMES 'utf8'");


$query="SELECT * FROM `departamento` ORDER BY nombre ASC";   
$departamento2=mysql_query($query) or die(mysql_error());
$row_departamento2 = mysql_fetch_assoc($departamento2);
$numero_departamentos = mysql_num_rows($departamento2);


//para empresas
$query="SELECT * FROM `empresa` ORDER BY empresa ASC";   
$empresa=mysql_query($query) or die(mysql_error());
$row_empresa = mysql_fetch_assoc($empresa);
$numero_empresas = mysql_num_rows($empresa);



?>
<div class="span9">
<center>

<!-- si hay modificacion o eliminacion de usuario se da aviso que se realizado exitosamente -->
<? if($_GET['modificar']==1 || $_GET['eliminar']==1){?>
<div class='alert alert-success'>
	<button type='button' class='close' data-dismiss='alert'>&times;</button>
	El usuario: <b>"<? echo $_GET['usuario'];?>"</b><br> 
	Nombre: <b>"<? echo $_GET['nombre'];?>"</b><br> 
	Apellido: <b>"<? echo $_GET['apellido'];?>"</b><br>  
	se ha modificado con éxito <i class="icon-thumbs-up text-success"></i>
</div>
<? } ?>

<div ALIGN=left>
<a href='#' class='show_hide btn btn-primary' title='Añadir registro'><i class="icon-plus-sign-alt"></i> Nuevo</a>
<a href="javascript:imprSelec('muestra')" class='btn'><i class="icon-print"></i> Imprimir</a>
<button class="btn" onclick="tableToExcel('example', 'W3C Example Table')"><i class="icon-download-alt"></i> Excel</button>
</div>
<br>

<!--------------------------------------------------------------------
----------------------------------------------------------------------
			Formulario nuevo usuario
----------------------------------------------------------------------			
--------------------------------------------------------------------->

<div class='slidingDiv'>
<div class="span9">
		
<!-- Formulario de alta usuario -->
<form class="form-inline" action="index.php" >
<table class="table table-hover">
<tr>
<td>Usuario</td>
<td><input type="text" name="usuario" class="span4" placeholder="ingrese Usuario" required></td>
</tr>

<tr>
<td>Nombre</td>
<td><input type="text" name="nombre" class="span4" placeholder="ingrese Nombre" required></td>
</tr>

<tr>
<td>Apellido</td>
<td><input type="text" name="apellido" class="span4" placeholder="ingrese Apellido" required></td>
</tr>

<tr>
<td>DNI</td>
<td><input type="text" name="dni" class="span4" onkeypress="return isNumberKey(event)" maxlength="8" placeholder="ingrese DNI" required></td>
</tr>

<tr>
<td>CUIL</td>
<td>
	<input type="text" name="cuil1" onkeypress="return isNumberKey(event)" maxlength="2" class="span1" required>-
	<input type="text" name="cuil2" onkeypress="return isNumberKey(event)" maxlength="8" class="span2" required>-
	<input type="text" name="cuil3" onkeypress="return isNumberKey(event)" maxlength="1" class="span1" required>-
</td>
</tr>

<tr>
<td>Legajo</td>
<td><input type="text" name="legajo" class="span4" onkeypress="return isNumberKey(event)" placeholder="Legajo" required></td>
</tr>

<tr>
<td>Empresa</td>
<td><select class="span4" name="empresa" required>
		<option></option>
	<? do{ ?>	
		<option value="<? echo $row_empresa['id_empresa'];?>"><? echo $row_empresa['empresa'];?></option>
	<? }while ($row_empresa = mysql_fetch_array($empresa)) ?>
	</select>
</td>
</tr>  

<tr>
<td>Departamento</td>
<td><select class="span4" name="departamento" required>
		<option></option>
	<? do{ ?>	
		<option value="<? echo $row_departamento2['id_departamento'];?>"><? echo $row_departamento2['nombre'];?></option>
	<? }while ($row_departamento2 = mysql_fetch_array($departamento2)) ?>
	</select>
</td>
</tr>  

<tr>
<td></td>
<td>
<button type="submit" class="btn btn-primary" name="nuevo" value="1"><i class="icon-plus-sign-alt"></i> Alta</button>
<A class="show_hide btn btn-danger"  title="Cancelar" href='#'><i class="icon-ban-circle"></i> Cancelar</A></td>
</tr>  


</table>
</form><br>
</div>
</div>

<!--------------------------------------------------------------------
----------------------------------------------------------------------
			Tabla de usuario
----------------------------------------------------------------------			
--------------------------------------------------------------------->

<div id="muestra">
<table border="1" class="table table-hover" id="example">

<!-- Cabecera -->
<thead>
	<tr class="success">
	<td>Usuario</td>
	<td>Legajo</td>
	<td>Depar.</td>
	<td>Estado</td>
	<td>Operación</td>
	</tr>
</thead>

<tbody>
<?do{ ?>
<tr>
<td><? echo $row_usuario['usuario'];?></td>
<td><? echo $row_usuario['legajo'];?></td>
<td><? echo $row_usuario['d_nombre'];?></td>
<td><? echo $row_usuario['estado'];?></td>
<td><A class="btn btn-primary" title="Editar usuario" HREF="modificar.php?id=<? echo $row_usuario['id_usuario'];?>"><i class="icon-edit"></i></A>
	<?if ($row_usuario['id_estado']==0) {?>
	<A type="submit" class="btn btn-danger disabled"  title="El usuario ya esta dado de baja"><i class="icon-minus-sign"></i></i></A>
	<? } else { ?>
	<A type="submit" class="btn btn-danger"  title="Dar de baja" HREF="eliminar.php?id=<? echo $row_usuario['id_usuario'];?>"><i class="icon-minus-sign"></i></i></A>
	<? } ?>
	</td>
</tr>
<? }while ($row_usuario = mysql_fetch_array($usuario)) ?>
</tbody>

</table>
</div>



</center>
</div>

<? include_once("footer.php");?>
