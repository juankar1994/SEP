<?php

// Include confi.php
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Origin: *');
include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
    
	$nombre = stripslashes($_POST['nombre']);
	$descripcion = stripslashes($_POST['descripcion']);
	$profesor = $_POST['profesor'];
	$integrantes = $_POST['integrantes'];
	$tipo = $_POST['tipo'];
	$feria = $_POST['feria'];
	$sede = $_POST['sede'];
	$stand = $_POST['stand'];
    
    if (mysqli_connect_errno()) {
        $json = array("status" => 0, "msg" => "Error de conexion!");
    }
    
    
    $query = "INSERT INTO sepdba.Proyectos(nombre,descripcion,idFeria,idSede,idTipo,idProfesor,stand) VALUES
    ('$nombre','$descripcion','$feria','$sede','$tipo','$profesor','$stand');";
    
    
    if (!$result = $mysqli->query($query)){
        $json = array("status" => 0, "msg" => "Error registrando proyecto!", "error" =>$mysqli->error);
    }
        
    else{
        $query = "INSERT INTO sepdba.Integrantes(idProyecto,nombre,correoElectronico,apellido1,apellido2) VALUES (?,?,?,?,?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("issss", $idProyecto, $nombre,$correo,$apellido1,$apellido2);
        $idProyecto = $mysqli->insert_id;
        foreach ($integrantes as $integrante) {
            $nombre = $integrante['nombre'];
            $apellido1 = $integrante['apellido1'];
            $apellido2 = $integrante['apellido2'];
            $correo = $integrante['correo'];
            $stmt->execute();
        }
        $stmt->close();

        
        $json = array("status" => 1, "msg" => "Proyecto Registrado!");
    }
        

}
else{

    $json = array("status" => 0, "msg" => "Request method not accepted");

}

/* Output header */

header('Content-Type: application/json; charset=utf-8');

echo json_encode($json);

?>


		