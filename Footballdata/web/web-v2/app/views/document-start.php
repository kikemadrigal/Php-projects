<?php 
ini_set('display_errors', '1');
require_once("pagination.php");
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="application-name" content="Breeds" />
    <meta name="author" content="Murciadevs.tipolisto.es">
    <meta name="description" content="Footballdata">
    <meta name="generator" content="Bootstrap" />
	<meta name="keywords" content="Footballdata" />
    <link rel="icon" type="image/png" href="images/icon.ico" />
	<title>Footballdata</title>
    <!-- Bootstrap CSS 5.3.3: https://getbootstrap.com/docs/5.3/getting-started/introduction/ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link href="css/styles.css" rel="stylesheet">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XF4Q34MQ6T"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-XF4Q34MQ6T');
    </script>
  </head>
  <body>
  	<div class="container">
        <!--<nav class="navbar navbar-expand-lg navbar-light bg-light bg-primary">-->
        <nav class="navbar navbar-light mb-3" style="background-color: #e3f2fd;">
            <div class="container-fluid">
                <a class="nav-link active" href="index.php">Home</a>
                <a class="nav-link active" href="jugadores.php">jugadores</a>
                <a class="nav-link active" href="clubes.php">clubes</a>
                <a class="nav-link active" href="competiciones.php">competiciones</a>
                <a class="nav-link active" href="juegos.php">juegos</a>     
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Mas...
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#">Club-juegos</a>
                            <a class="dropdown-item" href="#">Apariciones de jugadores en juegos</a>
                            <a class="dropdown-item" href="#">Juegos-eventos</a>
                            <a class="dropdown-item" href="#">Evaluzaciones jugadores</a>
                            <a class="dropdown-item" href="Cruzadas.php">Preguntas cruzadas</a>
                            <a class="dropdown-item" href="esquema.php">Esquema</a>
                            <a class="dropdown-item" href="#">Rendimiento</a>
                            <a class="dropdown-item" href="https://murciadevs.tipolisto.es/contacta/" target="_blank">Contacta</a>
                        </div>
                    </li>
                </ul>
            </div><!--fin clase container fluid -->
        </nav>