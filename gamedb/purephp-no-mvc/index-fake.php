<?php
//VERSION DEVELOPMENT
/**
 * Para la producción: 
 * 1.Cambia el archivo index.php por la versión producción o desarrollo
 * 2.Cambia la variable de entorno PRODUCTION que está en .env
 * 
 */
/*para trabajr con rutas:
1.Modicamos el archivo de host de windows(abrelo como admimistrador) que están en C:\Windows\System32\drivers\etc\hosts:
#---------------------
#   virtual hosts
#--------------------
127.0.0.1	gestordb.es

2.Modificamos los host virtuales de apache que están en C:\xampp\apache\conf\extra\httpd-vhosts.conf
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/gamedb"
    ServerName gamedb.es
</VirtualHost>
*/
//El index hace de enrutador
session_start();


require_once("./app/App.php");
require_once("./app/controllers/BaseController.php");
require_once("./app/controllers/BaseController.php");
require_once("./app/models/Model.php");
require_once("./views/View.php");


$app=new App();









?>


		

