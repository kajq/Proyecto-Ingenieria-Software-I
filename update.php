<?php
/**
 * update short summary.
 *
 * update description.
 *
 * @version 1.0
 * @author keilo
 */
	extract($_POST);
	$tipo= $_GET["tipo"];
	$codigo= $_GET["cod"];
	$valor = $_GET["valor"];
    $cod_tarea = $_GET["tarea"];
    $cont = 0;
	require("connect_db.php");

    if ($tipo==1){
		$sqlTask = mysqli_query($mysqli,
			"UPDATE `tareas` SET `detalle`='$detalle',`propietario`='$propietario',`responsable`='$responsable',
			`fecha`='$fecha_entrega' WHERE codigo = $codigo");
		if (!$sqlTask) {
			echo ' <script language="javascript">alert("Error al Actualizar tarea: ';
			echo $mysqli->error;
			echo '");</script> ';
			printf("Errormessage1: %s\n", $mysqli->error);
		} else {
			$sqltarea= mysqli_query($mysqli,"SELECT `codigo` FROM acciones WHERE cod_tarea = $codigo");
			while($codigos=mysqli_fetch_array($sqltarea)){
                if($detalle_acciones[$cont]==""){
                    $sqlAccion = mysqli_query($mysqli, "DELETE FROM acciones WHERE codigo = $codigos[0]");
                } else {
				$sqlAccion = mysqli_query($mysqli, "UPDATE acciones SET descripcion = '$detalle_acciones[$cont]' WHERE codigo = $codigos[0]");
                }
			$cont++;
            if (!$sqlAccion) {
                printf("Errormessage1: %s\n", $mysqli->error);
            }
			}
			if($tarea_nueva<>""){
				$sqlDatos= mysqli_query($mysqli,"INSERT INTO acciones VALUES('', '$tarea_nueva', $codigo, 1)");
				if (!$sqlDatos) {
					printf("Errormessage1: %s\n", $mysqli->error);
				}
			}
        }
	} else if($tipo==2){
		$sqlTask = mysqli_query($mysqli, "UPDATE `tareas` SET `estado`= $valor WHERE codigo = $codigo");

	} else if($tipo==3){
        if($valor=='checked'){$valor=1;}else{$valor=4;}
		$sqlAccion = mysqli_query($mysqli, "UPDATE acciones SET cod_estado = $valor WHERE codigo = $codigo");
	    }
                    $cont_acciones4= 0;
                    $cont_acciones = 0;
                    $sqlacciones= mysqli_query($mysqli,"SELECT codigo FROM acciones WHERE cod_tarea = $cod_tarea AND cod_estado = 4");
                    while($acciones4=mysqli_fetch_array($sqlacciones)){
                        $cont_acciones4++;
                    }
                    $sqlacciones= mysqli_query($mysqli,"SELECT codigo FROM acciones WHERE cod_tarea = $cod_tarea");
                    while($acciones=mysqli_fetch_array($sqlacciones)){
                        $cont_acciones++;
                    }
                    if(($cont_acciones4 > 0) and ($cont_acciones4 < $cont_acciones)){
                        $sqlTask = mysqli_query($mysqli, "UPDATE tareas SET estado= 2 WHERE codigo = $cod_tarea");
                    } else if ($cont_acciones4 == 0){
                        $sqlTask = mysqli_query($mysqli, "UPDATE tareas SET estado= 1 WHERE codigo = $cod_tarea");
                    } else if ($cont_acciones4 == $cont_acciones){
                        $sqlTask = mysqli_query($mysqli, "UPDATE tareas SET estado= 4 WHERE codigo = $cod_tarea");
                    }

                    header("Location: dashboard.php");

?>
