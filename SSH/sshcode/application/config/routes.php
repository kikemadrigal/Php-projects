<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'clientes/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
//$route['about']='about';

//las rutas nos van a permitir enmascarar los controladores y así hacerlos más amigables
//Rutas para clientes
/*
$route['clientes']['get'] = 'clientes/index';
//El :num nos permite que vaya unos número despues de la barra
$route['clientes/(:num)']['get'] = 'clientes/find/$1';
$route['clientes/form']['get'] = 'clientes/form_insert';
$route['clientes']['post'] = 'clientes/insert';
$route['clientes/(:num)']['put'] = 'clientes/update/$1';
//El :any nos va a permitir pner número y letras
$route['clientes/(:num)']['delete'] = 'clientes/delete/$1';
*/

