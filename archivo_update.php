<?php
    require("connect_db.php");
    /*
    id_boton 1 = Reiniciar Tarea
    id_boton 2 = Eliminar Tarea
    */
    $id_boton= $_GET["id_boton"];
    $id= $_GET["id"];
    $esProp = $_GET["us"];

    if($id_boton==1){
        $sqlUpdateDatos="UPDATE tareas SET estado = 1 WHERE codigo = $id";
        $resUpdateDatos=mysqli_query($mysqli,$sqlUpdateDatos);
        if (!$resUpdateDatos) {
            printf("Errormessage1: %s\n", $mysqli->error);
            } else {
                $sqlestados="UPDATE acciones SET cod_estado = 1 where cod_tarea = $id";
                $res_sqlestados=mysqli_query($mysqli,$sqlestados);
                if(!$res_sqlestados){
                    printf("Errormessage1: %s\n", $mysqli->error);
                }
                echo '<script>alert("Se ha reinicado el estado de la tarea")</script> ';
                header('Location: archivo.php');
            }
    } else if($id_boton==2){
        if($esProp==true){
            $sqlborrarDatos="DELETE FROM acciones WHERE cod_tarea = $id";
            $resborrarDatos=mysqli_query($mysqli,$sqlborrarDatos);
            if (!$resborrarDatos) {
    	          printf("Errormessage1: %s\n", $mysqli->error);
            }else {
    	        $sqlborrarUsuario="DELETE FROM tareas WHERE codigo = $id";
    	        $resborrarUsuario=mysqli_query($mysqli,$sqlborrarUsuario);
    	          if (!$resborrarUsuario) {
    		         printf("Errormessage2: %s\n", $mysqli->error);
    	          } else {
    		         echo '<script>alert("Tarea y acciones relacionadas ELIMINADAS")</script> ';

    	          }
           }
        } else {
            echo '<script>confirm("Solo el propietario de la tarea puede eliminar la tarea");</script> ';
        }
    }
    header('Location: archivo.php');
?>