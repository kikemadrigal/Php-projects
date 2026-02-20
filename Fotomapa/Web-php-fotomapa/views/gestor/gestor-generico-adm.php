<?php

require_once('app/Conexion.php');
require_once('app/ObtenerUsuario.php');
require_once('app/RepositorioFotos.php');
require_once('app/RepositorioUsuario.php');		
Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();
/******************Fotos*********************************/
$totalFotos=RepositorioFotos::getTotal($conexion);
$totalNoValidadasDeUsuariosRegistrados=RepositorioFotos::getTotalNotValidateRegisterUser($conexion);
$totalFotosNoValidadasDeUsuariosAnonimos=RepositorioFotos::getTotalNotValidateAnonymousUser($conexion);
/***************Fin de fotos******************************/
/******************usuarios********************************/
$totalUsuarios=RepositorioFotos::getTotal($conexion);
/***************Fin de usuarios******************************/
Conexion::cerrar_conexion();
//echo "<h1>Usuario: ".ObtenerUsuario::get()."-->".$totalFotosDeUnUsuario."</h1>";
?>



<div class="row text-center">
	<div class="col-md-4" id='divGestorFotos'>
		<br>	
		<h5><i class="fa fa-camera"></i></h5><h5>Fotos</h5>
		<hr style="border-width: medium; background-color: white;">
		<h6><?php echo $totalFotos; ?></h6>
		<h5>Fotos subidas</h5>
		<br>
		<h6><?php echo $totalNoValidadasDeUsuariosRegistrados; ?></h6>
		<h5>Fotos no validadas de usuarios registrados</h5>
		<br>
		<h6><?php echo $totalFotosNoValidadasDeUsuariosAnonimos; ?></h6>
		<h5>Fotos no validadas de usuarios anónimos</h5>
		<br>
	</div>
	<div class="col-md-4" id='gestor-generico-comentarios'>
		<br>
		<h5><i class="fa fa-comments"></i></h5><h5>Comentarios</h5>
		<hr style="border-width: medium; background-color: white;">
		<h6>0</h6>
		<h5>Escritos</h5>
		<br>
		<h6>0</h6>
		<h5>Mensajes privados</h5>
		<br>
		<h6>0</h6>
		<h5>Comentarios con likes</h5>
		<br>
	</div>
	<div class="col-md-4" id='gestor-generico-favoritos'>
		<br>
		<h5><i class="fa fa-star"></i></h5><h5>Favoritos</h5>
		<hr style="border-width: medium; background-color: white;">
		<h6>0</h6>
		<h5>Entradas favoritos</h5>
		<br>
		<h6>0</h6>
		<h5>Autores favoritos</h5>
		<br>
		<h6>0</h6>
		<h5>usuarios favoritos</h5>
		<br>
	</div>
</div>
<br>
<div class="row text-center">
	<div class="col-md-4" id='divGestorFotos'>
		<br>	
		<h5><i class="fa fa-users"></i></h5><h5>Usuarios</h5>
		<hr style="border-width: medium; background-color: white;">
		<h6><?php echo $totalUsuarios; ?></h6>
		<h5>Total usuarios</h5>
		<br>
	</div>
	<div class="col-md-4" id='gestor-generico-comentarios'>
		<br>
		<h5><i class="fa fa-map"></i></h5><h5>Mapa</h5>
		<hr style="border-width: medium; background-color: white;">
		<h6>0</h6>
		<h5>Nada</h5>
		<br>
	</div>
	<div class="col-md-4" id='gestor-generico-favoritos'>
		<br>
		<h5><i class="fa fa-image"></i></h5><h5>Carrusel</h5>
		<hr style="border-width: medium; background-color: white;">
		<h6>0</h6>
		<h5>Nada</h5>
		<br>
		<br>
	</div>
</div>