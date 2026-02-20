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

   <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled and minified JavaScript -->
	<script src="js/bootstrap.min.js"></script>
    <!-- Custom styles for this template -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!-- Optional theme -->
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
  	<div class="container">
    
    
    


<div class="page-header">
<?php
	if(isset($_GET['mensaje'])){
		echo"<br />".$_GET['mensaje']."<br />";
	}

?>
<h1>Entrada no autorizada</h1>
</div>








      <footer>
        <p>&copy; Tipolisto.es 2015</p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
