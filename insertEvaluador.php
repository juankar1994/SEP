<?php

// Include confi.php
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Origin: *');
include_once('confi.php');




if($_SERVER['REQUEST_METHOD'] == "POST"){
    
	$nombre = $_POST['nombre'];
	$telefono = $_POST['telefono'];
	$correoElectronico = $_POST['correoElectronico'];
	$apellido1 = $_POST['apellido1'];
	$apellido2 = $_POST['apellido2'];
    
    if (mysqli_connect_errno()) {
        $json = array("status" => 0, "msg" => "Error de conexion!");
    }
    
    
    $query = "INSERT INTO sepdba.Evaluador(nombre,telefono,correoElectronico,PIN,apellido1,apellido2,idFeria) VALUES
    ('$nombre','$telefono','$correoElectronico','1234','$apellido1','$apellido2','1');";
    
    
    if (!$result = $mysqli->query($query))
        $json = array("status" => 0, "msg" => "Error registrando evaluador!", "error" =>$mysqli->error);
    else
        $json = array("status" => 1, "msg" => "Evaluador Registrado!");

}
else{

    $json = array("status" => 0, "msg" => "Request method not accepted");

}

/* Output header */

header('Content-Type: application/json; charset=utf-8');

echo json_encode($json);

?>


		