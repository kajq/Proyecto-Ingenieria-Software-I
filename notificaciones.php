<?php
require("connect_db.php");
$usuarios=("SELECT FK_correo, dias_record FROM datos_personales ");
$qUsuarios=mysqli_query($mysqli,$usuarios);
while($usuario=mysqli_fetch_array($qUsuarios)){
 $notificaciones = "SELECT ta.responsable, ta.codigo FROM tareas ta 
 left join datos_personales da 
 ON da.FK_correo = ta.responsable 
 where ta.estado not in (3, 6) 
 and now() >= date_sub(ta.fecha, INTERVAL $usuario[1] DAY) 
 and now() <= ta.fecha and da.dias_record <> ('') 
 and ta.responsable = ('$usuario[0]') 
 and ta.codigo not in ( SELECT cod_tarea from notificaciones where cod_tarea = ta.codigo and cod_mensaje = 1)";

 $qnotificacion = mysqli_query($mysqli, $notificaciones);
	if (!$qnotificacion) {
		echo ' <script language="javascript">alert("Error al revizar datos: ';
		echo $mysqli->error;
		echo '");</script> ';
		printf("Errormessage1: %s\n", $mysqli->error);
	} else {
		while($notificacion=mysqli_fetch_array($qnotificacion)){
			$sqlTask = mysqli_query($mysqli,
				"INSERT INTO notificaciones VALUES('', '$usuario[0]', '$notificacion[1]', 1,0)");

		if (!$sqlTask) {
			echo ' <script language="javascript">alert("Error al insertar notificacio: ';
			echo $mysqli->error;
			echo '");</script> ';
			printf("Errormessage1: %s\n", $mysqli->error);
		}
	}
	}
	$notificaciones = "SELECT ta.responsable, ta.codigo FROM tareas ta 
	 left join datos_personales da 
	 ON da.FK_correo = ta.responsable 
	 where ta.estado not in (3, 6) 
	 and now() > ta.fecha
	 and ta.responsable = ('$usuario[0]') 
	 and ta.codigo not in ( SELECT cod_tarea from notificaciones where cod_tarea = ta.codigo and cod_mensaje = 2)";

	 $qnotificacion = mysqli_query($mysqli, $notificaciones);
		if (!$qnotificacion) {
		echo ' <script language="javascript">alert("Error al revizar datos: ';
		echo $mysqli->error;
		echo '");</script> ';
		printf("Errormessage1: %s\n", $mysqli->error);
	} else {
		while($notificacion=mysqli_fetch_array($qnotificacion)){
			$sqlTask = mysqli_query($mysqli,
				"INSERT INTO notificaciones VALUES('', '$usuario[0]', '$notificacion[1]', 2,0)");

		if (!$sqlTask) {
			echo ' <script language="javascript">alert("Error al insertar notificacio: ';
			echo $mysqli->error;
			echo '");</script> ';
			printf("Errormessage1: %s\n", $mysqli->error);
		}
	}
	}
}
?>