<?php

// Include confi.php
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Origin: *');
include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $correoElectronico = $_POST['correoElectronico'];
    $contrasenia = $_POST['contrasenia'];
    $estado = "ACTIVO"; 
    
    if (mysqli_connect_errno()) {
        $json = array("status" => 0, "msg" => "Error de conexion!");
    }
    
    $query = "INSERT INTO sepdba.Administrador(nombre,apellido1,apellido2,correoElectronico,contrasenia,estado) VALUES
    ('$nombre','$apellido1','$apellido2','$correoElectronico','$contrasenia','$estado');";
    
    if (!$result = $mysqli->query($query))
        $json = array("status" => 0, "msg" => "Error registrando administrador!", "error" =>$mysqli->error);
    else
        $json = array("status" => 1, "msg" => "Administrador Registrado!");
}
else{
    $json = array("status" => 0, "msg" => "Request method not accepted");
}
/* Output header */
header('Content-Type: application/json; charset=utf-8');
echo json_encode($json);

?>