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
    $idAdministrador = $_POST['idAdministrador'];
     
    
    if (mysqli_connect_errno()) {
        $json = array("status" => 0, "msg" => "Error de conexion!");
    }
    

    $query = "UPDATE Administrador SET nombre = '$nombre', contrasenia = '$contrasenia',correoElectronico = '$correoElectronico',apellido1 = '$apellido1',apellido2 ='$apellido2' WHERE idAdministrador = '$idAdministrador' ;";

    
    if (!$result = $mysqli->query($query))
        $json = array("status" => 0, "msg" => "Error al actualizar datos de administrador!", "error" =>$mysqli->error);
    else
        $json = array("status" => 1, "msg" => "Actualización exitosa!");
}
else{
    $json = array("status" => 0, "msg" => "Request method not accepted");
}
/* Output header */
header('Content-Type: application/json; charset=utf-8');
echo json_encode($json);

?>