<?php
	$nombre=$_POST['nombre'];
	$correo=$_POST['correo'];
	$fecha_nac= $_POST['fecha_nac'];
	$telefono=$_POST['telefono'];
	$empresa=$_POST['empresa'];
	$ocupacion=$_POST['ocupacion'];
	$dias_record=$_POST['dias_record'];
	$FK_cod_pregunta=$_POST['FK_cod_pregunta'];
	$respuesta=$_POST['respuesta'];
	$contraseña=$_POST['contraseña'];
	$rcontraseña=$_POST['rcontraseña'];

	require("connect_db.php");
//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
	$checkemail=mysqli_query($mysqli,"SELECT * FROM datos_personales WHERE FK_correo='$correo'");
	$check_mail=mysqli_num_rows($checkemail);
		if($contraseña==$rcontraseña){
			if($check_mail>0){
				echo ' <script language="javascript">alert("Atencion, ya existe el correo designado para un usuario, verifique sus datos");</script> ';
			}else{
				
				//require("connect_db.php");
//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
				mysqli_query($mysqli,"INSERT INTO usuarios VALUES('$correo', MD5('$contraseña'),'$FK_cod_pregunta','$respuesta','2')");
				mysqli_query($mysqli,"INSERT INTO datos_personales VALUES('', '$nombre','$correo','$fecha_nac','$telefono',  '$empresa', '$ocupacion', '$dias_record')");
				//echo 'Se ha registrado con exito';
				echo ' <script language="javascript">alert("Usuario registrado con éxito");</script> ';
				//header("Location: index.php");
			}
			
		}else{
	echo '<script language="javascript">alert("Las contraseñas no son iguales, intentelo de nuevo");</script> ';
		}

	
?>