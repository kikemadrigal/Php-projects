<?php
header('Content-Type: application/json');
header("access-control-allow-origin: *");
require_once("../env.php");
include_once("../MysqliClient.php");
// Obtén el cuerpo de la solicitud
//$json = file_get_contents("php://input");

// Decodifica el JSON en un array asociativo
//$data = json_decode($json, true);
/*echo json_encode([
    "success" => true,
    "message" => "Datos recibidos correctamente",
    "datos" => $_GET['id_evento']
]);*/

if ($_GET['id_evento']) {
    $participantes=[];
    $id_evento = $_GET['id_evento'];
    $bd= new MysqliClient();
    $bd->conectar_mysql();     
    $sql="select * from participantes where id_evento='".$id_evento."'";
    $resultado=$bd->ejecutar_sql($sql);  
    foreach ($resultado as $key => $value) {
        $participantes[]=$value;
    }
    $bd->desconectar();
    if(empty($resultado) || !$resultado){
        echo json_encode([
            "success" => false,
            "message" => "No hay datos para mostrar"
        ]);
    }
    //echo json_encode($resultado);


    //$cantidad=count($resultado);      

    echo json_encode([
        "success" => true,
        "message" => "Datos recibidos correctamente",
        "datos" => $participantes
    ]);


} else {
    // Si no se reciben datos
    echo json_encode([
        "success" => false,
        "message" => "No se enviaron datos válidos"
    ]);
}


?>

