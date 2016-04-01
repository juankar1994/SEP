<?php

header("Access-Control-Allow-Origin: *");
include_once('confi.php');


$response = array();
$sql = "SELECT p.idProyecto, p.nombre as nombreProyecto, p.descripcion, p.idFeria, tp.nombre as tipo, s.nombre as nombreSede  FROM TipoProyecto tp INNER JOIN Proyectos p ON p.idTipo = tp.idTipo INNER JOIN Sede s ON s.idSede = p.idSede;";
$result = $mysqli->query($sql);

if (mysqli_connect_errno()) {
        $response["success"] = 0;
		$response["message"] = "Error conection";
}
else{
    if ($result->num_rows > 0) {
        // Fetch all
        $array = array();
        while($row = $result->fetch_assoc()){
            $row['Integrantes'] = array();
            $row['nombre'] = stripslashes($row['nombre']);
            $row['descripcion'] = stripslashes($row['descripcion']);
            $idProyecto = $row['idProyecto'];
            $idFeria = $row['idFeria'];
            $idSede = $row['idSede'];
            $idTipo = $row['idTipo'];
            $queryIntegrantes = "SELECT nombre, apellido1, apellido2, correoElectronico FROM Integrantes WHERE idProyecto = '$idProyecto';";
            $resultIntegrantes = $mysqli->query($queryIntegrantes);
            if($resultIntegrantes->num_rows > 0){
                while($integrante = $resultIntegrantes->fetch_assoc()){
                    $row['Integrantes'][] = $integrante;
                }    
            }
            $array[] = $row;
        }
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
		