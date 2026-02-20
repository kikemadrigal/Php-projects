<?php
session_start();
if ($_SESSION["claveusuario"] !="1c558dfd6f4148767d40386fa7b59c18e3b8627e") {
    header("Location: ../noautorizado.php?mensaje=$mensaje");
   exit();
}
	function dibujarhtmladministrador(){
			?>
			<!DOCTYPE html>
			<html lang="en">
			<head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
                <meta name="description" content="gestinar paginas web">
                <meta name="author" content="tipolisto">
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
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-2">
        	 			<div id="girando">GW</div>
                        <ul class="nav navbar-nav" >
                            <li><a href='http://www.gestorwebs.tipolisto.es/adm/admgestionarusuarios.php'  >Gestionar usuarios</a></li>
                            <li><a href='http://www.gestorwebs.tipolisto.es/adm/admcategorias.php'  >Gestionar categorias</a></li>
                            <li><a href='http://www.gestorwebs.tipolisto.es/adm/admgestionarwebs.php'>Gestionar webs</a></li>
                             <li><a href='http://www.gestorwebs.tipolisto.es/adm/admgestionarpasear.php'  >Gestionar pasear</a></li>
                            <li><a href='http://www.gestorwebs.tipolisto.es/adm/admgestionarimagenes.php'  >Gestionar imagenes</a></li>
                            <li><a href='http://www.gestorwebs.tipolisto.es/gestionarcomentariosweb.php' >Gestionar comentarios</a></li>
						</ul>   
                    </div>
    		    <div class="col-xs-12 col-sm-10 col-md-10">
                     	
			<?php	
				
		}
		function dibujarPaginaAbajoAdministrador(){
?>
            		</div>
            	</div> <!-- fin de la fila -->
            <hr>
        	
            <footer>
               <!-- <br /><br /><br /><br /><p>&copy; Tipolisto.es 2015</p> -->
            </footer>
            </div> <!-- /container -->
        
        
            <!-- Bootstrap core JavaScript
            ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <script src="../js/bootstrap.min.js"></script>
            <script src="../js/micodigo.js"></script>
            <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
            <script src="../js/ie10-viewport-bug-workaround.js"></script>
          </body>
        </html>
        
        
        
        
        
        
<?php
		}
		
?>