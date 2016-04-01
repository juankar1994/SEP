<?php

header("Access-Control-Allow-Origin: *");
include_once('confi.php');

$response = array();
if (mysqli_connect_errno()) {
        $response["success"] = 0;
        $response["message"] = "Error conection";
}
else{
    if (isset($_GET["correo"], $_GET["pass"])) 
    {
        $correo = $_GET['correo'];
        $pass = $_GET['pass'];
        $response = array();
        $sql = sprintf("SELECT nombre, apellido1, apellido2 FROM Administrador WHERE correoElectronico = '%s' AND contrasenia = '%s' AND estado ='ACTIVO'", $correo, $pass);
        $result = $mysqli->query($sql);
        if ($result->num_rows == 1) {
            // Fetch all
            $row = $result->fetch_assoc();
            $response['nombre']=$row['nombre'];
            $response['apellido1']=$row['apellido1'];
            $response['apellido2']=$row['apellido2'];

            $response["success"] = 1;
        }else{
            $response["success"] = 0;
            $response["message"]= "Usuario o password incorrecto";
        }
    } 
    else{
        $response["success"] = 0;
        $response["message"] = "No hay parametros";
    }
    mysqli_close($mysqli);
}

echo json_encode($response);
?>


