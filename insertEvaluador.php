<?php

// Include confi.php
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Origin: *');
include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){

    // Get _POST
    // Insert _POST into _POST base
        
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $sql = "INSERT INTO sepdba.evaluador(nombre,telefono,correoElectronico,PIN,apellido1,apellido2,idFeria) VALUES
    ('$request->nombre','$request->telefono','$request->correoElectronico','1234','$request->apellido1','$request->apellido2','1');";
    

    $qur = db->prepare($sql);

    $qur->execute();

    if($qur){

        $json = array("status" => 1, "msg" => "Evaluador Registrado!");

    }else{

        $json = array("status" => 0, "msg" => "Error registrando evaluador!");

    }

}
else{

    $json = array("status" => 0, "msg" => "Request method not accepted");

}




/* Output header */

header('Content-Type: application/json; charset=utf-8');

echo json_encode($json);

?>


		