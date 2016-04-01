<?php

// Include confi.php
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Origin: *');
include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $correoElectronico = $_POST['correoElectronico'];
    $estado = "INACTIVO"; 
    
    if (mysqli_connect_errno()) {
        $json = array("status" => 0, "msg" => "Error de conexion!");
    }
    
    $query = "UPDATE sepdba.Administrador SET estado = '$estado' WHERE correoElectronico = '$correoElectronico';";
    
    if (!$result = $mysqli->query($query))
        $json = array("status" => 0, "msg" => "Error al eliminar administrador!", "error" =>$mysqli->error);
    else
        $json = array("status" => 1, "msg" => "Administrador eliminado");
}
else{
    $json = array("status" => 0, "msg" => "Request method not accepted");
}
/* Output header */
header('Content-Type: application/json; charset=utf-8');
echo json_encode($json);

?>

