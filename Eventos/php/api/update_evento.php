<?php
    header('Content-Type: application/json');
    header("access-control-allow-origin: *");
    require_once("../env.php");
    include_once("../MysqliClient.php");

    // Obtén el cuerpo de la solicitud
    $json = file_get_contents("php://input");
    
    // Decodifica el JSON en un array asociativo
    $data = json_decode($json, true);
    /*
    if ($data) {
        $id_evento = $data['id_evento'];
        $cantidad_participantes = $data['cantidad_participantes'];
        $precio = $data['precio_total'];
    }    
    echo json_encode([
        "success" => true,
        "message" => "Datos recibidos correctamente",
        "datos" => $data
    ]);
    */

 
    // Asegúrate de que los datos estén presentes
    if ($data) {
        $id_evento = $data['id_evento'];
        $cantidad_participantes = $data['cantidad_participantes'];
        $precio = $data['precio_total'];
  
        $bd= new MysqliClient();
        $bd->conectar_mysql();     
        $sql="update eventos set cantidad_participantes='".$cantidad_participantes."', precio='".$precio."' WHERE id='".$id_evento."'";
        $resultado=$bd->ejecutar_sql($sql);        
        $bd->desconectar();
        echo json_encode([
            "success" => true,
            "message" => "Datos recibidos correctamente",
            "datos" => $data
        ]);
    
    } else {
        // Si no se reciben datos
        echo json_encode([
            "success" => false,
            "message" => "No se enviaron datos válidos"
        ]);
    }



?>