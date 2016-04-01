<?php

// Include confi.php

header('Access-Control-Allow-Origin: *');
include_once('confi.php');
$response = array();

if($_SERVER['REQUEST_METHOD'] == "GET"){
    
	$feria = $_GET['idFeria'];
    
    if (mysqli_connect_errno()) {
        $response["success"] = 0;
        $response["message"] = "Error conection";
    }else{
        $sql = "SELECT * FROM Evaluador WHERE idFeria='$feria';";
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
            $response["message"] = "No hay evaluadores registrados";
        }
        mysqli_close($mysqli);
    }
}


header('Content-Type: application/json; charset=utf-8');

echo json_encode($response);



?>