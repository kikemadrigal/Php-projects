<?php
//El idMedia lo obtenemos en el index
MultimediaRepository::delete($idMedia);
header('Location: '.PATHSERVER."media/showAll");
if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."media/showAll';</script>";
?>
