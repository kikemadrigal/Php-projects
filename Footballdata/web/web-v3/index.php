<?php
//Arranca el servidor con: php -S localhost:80 -t .
ini_set('display_errors', '1');
error_reporting(E_ALL);
session_start();
//require_once("borrar_autoload.php");
require_once("vendor/autoload.php");
$method = $_SERVER['REQUEST_METHOD'];
define("STABILITY", "dev");
//define("STABILITY", "prod");

/*
*
*   Nuestro enrutador
*
*/
if(STABILITY == "dev"){
    define("BASE", "/cuarta");
}else{
    //define("BASE", "");
    define("BASE", "");
}
$request_uri =$_SERVER['REQUEST_URI'];
//echo "------>".$request_uri;

if ($request_uri==BASE."/" || $request_uri==BASE."/index" || $request_uri==BASE."/index.php") {
    require_once(__DIR__ ."/app/views/index.php");
}elseif ($request_uri==BASE."/jugadores" || $request_uri==BASE."/jugadores.php") {
    require_once(__DIR__ ."/app/views/jugadores.php");
}elseif ($request_uri==BASE."/clubes" || $request_uri==BASE."/clubes.php") {
    require_once(__DIR__ ."/app/views/clubes.php");
}elseif ($request_uri==BASE."/competiciones" || $request_uri==BASE."/competiciones.php") {
    require_once(__DIR__ ."/app/views/competiciones.php");
}elseif ($request_uri==BASE."/juegos" || $request_uri==BASE."/juegos.php") {
    require_once(__DIR__ ."/app/views/juegos.php");
}elseif ($request_uri==BASE."/cruzadas" || $request_uri==BASE."/cruzadas.php") {
    require_once(__DIR__ ."/app/views/cruzadas.php");
}elseif ($request_uri==BASE."/esquema" || $request_uri==BASE."/esquema.php") {
    require_once(__DIR__ ."/app/views/esquema.php");
}else{
    echo "Method not allowed";
    exit;
}



