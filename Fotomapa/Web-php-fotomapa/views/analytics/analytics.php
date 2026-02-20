<?php
require_once('app/config.php');

//require_once( "../app/ControlSesion.php" );



$titulo ="Analytycs";
include_once( "views/layouts/document-start.inc.php" );
?>

<!--<frameset rows="20%,80%" border>
  <frame src="analytycs-frame-a.htm"  name="analytycs-frame-a" id="analytycs-frame-a">
  <frame src="https://analytics.google.com" name="analytycs-frame-b" id="analytycs-frame-b">
</frameset>	-->
<div class="container">
	<br><br>
	<h3><a href="https://accounts.google.com/Login?hl=ES" target="_blanck">1.Inicia sesión con esta cuenta, picha aquí</a>, si ya has iniciado sesión con otra cuenta tendrás que cerrar sesión, escribe estos datos:</h3>
	<p>Cuenta: alimisfotos@gmail.com</p>
	<p>Contraseña:alicia52535</p>
	<h3><a href="https://analytics.google.com">2.Una vez, iniciada la sesión, ve a google analytics, picha aquí.</a></h3>

	<p>El usuario administrador será admmisfotos@gamil.com</p>



</div>
<?php
include_once( "views/layouts/document-end.inc.php" );
?>

