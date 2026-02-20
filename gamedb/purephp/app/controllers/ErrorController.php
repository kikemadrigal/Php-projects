<?php
class ErrorController extends BaseController{
    function __construct()
    {
        //echo "<p>Hubo un error</p>";
    }
    public function error($error){
        echo "Error: ".$error;
    }
}