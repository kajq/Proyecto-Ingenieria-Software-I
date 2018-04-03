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
										<input type="text" name="detalle" class="form-control" required placeholder="Detalle" />
										<input type="text" name="propietario" class="form-control" placeholder="Propietario" />
										<input type="text" name="responsable" class="form-control" placeholder="Responsable" />
										<input type="date" name="fecha_entrega" class="form-control" placeholder="Fecha Entrega" />
										<hr />
										<input type="text" name="tarea" class="form-control" placeholder="Tarea.." />
										<input type="text" name="tarea" class="form-control" placeholder="Tarea.." />
										<input type="text" name="tarea" class="form-control" placeholder="Tarea.." />
										<input class="btn btn-danger" type="submit" name="Guardar" value="Guardar" />
									</form>
								</div>
								
							</div>
                        </div>
                        <br />
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