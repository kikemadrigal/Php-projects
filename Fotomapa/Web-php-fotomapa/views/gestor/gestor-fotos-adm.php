<?php
require_once('app/Conexion.php');
require_once('app/config.php');
require_once('app/ObtenerUsuario.php');
require_once('app/RepositorioFotos.php');
require_once('app/Foto.php');
Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();
$fotos=RepositorioFotos::getAll($conexion);
Conexion::cerrar_conexion();
//Si $fotos está vacía
if(empty($fotos) || count($fotos)==0){
	echo "<div class='container'>No hay fotos para mostrar</div>";
}else{
?>



<div class="container">
	<div class="row">
		<div class="col-md-12" id='divGestorFotos'>
			<br>	
			<div class="text-center"><h5><i class="fa fa-camera"></i></h5><h5>Fotos</h5></div>
			<hr style="border-width: medium; background-color: white;">
			<a href="<?php echo RUTA_GESTOR_FOTOS_VER_TODAS_ADM; ?>" >Ver todas</a>
			<a href="<?php echo RUTA_GESTOR_FOTOS_VER_TODAS_ADM; ?>">Buscar Foto</a>
			<a href="<?php echo RUTA_VER_NO_VALIDADAS_DE_ANONIMOS; ?>">Fotos no validadas usuarios anónimos</a>
			<a href="<?php echo RUTA_VER_NO_VALIDADAS_DE_USUARIOS_REGISTRADOS; ?>">Fotos no validadas usuarios registrados</a>
			<br>
	</div>
		</div>
	</div>
</div>

<?php
}//Final de si $fotos está vacía
?>
