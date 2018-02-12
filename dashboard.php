<?php
  session_start();
  if (@!$_SESSION['username']) {
    header("Location:index.php");
  }
  require("connect_db.php");
  $user=$_SESSION['username'];
  $sql=mysqli_query($mysqli, "SELECT nombre FROM datos_personales where FK_correo = '$user'"); 
      if (!$sql) {
        printf("Errormessage1: %s\n", $mysqli->error);
      } else {
        $datos_usuario=mysqli_fetch_assoc($sql);
        $_SESSION['nombre']=$datos_usuario['nombre'];
      }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <title>Administrador de Tareas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="bootstrap/js/jquery-1.8.3.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
	
</head>
<body background="" style="background-attachment: fixed" >
  <ul>
    <li><form action="formulario.php" method="POST">
          <input class="btn btn-danger" type="submit" name="Accion" value="Editar">
        </form> 
    </li>
    <li>
  <?php  
    if($_SESSION['rol']==1){
        echo '<form action="admin.php">'; 
        echo '<input  class="btn btn-danger" type="submit" value="Administrar"/>';
        echo '</form>';
      }
  ?>  
  </li>
  </ul>
	<center>
     <div class="tit">
        <h2 style="color: #; ">Inicio</h2>
     </div>
  </center>
</body>
</html>