<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="application-name" content="Game manager and cataloger" />
    <meta name="author" content="tipolisto.es">
    <meta name="description" content="Game manager and cataloger">
    <meta name="generator" content="Bootstrap" />
	<meta name="keywords" content="Game manager and cataloger" />
    <link rel="icon" type="image/png" href="<?php echo PATHIMAGES ?>icono.png" />
	<title>GamesDB</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

	<link href="<?php echo PATHCSS;?>styles.css" rel="stylesheet">
  </head>
  <body>
  	<div class="container">


        <!------------------------    BARRA DE INICIO --------------------------------->
        <?php //require_once('views/templates/barrainicio.php'); ?>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo PATHSERVER.'home';?>">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="<?php echo PATHSERVER."game/showUnregisteredView" ?>">View user games</a></li>
                    <li class="nav-item"><a class="nav-link active" href="<?php echo PATHSERVER."about" ?>">About</a></li>
                    <li class="nav-item"><a class="nav-link active" href="<?php echo PATHSERVER."webs" ?>">Webs</a></li>
                    <li class="nav-item"><a class="nav-link active" href="http://msx.tipolisto.es" target="_blanck">msx.tipolisto.es</a></li>
                </ul>
            </div>




            <!--CONTROL DE USUARIOS -->

            <ul class="navbar-nav">
            <?php
                //Si no existe la sesión del usuario
                
                if(!isset($_SESSION['idusuario'])){
                    echo"<li class='nav-item'><a class='nav-link active' href='".PATHSERVER."register'>Register</a></li><li><a class='nav-link active' href='".PATHSERVER."login'>Login</a></li>";
                }else{
                    if($_SESSION['nivelaccesousuario']==0){
                        $roll="Sin validar";
                    }else { 
                    if($_SESSION['nivelaccesousuario']==1){
                            $roll="Administrador";
                    }else{
                            $roll="Usuario normal";
                    }          
                    } 
                    
                    echo "<li class='nav-item m-2'>User: ".$_SESSION['nombreusuario']."</li>";
                    echo "<li class='nav-item m-2'><a href='".PATHSERVER."logout'>Logout</a></li>";
                }
                ?>
                </ul>




            <!--Busqyeda de games -->     
            <form class="d-flex" method=post action='<?php echo PATHSERVER; ?>game/search' >
                <input class="form-control me-2" type="search" name="search" id="search" placeholder="Search" aria-label="Search" >
                <button class="btn btn-outline-success" type="submit" name="submit">Search</button>
            </form>

        </div><!--fin clase container fluid -->
        </nav>
        <!------------------------   FIN DE BARRA DE INICIO --------------------------------->  








        <!------------------------    BARRA DE MENU USUARIO --------------------------------->
        <?php  //include_once('barramenu.php');?>    
        <?php 
        if(isset($_SESSION['idusuario'])){
            //Si es el administrador el nivel de acceso será el 3
            if($_SESSION['nivelaccesousuario']==3){
            ?>
                <nav aria-label="breadcrumb">
                    <ol class='breadcrumb'>
                        <!--Estos enlaces van a la direccion http://www.gestorwebs.tipolisto.es/gestionarwebs.php?idCategoria=66 por ejemplo
                        Pero han sido sobreescritos con mod_rewrite del archivo .htacces fichero de configuración de apache-->
                        <li class="breadcrumb-item"><a href='<?php echo PATHSERVER ?>game/showByCategoriesUsers'>My Games</a></li>
                        <li class="breadcrumb-item"><a href='<?php echo PATHSERVER ?>game/insert'>New Game</a></li>
                        <li class="breadcrumb-item"><a href='<?php echo PATHSERVER ?>user/update'>My data</a></li>
                        <li class="breadcrumb-item"><a href='<?php echo PATHSERVER ?>database/show'>Database</a></li>
                        <li class="breadcrumb-item"><a href='<?php echo PATHSERVER ?>media/showAll'>Images</a></li>
                    </ol> 
                    <form class="d-flex col-md-4" method=post action='<?php echo PATHSERVER; ?>game/searchUser'>
                        <input class="form-control" type="search" name="search" id="search" placeholder="Search your games" aria-label="search your games">
                        <button class="btn btn-outline-success" type="submit" name="submit">Search</button>
                    </form> 
                </nav>
            <?php                   
            }
        }//Fin de sesion
        ?>
        <!------------------------    FIN DE BARRRA DE USUARIO --------------------------------->





         
   
   <!--<div class="col-xs-12 col-sm-8 col-md-10">-->
   <!--<div class="mueble">-->