<?php

$componentes_url=parse_url($_SERVER['REQUEST_URI']);
$ruta=$componentes_url['path'];
$partesRuta=explode("/",$ruta);
$partesRuta=array_filter($partesRuta);
$partesRuta=array_slice($partesRuta,0);


/**
 * Configuraciones
 */
//Configuracines generales
include_once "application/config/config.php";
//Constantes
include_once "application/config/constantes.php";
//Base de datos
include_once "application/config/Conexion.php";



if($partesRuta[0]=='prueba'){
    $rutaElegida='application/api/user/json.php';
}else if($partesRuta[0]=='user'){
    include_once "application/model/user/User.php";
    include_once "application/model/user/Users.php";
    if($partesRuta[1]=='create'){
        $rutaElegida='application/api/user/create.php';
    }else if($partesRuta[1]=='showAll'){
        $rutaElegida='application/api/user/showAll.php';
    }else if($partesRuta[1]=='show'){
        //echo "<h3>".count($partesRuta)."</h3>";
        //echo var_dump($partesRuta);
        if(count($partesRuta)==3){
            $id_usuario=$partesRuta[2];
            $rutaElegida='application/api/user/show.php';
        }else{
            echo "Para ver un usuario debes de poner /user/x donde x es un número.";
        } 
    }else if($partesRuta[1]=='update'){
        $rutaElegida='application/api/user/update.php';
    }else if($partesRuta[1]=='delete'){
        $rutaElegida='application/api/user/delete.php';
    }else{
        echo "Para realizar alguna operación con un usuario por user/create o show o delete o update.";
    }
}else{
    echo "Acceso prohibido";
}






include_once $rutaElegida;
?>