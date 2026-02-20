 <?php
	 session_start();
	 $idusuario=$_SESSION['idusuario'];
	 $validadousuario=$_SESSION['validadousuario'];
	 $nivelaccesousuario=$_SESSION['nivelaccesousuario'];
 ?>
 
 <!---------------------------------Barra Inicio---------------------------------->
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
                <a class="navbar-brand" href="http://www.gestorwebs.tipolisto.es/index.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a>
              </div>
             
              <!-- Agrupar los enlaces de navegación, los formularios y cualquier
                   otro elemento que se pueda ocultar al minimizar la barra -->
              <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                  <li><a href="http://www.gestorwebs.tipolisto.es/contacta.php">Contacta</a></li>
                  <li><a href="#" onclick="alert('No operativo, disculpa las molestias')">Foro</a></li>
				  <li><a href="#" onclick="alert('No operativo, disculpa las molestias')">Whatestrellaap</a></li>
                </ul>
                
                <form class="navbar-form navbar-left" role="search" method=post action='http://www.gestorwebs.tipolisto.es/gestionarwebs.php'>
                  <div class="form-group">
                    <input type="text" name='tagsWeb' class="form-control" placeholder="Buscar" title="Introduce el texto a buscar" required>
                    <input type=hidden name=accion value=13></input>
                  </div>
                  <button type="submit" class="btn btn-default">Enviar</button>
                </form>
                 	<div>
					<?php
						
                        if(!isset($idusuario)){
                            echo"<ul class='nav navbar-nav'><li><a href='http://www.gestorwebs.tipolisto.es/gestionarusuarios.php?accion=10'>Registrate</a></li><li><a href='http://www.gestorwebs.tipolisto.es/gestionarusuarios.php?accion=20'>Acceder</a></li></ul>";
					    }else{
                            if($validadousuario==0){
                                $roll="Sin validar";
                            }else {
                                
                                    
                             if($nivelaccesousuario==1){
                                    $roll="Administrador";
                                }else{
                                    $roll="Usuario normal";
                                }
                                        
                            }
                    
                       //echo " <div class='navbar-header'><span class='navbar-brand'>Usuario: ".$_SESSION['nombreusuario'].", roll: ".$roll."</span>";
                       //echo "<a class='navbar-brand' href='gestionarusuarios.php?pagina=index.php&accion=7'>cerrar sesion</a></div>";
					  // echo "<span class='navbar-brand'>Usuario: ".$_SESSION['nombreusuario'].", roll: ".$roll."</span>";
					   echo "<span class='navbar-brand'>Usuario: ".$_SESSION['nombreusuario']."</span>";
                       echo "<a class='navbar-brand' href='http://www.gestorwebs.tipolisto.es/gestionarusuarios.php?pagina=index.php&accion=7'>cerrar sesion</a>";
                    }?>
              	 	</div> 
              </div>
            </nav>
             <!---------------------------------Fin barra Inicio---------------------------------->
        