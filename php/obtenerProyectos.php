<?php

// Include confi.php

header('Access-Control-Allow-Origin: *');
include_once('confi.php');


if($_SERVER['REQUEST_METHOD'] == "GET"){
    
	$feria = $_GET['idFeria'];
    $response = array();

    if (mysqli_connect_errno()) {
            $response["success"] = 0;
            $response["message"] = "Error conection";
    }
    else{
        $sql = "SELECT p.idProyecto, p.nombre FROM Proyectos p INNER JOIN (SELECT * FROM Evaluacion e WHERE e.estado = 0) as ev on ev.idProyecto = p.idProyecto WHERE p.idFeria = '$feria' GROUP BY p.idProyecto;";
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
            $response["message"] = "Error";;
        }
        mysqli_close($mysqli);
    }
}

echo json_encode($response);

?>