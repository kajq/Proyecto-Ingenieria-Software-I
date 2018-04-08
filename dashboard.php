<!DOCTYPE html>
<?php
session_start();
if (@!$_SESSION['username']) {
    header("Location:index.php");
}
require("connect_db.php");
$user=$_SESSION['username'];
$sql=mysqli_query($mysqli, "SELECT nombre FROM datos_personales where FK_correo = '$user'");
if (!$sql) {
printf("Errormessage1: %s\n", $mysqli->error);
} else {
$datos_usuario=mysqli_fetch_assoc($sql);
$_SESSION['nombre']=$datos_usuario['nombre'];
}
?>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Tareas</title>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
</head>
<body background="images/fondotot.jpg" style="background-attachment: fixed">
	<div class="container">
		<header class="header">
			<div class="row">
				<?php
				include("include/cabecera.php");
				?>
			</div>
		</header>

		<!-- Navbar
    ================================================== -->
		<div class="navbar">
			<div class="navbar-inner">
				<div class="container">
					<div class="nav-collapse">
						<ul class="nav">
							<li>
								<a href="">
									Tareas de
									<strong>
										<?php echo $_SESSION['nombre'];?>
									</strong>
								</a>
							</li>
						</ul>
						<form action="#" class="navbar-search form-inline" style="margin-top:6px"></form>
						<ul class="nav pull-right">
							<?php
							if($_SESSION['rol']==1){
								echo '<li> <form action="admin.php">';
								echo '<input  class="btn btn-danger" type="submit" value="Administrar"/>';
								echo '</form> </li>';
							}
                            ?>
							<li>
								<form action="formulario.php" method="POST">
									<input class="btn btn-danger" type="submit" name="Accion" value="Editar" />
								</form>
								<li>
									<form action="desconectar.php">
										<input class="btn btn-danger" type="submit" value="Cerrar Cesión" />
									</form>
									<!--<a href="desconectar.php"> Cerrar Cesión </a>-->
								</li>
						</ul>
					</div><!-- /.nav-collapse -->
				</div>
			</div><!-- /navbar-inner -->
		</div>

		<!-- ======================================================================================================================== -->

		<div class="row">
			<div class="span12">
				<div class="caption">
		<!--///////////////////////////////////////////////////Empieza cuerpo del documento interno////////////////////////////////////////////-->
					<h2> Administración de tareas</h2>
					<div class="well well-small">
						<div class="tasks">
							<div class="task">
								<h4>
									Nuevo
									<a href='dashboard.php?boton="new"'>
										<img src='images/plus.png' class='img-rounded' />
									</a>
								</h4>
								<div class="modal-form">
									<form action="insertar.php" method="post">
										<label style="font-size: 14pt">
											<b>Tarea: </b>
										</label>
										<input type="text" name="detalle" class="form-control" required placeholder="Detalle" />
										<label style="font-size: 14pt">
											<b>Propietario: </b>
										</label>
										<input type="text" name="propietario" class="form-control" placeholder="Correo del Propietario" />
										<label style="font-size: 14pt">
											<b>Responsable: </b>
										</label>
										<input type="text" name="responsable" class="form-control" placeholder="Correo del Responsable" />
										<label style="font-size: 14pt">
											<b>Fecha Entrega: </b>
										</label>
										<input type="date" name="fecha_entrega" class="form-control" placeholder="Fecha Entrega" />
										<hr />
										<input class="btn btn-danger" type="submit" name="Guardar" value="Guardar" />
									</form>
								</div>
							</div>

							<br />
							<?php
							$sql=("SELECT ta.codigo, ta.detalle, ta.propietario, ta.responsable, ta.fecha, est.descripcion, ta.estado
								FROM tareas ta
									left join estados est
								on est.codigo = ta.estado
								WHERE propietario = '$user' or responsable = '$user' and ta.estado not in (3,4) ");
								//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
								$query=mysqli_query($mysqli,$sql);
								while($arreglo=mysqli_fetch_array($query)){
					echo "<div class='task'>";
					if (($arreglo[3]==$user) && ($arreglo[6]==1)){
						echo "<label style='font-size: 8pt'><b>¿Quieres aceptar esta tarea asignada?</b></label>";
						echo "<img src='images/alert.png' class='img-rounded' />";
						echo "<a href='update.php?cod=$arreglo[0]&tipo=estado-5'><img src='images/acept.png' class='img-rounded' /></a>";
						echo "<a href='update.php?cod=$arreglo[0]&tipo=estado-3'><img src='images/eliminar.png' class='img-rounded' /></a>";
					}
					echo			"<form action='update.php?cod=$arreglo[0]&tipo=tarea' method='post'>";
					echo				"<label style='font-size: 14pt'><b>Estado: $arreglo[5]</b></label>";
					echo				"<label style='font-size: 14pt'><b>Tarea: </b></label>";
					echo				"<input type='text' name='detalle' class='form-control' required placeholder='Detalle' value= '$arreglo[1]'/>";
					echo				"<label style='font-size: 14pt'><b>Propiestario: </b></label>";
					echo				"<input type='text' name='propietario' class='form-control' required placeholder='Detalle' value= '$arreglo[2]'/>";
					echo				"<label style='font-size: 14pt'><b>Responsable: </b></label>";
					echo				"<input type='text' name='responsable' class='form-control' placeholder='Detalle' value= '$arreglo[3]'/>";
					echo				"<label style='font-size: 14pt'><b>Fecha de entrega: </b></label>";
					echo				"<input type='date' name='fecha_entrega' class='form-control' required placeholder='Detalle' value= '$arreglo[4]'/>";
					echo				"<hr />";
						$sql_accion=("SELECT * FROM acciones WHERE cod_tarea = $arreglo[0]");
						$query_accion=mysqli_query($mysqli,$sql_accion);
						while($acciones=mysqli_fetch_array($query_accion)){
echo"<input type='checkbox' name='acciones' value=$acciones[0] onchange='update.php?cod=$arreglo[0]&tipo=estado-5' > <input type='text' name='accion' class='form-control' placeholder='Detalle' value='$acciones[1]'/><br>";
							}
					echo				"<input type='text' name='tarea_nueva' class='form-control' required placeholder='Nueva Tarea'/>";
					echo				"<input class='btn btn-success' type='submit' name='Guardar' value='Actualizar' />";
					echo				"<br />";
					echo			"</form>";
					echo		"</div>";
					echo		"<br />";
			}
							?>
							<br />
						</div>
					</div>
<!--///////////////////////////////////////////////////Termina cuerpo del documento interno////////////////////////////////////////////-->
				</div>
			</div>
		</div>
			<!-- Pie de pagina-->
			<hr class="soften" />
			<footer class="footer">
				<hr class="soften" />
				<p>
					&copy; Copyright Keilor Jiménez
					<br />
					<br />
				</p>
			</footer>
		</div><!-- /container -->
</body>
</html>
