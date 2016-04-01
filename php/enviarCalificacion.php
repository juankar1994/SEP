<?php

// Include confi.php
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Origin: *');
include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $idEvaluacion = $_POST['idEvaluacion'];
    $rubels = $_POST['rubels'];
    $comentario = $_POST['comentario'];
 
    if (mysqli_connect_errno()) {
        $json = array("status" => 0, "msg" => "Error de conexion!");
    }
    
    
    $query = "update sepdba.Evaluacion set comentario='$comentario',estado = 1 where idEvaluacion='$idEvaluacion'";
    $result = $mysqli->query($query);

    $query = "INSERT INTO sepdba.EvaluacionRubrica(valor, idEvaluacion, idRubricaEvaluacion) VALUES (?,?,?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("iii", $valor,$idEvaluacion,$idRubricaEvaluacion);

    foreach ($rubels as $rubel) {
        $valor = $rubel['valor'];
        $idRubricaEvaluacion = $rubel['idRubrica'];
        $stmt->execute();
    }
    $stmt->close();

    $response = array();
    $sql = "SELECT c.nombre, SUM(valor*(porcentaje/100)) as nota FROM sepdba.EvaluacionRubrica a INNER JOIN RubricaEvaluacion b on a.idRubricaEvaluacion=b.idRubricaEvaluacion INNER JOIN TipoRubrica c on b.idTipoRubrica=c.idTipoRubrica where idEvaluacion='$idEvaluacion' group by c.idTipoRubrica;";
    $result = $mysqli->query($sql);
    
    
     if ($result->num_rows > 0) {
        // Fetch all
        $array = array();
        while($row = $result->fetch_assoc())
            $array[] = $row;
        
        $response["success"] = 1;
        $response["data"]= $array;
    }else{
        $response["success"] = 0;
        $response["message"] = "Error al insertar evaluación";
    }

}
else{

    $json = array("status" => 0, "msg" => "Request method not accepted");

}

/* Output header */

header('Content-Type: application/json; charset=utf-8');

echo json_encode($response);

?>

		