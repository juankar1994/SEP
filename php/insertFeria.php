<?php

// Include confi.php
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Origin: *');
include_once('confi.php');




if($_SERVER['REQUEST_METHOD'] == "POST"){
    
	$nombre = $_POST['nombre'];
	$anno = $_POST['anno'];
	$periodo = $_POST['periodo'];
	
    if (mysqli_connect_errno()) {
        $json = array("status" => 0, "msg" => "Error de conexion!");
    }
    
    
    $query = "INSERT INTO sepdba.Feria(nombre,año,periodo) VALUES
    ('$nombre','$anno','$periodo);";
    
    if (!$result = $mysqli->query($query))
        $json = array("status" => 0, "msg" => "Error registrando feria!", "error" =>$mysqli->error);
    else
        $json = array("status" => 1, "msg" => "Feria Registrado!");

}
else{

    $json = array("status" => 0, "msg" => "Request method not accepted");

}

/* Output header */

header('Content-Type: application/json; charset=utf-8');

echo json_encode($json);

?>


		