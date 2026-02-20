<?php

$ipServer=obtenerIpLocal();

/*************
	Rutas
**************/
/**
 * Servidor
 */
$rutaServer="http://".$ipServer."/ssh";

/**
 * Páginas estáticas
 */
define('RUTA_IMAGENES', $rutaServer."/images");


/**
 * Clientes
 */
define('RUTA_CLIENTES_MOSTRAR', $rutaServer."/views/clientes/show.php");
define('RUTA_CLIENTE_NUEVO', $rutaServer."/views/clientes/form_insert.php");
define('RUTA_CLIENTE_ACTUALIZAR', $rutaServer."/views/clientes/update.php");
define('RUTA_CLIENTE_ElIMINAR', $rutaServer."/views/clientes/delete.php");

/**
 * Comandos
 */
define('RUTA_COMANDOS_MOSTRAR', $rutaServer."/views/comandos/show.php");
define('RUTA_COMANDO_NUEVO', $rutaServer."/views/comandos/form_insert.php");
define('RUTA_COMANDO_ACTUALIZAR', $rutaServer."/views/comandos/update.php");
define('RUTA_COMANDO_ElIMINAR', $rutaServer."/views/comandos/delete.php");




 /**
  * Clientes-Comandos
  */
  define('RUTA_CLIENTECOMANDOS_MOSTRAR_COMANDOS_DE_UN_CLIENTE', $rutaServer."/views/clientesComandos/showOneClient.php");

/*************
	database
**************/        
/*
const SERVER="";
const USER="";
const PASSWORD="";
const DATABASE="";*/
/*
define('SERVER', "");
define('USER', "");
define('PASSWORD', "");
define('DATABASE',"");
*/


