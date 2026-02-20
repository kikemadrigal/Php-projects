<?php
class View{
    function __construct(){
        //echo "<p>Salidos desde BaseView</p>";
    }
    function render($name){
        require 'views/'.$name.'.php';
    }
}