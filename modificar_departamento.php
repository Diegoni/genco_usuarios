<?php
session_start();
	if(!isset($_SESSION['usuario_nombre'])){
	header("Location: ../login/acceso.php");
	}
include_once("menu.php");

//seleccion del usuario
$query="SELECT * FROM `departamento` WHERE id_departamento='".$_GET['id']."'";   
$departamento=mysql_query($query) or die(mysql_error());
$row_departamento = mysql_fetch_assoc($departamento);

$action=$_GET['action'];
$input_action="";
if($action==0){
	$input_action="readonly";
}


?>
<div class="span9">
<center>

<!-- formulario de modificacion-->
<form class="form-inline" action="departamentos.php">
<table class="table table-hover">
<tr>
<input type="hidden" name="id" class="span4" value="<? echo $row_departamento['id_departamento'];?>">


<tr>
<td>Departamento</td>
<td><input type="text" name="departamento" class="span4" value="<? echo $row_departamento['nombre'];?>" <?= $input_action; ?> required></td>
</tr>

<? if($action==0){?>
<tr>
<td>Estado</td>
<td>
<input type="radio" name="estado" id="alta" value="1" >
 Alta
<input type="radio" name="estado" id="baja" value="0" checked>
 Baja
</td>
</tr>


<tr>
<td></td>
<td>
<button type="submit" onclick="return confirm('Esta seguro de eliminar este item?');" class="btn btn-primary" name="modificar" value="1" title="Dar de baja al departamento <? echo $row_departamento['nombre'];?>"><i class="icon-minus-sign"></i> Eliminar</button>
<A class="btn btn-danger"  HREF="departamentos.php" title="Cancelar la baja"> <i class="icon-ban-circle"></i> Cancelar</A></td>
</tr>  

</table>
</form>

<div id="dialog" title="Eliminar departamento">
	<p>El departamento eliminado no se mostrara más en las planillas de horarios.<p> 
	<p>El departamento no se borra de la base de datos solo se cambia su estado, se puede recuperar el departamento si se elimina.</p>
</div>

<button id="opener" class="btn"><i class="icon-question-sign"></i></button>

<?}else{?>


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
<button type="submit" class="btn btn-primary" name="modificar" value="1" title="Editar departamento <? echo $row_departamento['nombre'];?>"><i class="icon-edit"></i> Editar</button>
<A class="btn btn-danger"  title="Cancelar la edición" HREF="empresas.php"><i class="icon-ban-circle"></i> Cancelar</A></td>
</tr> 

</table>
</form> 
<?}?>





</center>
</div>


<? include_once("footer.php");?>