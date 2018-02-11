<?php
  require("connect_db.php");
  $mysqli->set_charset("utf8");
  $res = $mysqli->query("SELECT * FROM preguntas");
  
?>
<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.css">
		<link rel="stylesheet" type="text/css" href="estilos/estilos.css">
	<title>Task Manager</title>
</head>
<body background="images/fondotot.jpg" style="background-attachment: fixed" >
	<center><div class="tit"><h2 style="color: #; ">Inicio de sesión</h2>
		<center><div class="Ingreso">

	<table border="0" align="center" valign="middle">
		<tr>
		<td rowspan=2>
		<form action="validar.php" method="post">

		<table border="0">

		<tr><td><label style="font-size: 14pt"><b>Correo: </b></label></td>
			<td width=80> <input class="form-group has-success" style="border-radius:15px;" type="text" name="mail"></td></tr>
		<tr><td><label style="font-size: 14pt"><b>Contraseña: </b></label></td>
			<td witdh=80><input style="border-radius:15px;" type="password" name="pass"></td></tr>
		<tr>
			<td width=80 align=center><input class="btn btn-primary" type="submit" value="Aceptar"></td></form>
      <td width=80 >
        <br>
        <form action="formulario.php">
          <input class="btn btn-danger" type="submit" value="Registro">
        </form> 
      </td>   
		</tr>
	
</body>
</html>