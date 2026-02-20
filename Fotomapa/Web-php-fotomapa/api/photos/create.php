<?php

//echo json_encode($_GET['nombre']);
//echo json_encode($_POST['nombre']);
//$id, $name, $text, $type, $address, $city, $country, $lat, $lng, $user,$validada, $timestamp
//echo "post ".count($_POST).", get: ".count($_GET);
$image= $_POST['imagen'];
$name= $_POST['name'];
$text=$_POST['text'];
$ruta_imagen="resources/imagesusers/21/$name.jpg";

$fueguardada=file_put_contents($ruta_imagen, base64_decode($image));
$foto = new Foto( '', $name, $text, "", "", "", "", "", "", 21,0, "");


Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();
$fotoInsertada = RepositorioFotos::stored( $conexion, $foto );		
Conexion::cerrar_conexion();
if($fotoInsertada){
    echo json_encode("capullo--->"+$fueguardada);
}else{
    echo json_encode("no guradaa");
}
			
//echo json_encode(array("response"=>"respuesta"));


?>