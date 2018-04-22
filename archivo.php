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
    <meta charset="utf-8">

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
                                <a href='dashboard.php'>
                                    <img src='images/volver.png' title="Volver" class='img-rounded' />
                                </a>
                            <li>
                                <a href="desconectar.php">
                                    <img src="images/cerrar.png" title="Cerrar Sesion" class='img-rounded' />
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
                    <h2> Administracion de tareas archivadas</h2>
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
                                $esProp=false;
                                if($username == $cerrada[2]){
                                    $esProp=true;
                                }
                                echo "<tr class='success'>";
                                echo "<td>$cerrada[1]</td>";
                                echo "<td>$cerrada[2]</td>";
                                echo "<td>$cerrada[3]</td>";
                                echo "<td>$cerrada[4]</td>";

                                echo "<td><a href='archivo_update.php?id=$cerrada[0]&id_boton=1&us=$esProp'><img src='images/reiniciar.png' class='img-rounded'></td>";
                                echo "<td><a href='archivo_update.php?id=$cerrada[0]&id_boton=2&us=$esProp'><img src='images/eliminar.ol.png' class='img-rounded'/></a></td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                        ?>

                            <div class="span8"></div>
                        </div>
                        <br />
                    </div>
                    <!--Fin tabla tareas cerradas 
                        Inicio Tabla Canceladas-->
                    <div class="well well-small">
                        <hr class="soft" />
                        <h4>Tareas Canceladas</h4>
                        <div class="row-fluid">

                            <?php
                            $username = $_SESSION['username'];
                            require("connect_db.php");
                            $sql=("SELECT * FROM tareas WHERE estado = 3 and ((propietario = '$username') or (responsable = '$username'))");

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
                                $esProp=false;
                                if($username == $cerrada[2]){
                                    $esProp=true;
                                }
                                echo "<tr class='success'>";
                                echo "<td>$cerrada[1]</td>";
                                echo "<td>$cerrada[2]</td>";
                                echo "<td>$cerrada[3]</td>";
                                echo "<td>$cerrada[4]</td>";

                                echo "<td><a href='archivo_update.php?id=$cerrada[0]&id_boton=1&us=$esProp'><img src='images/reiniciar.png' class='img-rounded'></td>";
                                echo "<td><a href='archivo_update.php?id=$cerrada[0]&id_boton=2&us=$esProp'><img src='images/eliminar.ol.png' class='img-rounded'/></a></td>";
                                echo "</tr>";
                            }
                            echo "</table>";
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
                &copy; Copyright Keilor Jimenez
                <br />
                <br />
            </p>
        </footer>
    </div><!-- /container -->

</body>
</html>
