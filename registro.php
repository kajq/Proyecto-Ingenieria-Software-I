<?php

	$name=$_POST['name'];
	$mail=$_POST['mail'];
	$birthdate= $_POST['birthdate'];
	$phone=$_POST['phone'];
	$company=$_POST['company'];
	$job=$_POST['job'];
	$days=$_POST['days'];
	$question=$_POST['question'];
	$answer=$_POST['answer'];
	$pass=$_POST['pass'];
	$rpass=$_POST['rpass'];

	require("connect_db.php");
//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
	$checkemail=mysqli_query($mysqli,"SELECT * FROM datos_personales WHERE FK_correo='$mail'");
	$check_mail=mysqli_num_rows($checkemail);
		if($pass==$rpass){
			if($check_mail>0){
				echo ' <script language="javascript">alert("Atencion, ya existe el correo designado para un usuario, verifique sus datos");</script> ';
			}else{
				
				//require("connect_db.php");
//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
				mysqli_query($mysqli,"INSERT INTO usuarios VALUES('$mail', MD5('$pass'),'$question','$answer','2')");
				mysqli_query($mysqli,"INSERT INTO datos_personales VALUES('', '$name','$mail','$birthdate','$phone',  '$company', '$job', '$days')");
				//echo 'Se ha registrado con exito';
				echo ' <script language="javascript">alert("Usuario registrado con éxito");</script> ';
				header("Location: index.php");
			}
			
		}else{
	echo '<script language="javascript">alert("Las contraseñas no son iguales, intentelo de nuevo");</script> ';
		}

	
?>