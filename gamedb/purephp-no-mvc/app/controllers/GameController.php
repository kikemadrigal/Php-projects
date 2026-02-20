<?php
class GameController {
    function __construct()
    {
        
    }

    public function show(){
        $this->view->render("game/show");
    }
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
}