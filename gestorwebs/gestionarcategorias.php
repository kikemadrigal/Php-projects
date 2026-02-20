<?php
	session_start();
	//Si existe la variable idusuario lo redireccionamos a otra vista
	if(isset($_SESSION['idusuario'])){
		//header("Location: gestionarusarios?accion=20");
		//echo "<script type='text/javascript'>location.href='".PATHSERVER."gestionarusuarios.php?accion=20';</script>";
		//exit();
	}

	include_once('includes/document-start.php');



	if (!isset($_GET['accion'])){
		showCategories();
	}else{
		if ($_GET['accion']==1){
			insert();
		}else if($_GET['accion']==2){
			update($_GET['idCategoria']);
		}else if($_GET['accion']==3){
			confirmarBorrarCategoria($_GET['idCategoria']);
		}else if($_GET['accion']==4){
			showCategory($_GET['idCategoria']);
		}else if($_GET['accion']==5){
			borrarCategoria($_GET['idCategoria']);
		}else if($_GET['accion']==6){
			redirigirPorNoBorrar($_GET['idCategoria']);
		}/*else if($_GET['accion']==4){
			mostrarUnacategoria($_GET['idCategoria']);
		}*/else if($_GET['accion']==7){
			cerrarSesion();
		}
		
	}
	if(isset($_POST['accion'])){
			//echo "<p>Entra en el if de accion</p>";
		if($_POST['accion'] == 12){
				aplicarInsercionCategoria($_POST);
		}else if($_POST['accion'] == 22){
			//echo "<p>Pasa por el if de actualizar nombre</p>";
			aplicarActualizacionNombreCategoria($_POST['idCategoria']);
		}else if($_POST['accion'] == 23){
			aplicarActualizacionPadreCategoria($_POST['idCategoria']);
		}else if($_POST['accion'] == 24){
			aplicarActualizacionTituloCategoria($_POST['idCategoria']);
		}
	}


include_once('includes/document-end.php'); 





































