<?php

// Include confi.php
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Origin: *');
include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $evaluadores = $_POST['evaluadores'];
    $feria = $_POST['feria'];
    

    if (mysqli_connect_errno()) {
        $json = array("status" => 0, "msg" => "Error de conexion!");
    }
    
    
    $query = "INSERT INTO sepdba.Evaluador(nombre,telefono,correoElectronico,PIN,apellido1,apellido2,idFeria) VALUES (?,?,?,1234,?,?,?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sssssi", $nombre,$telefono,$correo,$apellido1,$apellido2,$feria);

    foreach ($evaluadores as $evaluador) {
        $nombre = $evaluador['Nombre'];
        $apellido1 = $evaluador['Apellido1'];
        $apellido2 = $evaluador['Apellido2'];
        $correo = $evaluador['Correo'];
        $telefono = $evaluador['Telefono'];
        $stmt->execute();
    }
    $stmt->close();
    
    
    
    $json = array("status" => 1, "msg" => "Evaluadores Registrados!", "evaluadores" => $evaluadores);

}
else{

    $json = array("status" => 0, "msg" => "Request method not accepted");

}

/* Output header */

header('Content-Type: application/json; charset=utf-8');

echo json_encode($json);

?>


		


						