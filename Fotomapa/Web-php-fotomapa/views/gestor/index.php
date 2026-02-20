<?php
//En este archivo obetenemos la variable gestorActual del index.php de la raiz y con el mostramos una
//u otro div en la derecha con un col de 9 en pequeño y 10 en grande
require_once('app/config.php');
$titulo ="Gestor";


include_once("views/layouts/document-start.inc.php");
include_once("views/gestor/control-panel-start.inc.php");
	
	switch($gestorActual){
		case '':
			include('gestor-generico-user.php');
			break;
		case 'fotosUser':
			include('gestor-fotos-user.php');
			break;
		case 'comentariosUser':
			include('gestor-comentarios-user.php');
			break;
		case 'favoritosUser':
			include('gestor-favoritos-user.php');
			break;
		case 'genericoAdm':
			include('gestor-generico-adm.php');
			break;
		case 'fotosAdm':
			include('gestor-fotos-adm.php');
			break;
		case 'comentariosAdm':
			include('gestor-comentarios-adm.php');
			break;
		case 'favoritosAdm':
			include('gestor-favoritos-adm.php');
			break;	
		case 'admShowAll':
			include('gestor-showall-adm.php');
			break;	
		case 'admEdit':
			if(isset($_POST)){
				$idFoto=$_POST['idFoto'];
			} 
			else{
				echo "<h1>POST no existe</h1>";
			}
			include('gestor-edit-adm.php');
			break;	
		case 'admDelete':
			if(isset($_POST)){
				$idFoto=$_POST['idFoto'];
			} 
			else{
				echo "<h1>POST no existe</h1>";
			}
			include('gestor-delete-adm.php');
			break;	
	}

include_once("views/gestor/control-panel-end.inc.php");
include_once("views/layouts/document-end.inc.php");
?>