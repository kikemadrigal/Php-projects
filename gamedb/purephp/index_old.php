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


include_once("./app/config/env.php");

require_once('./app/util/Util.php');
require_once('./app/util/StringManager.php');
require_once('./app/util/FilesManager.php');
include_once("./app/util/RegisterValidator.php");

include_once("./app/models/Game.php");
include_once("./app/models/FileGame.php");
include_once("./app/models/ScreenShotGame.php");
include_once("./app/models/VideoGame.php");
include_once("./app/models/WebGame.php");
include_once("./app/models/User.php");
include_once("./app/models/Multimedia.php");

include_once("./app/data/FileGameRepository.php");
include_once("./app/data/ScreenShotGameRepository.php");
include_once("./app/data/VideoGameRepository.php");
include_once("./app/data/WebGameRepository.php");
require_once("./app/data/UserRepository.php");
include_once("./app/data/ViewsUsersRepository.php");
require_once('./app/data/GameRepository.php');
require_once('./app/data/GameUserRepository.php');
include_once("./app/data/MultimediaRepository.php");

include_once("./app/database/MysqliClient.php");
include_once("./app/database/SQLiteClient.php");
include_once("./app/database/PdoSQLiteClient.php");
include_once("./app/database/PdoMySQLClient.php");







//I btenemos la URL
$componentesUrl=parse_url($_SERVER["REQUEST_URI"]);
//sacamos solo la ruta del final, toda la dirección menos la parte del servivor
$ruta=$componentesUrl["path"];
//Obtenemos los partes de la ruta
$partesRuta=explode("/", $ruta);
//echo var_dump($partesRuta);
//echo "<br>";
//echo $_SESSION['idusuario']."<br>";

/***********************************
*               GAME 
***********************************/  
if($partesRuta[1]=="game"){
    //Permite visualizar los datos de un juego alamcenado en la tabla games
    if($partesRuta[2]=="show"){
        if (isset($partesRuta[3])) $idGame=$partesRuta[3];
        include_once("views/game/show.php");
    //Muestra los datos del juego almacenado en la tabla usersgames
    }else if($partesRuta[2]=="showUser"){
        if (isset($partesRuta[3])) $idGame=$partesRuta[3];
        include_once("views/game/showUser.php");
    //Muestra en una vistas elegidas por el usuario los juegos de la tabla usersgames
    }else if($partesRuta[2]=="showByCategoriesUsers"){
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==3){
            include_once("views/game/showByCategoriesUsers.php");
        }
    //Muestra una vista especial para seleccionar usuarios y ver todos sus juegos
    }else if($partesRuta[2]=="showUnregisteredView"){
        include_once("views/game/showUnregisteredView.php");
    }else if($partesRuta[2]=="search"){
        $search=$_POST['search'];
        include_once("views/game/search.php"); 
    }else if($partesRuta[2]=="searchUser"){
        $search=$_POST['search'];
        include_once("views/game/searchUser.php"); 
    //Acurdate que el formulario de insertar en la action debe de ponerse insert
    }else if($partesRuta[2]=="insert"){
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1){
            include_once("views/game/insert.php");
        }else if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==3){
            include_once("views/game/insertUser.php");
        }
    }else if($partesRuta[2]=="update"){
        if (isset($_POST['idGame'])) $idGame=$_POST['idGame'];
        else{
            $idGame=$partesRuta[3];
        }
        if (isset($_POST['text'])) $text=$_POST['text'];
        if (isset($_POST['idFileGame'])) $idFileGame=$_POST['idFileGame'];
        if (isset($_POST['idScreenShotGame'])) $idScreenShotGame=$_POST['idScreenShotGame'];
        if (isset($_POST['idVideoGame'])) $idVideoGame=$_POST['idVideoGame'];
        if (isset($_POST['idWebGame'])) $idWebGame=$_POST['idWebGame'];
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1){
            include_once("views/game/update.php");
        }else if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==3){
            include_once("views/game/updateUser.php");
        }
    }else if($partesRuta[2]=="delete"){
        $idGame=$partesRuta[3];
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1){
            include_once("views/game/delete.php");
        }else if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==3){
            include_once("views/game/deleteUser.php");
        }
    }else {
        include_once("views/404.php");
    }
/***********************************
*          END GAME
***********************************/
/***********************************
*               AUTH 
***********************************/   
}else if($partesRuta[1]=="login"){
    include_once("views/auth/login.php");
}else if($partesRuta[1]=="logout"){
    include_once("views/auth/logout.php");
}
else if($partesRuta[1]=="register"){ 
    include_once("views/auth/register.php");
}else if($partesRuta[1]=="mailValidation"){
    if(isset($partesRuta[2])&& isset($partesRuta[3])){
        $nombreUsuario=$partesRuta[2];
        $codigoDeActivacion=$partesRuta[3];
    }
    include_once("views/auth/mailValidation.php");
}else if($partesRuta[1]=="resetPassword"){
    include_once("views/auth/resetPassword.php");
}else if($partesRuta[1]=="recoveryPassword"){
    include_once("views/auth/recoveryPassword.php");
}
/***********************************
*               END AUTH 
***********************************/   
/***********************************
*               USER 
***********************************/  
else if($partesRuta[1]=="user"){
    if($partesRuta[2]=="showAll"){
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1 ){
            include_once("views/user/showAll.php");
        }
    }else if($partesRuta[2]=="update"){
        include_once("views/user/update.php");
    }else {
        include_once("views/404.php");
    }
}
/***********************************
*               END USER 
***********************************/  
/***********************************
*               MULTIMEDIA 
***********************************/  
else if($partesRuta[1]=="media"){
    if($partesRuta[2]=="showAll"){
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==3){
            include_once("views/media/showAllUser.php");
        }
    }else if($partesRuta[2]=="insert"){
        include_once("views/media/insert.php");
    }else if($partesRuta[2]=="update"){
        include_once("views/media/update.php");
    }else if($partesRuta[2]=="delete"){
        $idMedia=$_POST['id'];
        include_once("views/media/delete.php");   
    }else {
        include_once("views/404.php");
    }
}
/***********************************
*               END MULTIMEDIA 
***********************************/  
else if($partesRuta[1]=="home"){
    if (isset($partesRuta[2])) $letter=$partesRuta[2];
    //Si eres el administrado vamos al index
    if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1 ){
        include_once("views/adm/index.php");
    }else if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==3){
        include_once("views/home.php");
    }else{
        include_once("views/home.php");
    }
}else if($partesRuta[1]=="about"){
    include_once("views/about.php");
}else if($partesRuta[1]=="webs"){
    include_once("views/webs.php");
/***********************************
*              DATABASE 
***********************************/  
}else if($partesRuta[1]=="database"){
    if($partesRuta[2]=="show"){
        include_once("views/database/show.php");
    }else if($partesRuta[2]=="mysql"){
        include_once("views/database/mysql.php");
    }else if($partesRuta[2]=="csv"){
        include_once("views/database/csv.php");
    }else if($partesRuta[2]=="sqlite"){
        include_once("views/database/sqlite.php");
    }else {
        include_once("views/404.php");
    }
/***********************************
*               END DATABASE 
***********************************/  
}else if($partesRuta[1]==""){
    if (isset($partesRuta[2])) $letter=$partesRuta[2];
    //Si eres el administrado vamos al index
    if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1 ){
       include_once("views/adm/index.php");
    }else if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==3){
        include_once("views/home.php");
    }else{
        include_once("views/home.php");
    }
}else {
    include_once("views/404.php");
}



?>


		

