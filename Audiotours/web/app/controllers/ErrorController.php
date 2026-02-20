<?php
class ErrorController extends BaseController{
    function __construct()
    {
        //echo "<p>Hubo un error</p>";
    }
    public function index(){
        echo "Error: not found <a href='".PATHSERVER."home'>Back</a> ";
    }
    public function error($error){
        echo "Error: ".$error;
    }
}