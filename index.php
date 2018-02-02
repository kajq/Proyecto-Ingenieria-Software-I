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
<body background="" style="background-attachment: fixed" >
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
		<tr><td></td>
			<td width=80 align=center><input class="btn btn-primary" type="submit" value="Aceptar"></td>
			</tr></tr></table>
		</form>
    
<br>
<!-- formulario registro -->

<form method="post" action="" >
  <fieldset>
    <legend  style="font-size: 18pt"><b>Registro</b></legend>
    <div class="form-group">
      <label style="font-size: 14pt"><b>Ingresa tu nombre</b></label>
      <input type="text" name="name" class="form-control" placeholder="Ingresa tu nombre" />
    </div>
    <div class="form-group">
      <label style="font-size: 14pt; color: #;"><b>Ingresa tu correo</b></label>
      <input type="text" name="mail" class="form-control"  required placeholder="Ingresa correo"/>
    </div>
    <div class="form-group">
      <label style="font-size: 14pt; color: #;"><b>Fecha de nacimiento</b></label>
      <input type="date" name="birthdate" class="form-control"  required placeholder="Ingresa fecha"/>
    </div>
    <div class="form-group">
      <label style="font-size: 14pt; color: #;"><b>Ingresa tu telefono</b></label>
      <input type="text" name="phone" class="form-control"  required placeholder="Ingresa telefono"/>
    </div>
    <div class="form-group">
      <label style="font-size: 14pt; color: #;"><b>Ingresa tu Empresa</b></label>
      <input type="text" name="company" class="form-control"  required placeholder="Ingresa tu empresa"/>
    </div>
    <div class="form-group">
      <label style="font-size: 14pt; color: #;"><b>Ingresa tu puesto</b></label>
      <input type="text" name="job" class="form-control"  required placeholder="Ingresa puesto"/>
    </div>
    <div class="form-group">
      <label style="font-size: 14pt; color: #;"><b>Recordatorios</b></label>
      <input type="number" name="days" class="form-control"  required placeholder="Ingresa cuanto días antes prefieres"/>
    </div>
    <div class="form-group">
      <label style="font-size: 14pt; color: #;"><b>Selecciona una pregunta y réspondala</b></label>
      <select name="question">
        <option value="">Seleccionar</option>
        <?php
            while($f = $res->fetch_object()){
          echo '<option value= ';
          echo $f->codigo.'"> ';
          echo  $f->descripcion.' </option>';
        }
        ?>
      </select>
      <input type="text" name="answer" class="form-control"  required placeholder="Respuesta"/>
    </div>
    <div class="form-group">
      <label style="font-size: 14pt; color: #;"><b>Ingresa tu contraseña</b></label>
      <input type="password" name="pass" class="form-control"  placeholder="Ingresa contraseña" />
    </div>
    <div class="form-group">
      <label style="font-size: 14pt"><b>Repite tu contraseña</b></label>
      <input type="password" name="rpass" class="form-control" required placeholder="Repite contraseña" />
    </div>
      
    </div>
   
    <input  class="btn btn-danger" type="submit" name="submit" value="Registrarse"/>

  </fieldset>
</form>
</div>
<?php
		if(isset($_POST['submit'])){
			require("registro.php");
		}
	?>
<!--Fin formulario registro -->

		</td>
		</tr>
		</table>
		</div></center></div></center>

	
</body>
</html>