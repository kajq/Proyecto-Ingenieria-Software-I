<?php
session_start();
if (@!$_SESSION['username']) {
    header("Location:index.php");
}
require("connect_db.php");
$user=$_SESSION['username'];
$sql=mysqli_query($mysqli, "SELECT dat.nombre, us.estado FROM datos_personales dat
left join usuarios us
on dat.FK_correo = us.correo
 where FK_correo = '$user'");
if (!$sql) {
printf("Errormessage1: %s\n", $mysqli->error);
} else {
$datos_usuario=mysqli_fetch_assoc($sql);
$_SESSION['nombre']=$datos_usuario['nombre'];
if ($datos_usuario['estado'] == 2){
	echo '<script> $cf=confirm("Es necesario cambiar la contraseña"); </script>';
	}
}
?>
<!DOCTYPE html>
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
								echo '<li> <a href="admin.php">';
								echo    ' <img src="images/admin.png" class="img-rounded" />';
								echo '</a> </li>';
							}
                            ?>
							<li>
                                <a href='formulario.php'>
                                    <img src='images/perfil.png' class='img-rounded' />
                                </a>
                            </li>
                            <li>
                                <a href='archivo.php'>
                                    <img src='images/archivo.png' class='img-rounded' />
                                </a>
                            </li>
                            <li>
                                <a href='pass_change.php'>
                                    <img src='images/pass.png' class='img-rounded' />
                                </a>
                            </li>
							<li>
                                <a href='desconectar.php'>
                                    <img src='images/cerrar.png' class='img-rounded' />
                                </a>
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
							
                            <?php
							$sql=("SELECT ta.codigo, ta.detalle, ta.propietario, ta.responsable, ta.fecha, est.descripcion, ta.estado
								FROM tareas ta
									left join estados est
								on est.codigo = ta.estado
								WHERE ((propietario = '$user' or responsable = '$user') and ta.estado not in (3,6)) ");
								//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
								$query=mysqli_query($mysqli,$sql);
								while($arreglo=mysqli_fetch_array($query)){
                                    $sqltotal = mysqli_query($mysqli, "select COUNT(*) from acciones where cod_tarea = $arreglo[0]");
                                    $total=mysqli_fetch_array($sqltotal);
                                    $sqlpromedio = mysqli_query($mysqli, "select ROUND(((COUNT(*) * 100) / $total[0]) ,0) from acciones where cod_estado = 4 AND cod_tarea = $arreglo[0]");
                                    $promedio=mysqli_fetch_array($sqlpromedio);
                                    if ($promedio[0] == null){$promedio[0]=0;}
					echo "<div class='task'>";
					echo			"<form action='update.php?cod=$arreglo[0]&tipo=1&valor=0&tarea=$arreglo[0]' method='post'>";
					echo				"<label style='font-size: 14pt'><b>Estado: $arreglo[5] $promedio[0]%</b></label>";
					echo				"<label style='font-size: 14pt'><b>Tarea: </b></label>";
					echo				"<input type='text' name='detalle' class='form-control' required placeholder='Detalle' value= '$arreglo[1]' onChange='this.form.submit'/>";
					echo				"<label style='font-size: 14pt'><b>Propiestario: </b></label>";
					echo				"<input type='text' name='propietario' class='form-control' required placeholder='Propietario' value= '$arreglo[2]' onChange='this.form.submit'/>";
					echo				"<label style='font-size: 14pt'><b>Responsable: </b></label>";
					echo				"<input type='text' name='responsable' class='form-control' placeholder='Responsable' value= '$arreglo[3]' onChange='this.form.submit'/>";
					echo				"<label style='font-size: 14pt'><b>Fecha de entrega: </b></label>";
					echo				"<input type='date' name='fecha_entrega' class='form-control' required  value= '$arreglo[4]' onChange='this.form.submit'/>";
					echo				"<hr />";
						$sql_accion=("SELECT `codigo`, `descripcion`, `cod_tarea`,
              case when `cod_estado` = 4 then 'checked' else 'unchecked' end
              FROM acciones WHERE cod_tarea = $arreglo[0]");
						$query_accion=mysqli_query($mysqli,$sql_accion);
						while($acciones=mysqli_fetch_array($query_accion)){
echo"<input type='checkbox' $acciones[3] name='checkbox_acciones[]' value=$acciones[0] onchange=location.href='update.php?cod=$acciones[0]&tipo=3&valor=$acciones[3]&tarea=$arreglo[0]' > <input type='text' name='detalle_acciones[]' class='form-control' placeholder='Detalle' value='$acciones[1]' onChange='this.form.submit'/><br>";
							}
					echo				"<input type='text' name='tarea_nueva' class='form-control' placeholder='Agrega acciones a la tarea'onChange='this.form.submit'/>";
					echo				"<input class='btn btn-success' type='submit' name='Guardar' value='Actualizar' style='visibility:hidden' />";
					echo				"<br />";
                    if (($arreglo[3]==$user) && ($arreglo[6]==1)){
						echo "<label style='font-size: 8pt'><img src='images/alert.png' class='img-rounded' /><b>¿Quieres aceptar esta tarea asignada?</b></label>";
						echo "";
						echo "<a href='update.php?cod=$arreglo[0]&tipo=2&valor=5'><img src='images/acept.png' class='img-rounded' />   </a>";
						echo "<a href='update.php?cod=$arreglo[0]&tipo=2&valor=3'><img src='images/eliminar.png' class='img-rounded' /></a>";
					}
                    if (($promedio[0] == 100) or ($promedio[0]== null)){
                        echo "<label style='font-size: 8pt'><b><img src='images/alert.png' class='img-rounded' /> ¿Quieres cerrar esta tarea finalizada?</b></label>";
                        echo "<a href='update.php?cod=$arreglo[0]&tipo=2&valor=6'><img src='images/acept.png' class='img-rounded' /></a>";
                    }
					echo			"</form>";
					echo		"</div>";
					echo		"<br />";
			}
                            ?>
							<br />
                            <div class="task">
                                <h4>
                                    Nuevo
                                    <a href='dashboard.php?n="hidden"'>
                                        <img src='images/plus.png' class='img-rounded' />
                                    </a>
                                </h4>
                                <div class="modal-form" >
                                    <form action="insertar.php" method="post">
                                        <label style="font-size: 14pt">
                                            <b>Tarea: </b>
                                        </label>
                                        <input type="text" name="detalle" class="form-control" required placeholder="Detalle" />
                                        <label style="font-size: 14pt">
                                            <b>Propietario: </b>
                                        </label>
                                        <input type="text" name="propietario" class="form-control" required placeholder="Correo del Propietario" />
                                        <label style="font-size: 14pt">
                                            <b>Responsable: </b>
                                        </label>
                                        <input type="text" name="responsable" class="form-control" placeholder="Correo del Responsable" />
                                        <!--Mejora: Combo con correos registrados y opcion de escribir uno-->
                                        <label style="font-size: 14pt">
                                            <b>Fecha Entrega: </b>
                                        </label>
                                        <input type="date" name="fecha_entrega" class="form-control" required placeholder="Fecha Entrega" />
                                        <hr />
                                        <input class="btn btn-danger" type="submit" name="Guardar" value="Guardar" />
                                    </form>
                                </div>
                            </div>
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
