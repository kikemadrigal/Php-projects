
<!DOCTYPE html>
	<html lang="en">
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
        
    	<link rel="icon" href="imagenes/favicon.ico">
		
      	<title>Gestor de p&aacute;ginas webs</title>
		<link href="css/miestilo.css" rel="stylesheet">
       <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Latest compiled and minified JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <!-- Custom styles for this template -->
        <link href="css/bootstrap-theme.css" rel="stylesheet">
        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
      </head>

      <body ">
        <div class="container">
			<?php require('barrainicio.php'); ?>
			<?php require('barramenu.php'); ?>

		 <div class="row">

        <div class="col-xs-12 col-sm-6 col-md-2">
        	 <div id="girando">GW</div>
				<?php
				if($_SESSION['nivelaccesousuario']==null || $_SESSION['nivelaccesousuario']==0){ //usuario no logeado
					echo "";
				}else if($_SESSION['nivelaccesousuario']==1){ //administrador
					?>
						 <ul class="nav navbar-nav" >
                            <li><a href='http://www.gestorwebs.tipolisto.es/adm/admgestionarusuarios.php'  >Gestionar usuarios</a></li>
                            <li><a href='http://www.gestorwebs.tipolisto.es/adm/admcategorias.php'  >Gestionar categorias</a></li>
                            <li><a href='http://www.gestorwebs.tipolisto.es/adm/admgestionarwebs.php'>Gestionar webs</a></li>
                            <li><a href='http://www.gestorwebs.tipolisto.es/adm/admgestionarpasear.php'  >Gestionar pasear</a></li>
                            <li><a href='http://www.gestorwebs.tipolisto.es/adm/admgestionarimagenes.php'  >Gestionar imagenes</a></li>
                            <li><a href='http://www.gestorwebs.tipolisto.es/gestionarcomentariosweb.php' >Gestionar comentarios web</a></li>
                            <li><a href='http://www.gestorwebs.tipolisto.es/gestionarcomentarioscategoria.php'>Gestionar comentarios categoria</a></li>
						</ul>   
					<?php
				}else{ //Usuario logeado
					?>
                     	<ul class="nav navbar-nav" >
                    <?php
							echo "<li><a href='http://www.gestorwebs.tipolisto.es/gestionarusuarios.php?accion=4&idusuario=$_SESSION[idusuario]' >Mis datos</a></li>";
					?>
                            <li><a href='http://www.gestorwebs.tipolisto.es/usuarios/usuariosgestionarcategorias.php' >Gestionar mis categorias</a></li>
                            <li><a href='http://www.gestorwebs.tipolisto.es/usuarios/usuariosgestionarwebs.php'  >Gestionar mis webs</a></li>
                        </ul>
               		<?php
				}
	 		 	
				?>
           
        </div>
    	<div class="col-xs-12 col-sm-10 col-md-10">
       			 <?php
					if(isset($_GET['mensaje'])) echo "<h4><span class='label label-danger'>".$_GET['mensaje']."</span></h4>";
				?>






	


		









<?php
	require('Mysql.php');
	

	
	
	
	
	
	
	function cortarCadena($cadena){
		//Strip_tags: retira las etiquetas HTML y PHP de un String
		//substr($cadena, corta inicio, corta final)
		//strlen: devuelve la longitud de la cadena
		$longitud = 20;
		$stringDisplay = substr(strip_tags($cadena), 0, $longitud);
		if (strlen(strip_tags($cadena)) > $longitud)
        	$stringDisplay .= ' ...';
		return $stringDisplay;
	}
	
	/*function obtenerNombreCategoria($idCategoria){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM pasear WHERE idPasear='".$idCategoria."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			return $linea['nombrecategoria'];
		}
		$basededatos->desconectar();
	}
	
	
	function obtenerNombreWeb($idWeb){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT nombreweb FROM webs WHERE idweb='".$idWeb."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			return $linea['nombreweb'];
		}
		$basededatos->desconectar();
	}
	*/
	
	
	
	


	function dibujarLayoutCategoriasDos(){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta= "SELECT * FROM pasear";
		$resultado=$basededatos->ejecutar_sql($consulta);
		$array=array();
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$array[]=$linea['idwebpasear'];
			//echo $linea['idpasear'];
		}
		$basededatos->desconectar();
		$numero_dentro_array=rand(0, count($array)-1);
		//echo "<br />El tamaño del array es: ".count($array)."<br />";
		//echo "<br />El numero aleatroio es: ".$numero_dentro_array."<br />";
		$id_aleatoria=$array[$numero_dentro_array];
		//echo "<br />Elid aleatoria es: ".$id_aleatoria."<br />";
			
		
		$basededatos2= new Mysql();
		$basededatos2->conectar_mysql();
		$consulta2= "SELECT * FROM webs WHERE idweb='".$id_aleatoria."'";
		$resultado2=$basededatos2->ejecutar_sql($consulta2);
		echo "<div class='contenedorimagenesdewebs' >";
		while ($linea2 = mysqli_fetch_array($resultado2)) 
		{
			echo "<center ><a href='http://".$linea2[nombreweb]."' target='_blanck' class='tituloweb' >";
			echo cortarCadena($linea2[tituloweb])."";
			echo "<br /><span style='color:black; font-size:10px;'>Enlace: ".cortarCadena($linea2[nombreweb])."</span></a>";
			echo "<br /><pre>".$linea2['descripcionweb']."</pre>";
			echo "<br /><a href='http://".$linea2[nombreweb]."' target='_blanck' class='tituloweb' ><img src='imagenes/webs/".$linea2[imagenweb]."' width='500px' /></a></center>";
			echo "<br /><span>".$linea2['mediavotosweb']." <a href='gestionarwebs?accion=4&idWeb=".$linea2[idweb]."'> Votar</a></span >";
								
			echo "<br /><a href=gestionarwebs.php?accion=1&idWeb=".$linea2[idweb]." >Detalles...</a><br />";
			echo "<br />";
			if($_SESSION['nivelaccesousuario']==1){
					echo "<a href='adm/admgestionarwebs.php?accion=2&idWeb=".$linea2[idweb]."'>Editar, <span style='color:red'> solo administrador</span></a>";
			}
			
		}
		$basededatos2->desconectar();
		echo "</div>";
	}













		

	
	
	
	
/***************************Main*********************************************/
	
	if (!isset($_GET['accion'])){
		if (isset($_GET['mensaje'])) echo "<br /><span style='color:red'>".$_GET['mensaje']."</span><br /><br />";
		echo"<p><a href='gestionarpasear.php'>Ver m&aacute;s</a></p>";
		dibujarLayoutCategoriasDos();
	}
/****************************************************************************/








	
?>


			</div><!--final del div central -->
        </div> <!-- final de la fila -->
            <hr>
        	
            <footer>
               <br /><br /><br /><br /><p>&copy; Tipolisto.es 2015</p>
            </footer>
     </div> <!-- final del container -->
        
        
            <!-- Bootstrap core JavaScript
            ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script language="javascript" src="js/micodigo.js"></script>
            <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
            <script src="js/ie10-viewport-bug-workaround.js"></script>
          </body>
        </html>
       