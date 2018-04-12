<!DOCTYPE html>
<?php
session_start();
if (@!$_SESSION['username']) {
	header("Location:index.php");
}
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Admin</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet"/>
  </head>
<body data-offset="40" background="images/fondotot.jpg" style="background-attachment: fixed">
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
			<li><a href="">Administrado por <strong><?php echo $_SESSION['nombre'];?></strong> </a></li>
		</ul>
		<form action="#" class="navbar-search form-inline" style="margin-top:6px">
		
		</form>
		<ul class="nav pull-right">
			<li>
                <a href='dashboard.php'>
                    <img src='images/volver.png' class='img-rounded' />
                </a>
            <li>
                <a href="desconectar.php">
                    <img src="images/cerrar.png" class='img-rounded' />
                </a>   
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
		<h2> Administración de usuarios registrados</h2>	
		<div class="well well-small">
		<hr class="soft"/>
		<h4>Tabla de Usuarios</h4>
		<div class="row-fluid">

			<?php
			$username = $_SESSION['username'];
			require("connect_db.php");
			$sql=("SELECT correo, contrasena, case when rol = 1 then 'Administrador' else 'Usuario' end FROM usuarios WHERE correo <> '$username' ");
			
			//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
			$query=mysqli_query($mysqli,$sql);

			echo "<table border='1'; class='table table-hover';>";
			echo "<tr class='warning'>";
			echo "<td>Correo</td>";
			echo "<td>Password</td>";
			echo "<td>Rol</td>";
			echo "<td>Cambiar</td>";
			echo "<td>Eliminar</td>";
			echo "</tr>";

			while($arreglo=mysqli_fetch_array($query)){
				echo "<tr class='success'>";
				echo "<td>$arreglo[0]</td>";
				echo "<td>$arreglo[1]</td>";
				echo "<td>$arreglo[2]</td>";

				echo "<td><a href='admin.php?id=$arreglo[0]&rol=$arreglo[2]&id_boton=1'><img src='images/actualizar.png' class='img-rounded'></td>";
				echo "<td><a href='admin.php?id=$arreglo[0]&id_boton=2'><img src='images/eliminar.ol.png' class='img-rounded'/></a></td>";
				echo "</tr>";
			}
				echo "</table>";
			extract($_GET);
			if(@$id_boton==1){
				if(@$rol=='Usuario'){	
					$sqlUpdateDatos="UPDATE usuarios SET rol = 1 WHERE usuarios.correo = '$id'";
					$resUpdateDatos=mysqli_query($mysqli,$sqlUpdateDatos);
				}
				if(@$rol=='Administrador'){
					$sqlUpdateDatos="UPDATE usuarios SET rol = 2 WHERE usuarios.correo = '$id'";
					$resUpdateDatos=mysqli_query($mysqli,$sqlUpdateDatos);
				}
				if (!$resUpdateDatos) {
					printf("Errormessage1: %s\n", $mysqli->error);
				} else {
					echo '<script>alert("Se ha editado los administradores")</script> ';
					//header('Location: proyectos.php');
					echo "<script>location.href='admin.php'</script>";
				}
			}
			if(@$id_boton==2){
				$sqlborrarDatos="DELETE FROM datos_personales WHERE FK_correo='$id'";
				$resborrarDatos=mysqli_query($mysqli,$sqlborrarDatos);
				if (!$resborrarDatos) {
					printf("Errormessage1: %s\n", $mysqli->error);
				}else {
					$sqlborrarUsuario="DELETE FROM usuarios WHERE correo='$id'";
					$resborrarUsuario=mysqli_query($mysqli,$sqlborrarUsuario);
					if (!$resborrarUsuario) {
						printf("Errormessage2: %s\n", $mysqli->error);
					} else {
						echo '<script>alert("REGISTRO ELIMINADO")</script> ';
						//header('Location: proyectos.php');
						echo "<script>location.href='admin.php'</script>";
					}
				}
			}
			?>
			
		<div class="span8">
		</div>	
		</div>	
		<br/>
		</div>
<!--///////////////////////////////////////////////////Termina cuerpo del documento interno////////////////////////////////////////////-->
</div>
</div>
</div>
<!-- Footer
      ================================================== -->
<hr class="soften"/>
<footer class="footer">

<hr class="soften"/>
<p>&copy; Copyright Keilor Jiménez <br/><br/></p>
 </footer>
</div><!-- /container -->

  </body>
</html>