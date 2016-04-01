<?php

// Include confi.php
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Origin: *');
include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    
    if (mysqli_connect_errno()) {
        $json = array("status" => 0, "msg" => "Error de conexion!");
    }
    else{
        $proyectos = $_POST['proyectos'];
        $feria = $_POST['feria'];
        $tipo = $_POST['tipo'];

        
        $insertProfesor = "INSERT INTO sepdba.Profesor(nombre,correoElectronico,apellido1,apellido2) VALUES (?,?,?,?);";
        $insertSede = "INSERT INTO sepdba.Sede(nombre) VALUES (?);";
        $insertIntegrante = "INSERT INTO sepdba.Integrantes(idProyecto,nombre,correoElectronico,apellido1,apellido2) VALUES (?,?,?,?,?);";
        $insertProyecto = "INSERT INTO sepdba.Proyectos(nombre,descripcion,idFeria,idSede,idTipo,idProfesor,stand) VALUES (?,?,?,?,?,?,?);";

        foreach($proyectos as $proyecto){
            $stmtISede = $mysqli->prepare($insertSede);
            $stmtIProfesor = $mysqli->prepare($insertProfesor);
            $stmtIIntegrante = $mysqli->prepare($insertIntegrante);
            $stmtIProyecto = $mysqli->prepare($insertProyecto);

            $stmtISede->bind_param("s", $sede);
            $stmtIProfesor->bind_param("ssss", $nombreP, $correoP, $apellido1P, $apellido2P);
            $stmtIIntegrante->bind_param("issss", $idProyecto, $nombreI, $correoI, $apellido1I, $apellido2I);
            $stmtIProyecto->bind_param("ssiiiis", $nombreProy, $descripcion, $feria, $idSede, $tipo, $idProfesor,$stand);
            
            $nombreProy = stripslashes($proyecto['Proyecto']);
            $descripcion = stripslashes($proyecto['Descripcion']);
            $integrantes = $proyecto['Integrantes'];
            $stand = $proyecto['Stand'];
            $sede = $proyecto['Sede'];
            $nombreP = $proyecto['Profesor_Nombre'];
            $correoP = $proyecto['Profesor_Correo'];
            $apellido1P = $proyecto['Profesor_Apellido1'];
            $apellido2P = $proyecto['Profesor_Apellido2'];
            $querySede = "SELECT idSede FROM sepdba.Sede s WHERE s.nombre = '$sede';";
            $queryProfesor = "SELECT idProfesor FROM sepdba.Profesor p WHERE p.correoElectronico = '$correoP';";

            if (!$resultQSede = $mysqli->query($querySede))
            {
                echo 'First stmt failed: ' . $mysqli->error;
                exit();
            }
            if($resultQSede->num_rows > 0){
                $row = $resultQSede->fetch_assoc();
                echo 'ID SEDE: ' . $row['idSede'];
                exit();
                $idSede = $row['idSede'];
            }else{
                $stmtISede->execute();
                $idSede = $mysqli->insert_id;
                $stmtISede->close();
            }
            
            if (!$resultQProfesor = $mysqli->query($queryProfesor))
            {
                echo 'Second stmt failed: ' . $mysqli->error;
                exit();
            }
            
            if($resultQProfesor->num_rows > 0){
                $row = $resultQProfesor->fetch_assoc();
                $idProfesor = $row['idProfesor'];
            }else{
                $stmtIProfesor->execute();
                $idProfesor = $mysqli->insert_id;
                $stmtIProfesor->close();
            }
            
            if(!$resultIProyecto = $stmtIProyecto->execute()){
                echo 'Error fatal: ' . $mysqli->error;
                exit();
            }
            $idProyecto = $mysqli->insert_id;
            $stmtIProyecto->close();
            
            foreach ($integrantes as $integrante) {
                $nombreI = $integrante['Nombre'];
                $apellido1I = $integrante['Apellido1'];
                $apellido2I = $integrante['Apellido2'];
                $correoI = $integrante['Correo'];
                $stmtIIntegrante->execute();
            }
            $stmtIIntegrante->close();
            
        }
        
        if (!$mysqli->commit()) {
           $json = array("status" => 0, "msg" => "Proyectos NO Registrados!", "error" => $mysqli->error);
        }
        else{
           $json = array("status" => 1, "msg" => "Proyectos Registrados!", "proyectos" => $proyectos);
        }
    }
}
else{

    $json = array("status" => 0, "msg" => "Request method not accepted");
    
}

/* Output header */

header('Content-Type: application/json; charset=utf-8');

echo json_encode($json);

?>


				