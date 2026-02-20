<?php
    header('Content-Type: application/json');
    header("access-control-allow-origin: *");
    require_once("../env.php");
    include_once("../MysqliClient.php");

    // Obtén el cuerpo de la solicitud
    $json = file_get_contents("php://input");
    
    // Decodifica el JSON en un array asociativo
    $data = json_decode($json, true);
    
    // Asegúrate de que los datos estén presentes
    if ($data) {
        $id_evento = $data['id_evento'];
        $nombre_participante = $data['nombre_participante'];
        $comentario = $data['comentario'];

        $bd= new MysqliClient();
        $bd->conectar_mysql();
        $sql="update participantes set comentario='".$comentario."' WHERE nombre='".$nombre_participante."' AND id_evento='".$id_evento."'";
        $resultado=$bd->ejecutar_sql($sql);
        $bd->desconectar();
    
        // Responde con un JSON de confirmación
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
    
    



    
    //echo json_encode(array("status" => "ok", "nombre"=>$_POST['nombre'], "campo"=>$_POST['campo'], "valor"=>$valor, "id_evento"=>$id_evento));
    //echo json_encode(array("nombre"=>$_POST['nombre'], "campo"=>$_POST['campo'], "valor"=>$_POST['valor'], "id_evento"=>$_POST['id_evento']));
    //echo json_encode(array("mensaje"=>$mensaje));
    //echo json_encode(array("mensaje"=>"hola"));
?>