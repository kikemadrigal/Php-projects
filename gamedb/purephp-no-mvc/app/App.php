<?php


class App {
    function __construct(){
        //I btenemos la URL
        $componentesUrl=parse_url($_SERVER["REQUEST_URI"]);
        //sacamos solo la ruta del final, toda la dirección menos la parte del servivor
        $ruta=$componentesUrl["path"];
        //Obtenemos los partes de la ruta
        $partesRuta=explode("/", $ruta);
        //echo var_dump($partesRuta);
        //echo "<br>";
        //echo $_SESSION['idusuario']."<br>";


        //http://gamedb.es/Main
        $controller="app/controllers/".$partesRuta[1].".php";
        if (file_exists($controller)){
            require_once($controller);
            $controller=new $partesRuta[1];
            //Si ha puesto algo más en el path el 2 string lo va a tratar como un método
            if(isset( $partesRuta[2])){
                $controller->{$partesRuta[2]}();
            }
        }else{
            $controller="app/controllers/NotFound.php";
            require_once($controller);
            $controller=new NotFound();
        }

    }//final construct
}//final clase