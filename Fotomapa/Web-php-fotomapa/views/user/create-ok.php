<?php
//Archivos necesarios para trabajar:
//	App tiene las rutas
require_once( "app/config.php" );
//	Conexion conecta con la base de datos
require_once( "app/Conexion.php" );
//	Repositorio usuario tiene todas las consultas a usuarios
require_once( "app/RepositorioUsuario.php" );
require_once( "app/Usuario.php" );

 /*if(isset($nombreUsuario) && !empty($nombreUsuario)){
	 $nombre=$nombreUsuario;
 }else{
	 header ('Location: '.RUTA_SERVER, true, 301);
 }*/

$titulo='Registro-ok';
//	Cabecera html
include_once( "views/layouts/document-start.inc.php" );
//	Barra de navegacion
include_once( "views/layouts/navbar.inc.php" );
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<p></p>
				</div>
				<div class="panel-body text-center">
					<p>Gracias por registrarte <b><?php echo $nombreUsuarioNuevoRegistrado; ?></b></p>
					<br>
					<p><a href="<?php echo RUTA_LOGIN; ?>">Inicia sesión para comenzar a usar tu cuenta</a></p>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

//Final html
include_once( "views/layouts/document-end.inc.php" );
?>