
<?php
//include("connect_db.php");

//$miconexion = new connect_db;


session_start();
	require("connect_db.php");

	$username=$_POST['mail'];
	$pass=$_POST['pass'];


	//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
	$sql2=mysqli_query($mysqli,
		"SELECT correo, contrasena, rol 
		FROM usuarios 
		WHERE correo='$username'");
	if($f2=mysqli_fetch_assoc($sql2)){
		if($pass==$f2['contrasena']){
			$_SESSION['correo']=$f2['correo'];
			$_SESSION['rol']=$f2['rol'];

			if($f2['rol']==1){
				echo '<script>alert("BIENVENIDO ADMINISTRADOR")</script> ';
			}

			header("Location: dashboard.php");
		}else{
			echo '<script>alert("CONTRASEÑA INCORRECTA")</script> ';
		
			echo "<script>location.href='index.php'</script>";
		}
	}else{
		
		echo '<script>alert("ESTE USUARIO NO EXISTE, PORFAVOR REGISTRESE PARA PODER INGRESAR")</script> ';
		
		echo "<script>location.href='index.php'</script>";	

	}

?>