<?php
	//ob_clean();
	//session_start();
	
	//Si existe el cookie idusuario lo redireccionaos a la página de gestión de webs, sino se muestra el index con las últimas 5 webs.
	if(isset($_COOKIE['idusuario'])){
		
	}
	
	include_once('includes/document-start.php');
	$webs=array();
	$webs=obtenerTodosLasUltimasCincoWebsAdm();
	dibujarLayoutWebs($webs);
	include_once('includes/document-end.php'); ?>
?>