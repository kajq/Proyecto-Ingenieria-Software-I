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
	$estado = $_GET["estado"];
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
				if (!$sqlDatos) {
					printf("Errormessage1: %s\n", $mysqli->error);
				}
			} 
			echo ' <script language="javascript">alert("Tarea actualizada con éxito");</script> ';
			header("Location: dashboard.php");
		}
	} else if($tipo=="estado"){
		$sqlTask = mysqli_query($mysqli,
		  "UPDATE `tareas` SET `estado`= $estado WHERE codigo = $codigo");
		header("Location: dashboard.php");
	} else if($tipo=="accion"){
		if($estado=='checked'){$aux=1;}else{$aux=4;}
		$estado = $aux;
		$sqlAccion = mysqli_query($mysqli,
			"update acciones SET cod_estado = $estado WHERE codigo = $codigo");
		header("Location: dashboard.php");
	}

?>
