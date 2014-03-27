<?php
session_start();
	if(!isset($_SESSION['usuario_nombre'])){
	header("Location: ../login/acceso.php");
	}
include_once("menu.php");


/*--------------------------------------------------------------------
----------------------------------------------------------------------
			ABM de departamento
----------------------------------------------------------------------			
--------------------------------------------------------------------*/
//modifica al usuario segun el formulario de modificar.php
if(isset($_GET['modificar'])){
	mysql_query("UPDATE `departamento` SET	
				nombre='".$_GET['departamento']."',
				id_estado='".$_GET['estado']."'		
				WHERE id_departamento='".$_GET['id']."'			
				") or die(mysql_error());
}

//modifica al usuario segun el formulario de modificar.php
if(isset($_GET['nuevo'])){

	$query="SELECT  *
				FROM `departamento` 
				WHERE 
				departamento.nombre like '".$_GET['departamento']."'";
	$departamento=mysql_query($query) or die(mysql_error());
	$row_departamento = mysql_fetch_assoc($departamento);
	$numero_departamentos = mysql_num_rows($departamento);
	
	if($numero_departamentos>0){
		echo 	"<div class='alert'>
				<button type='button' class='close' data-dismiss='alert'>&times;</button>
				El departamento ya existe
				</div>";
	}else{
	
	mysql_query("INSERT INTO `departamento` 
				(nombre, id_estado) 
				VALUES 
				('".$_GET['departamento']."', '".$_GET['estado']."')
		
				") or die(mysql_error());
	}
}


/*--------------------------------------------------------------------
----------------------------------------------------------------------
			Consulta para traer los departamentos
----------------------------------------------------------------------			
--------------------------------------------------------------------*/


//si no hay busqueda los trae a todos
if(isset($_GET['buscar'])){
$query="SELECT  *
				FROM `departamento` 
				INNER JOIN estado ON(departamento.id_estado=estado.id_estado)
				WHERE 
				departamento.nombre like '%".$_GET['departamento']."%' AND
				departamento.id_estado like '%".$_GET['estado']."%'
				ORDER BY departamento.nombre ASC";   
}

else{
			$query="SELECT *
			FROM 
			departamento
			INNER JOIN estado ON (departamento.id_estado=estado.id_estado)
			WHERE 
			departamento.id_estado=1
			ORDER BY nombre ASC"; 
}
			$departamento=mysql_query($query) or die(mysql_error());
			$row_departamento = mysql_fetch_assoc($departamento);
			$numero_departamentos = mysql_num_rows($departamento);







?>
<div class="span9">
<center>

<!-- si hay modificacion o eliminacion de departamento se da aviso que se realizado exitosamente -->
<? if($_GET['modificar']==1 || $_GET['eliminar']==1){?>
<div class='alert alert-success'>
<button type='button' class='close' data-dismiss='alert'>&times;</button>
El Departamento : "<? echo $_GET['departamento'];?>" se ha modificado con éxito <i class="icon-thumbs-up text-success"></i>
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
		
<form class="form-inline" action="departamentos.php">
	<table class="table table-hover">
	
	<tr>
		<td>Departamento</td>
		<td><input type="text" name="departamento" class="span4" placeholder="ingrese departamento" required></td>
	</tr>

	<tr>
		<td>Estado</td>
		<td>
		<input type="radio" name="estado" id="alta" value="1" checked>
		 Alta
		<input type="radio" name="estado" id="baja" value="0" >
		 Baja
		</td>
	</tr>

	<tr>
		<td></td>
		<td>
		<button type="submit" class="btn btn-primary" name="nuevo" value="1" title="Alta departamento"><i class="icon-plus-sign-alt"></i> Alta</button>
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
<td>Departamento</td>
<td>Estado</td>
<td>Operación</td>
</tr>
</thead>

<tbody>
<? do{ ?>
<tr>
<td><? echo $row_departamento['nombre'];?></td>
<td><? echo $row_departamento['estado'];?></td>
<td><A class="btn btn-primary" title="Editar departamento" HREF="modificar_departamento.php?id=<? echo $row_departamento['id_departamento'];?>&action=1"><i class="icon-edit"></i></A>
	<?if ($row_departamento['id_estado']==0) {?>
	<A type="submit" class="btn btn-danger disabled"  title="El departamento partamento ya esta dada de baja"><i class="icon-minus-sign"></i></i></A>
	<? } else { ?>
	<A type="submit" class="btn btn-danger"  title="Dar de baja" HREF="modificar_departamento.php?id=<? echo $row_departamento['id_departamento'];?>&action=0"><i class="icon-minus-sign"></i></i></A>
	<? } ?>
	</td>
</tr>
<? }while ($row_departamento = mysql_fetch_array($departamento )) ?>
</tbody>


</table>
</div>
</center>
</div>


<? include_once("footer.php");?>