<?php

header("Access-Control-Allow-Origin: *");
include_once('confi.php');


$response = array();
$sql = "SELECT * FROM Feria";
$result = $mysqli->query($sql);

if (mysqli_connect_errno()) {
        $response["success"] = 0;
		$response["message"] = "Error conection";
}
else{
    if ($result->num_rows > 0) {
        // Fetch all
        $array = array();
        while($row = $result->fetch_assoc())
            $array[] = $row;
        
        
        $response["success"] = 1;
        $response["data"]= $array;
    }else{
            $response["success"] = 0;
            $response["message"] = "No products found";
    }
    mysqli_close($mysqli);
}

echo json_encode($response);
?>
		