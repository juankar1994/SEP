<?php

// Include confi.php

header('Access-Control-Allow-Origin: *');
include_once('confi.php');


if($_SERVER['REQUEST_METHOD'] == "GET"){
    $response = array();
	$proyecto = $_GET['idProyecto'];
    
    $sql = "SELECT e.idEvaluador, nombre, apellido1, apellido2 FROM Evaluacion v inner join Evaluador e on e.idEvaluador = v.idEvaluador WHERE idProyecto = '$proyecto' AND v.estado = 0;";

    if (mysqli_connect_errno()) {
            $response["success"] = 0;
            $response["message"] = "Error conection";
    }
    else{
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
                $response["message"] = "Error";
        }
        mysqli_close($mysqli);
    }
}

echo json_encode($response);

?>

			