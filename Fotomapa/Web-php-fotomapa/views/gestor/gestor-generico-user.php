<?php

require_once('app/Conexion.php');
require_once('app/ObtenerUsuario.php');
require_once('app/RepositorioFotos.php');
		
Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();
$totalFotosDeUnUsuario=RepositorioFotos::getTotalWithNameUser($conexion,ObtenerUsuario::get());
$totalFotosValidadas=RepositorioFotos::getTotalValidatesWithNameUser($conexion,ObtenerUsuario::get());
$totalFotosNoValidadas=RepositorioFotos::getTotalNotValidatesWithNameUser($conexion,ObtenerUsuario::get());
Conexion::cerrar_conexion();
//echo "<h1>Usuario: ".ObtenerUsuario::get()."-->".$totalFotosDeUnUsuario."</h1>";
?>



<div class="row text-center">
	<div class="col-md-4" id='divGestorFotos'>
		<br>	
		<h5><i class="fa fa-camera"></i></h5><h5>Fotos</h5>
		<hr style="border-width: medium; background-color: white;">
		<h6><?php echo $totalFotosDeUnUsuario; ?></h6>
		<h5>Fotos subidas</h5>
		<br>
		<h6><?php echo $totalFotosValidadas; ?></h6>
		<h5>Fotos validadas</h5>
		<br>
		<h6><?php echo $totalFotosNoValidadas; ?></h6>
		<h5>Fotos no validadas</h5>
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


	<div class="col-md-4" id='divGestorFotos'>
		<br>	
		<h5><i class="fa fa-images"></i></h5><h5>Álbunes</h5>
		<hr style="border-width: medium; background-color: white;">
		<h6>0</h6>
		<h5>Creados</h5>
		<br>
		<h6>0</h6>
		<h5>Otro</h5>
		<br>
		<h6>0</h6>
		<h5>Otro</h5>
		<br>
	</div>
	<div class="col-md-4" id='gestor-generico-comentarios'>
		<br>	
		<h5><i class="fa fa-coffee"></i></h5><h5>Blabla</h5>
		<hr style="border-width: medium; background-color: white;">
		<h6>0</h6>
		<h5>Creados</h5>
		<br>
		<h6>0</h6>
		<h5>Otro</h5>
		<br>
		<h6>0</h6>
		<h5>Otro</h5>
		<br>
	</div>
	<div class="col-md-4" id='gestor-generico-favoritos'>
		<br>	
		<h5><i class="fa fa-bath"></i></h5><h5> Blabla 2</h5>
		<hr style="border-width: medium; background-color: white;">
		<h6>0</h6>
		<h5>Creados</h5>
		<br>
		<h6>0</h6>
		<h5>Otro</h5>
		<br>
		<h6>0</h6>
		<h5>Otro</h5>
		<br>
	</div>
</div>