<?php
class BaseController {
    function __construct(){
        echo "Controlador base";
        $view=new View();
    }
}