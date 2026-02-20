<?php
GameUserRepository::delete($idGame);
header("location: ".PATHSERVER."game/showByCategoriesUsers");
if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."game/showByCategoriesUsers';</script>";
?>