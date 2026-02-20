<?php
if(isset($_SESSION['idusuario'])){
    session_unset();
    session_destroy();
}
header('Location: '.PATHSERVER);
if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."';</script>";
?>