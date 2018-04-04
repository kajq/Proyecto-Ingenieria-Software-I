<?php

/**
 * Insertar short summary.
 *
 * Insertar description.
 *
 * @version 1.0
 * @author keilo
 */
	extract($_POST);
	require("connect_db.php");
	$sqlTask = mysqli_query($mysqli,"INSERT INTO tareas VALUES('', '$detalle', '$propietario','$responsable', '$fecha_entrega', 1)");

	if (!$sqlTask) {
		echo ' <script language="javascript">alert("Error al insertar tarea: ';
		echo $mysqli->error;
		echo '");</script> ';
		printf("Errormessage1: %s\n", $mysqli->error);
	} else {/*
		$sqlDatos= mysqli_query($mysqli,"INSERT INTO datos_personales VALUES('', '$nombre','$correo','$fecha_nac',
					'$telefono',  '$empresa', '$ocupacion', '$dias_record')");
		if (!$sqlDatos) {
			printf("Errormessage1: %s\n", $mysqli->error);
		} else {*/
			echo ' <script language="javascript">alert("Tarea registrada con éxito");</script> ';
			header("Location: dashboard.php");
		}
	//}

?>
