<?php
/*$isNew=true;
  
  $ocupacion="";
  $dias_record="";
  $FK_cod_pregunta="";
  $respuesta="";*/

extract($_POST);	//extraer todos los valores del metodo post del formulario de actualizar
	require("connect_db.php");
	$sentencia="update datos_personales set nombre='$nombre', fecha_nac='$fecha_nac', telefono='$telefono', empresa='$empresa', puesto='$ocupacion', dias_record='$dias_record' where FK_correo='$correo'";
	$sentencia2="update usuarios set FK_cod_pregunta = $codigo_pregunta, respuesta = '$respuesta' 
	WHERE correo = '$correo'";
	//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
	$resent=mysqli_query($mysqli,$sentencia);
	$resent2=mysqli_query($mysqli,$sentencia2);
	if (!$resent and !$resent2) {
   		printf("$codigo_pregunta Errormessage1: %s\n", $mysqli->error);
   		echo "Error de procesamieno no se han actuaizado los datos";
		echo '<script>alert("ERROR EN PROCESAMIENTO NO SE ACTUALIZARON LOS DATOS")</script> ';
		/*header("location: dashboard.php");
		
		echo "<script>location.href='dashboard.php'</script>";*/
	}else {
		echo '<script>alert("REGISTRO ACTUALIZADO")</script> ';		
	}
?>