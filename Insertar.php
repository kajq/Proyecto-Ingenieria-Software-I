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
	} else {
			if($responsable != ""){
				include("sendemail.php");//Llama la funcion que se encarga de enviar el correo electronico
				$mail_addAddress=$responsable;//correo electronico que recibira el mensaje
				$template="email_template.html";//Ruta de la plantilla HTML para enviar nuestro mensaje
				/*Inicio captura de datos enviados por $_POST para enviar el correo */
				$mail_setFromEmail= $responsable;
				$mail_setFromName= "Usuario";
				$txt_message="El usuario $propietario le ha asignado una tarea con el detalle [ $detalle ] con fecha limite [ $fecha_entrega ] en el sistema TaskManager, le invitamos a ingresar en el sistema para poder darle seguimiento a esta tarea";
				$mail_subject="Tarea nueva asignada";
				
				sendemail($mail_setFromEmail,$mail_setFromName,$mail_addAddress,$txt_message,$mail_subject,$template);//Enviar el mensaje
			}
			header("Location: dashboard.php");
		}

?>
