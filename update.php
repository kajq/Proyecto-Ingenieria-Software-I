<?php

/**
 * update short summary.
 *
 * update description.
 *
 * @version 1.0
 * @author keilo
 */
	extract($_POST);
	$codigo= $_GET["cod"];
	$tipo= $_GET["tipo"];
	require("connect_db.php");
	if ($tipo=="tarea"){
		$sqlTask = mysqli_query($mysqli,
			"UPDATE `tareas` SET `detalle`='$detalle',`propietario`='$propietario',`responsable`='$responsable',
		`fecha`='$fecha_entrega' WHERE codigo = $codigo");

		if (!$sqlTask) {
			echo ' <script language="javascript">alert("Error al Actualizar tarea: ';
			echo $mysqli->error;
			echo '");</script> ';
			printf("Errormessage1: %s\n", $mysqli->error);
		} else {
			if($tarea_nueva<>""){
				$sqlDatos= mysqli_query($mysqli,"INSERT INTO acciones VALUES('', '$tarea_nueva', $codigo, 1)");
			}
			if (!$sqlDatos) {
				printf("Errormessage1: %s\n", $mysqli->error);
			} else {
				echo ' <script language="javascript">alert("Tarea actualizada con éxito");</script> ';
				header("Location: dashboard.php");
			
		}
		}
	} else if($tipo=="estado-5"){
		$sqlTask = mysqli_query($mysqli,
		  "UPDATE `tareas` SET `estado`= 5 WHERE codigo = $codigo");
		header("Location: dashboard.php");
	} else if($tipo=="estado-3"){
		  $sqlTask = mysqli_query($mysqli,
			"UPDATE `tareas` SET `estado`= 3 WHERE codigo = $codigo");
		  header("Location: dashboard.php");
	}

?>
