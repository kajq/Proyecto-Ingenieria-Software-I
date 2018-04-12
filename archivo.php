<?php
/**
 * archivo short summary.
 *
 * archivo description.
 *
 * @version 1.0
 * @author keilo
 */
session_start();
if (@!$_SESSION['username']) {
	header("Location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Archivo</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
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
                            <li>
                                <a href="">
                                    Archivo de tareas de 
                                    <strong>
                                        <?php echo $_SESSION['nombre'];?>
                                    </strong>
                                </a>
                            </li>
                        </ul>
                        <form action="#" class="navbar-search form-inline" style="margin-top:6px"></form>
                        <ul class="nav pull-right">
                            <li>
                                <form action="dashboard.php">
                                    <input class="btn btn-danger" type="submit" value="Dashboard" />
                                </form>
                                <li>
                                    <form action="desconectar.php">
                                        <input class="btn btn-danger" type="submit" value="Cerrar Cesión" />
                                    </form>
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
                    <h2> Administración de tareas archivadas</h2>
                    <div class="well well-small">
                        <hr class="soft" />
                        <h4>Tareas Cerradas</h4>
                        <div class="row-fluid">

                            <?php
                            $username = $_SESSION['username'];
                            require("connect_db.php");
                            $sql=("SELECT * FROM tareas WHERE estado = 6 and ((propietario = '$username') or (responsable = '$username'))");

                            //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
                            $query=mysqli_query($mysqli,$sql);

                            echo "<table border='1'; class='table table-hover';>";
                            echo "<tr class='warning'>";
                            echo "<td>Detalle</td>";
                            echo "<td>Propietario</td>";
                            echo "<td>Responsable</td>";
                            echo "<td>Fecha</td>";
                            echo "<td>Reiniciar</td>";
                            echo "<td>Eliminar</td>";
                            echo "</tr>";

                            while($cerrada=mysqli_fetch_array($query)){
                                echo "<tr class='success'>";
                                echo "<td>$cerrada[1]</td>";
                                echo "<td>$cerrada[2]</td>";
                                echo "<td>$cerrada[3]</td>";
                                echo "<td>$cerrada[4]</td>";

                                echo "<td><a href='archivo.php?id=$cerrada[0]&id_boton=1'><img src='images/reiniciar.png' class='img-rounded'></td>";
                                echo "<td><a href='archivo.php?id=$cerrada[0]&id_boton=2'><img src='images/eliminar.ol.png' class='img-rounded'/></a></td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                            extract($_GET);
                            if(@$id_boton==1){
                                $sqlUpdateDatos="UPDATE tareas SET estado = 1 WHERE codigo = $id";
                                $resUpdateDatos=mysqli_query($mysqli,$sqlUpdateDatos);
                                if (!$resUpdateDatos) {
                                    printf("Errormessage1: %s\n", $mysqli->error);
                                } else {
                                    $sqlestados="UPDATE acciones SET cod_estado = 1 where cod_tarea = $id";
                                    $res_sqlestados=mysqli_query($mysqli,$sqlestados);
                                    if(!$res_sqlestados){
                                        echo '<script>alert("Se ha reinicado el estado de la tarea")</script> ';
                                        echo "header('Location: archivo.php');
";
                                    }
                                }
                            }
                            if(@$id_boton==2){
                                $sqlborrarDatos="DELETE FROM acciones WHERE cod_tarea = $id";
                                $resborrarDatos=mysqli_query($mysqli,$sqlborrarDatos);
                                if (!$resborrarDatos) {
					printf("Errormessage1: %s\n", $mysqli->error);
				}else {
					$sqlborrarUsuario="DELETE FROM tareas WHERE codigo = $id";
					$resborrarUsuario=mysqli_query($mysqli,$sqlborrarUsuario);
					if (!$resborrarUsuario) {
						printf("Errormessage2: %s\n", $mysqli->error);
					} else {
						echo '<script>alert("Tarea y acciones relacionadas ELIMINADAS")</script> ';
						echo "header('Location: archivo.php')";
					}
				}
			}
                            ?>

                            <div class="span8"></div>
                        </div>
                        <br />
                    </div>
                    <!--///////////////////////////////////////////////////Termina cuerpo del documento interno////////////////////////////////////////////-->
                </div>
            </div>
        </div>
        <!-- Footer
      ================================================== -->
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
