<?php
  require("connect_db.php");
  $mysqli->set_charset("utf8");
  $v1 = $_GET['us'];
  $sql = $mysqli->query("SELECT * FROM usuarios where correo = '$v1'");
  
?>
<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.css">
		<link rel="stylesheet" type="text/css" href="estilos/estilos.css">
	<title>Dashboard</title>
</head>
<body background="" style="background-attachment: fixed" >
  <?php  
  echo $v1;
  if($f2=mysqli_fetch_assoc($sql)){
    if($f2['rol']==1){
        echo '<form action="../admin.php/?us=$v1">';
        echo '<input  class="btn btn-danger" type="submit" name="config" value="Configuración"/>';
        echo '</form>';
      }
    }  
  ?>  
	<center>
     <div class="tit">
        <h2 style="color: #; ">Inicio</h2>
     </div>
  </center>
</body>
</html>