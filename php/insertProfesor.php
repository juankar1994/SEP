<?php

// Include confi.php
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Origin: *');
include_once('confi.php');




if($_SERVER['REQUEST_METHOD'] == "POST"){
    
	$nombre = $_POST['nombre'];
	$apellido1 = $_POST['apellido1'];
	$apellido2 = $_POST['apellido2'];
    $correo = $_POST['correo'];
    
    if (mysqli_connect_errno()) {
        $json = array("status" => 0, "msg" => "Error de conexion!");
    }
    
    
    $query = "INSERT INTO sepdba.Profesor(nombre,correoElectronico,apellido1,apellido2) VALUES
    ('$nombre','$correo','$apellido1','$apellido2');";
    
    
    
    if (!$result = $mysqli->query($query))
        $json = array("status" => 0, "msg" => "Error registrando profesor!", "error" =>$mysqli->error);
    else
        $json = array("status" => 1, "msg" => "Profesor Registrado!");

}
else{

    $json = array("status" => 0, "msg" => "Request method not accepted");

}

/* Output header */

header('Content-Type: application/json; charset=utf-8');

echo json_encode($json);

?>


		