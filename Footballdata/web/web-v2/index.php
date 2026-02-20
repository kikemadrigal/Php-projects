<?php
//Arrnca el servidor con "php -S localhost:80 router-htaccess.php"
ini_set('display_errors', '1');
error_reporting(E_ALL);
session_start();
include_once(__DIR__ . "/autoload.php");
$request_uri = $_SERVER['REQUEST_URI'];

$pagina_hasta_el_punto=strrpos($request_uri,".");
$pagina=substr($request_uri,0,$pagina_hasta_el_punto);


if ($pagina=="" || $pagina=="/index") {
    require_once(__DIR__ ."/app/views/index.php");
}elseif ($pagina=="/jugadores") {
    require_once(__DIR__ ."/app/views/jugadores.php");
}elseif ($pagina=="/clubes") {
    require_once(__DIR__ ."/app/views/clubes.php");
}elseif ($pagina=="/competiciones") {
    require_once(__DIR__ ."/app/views/competiciones.php");
}elseif ($pagina=="/juegos") {
    require_once(__DIR__ ."/app/views/juegos.php");
}elseif ($pagina=="/cruzadas") {
    require_once(__DIR__ ."/app/views/cruzadas.php");
}elseif ($pagina=="/esquema") {
    require_once(__DIR__ ."/app/views/esquema.php");
}else{
    echo "\nMethod not allowed";
    exit;
}





