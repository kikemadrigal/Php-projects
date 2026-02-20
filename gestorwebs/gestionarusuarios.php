<?php
	
	//session_start();


	



	include_once('includes/document-start.php');
	include_once('includes/barrainicio.php'); 
	include_once('includes/barramenu.php'); 
	

	if(isset($_GET['accion'])){
		if($_GET['accion']==4){
			mostrarUnusuario($_GET['idusuario']);
		}else if($_GET['accion']==5){
			actualizarusuario($_GET['idusuario']);
		}else if($_GET['accion']==7){
			cerrarSesion();
		}else if($_GET['accion']==10){
			//mailActivacion();
			//echo "<p>Robot detectado..</p>";
		}else if($_GET['accion']==12){
			confirmarActivacionPorCorreo($_GET['codigoactivacion'], $_GET['nombreusuario'] );
		}else if($_GET['accion']==20){
			if(!isset($_SESSION['idusuario'])){
				menuAccederUsuario();
			}else{
				echo "<p>Selecciona una opción del menú para gestionar los usuarios.</p>";
				//header("Location: usuarios/usuariosgestionarwebs.php");
				//echo "<script type='text/javascript'>location.href='".PATHSERVER."gestionarusuarios.php';</script>";
			}
			
		}else if($_GET['accion']==30){
			enviarMensajeConNuevaClavePorOlvidoDeClave();
		}else if($_GET['accion']==15){
			actualizarusuarioQueVieneDeRegistrarse($_GET['idusuario']);
		}
	}
	
	
	if(isset($_POST['accion'])){
		if($_POST['accion']==6){
			aplicarActualizacionusuario($_POST['idusuario']);
		}
		
		if($_POST['accion'] == 11){
			mailActivacion($_POST['correousuario'], $_POST['nombreusuario'],$_POST['codigoActivacion']);
		}else if($_POST['accion'] == 12){
			aplicarInsercionusuario($_POST);
		}else if($_POST['accion'] == 21){
			controlUsuarios($_POST['nombreusuario'], $_POST['claveusuario']);
		}else if($_POST['accion'] == 22){
			aplicarActualizacionusuario($_POST['idusuario'], $_POST);
		}else if($_POST['accion']==16){
			validarusuario($_POST['idusuario'],$_POST['claveusuario']);
		}else if($_POST['accion']==31){
			mailActivationPorOlvidoDeClave($_POST['correousuario'], $_POST['codigodeactivacion']);
		}
	}


	include_once('includes/document-end.php'); 
