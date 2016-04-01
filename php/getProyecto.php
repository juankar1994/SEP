<?php

header("Access-Control-Allow-Origin: *");
include_once('confi.php');

if (mysqli_connect_errno()) {
        $response["success"] = 0;
		$response["message"] = "Error conection";
}else{
    if (isset($_GET["idProyecto"])){
        $idProyecto = $_GET["idProyecto"];
        $response = array();
        $sql = "SELECT p.idProyecto, p.nombre as nombreProyecto, p.descripcion, p.idFeria, p.stand, tp.nombre as tipo, s.nombre as nombreSede  FROM TipoProyecto tp INNER JOIN Proyectos p ON p.idTipo = tp.idTipo INNER JOIN Sede s ON s.idSede = p.idSede WHERE p.idProyecto = '$idProyecto';";
        $result = $mysqli->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $row['Integrantes'] = array();
            $row['nombre'] = stripslashes($row['nombre']);
            $row['descripcion'] = stripslashes($row['descripcion']);
            $idProyecto = $row['idProyecto'];
            $queryIntegrantes = "SELECT nombre, apellido1, apellido2, correoElectronico FROM Integrantes WHERE idProyecto = '$idProyecto';";
            $resultIntegrantes = $mysqli->query($queryIntegrantes);
            if($resultIntegrantes->num_rows > 0){
                while($integrante = $resultIntegrantes->fetch_assoc()){
                    $row['Integrantes'][] = $integrante;
                }    
            }
            $response["success"] = 1;
            $response["data"]= $row;
        }
        else{
                $response["success"] = 0;
                $response["message"] = "No se puede mostrar el proyecto";
        }
    }
    else{
        $response["success"] = 0;
        $response["message"] = "No se puede mostrar el proyecto";
        
    }
    mysqli_close($mysqli);
}
echo json_encode($response);
?>