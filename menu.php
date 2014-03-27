<? include_once("head.php");  ?>

<body>

<div class="container">

<!--------------------------------------------------------------------
----------------------------------------------------------------------
							Cabecera
----------------------------------------------------------------------
--------------------------------------------------------------------->

		<div class="row cabecera">
	
			<div class="span3">
				<a href="../index.php"><img width="106" height="40" class="imagenlogo" src="../imagenes/genco.png"></a>
			</div>
			
			<div class="span6 title">
				<center>
				<p>Sistema de marcación horaria</p>
				</center>
			</div>
			
			<div class="span3 session">
				<strong><?=$_SESSION['usuario_nombre']?></strong> 
				<a title="Cerrar sessión de usuario" href="login/logout.php">Cerrar Sesión</a> 
			</div>
			<!--<a href='#' class='show_hide' title='Ayuda' id="ayuda-boton"><i class='icon-question-sign'></i></a>-->
			
		</div>
		
		

<!--------------------------------------------------------------------
----------------------------------------------------------------------
							Menu principal
----------------------------------------------------------------------
--------------------------------------------------------------------->		
		
		<div class="row">	
		<div class="span3; menu">
			<ul class="nav nav-pills nav-stacked">
				<li><a  class="opciones" href="index.php"><i class="icon-group"></i>  Usuarios</a></li>
				<li><a  class="opciones" href="empresas.php"><i class="icon-building"></i>  Empresas</a></li>
				<li><a  class="opciones" href="departamentos.php"><i class="icon-suitcase"></i>  Departamentos</a></li>
				<li><a  class="opciones" href="log.php" ><i class="icon-list"></i> Ver movimientos</a></li>		
				<li><a  class="opciones" href="../index.php" ><i class="icon-time"></i> Marcaciones</a></li>	
			</ul>
			
<!--
            <a href="buscardni.php"><img src="imagenes/boton.jpg" width="180" height="40" border="0"></a><br>
			<div style="margin-top:-30px;margin-bottom:13px;width:180px;text-align:center">
			<a style="color: white;text-decoration:none" href="buscardni.php">Buscar por DNI</a></div>


            <a href="buscarnombre.php"><img src="imagenes/boton.jpg" width="180" height="40" border="0"></a><br>
			<div style="margin-top:-30px;margin-bottom:13px;width:180px;text-align:center">
			<a style="color: white;text-decoration:none" href="buscarnombre.php">Buscar por Nombre</a></div>

            <a href="buscarapellido.php"><img src="imagenes/boton.jpg" width="180" height="40" border="0"></a><br>
			<div style="margin-top:-30px;margin-bottom:13px;width:180px;text-align:center">
			<a style="color: white;text-decoration:none" href="buscarapellido.php">Buscar por Apellido</a></div>
-->           
          
        </div>
	
			
		
