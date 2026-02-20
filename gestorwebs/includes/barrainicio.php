
  <nav class="navbar navbar-default" role="navigation">
    <!-- El logotipo y el icono que despliega el menú se agrupan
          para mostrarlos mejor en los dispositivos móviles -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse"
              data-target=".navbar-ex1-collapse">
        <span class="sr-only">Desplegar navegación</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    
    <!-- Agrupar los enlaces de navegación, los formularios y cualquier
          otro elemento que se pueda ocultar al minimizar la barra -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
      <ul class="nav navbar-nav">
        <li><a href="<?php echo PATHSERVER; ?>about.php">¿Que es tipolisto?</a></li>
        <li><a href="http://juegos.tipolisto.es" target="_blank">Juegos</a></li>
      </ul>
    <div>

    <?php
      //Si el usuario no se ha logeado mostarmos un menú para que se logee
      if(!isset($_SESSION['idusuario'])){
        echo"<ul class='nav navbar-nav text-right navbar-right'><li><a href='".PATHSERVER."gestionarusuarios.php?accion=10'>Registrate</a></li><li><a href='".PATHSERVER."gestionarusuarios.php?accion=20'>Acceder</a></li></ul>";
      //Si el usuario está logeado puede ser que esté validado por el administrador o no validado por el administrador
      }else{
      if($_SESSION['validadousuario']==0){
          $roll="Sin validar";
      }else {   
        //Si el usuario está validado por el administrador puede ser que sea normal o administrador
        if($_SESSION['nivelaccesousuario']==1){
              $roll="Administrador";
        }else{
            $roll="Usuario normal";
        }           
      }
      echo "<span class='navbar-brand'>Usuario: ".$_SESSION['nombreusuario']."</span>";
      echo "<a class='navbar-brand' href='".PATHSERVER."gestionarusuarios.php?accion=7'>cerrar sesion</a>";
    }
    ?>
    <!-- Dibujamos el formulario para buscar webs -->
    <form class="navbar-form navbar-right text-right" role="search" method="post" action="<?php echo PATHSERVER; ?>gestionarwebs.php">
      <div class="form-group">
        <input type="text" name='tagsWeb' class="form-control" placeholder="Nombre web" title="Introduce el texto de la web a buscar" required>
        <input type=hidden name=accion value=13></input>
      </div>
      <button type="submit" class="btn btn-default">Buscar web</button>
    </form>
  </nav><!--Final de la etiqueta nav-->
