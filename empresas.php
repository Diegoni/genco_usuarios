<?php
session_start();
	if(!isset($_SESSION['usuario_nombre'])){
	header("Location: ../login/acceso.php");
	}
include_once("menu.php");


/*--------------------------------------------------------------------
----------------------------------------------------------------------
			ABM empresas
----------------------------------------------------------------------			
--------------------------------------------------------------------*/
//modifica al usuario segun el formulario de modificar.php
if(isset($_GET['modificar'])){
	$cuil=$_GET['cuil1']."-".$_GET['cuil2']."-".$_GET['cuil3'];
	mysql_query("UPDATE `empresa` SET	
				empresa='".$_GET['empresa']."',
				cod_empresa='".$_GET['cod_empresa']."',
				cuil='".$cuil."',
				id_estado='".$_GET['estado']."'		
				WHERE id_empresa='".$_GET['id']."'			
				") or die(mysql_error());
}

//modifica al usuario segun el formulario de modificar.php
if(isset($_GET['nuevo'])){
	$query="SELECT  *
				FROM `empresa` 
				WHERE 
				empresa.empresa like '".$_GET['empresa']."'";
	$empresa=mysql_query($query) or die(mysql_error());
	$row_empresa = mysql_fetch_assoc($empresa);
	$numero_empresas = mysql_num_rows($empresa);
	
	if($numero_empresas>0){
		echo "<div class='alert'><button type='button' class='close' data-dismiss='alert'>&times;</button>La empresa ya existe</div>";
	}else{
	
	$cuil=$_GET['cuil1']."-".$_GET['cuil2']."-".$_GET['cuil3'];
	mysql_query("INSERT INTO `empresa` (
				empresa, 
				cod_empresa, 
				cuil, 
				id_estado) 
				VALUES (
				'".$_GET['empresa']."', 
				'".$_GET['cod_empresa']."',
				'".$cuil."',
				'".$_GET['estado']."'
				)
		
				") or die(mysql_error());
	}
}

/*--------------------------------------------------------------------
----------------------------------------------------------------------
			Consulta para traer las empresas
----------------------------------------------------------------------			
--------------------------------------------------------------------*/

//si no hay busqueda los trae a todos
if(isset($_GET['buscar'])){
$query="SELECT  *
				FROM `empresa` 
				INNER JOIN estado ON(empresa.id_estado=estado.id_estado)
				WHERE 
				empresa.empresa like '%".$_GET['empresa']."%' AND
				empresa.cod_empresa like '%".$_GET['cod_empresa']."%' AND
				empresa.cuil like '%".$_GET['cuil']."%' AND
				empresa.id_estado like '%".$_GET['estado']."%'
				ORDER BY empresa.empresa ASC";   
}

else{
			$query="SELECT *
			FROM 
			empresa
			INNER JOIN estado ON (empresa.id_estado=estado.id_estado)
			WHERE 
			empresa.id_estado=1
			ORDER BY empresa ASC"; 
}
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
La Empresa : "<? echo $_GET['empresa'];?>" se ha modificado con éxito <i class="icon-thumbs-up text-success"></i>
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
			Formulario nuevo departamento
----------------------------------------------------------------------			
--------------------------------------------------------------------->

<div class='slidingDiv'>
<div class="span9">
		
<form class="form-inline" action="empresas.php">
<table class="table table-hover">

	<tr>
		<td>Empresa</td>
		<td><input type="text" name="empresa" class="span4" placeholder="ingrese Empresa" required></td>
	</tr>

	<tr>
		<td>Cod</td>
		<td><input type="text" name="cod_empresa" class="span4" placeholder="ingrese codigo de empresa" required></td>
	</tr>

	<tr>
		<td>Cuil</td>
		<td>
			<input type="text" name="cuil1" onkeypress="return isNumberKey(event)" maxlength="2" class="span1" required>-
			<input type="text" name="cuil2" onkeypress="return isNumberKey(event)" maxlength="8" class="span2" required>-
			<input type="text" name="cuil3" onkeypress="return isNumberKey(event)" maxlength="1" class="span1" required>
		</td>
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
		<td></td>
		<td>
		<button type="submit" class="btn btn-primary" name="nuevo" value="1" title="Alta empresa"><i class="icon-plus-sign-alt"></i> Alta</button>
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
	<td>Empresa</td>
	<td>Codigo</td>
	<td>CUIL</td>
	<td>Estado</td>
	<td>Operación</td>
	</tr>
<thead>
<tbody>
<? do{ ?>
<tr>
<td><? echo $row_empresa['empresa'];?></td>
<td><? echo $row_empresa['cod_empresa'];?></td>
<td><? echo $row_empresa['cuil'];?></td>
<td><? echo $row_empresa['estado'];?></td>
<td><A class="btn btn-primary" title="Editar empresa" HREF="modificar_empresa.php?id=<? echo $row_empresa['id_empresa'];?>&action=1"><i class="icon-edit"></i></A>
	<?if ($row_empresa['id_estado']==0) {?>
	<A type="submit" class="btn btn-danger disabled"  title="La empresa ya esta dada de baja"><i class="icon-minus-sign"></i></i></A>
	<? } else { ?>
	<A type="submit" class="btn btn-danger"  title="Dar de baja" HREF="modificar_empresa.php?id=<? echo $row_empresa['id_empresa'];?>&action=0"><i class="icon-minus-sign"></i></i></A>
	<? } ?>
	</td>
</tr>
<? }while ($row_empresa = mysql_fetch_array($empresa)) ?>
</tbody>

</table>
</div>
</center>
</div>


<? include_once("footer.php");?>