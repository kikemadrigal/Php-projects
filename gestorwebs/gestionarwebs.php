<?php
	include_once('includes/document-start.php');

	//Si no se especifica una acción es como si pincharas en el menu superior
	if(!isset($_GET['accion'])){
		$TAMANO_PAGINA = 3;
		$pagina=1;
		if(isset($_GET["pagina"])){
			$pagina = $_GET["pagina"];
		}
		
		if (!$pagina) {
			$inicio = 0;
			$pagina=1;
		}
		else {
			$inicio = ($pagina - 1) * $TAMANO_PAGINA;
		} 
		$webs=array();	
		$webs=obtenerTodosLasWebsDeUnaCategoria($_GET['idCategoria'],$inicio, $TAMANO_PAGINA);
		paginacion($_GET['idCategoria'], $inicio, $TAMANO_PAGINA);
		dibujarLayoutWebsConArray($webs, $_GET['idCategoria'], $inicio, $TAMANO_PAGINA);
		
	}else{
		if ($_GET['accion']==1){
			crearNuevoWeb();
		}else if($_GET['accion']==2){
			actualizarWeb($_GET['idWeb']);
		}else if($_GET['accion']==3){
			confirmarBorrarWeb($_GET['idWeb']);
		}else if($_GET['accion']==4){
			//votarUnaWeb($_GET['idWeb']);
			mostrarUnWeb($_GET['idWeb']);
		}else if($_GET['accion']==5){
			borrarWeb($_GET['idWeb']);
		}else if($_GET['accion']==6){
			redirigirPorNoBorrarWeb($_GET['idWeb']);
		}else if($_GET['accion']==7){
			cerrarSesion();
		}else if($_GET['accion']==8){
			incluirWebEnPasear($_GET['idWeb']);
		// Tabla de las webs de un usuario
		}else if($_GET['accion']==9){
			echo"<p>Llevas: ".obtenerTotalRegistros()."</p>";
			drawWebUsers();
		}else if($_GET['accion']==40){
			dameUnaCategoria();
		}else if($_GET['accion']==43){
			rellenarRestoCamposWeb();
		}else if($_GET['accion']==44){
			crearNuevaCategoria();
		}
	}
	

	if (isset($_POST['accion'])){
		if($_POST['accion'] == 12){
			aplicarInsercionWeb($_POST);
		}else if($_POST['accion'] == 22){
			aplicarActualizacionWeb($_POST['idWeb'], $_POST);
		}
	}


	

include_once('includes/document-end.php'); 