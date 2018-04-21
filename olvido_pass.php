<!DOCTYPE HTML>
<html>
<head>
<title>Olvido contraseña</title>
<!-- Custom Theme files -->
<meta charset="utf-8">
<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.css">
<link rel="stylesheet" type="text/css" href="estilos/estilos.css">
<!-- Custom Theme files -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta name="keywords" content="" />
</head>
<body background="images/fondotot.jpg" style="background-attachment: fixed"		>
<!--coact start here-->

<center> <div class="tit"> <h2 style="color: #; ">Formulario recuperación</h2>
	<center> <div class="Ingreso">
	<table border="0" align="center" valign="middle">
		<tr>
		<td rowspan=2>
	<!-- formulario recuperación -->
	<form method="post">
		<div class="form-group">
		<h3>Correo electrónico</h3>
		<input type="email" placeholder="tu@email.com" class="form-group has-success" style="border-radius:15px;"  name="customer_email" required />
		</div>
		<div class="form-group">
		<h3>Respuesta secreta</h3>
		<input type="text" placeholder="Respuesta" class="form-group has-success" style="border-radius:15px;"  name="respuesta" required />
		</div>
		<div class="form-group">
		<h3>Fecha nacimiento</h3>
		<input type="date" class="form-group has-success" style="border-radius:15px;"  name="date" />
		</div>
		<div class="form-group">
		<?php
			if (isset($_POST['send'])){
				require("connect_db.php");
			$sql=("SELECT us.correo, us.contrasena, us.respuesta, dat.nombre, dat.fecha_nac FROM usuarios us 
					LEFT JOIN datos_personales dat 
						on dat.FK_correo = us.correo
				WHERE us.correo = '$_POST[customer_email]' ");
			$query=mysqli_query($mysqli,$sql);
			while($arreglo=mysqli_fetch_array($query)){
			if($arreglo[2] == $_POST['respuesta'] && $arreglo[4] == $_POST['date']){
				//Genero la nueva contraseña
				$random_string = chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90));
				$sqlTask = mysqli_query($mysqli,
					"UPDATE `usuarios` SET `estado`=2, contrasena = '$random_string' WHERE correo = '$_POST[customer_email]'");
		if (!$sqlTask) {
			echo ' <script language="javascript">alert("Error al Actualizar tarea: ';
			echo $mysqli->error;
			echo '");</script> ';
			printf("Errormessage1: %s\n", $mysqli->error);
		}
				include("sendemail.php");//Llama la funcion que se encarga de enviar el correo electronico
				$mail_addAddress=$_POST['customer_email'];//correo electronico que recibira el mensaje
				$template="email_template.html";//Ruta de la plantilla HTML para enviar nuestro mensaje
				/*Inicio captura de datos enviados por $_POST para enviar el correo */
				$mail_setFromEmail= $arreglo[0];
				$mail_setFromName= $arreglo[3];
				$txt_message="Se ha solicitado recuperar su contraseña. Por favor ingresa al sistema y realiza el cambio de contraseña para terminar el proceso.   Su contraseña actual es: $random_string";
				$mail_subject="Recuperación de contraseña";
				
				sendemail($mail_setFromEmail,$mail_setFromName,$mail_addAddress,$txt_message,$mail_subject,$template);//Enviar el mensaje

				} else {
					echo ' <script language="javascript">alert("Datos no concuerdan con ninguna cuenta, intentalo de nuevo");</script> ';
				}
			}
			}
		?>
	</div>
	<div class="enviar">
		<div class="contact-check">
			
		</div>
        <div class="contact-enviar">
		  <input class='btn btn-primary' type="submit" value="Enviar mensaje" name="send">
		</div>
		<div class="clear"> </div>
		</form>
		<form action="index.php">
			<div class="contact-enviar">
		  		<input class='btn btn-danger' type="submit" value="Cancelar">
			</div>
		</form>
</div>
</div>
<!--contact end here-->
</body>
</html>