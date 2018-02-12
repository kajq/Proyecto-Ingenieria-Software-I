<?php
  session_start();
  $Accion = $_POST['Accion'];
  //$Accion=true;
  $nombre="";
  $correo="";
  $fecha_nac="";
  $telefono="";
  $empresa="";
  $ocupacion="";
  $dias_record="";
  $FK_cod_pregunta="";
  $respuesta="";
  $contrasena="";
  if ($Accion=="Editar") {
    require("connect_db.php");
    //$Accion=false;
    $username = $_SESSION['username'];
    $sql="SELECT dp.nombre, dp.FK_correo, dp.fecha_nac, dp.telefono, dp.empresa, dp.puesto, dp.dias_record, us.FK_cod_pregunta, us.respuesta, us.contrasena FROM datos_personales dp LEFT JOIN usuarios us ON us.correo = dp.FK_correo WHERE dp.FK_correo='$username'";
  //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
    $ressql=mysqli_query($mysqli,$sql);
    if (!$ressql) {
                printf("Errormessage1: %s\n", $mysqli->error);
              }
    while ($row=mysqli_fetch_row ($ressql)){
          $nombre=$row[0];
          $correo=$row[1];
          $fecha_nac=$row[2];
          $telefono=$row[3];
          $empresa=$row[4];
          $ocupacion=$row[5];
          $dias_record=$row[6];
          $FK_cod_pregunta=$row[7];
          $respuesta=$row[8];
          $contrasena=$row[9];
        }
  }
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
	<title>Formulario</title>
</head>
<body background="" style="background-attachment: fixed" >
	<center><div class="tit"><h2 style="color: #; ">Formulario de usuario</h2>
		<center><div class="Ingreso">

	<table border="0" align="center" valign="middle">
		<tr>
		<td rowspan=2>
<!-- formulario registro -->

<form method="post" action="" >
    <legend  style="font-size: 18pt"><b>Registro</b></legend>
    <div class="form-group">
      <label style="font-size: 14pt"><b>Nombre completo</b>
      <input type="text" name="nombre" class="form-control" required value="<?php echo $nombre?>" placeholder="Ingresa tu nombre" /></label>
    </div>
    <div class="form-group">
      <label style="font-size: 14pt; color: #;"><b>Correo electronico</b>
      <input type="text" name="correo" class="form-control"  required value="<?php echo $correo?>" placeholder="Ingresa correo"/></label>
    </div>
    <div class="form-group">
      <label style="font-size: 14pt; color: #;"><b>Fecha de nacimiento</b>
      <input type="date" name="fecha_nac" class="form-control"  required value="<?php echo $fecha_nac?>"placeholder="Ingresa fecha"/></label>
    </div>
    <div class="form-group">
      <label style="font-size: 14pt; color: #;"><b>Número de teléfono</b>
      <input type="text" name="telefono" class="form-control"  required value="<?php echo $telefono?>"placeholder="Ingresa telefono"/></label>
    </div>
    <div class="form-group">
      <label style="font-size: 14pt; color: #;"><b>Lugar de trabajo</b>
      <input type="text" name="empresa" class="form-control"  required value="<?php echo $empresa?>"placeholder="Ingresa tu empresa"/></label>
    </div>
    <div class="form-group">
      <label style="font-size: 14pt; color: #;"><b>Ocupación</b>
      <input type="text" name="ocupacion" class="form-control"  required value="<?php echo $ocupacion?>" placeholder="Ingresa puesto"/></label>
    </div>
    <div class="form-group">
      <label style="font-size: 14pt; color: #;"><b>Días de recordatorios</b>
      <input type="number" name="dias_record" class="form-control"  required value="<?php echo $dias_record?>" placeholder="Ingresa cuanto días antes prefieres"/></label>
    </div>
    <div class="form-group">
      <label style="font-size: 14pt; color: #;"><b>Pregunta y respuesta de recuperación</b></label>
      <select name="codigo_pregunta">
        <option value="">Seleccionar</option>
        <?php
            while($f = $res->fetch_object()){
          echo '<option value= ';
          echo $f->codigo.'"> ';
          echo  $f->descripcion.' </option>';
        }
        ?>
      </select>
      <input type="text" name="respuesta" class="form-control"  required placeholder="Respuesta"/>
    </div>
    <div class="form-group">
      <label style="font-size: 14pt; color: #;"><b>Contraseña</b>
      <input type="password" name="contraseña" class="form-control"  required value="<?php echo $contrasena?>" placeholder="Ingresa contraseña" /></label>
    </div>
    <div class="form-group">
      <label style="font-size: 14pt"><b>Confirmar Contraseña</b>
      <input type="password" name="rcontraseña" class="form-control" required placeholder="Repite contraseña" /></label>
    </div>
      
    </div>
   
<?php
  if($Accion=="Registrar"){
  echo "<input  class='btn btn-primary' type='submit' name='submit' value='Registrarse'/> " ;
  if(isset($_POST['submit'])){
      require("registro.php");
    }
  echo "</form>";
  echo "<form action=\"index.php\"><input class=\"btn btn-danger\" type=\"submit\" value=\"Cancelar\"> </form>";
		
  } else {
  echo "<input  class='btn btn-primary' type='submit' name='update' value='Actualizar'/> </form>";
  echo "<form action=\"dashboard.php\"><input class=\"btn btn-danger\" type=\"submit\" value=\"Cancelar\"> </form>";
    if(isset($_POST['update'])){
      require("ejecutaactualizar.php");
    }
  }
	?>
<!--Fin formulario registro -->

</div>
		</td>
		</tr>
		</table>
		</div></center></div></center>

	
</body>
</html>