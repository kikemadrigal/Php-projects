<?php
function obtenerTodasLasWebsDeUnaCategoria($idCategoria){
		$basededatos= new mysqlusuarios();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT nombreweb,tituloweb FROM webs_".$_SESSION['idusuario']." WHERE categoriaweb='".$idCategoria."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		echo "<ul>";
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			echo "<li><a href='http://".$linea['nombreweb']."' target='_blank' ><span style='font-size:12px; color:red'>".$linea['tituloweb']."</span></a></li>";
		}
		echo "</ul>";
		$basededatos->desconectar();
}
function recorrerCategoriasUsuarios($nivelCategoria, $categoriaeshijade){//Esta funcion es solo par alos usuarios registrados
		$nivelCategoria++;
		$basededatos1= new mysqlusuarios();
		$basededatos1->conectar_mysql();
		$consulta1  = "SELECT * FROM categorias_".$_SESSION['idusuario']." WHERE nivelcategoria='".$nivelCategoria."' && idpadrecategoria='".$categoriaeshijade."' ORDER BY nombrecategoria";
		$resultado1=$basededatos1->ejecutar_sql($consulta1);
		for($i=2;$i<$nivelCategoria;$i++){
			$espacios=$espacios."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		while ($linea1 = mysqli_fetch_array($resultado1 )) 
		{
			echo "<li>".$espacios."|__  <a href=usuariosgestionarwebs.php?categoriaweb=$linea1[idcategoria] > ".$linea1['nombrecategoria']."</a>";
				obtenerTodasLasWebsDeUnaCategoria($linea1['idcategoria']);
			echo "</li>";
			if ($linea1['categoriaeshijade'] != null){
				recorrerCategoriasUsuarios($nivelCategoria, $linea1['idcategoria'] );							
			}
		}
		$basededatos1->desconectar();
	}



function dibujarLayoutCategoriasUsuarios(){//Esta funcion es para los usuaros registrados
	$nivelCategoria=1;
	$basededatos= new mysqlusuarios();
	$basededatos->conectar_mysql();
	$consulta= "SELECT * FROM categorias_".$_SESSION['idusuario']." WHERE nivelcategoria='".$nivelCategoria."' ORDER BY nombrecategoria";
	$resultado=$basededatos->ejecutar_sql($consulta);
	if(mysqli_num_rows($resultado)==null || mysqli_num_rows($resultado)==0){
		echo "<p>No hay webs creadas</p>";
	}else{
		echo "<ul style='list-style:none'>";
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			echo "<li> <a href=usuariosgestionarwebs.php?categoriaweb=$linea[idcategoria] > ".$linea['nombrecategoria']."</a></li>";
				recorrerCategoriasUsuarios($nivelCategoria, $linea['idcategoria'] );	
		}
	}
	$basededatos->desconectar();
	echo "</ul>";
}
					
			
		
	
	

	function dibujarhtmlUsuarios(){
			?>
			<!DOCTYPE html>
			<html lang="es">
			<head>
                <!--<meta charset="utf-8">-->
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
   				<meta name="application-name" content="Gestor de páginas web" />
    			<meta name="author" content="tipolisto.es">
    			<meta name="description" content="En usuarios puedes gestionar tus propias webs.">
    			<meta name="generator" content="Bootstrap" />
    			<meta name="keywords" content="Gestor webs, páginas web, websites, manager websites" />
                
                <link rel="icon" href="../imagenes/favicon.ico">
                
                <title>Gestor de p&aacute;ginas webs</title>
                <link href="../css/miestilo.css" rel="stylesheet">
                <!-- Bootstrap core CSS -->
                <link href="../css/bootstrap.min.css" rel="stylesheet">
                <!-- Latest compiled and minified JavaScript -->
                <script src="../js/bootstrap.min.js"></script>
                <!-- Custom styles for this template -->
                <!--<link href="../css/bootstrap-theme.css" rel="stylesheet">-->
                <!-- Optional theme -->
                <!--<link href="../css/bootstrap-theme.min.css" rel="stylesheet">-->
                <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
              
                <!--[if lt IE 9]><script src="../../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
                
                <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
                <!--[if lt IE 9]>
                  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
                <![endif]-->
		  </head>
	
		  <body ">
			<div class="container">	
				<?  require('../barrainicio.php'); ?>
				<?  require('../barramenu.php'); ?>




            	<div class="row"><!--En la vista de usuarios solo hay 1 fila, 1 tabla con el menu y 1 tabla de sus webs-->

					<div class="col-xs-12 col-sm-6 col-md-3"><!-- Esta es la tabla del menu-->
        	 			<div id="girando">GW</div>
                        <span class='glyphicon glyphicon-user'></span>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $_SESSION['nombreusuario'].", ". $_SESSION['idusuario'];?>
                     	<ul class="list-group" >
                   			<?php
							echo "<li class='list-group-item'><a href='http://www.gestorwebs.tipolisto.es/gestionarusuarios.php?accion=4&idusuario=$_SESSION[idusuario]' >Mis datos</a></li>";
							?>
                            <li class="list-group-item"><a href='http://www.gestorwebs.tipolisto.es/usuarios/usuariosgestionarcategorias.php' >Gestionar mis categorias</a></li>
                            <li class="list-group-item"><a href='http://www.gestorwebs.tipolisto.es/usuarios/usuariosgestionarwebs.php'  >Gestionar mis webs</a></li>
                        </ul>
                    	<?php
						//if($_SESSION['nivelaccesousuario']==3 && $_SERVER["PHP_SELF"]!="/usuarios/usuariosgestionarcategorias.php"){
						if($_SESSION['nivelaccesousuario']==3 ){
							echo "<span style='color:red'>Tus categorias</span>";
							dibujarLayoutCategoriasUsuarios();
						}
						
						?>
					</div><!--fin de la tabla del menu de usuario-->
    				<div class="col-xs-12 col-sm-10 col-md-9"><!-- tabla con las webs del usuario-->
       				 <?php
					//if(isset($_GET['mensaje'])) echo "<h4><span class='label label-danger'>".$_GET['mensaje']."</span></h4>";
				
				
		}
		function dibujarPaginaAbajoUsuarios(){
?>
           			</div><!--final del div central que contiene  la tabla con las webs-->
       			</div> <!-- final de la fila que contiene la tabla del menu y la tabla con las webs-->
                
                <hr>
				<!--<footer>
                   <br /><br /><br /><br /><p>&copy; Tipolisto.es 2015</p>
                </footer>-->
         </div> <!-- final del container -->
        
        
            <!-- Bootstrap core JavaScript
            ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <script src="../js/bootstrap.min.js"></script>
            <script language="javascript" src="../js/micodigo.js"></script>
            <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
            <script src="js/ie10-viewport-bug-workaround.js"></script>
          </body>
        </html>
        
        
        
        
        
        
<?php
		}
		
?>