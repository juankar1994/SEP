<?php

// Include confi.php

header('Access-Control-Allow-Origin: *');
include_once('confi.php');
$response = array();

if($_SERVER['REQUEST_METHOD'] == "GET"){
    
    $proyecto = $_GET['idProyecto'];
    $evaluador = $_GET['idEvaluador'];
    
    if (mysqli_connect_errno()) {

    }
    
    
    $sql = "Select idRubricaEvaluacion, nombre, ifnull(idEvaluacion, 0) as idEval from (SELECT p.idProyecto, idEvaluacion, idTipo, idEvaluador FROM Proyectos p inner join Evaluacion e on p.idProyecto = e.idProyecto WHERE p.idProyecto='$proyecto' and idEvaluador='$evaluador' limit 1) a right join (Select idRubricaEvaluacion, nombre, idTipoRubrica From RubricaEvaluacion) b on idTipoRubrica = idTipo where idTipoRubrica = idTipo or idTipoRubrica = 2 order by idEval desc;";
   

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
        $response["message"] = "Error";;
    }
    mysqli_close($mysqli);
}
}

echo json_encode($response);

?>