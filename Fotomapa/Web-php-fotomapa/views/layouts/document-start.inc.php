<?php
session_start();
if ( !isset( $titulo ) )$titulo = APP_NAME;
else $titulo .= " - ".APP_NAME;
?>
<!doctype html>
<html lang="es">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<!--4.0-->
	<!--	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">-->
	<!--bootstrap4.3-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!--Agregamos m is estilos-->
	<link rel="stylesheet" href="<?php echo RUTA_CSS_HTTPS ?>/miestilo.css">
	<!--Agregamos css Font awesome para los iconos-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!--Agregamos el icono de la imagen de la web-->
	<link rel="icon" type="image/png" href="<?php echo RUTA_IMAGENES_WEB ?>/icono.ico" />
	<?php echo "<title>$titulo</title>"; ?>

	<!--  METAS     -->
	<meta name="application-name" content="Mis fotos" />
	<meta name="author" content="misfotos.es">
	<meta name="description" content="misfotos es una web para compartir tus fotos colocadas en lugares sobre un mapa, tambien puedes crear álbunes e histórias bonitas ">
    <meta name="generator" content="tipolisto" />
	<meta name="keywords" content="fotos, pictures, photos, map, maps, foto, picture, photo, place, lugares, city, cities, country" />
	<!-- FIN DE METAS -->

	<!--Agregamos el CDN para el captcha-->
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-116597239-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	  gtag('config', 'UA-116597239-1');
	</script>
</head>
<body>

	<div class="container">
		<?php 
	  	//Mensajes de otras páginas por get
	  	include_once('views/layouts/header.php'); 
		?>
	</div>
