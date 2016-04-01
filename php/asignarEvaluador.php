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
        $idEvaluador = $_POST['idEvaluador'];

        if (!$mysqli->query("CALL asignarEvaluadores('$idEvaluador');")) {
            echo "CALL failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }else{
            if(!$mysqli->query("UPDATE Evaluador SET estado = 'ACTIVO' WHERE idEvaluador = '$idEvaluador';")){
                echo "UPDATE failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            else{
                $json = array("status" => 1, "msg" => "Evaluador Asignado!");
            }
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


				