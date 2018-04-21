<!DOCTYPE html>
<?php
session_start();
if (@!$_SESSION['username']) {
  header("Location:index.php");
}
$usuario = $_SESSION['username'];
?>
<html>
<head>

	<meta charset="utf-8">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.css">
		<link rel="stylesheet" type="text/css" href="estilos/estilos.css">
	<title>Formulario</title>
</head>
<body background="images/fondotot.jpg" style="background-attachment: fixed" >
	<center><div class="tit"><h2 style="color: #; ">Restaurar Contraseña</h2>
		<center><div class="Ingreso">

	<table border="0" align="center" valign="middle">
		<tr>
		<td rowspan=2>
<!-- formulario registro -->

<form method="post" action="" >
    <div class="form-group">
      <label style="font-size: 14pt; color: #;"><b>Correo electronico</b>
      <input type="text" name="correo" class="form-control"  value="<?php echo $usuario?>" disabled/></label>
    </div>
    <div class="form-group">
      <label style="font-size: 14pt"><b>Contraseña anterior</b>
      <input type="password" name="pre-pass" class="form-control"  /></label>
    </div>
    <div class="form-group">
      <label style="font-size: 14pt; color: #;"><b>Nueva Contraseña  </b>
      <input type="password" name="new_pass" class="form-control"   /></label>
    </div>
    <div class="form-group">
      <label style="font-size: 14pt; color: #;"><b>Confirmar Contraseña</b>
      <input type="password" name="rnew_pass" class="form-control"   /></label>
    </div>
   <div>
     <input  class='btn btn-primary' type='submit' value='Aceptar' name= 'cambiar'/> 
     <input  class='btn btn-danger' type='submit' value='Volver' name= 'salir'/> 
   </div>
</form>

<?php
$isChange= 0;
  if(isset($_POST['cambiar'])){
      require("connect_db.php");
      $sql=("SELECT contrasena, estado FROM usuarios WHERE correo = '$usuario' ");
      $query=mysqli_query($mysqli,$sql);
      while($arreglo=mysqli_fetch_array($query)){
      if($_POST['pre-pass'] == $arreglo[0] && $_POST['new_pass'] == $_POST['rnew_pass']){
        $sqlTask = mysqli_query($mysqli,
          "UPDATE usuarios SET contrasena = '$_POST[new_pass]', estado = 1 WHERE correo = '$usuario'");
        include("sendemail.php");//Llama la funcion que se encarga de enviar el correo electronico
        $mail_addAddress=$usuario;//correo electronico que recibira el mensaje
        $template="email_template.html";//Ruta de la plantilla HTML para enviar nuestro mensaje
        /*Inicio captura de datos enviados por $_POST para enviar el correo */
        $mail_setFromEmail= $usuario;
        $mail_setFromName= "usuario";
        $txt_message="Se ha restablecido la contraseña exitosmanete desde el sistema Taskmanager";
        $mail_subject="Se restablecio contraseña";
        
        sendemail($mail_setFromEmail,$mail_setFromName,$mail_addAddress,$txt_message,$mail_subject,$template);//Enviar el mensaje
        $isChange = 1;
    if (!$sqlTask) {
      echo ' <script language="javascript">alert("Error al Actualizar contraseña: ';
      echo $mysqli->error;
      echo '");</script> ';
      printf("Errormessage1: %s\n", $mysqli->error);
      } else {
      echo '<script> "Datos incorrectos, intentelo de nuevo"; </script>';
              }
                    }
                                                                                        }
  } 
  if(isset($_POST['salir'])){
    header("Location: dashboard.php");  
  }
	?>
<!--Fin formulario registro -->
</div>
</div>
		</td>
		</tr>
		</table>
		</div></center></div></center>

	
</body>
</html>