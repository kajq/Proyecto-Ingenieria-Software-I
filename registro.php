<?php
	/*$nombre=$_POST['nombre'];
	$correo=$_POST['correo'];
	$fecha_nac= $_POST['fecha_nac'];
	$telefono=$_POST['telefono'];
	$empresa=$_POST['empresa'];
	$ocupacion=$_POST['ocupacion'];
	$dias_record=$_POST['dias_record'];
	$FK_cod_pregunta=$_POST['FK_cod_pregunta'];
	$respuesta=$_POST['respuesta'];
	$contraseña=$_POST['contraseña'];
	$rcontraseña=$_POST['rcontraseña'];*/
	extract($_POST);

	require("connect_db.php");
//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
	$checkemail=mysqli_query($mysqli,"SELECT * FROM datos_personales WHERE FK_correo='$correo'");
	$check_mail=mysqli_num_rows($checkemail);
	$contraseña = chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90));
		
			if($check_mail>0){
				echo ' <script language="javascript">alert("Atencion, ya existe el correo designado para un usuario, verifique sus datos");</script> ';
			}else{

//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
				$sqlUsuarios = mysqli_query($mysqli,"INSERT INTO usuarios VALUES('$correo','$contraseña',$codigo_pregunta,'$respuesta',2, 2)");

				if (!$sqlUsuarios) {
					echo ' <script language="javascript">alert("Error al insertar usuario: ';
					echo $mysqli->error;
					echo '");</script> ';
					printf("Errormessage1: %s\n", $mysqli->error);
				} else {
					$sqlDatos= mysqli_query($mysqli,"INSERT INTO datos_personales VALUES('', '$nombre','$correo','$fecha_nac',
					'$telefono',  '$empresa', '$ocupacion', '$dias_record')");
					if (!$sqlDatos) {
						printf("Errormessage1: %s\n", $mysqli->error);
					} else {
						echo ' <script language="javascript">alert("Usuario registrado con éxito");</script> ';
						include("sendemail.php");//Llama la funcion que se encarga de enviar el correo electronico
						$mail_addAddress=$correo;//correo electronico que recibira el mensaje
						$template="email_template.html";//Ruta de la plantilla HTML para enviar nuestro mensaje
						/*Inicio captura de datos enviados por $_POST para enviar el correo */
						$mail_setFromEmail= $correo;
						$mail_setFromName= $nombre;
						$txt_message="Se ha creado exitosamente su usuario en el sistema TaskManager, su administrador de tareas. Para ingresar debes utilizar la contraseña temporal: [ $contraseña ]. Ingresa al sistema y cambiar la contraseña para terminar el registro.";
						$mail_subject="Registro exitoso";
						
						sendemail($mail_setFromEmail,$mail_setFromName,$mail_addAddress,$txt_message,$mail_subject,$template);//Enviar el mensaje
						header("Location: index.php");
					}
				}

			}
?>