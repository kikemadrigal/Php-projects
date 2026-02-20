<?php
	session_start();
	//i_set('session.save_path', './.tmp');
	require_once('./venv.php');
	require_once('./Mysql.php');
    require_once('./mysqlusuarios.php');
	require_once("./util.php");
	require_once('./repositories/categoriasRepository.php');
	require_once("./repositories/websRepository.php"); 
	require_once("./repositories/userRepository.php");
	require_once('./entities/Web.php');
	require_once('./entities/Categoria.php');
	require_once('./entities/ComentarioWeb.php');
	require_once("./entities/Usuario.php");
?>
<!DOCTYPE html>
	<html lang="es">
  	<head>
    	<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    	<meta name="application-name" content="Gestor de páginas web" />
    	<meta name="author" content="tipolisto.es">
    	<meta name="description" content="Tipolisto es un sistema de puntuación y clasificación de webs, para que siempre estés al día de las mejores webs, puedes gestionar gestionar tus propias webs.">
        <meta name="generator" content="Bootstrap" />
		<meta name="keywords" content="Gestor webs, páginas web, websites, manager websites" />
        
    	<link rel="icon" type="image/png" href="/imagenes/icono.png" />
		
      	<title>Gestor de p&aacute;ginas webs</title>
		<link href="css/miestilo.css" rel="stylesheet">
       <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Latest compiled and minified JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <!-- Custom styles for this template -->
        <link href="css/bootstrap-theme.css" rel="stylesheet">

      </head>

      <body>
        <div class="container">
		<?php include_once('includes/barrainicio.php'); ?>
		<div class="row">
		<!-- Barra lateral izquierda -->
        <div class="col-md-4 col-sm-12">
        	<div id="girando"> <a href="<?php echo PATHSERVER; ?>index.php">GW</a></div>
			<div>
			<?php	
			if(isset($_SESSION['idusuario'])){
				if($_SESSION['nivelaccesousuario']==1){ //administrador
					?>
						<ul class="nav navbar-nav" >
							<li><a href='<?php echo PATHSERVER;?>adm/admgestionarusuarios.php'  >Gestionar usuarios</a></li>
							<li><a href='<?php echo PATHSERVER;?>adm/admcategorias.php'  >Gestionar categorias</a></li>
							<li><a href='<?php echo PATHSERVER;?>adm/admgestionarwebs.php'>Gestionar webs</a></li>
							<li><a href='<?php echo PATHSERVER;?>adm/admgestionarimagenes.php'  >Gestionar imagenes</a></li>
							<li><a href='<?php echo PATHSERVER;?>adm/admgestionarpasear.php'  >Gestionar pasear</a></li>
							<li><a href='<?php echo PATHSERVER;?>gestionarcomentariosweb.php' >Gestionar comentarios web</a></li>
							<li><a href='<?php echo PATHSERVER;?>gestionarcomentarioscategoria.php'>Gestionar comentarios categoria</a></li>
						</ul>   
					<?php
				}else{ //Usuario logeado
					?>
					<ul class="list-group mt-3" >
					<?php
						echo "<li class='list-group-item'><a href='".PATHSERVER."gestionarusuarios.php?accion=4&idusuario=$_SESSION[idusuario]' >Mis datos</a></li>";
					?>
						<li class='list-group-item'><a href='<?php echo PATHSERVER;?>gestionarcategorias.php' >Gestionar mis categorias</a></li>
						<li class='list-group-item'><a href='<?php echo PATHSERVER;?>gestionarwebs.php?accion=9'  >Gestionar mis webs</a></li>
					</ul>
					<?php
				}
				//if($_SESSION['nivelaccesousuario']==3 && $_SERVER["PHP_SELF"]!="/usuarios/usuariosgestionarcategorias.php"){
				if($_SESSION['nivelaccesousuario']==3 ){
					echo "<span style='color:red'>Tus categorias</span>";
					sideMenuUsers();
				}	
			}								
			?> 
			</div>
	</div><!-- Fin barra lateral izquierda -->
	<!-- Contenido central -->
	<div class="col-md-8 col-sm-12">
		<?php include_once('includes/barramenu.php');?>
