<?php

function obtenerIpLocal(){
    exec("hostname -I",$o);
        foreach($o as $elemento){
           $ipEncontrada=$elemento;            
        }
    return $ipEncontrada;
}



function obtenerIpLocal_old(){
    exec("ifconfig",$o);
        foreach($o as $elemento){
            $posicionDelInet=stripos($elemento, "inet");
            $posicionDelNetmask=stripos($elemento, "netmask");
            if($posicionDelInet!=false){
                $ipEncontrada=substr($elemento, $posicionDelInet+5, $posicionDelNetmask-15);
            }else{
                echo "Ip no encoontrada";
                die();
            }
        }
    return $ipEncontrada;
}




function crearFormulario($direccion, $id, $texto){
    $formulario = "<form action='$direccion' method='post' class='form-inline'>".
       "<input type='hidden' name='id' value='$id'></input>".
       "<input type='submit' value='$texto' class='btn btn-link'></imput>".
    "</form>";
    return $formulario;
}




?>