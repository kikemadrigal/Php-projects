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
		<meta name="keywords" content="Gestor webs, páginas web, websites, manager websites" />">
        
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
	





	


	function dibujarLayoutComentariosCategoria(){
		echo "<div class='divcomentarioscategoria'>";
			echo "<h3>Comentarios  de categorias no validados<br /></h3>";
			$basededatos= new Mysql();
			$basededatos->conectar_mysql();
			$consulta= "SELECT * FROM comentarioscategoria WHERE validadocomentariocategoria=0 ORDER BY fechacomentariocategoria";
			$resultado=$basededatos->ejecutar_sql($consulta);
			echo "<ul style='list-style:none'>";
					while ($linea = mysqli_fetch_array($resultado)) 
					{
							echo "<a href=gestionarcomentarioscategoria.php?accion=2&codigoValidacion=$linea[idcomentariocategoria]> Identificador: ".$linea['idcomentariocategoria'].", nombre: ".$linea['nombrecomentariocategoria'].", texto: ".$linea['textocomentariocategoria']."</a><br />";
					}
					$basededatos->desconectar();
			echo "</ul>";
		echo "</div>";
	}
	
	function validarUnComentarioCategoria($codigoValidacion, $idCategoria){
		echo "<div class='divcomentarioscategoria'>";
			//echo "<h3>Pincha Si o No<br /></h3>";
			$basededatos= new Mysql();
			$basededatos->conectar_mysql();
			$consulta= "SELECT * FROM comentarioscategoria WHERE validadocomentariocategoria=0 && idcomentariocategoria='".$codigoValidacion."' ORDER BY fechacomentariocategoria";
			$resultado=$basededatos->ejecutar_sql($consulta);
			if(mysqli_num_rows($resultado)==0){
				 echo "Este comentario de una categoria ya ha sido validada, borra el mensaje de correo.";
			}
			echo "<ul style='list-style:none'>";
					while ($linea = mysqli_fetch_array($resultado)) 
					{
							echo "<p>Identificador: ".$linea['idcomentariocategoria']."</p><p>Nombre: ".$linea['nombrecomentariocategoria']."</p><p>Texto: ".$linea['textocomentariocategoria']."</p>";
							echo "<p><a href='gestionarcomentarioscategoria.php?idComentarioCategoria=$codigoValidacion&accion=3&idCategoria=$idCategoria' target='_blank'>SI para grabarlo</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p><a href=gestionarcomentarioscategoria.php?idComentarioCategoria=$codigoValidacion&accion=4&idCategoria=$idCategoria>NO para borrarlo definitivamente</a>";
					}
					$basededatos->desconectar();
			echo "</ul>";
		echo "</div>";
	}
	
	
	
	if (!isset($_GET['accion'])){
		dibujarLayoutComentariosCategoria();
	}
	if($_GET['accion']==2){
		validarUnComentarioCategoria($_GET['codigoValidacion'], $_GET['idCategoria']);
	}else if($_GET['accion']==3){
		$mensaje="Comentario de la categoria: ".$_GET['idCategoria']." validado!!!";
		$bd= new Mysql();
		$bd->conectar_mysql();
		$sql="update comentarioscategoria set validadocomentariocategoria=1 where idcomentariocategoria='".$_GET[idComentarioWeb]."'";
		$bd->ejecutar_sql($sql);
		$bd->desconectar();
		echo "<script type='text/javascript'>location.href='gestionarwebs.php?idCategoria=$_GET[idCategoria]&mensaje=$mensaje'</script>";
	}else if($_GET['accion']==4){
		$mensaje="Mensaje de la categoria ".$_GET['idCategoria']." borrado.";
		$bd= new Mysql();
		$bd->conectar_mysql();
		$sql="DELETE FROM comentarioscategoria WHERE idcomentariocategoria='".$_GET[idComentarioCategoria]."' LIMIT 1";
		$bd->ejecutar_sql($sql);
		$bd->desconectar();
		echo "<script type='text/javascript'>location.href='gestionarwebs.php?idCategoria=$_GET[idCategoria]&mensaje=$mensaje';</script>";
	}

	

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
        