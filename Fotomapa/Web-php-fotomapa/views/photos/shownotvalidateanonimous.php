<?php
require_once( "app/config.php" );
require_once( "app/Conexion.php" );
require_once( "app/ControlSesion.php" );
require_once( "app/RepositorioFotos.php" );
require_once( "app/RepositorioUsuario.php" );
require_once( "app/ObtenerUsuario.php" );
require_once( "app/Foto.php" );
Conexion::abrir_conexion();
//Obtenemos el tipo de usuario
$tipoDeUsuario=RepositorioUsuario::obtener_tipo_por_nombre(Conexion::obtener_conexion(),ObtenerUsuario::get());
if($tipoDeUsuario!=='administrador'){
	$mensaje = "Página no encontrada";
	echo "<script type='text/javascript'>location.href='http://fotomurcia.tipolisto.es/404.php'</script>";
	die();
}
//Obtenemos las fotos de los usuarios anónimos no validadas
$fotos = RepositorioFotos::getArrayPhotosNotValidateAnonimousUser(Conexion::obtener_conexion());			
Conexion::cerrar_conexion();




//Pintamos el inicio del documento
include_once( "views/layouts/document-start.inc.php" );
?>
<div class="container">
	<div class="row text-center">
		<div class="col-md-12">
			<h5>Fotos no validadas de usuarios anónimos</h5>
		</div>
	</div>	

<?php
if ( empty( $fotos ) )echo "<div class='container'><br><br><br><p><b>No hay fotos.</b></p></div>";
else {

	?>
	
		<?php
		//$inicio=1;
		$TOTAL_FOTOS = count( $fotos );
		$FOTOS_POR_PAGINA = 5;
		$PAGINAS = $TOTAL_FOTOS / $FOTOS_POR_PAGINA;
		if ( isset( $pagina ) ) {
			$inicio = $PAGINAS * $pagina;
		} else {
			$inicio = 0;
		}
		$final = $inicio + $FOTOS_POR_PAGINA;
		//echo "<p>Fotos de la ".$inicio." a la ".$final."</p>";
		echo "<nav aria-label='Page navigation example'>";
		echo "<ul class='pagination'>";
		for ( $i = 1; $i < $PAGINAS; $i++ ) {
			if ( $i == 1 ) {
				echo "<li class='page-item'><a class='page-link' href='" . RUTA_VER_TODAS_LAS_FOTOS . "'>" . $i . "</a></li>";
			} else {
				echo "<li class='page-item'><a class='page-link' href='" . RUTA_VER_TODAS_LAS_FOTOS . "/" . $i . "'>" . $i . "</a></li>";
			}
		}
		echo "</ul>";
		echo "</nav>";
		?>

		<table class="table">
			<thead>
				<tr>
					<th>¿Validada?</th>
					<th><i class='fa fa-eye' aria-hidden='true'></i> Nombre </th>
					<th>Texto</th>
					<th>Tipo</th>
					<th>Dirección</th>
					<th>Ciudad</th>
					<th>Usuario</th>
					<th>Fecha</th>
					<?php
					if($tipoDeUsuario==='administrador'){
						echo "<th>&nbsp;</th><th>&nbsp;</th>";
					}
					?>
					
				</tr>
			</thead>
			<tbody>
				<?php
				for ( $contador = 0; $contador < count( $fotos ); $contador++ ) {
					if ( $contador >= $inicio && $contador < $final ) {
						$foto = $fotos[ $contador ];
						echo "<tr>";
						echo "<td>";
						if($foto->getValidada()===10) $validada='Si';
						else{
							$validada='No';
							echo "<p>".$validada."</p>";
							?>
							<form method="post" action="<?php echo RUTA_VALIDAR_FOTO; ?> " style="display: inline">
								<input type="hidden" name="idFoto" value="<?php echo $foto->getId(); ?>">
								<button type='submit' name='validarFoto' class='btn btn-primary btn-sm'>Validar</button>
							</form>
							<?php
						} 
						echo "</td>";
						echo "<td>";
						echo "<a href='" . RUTA_VER_FOTO . "/" . $foto->getId() . "'> " . substr( $foto->getName(), 0, strlen( $foto->getName() ) - 4 ) . "<br>";
						echo "<img width='100px' src='../../resources/imagesusers/" . $foto->getUser() . "/foto/" . $foto->getName() . "' alt='" . $foto->getName() . "'></a>";
						echo "</td>";
						echo "<td>" . nl2br($foto->getText()) . "</td>";
						echo "<td>" . $foto->getType() . "</td>";
						echo "<td>" . $foto->getAddress() . "</td>";
						echo "<td>" . $foto->getCity() . "</td>";
						echo "<td>" . $foto->getUser() . "</td>";
						echo "<td>" . $foto->getTimeStamp() . "</td>";
			
						if($tipoDeUsuario==='administrador'){
							?>
							<td>
							<form method="post" action="<?php echo RUTA_EDITAR_FOTO; ?> " style="display: inline">
								<input type="hidden" name="idFoto" value="<?php echo $foto->getId(); ?>">
								<button type='submit' name='editarFoto' class='btn btn-success btn-sm'>Editar</button>
							</form>
							</td>
							<td>
							<form method="post" action="<?php echo RUTA_BORRAR_FOTO; ?> "  style="display: inline">
								<input type="hidden" name="idFoto" value="<?php echo $foto->getId(); ?>">
								<button type='submit' name='editarFoto' class='btn btn-danger btn-sm'>Borrar</button>
							</form>
							</td>
							<?php
						}
					}
				}
				?>
			</tbody>
		</table>
		<?php
		echo "<nav aria-label='Page navigation example'>";
		echo "<ul class='pagination'>";
		for ( $i = 1; $i < $PAGINAS; $i++ ) {
			if ( $i == 1 ) {
				echo "<li class='page-item'><a class='page-link' href='" .RUTA_VER_TODAS_LAS_FOTOS. "'>" . $i . "</a></li>";
			} else {
				echo "<li class='page-item'><a class='page-link' href='" . RUTA_VER_TODAS_LAS_FOTOS . "?pagina=" . $i . "'>" . $i . "</a></li>";
			}
		}
		echo "</ul>";
		echo "</nav>";

		?>
	</div>

	<?php
}
include_once( "views/layouts/document-end.inc.php" );
?>