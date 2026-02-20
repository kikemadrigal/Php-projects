<?php
require_once( "app/config.php" );
require_once( "app/Conexion.php" );
require_once( "app/ControlSesion.php" );
require_once( "app/RepositorioFotos.php" );
require_once( "app/RepositorioUsuario.php" );
require_once( "app/ObtenerUsuario.php" );
//Obtenemos el tipo de usuario
$tipoDeUsuario=RepositorioUsuario::obtener_tipo_por_nombre(Conexion::obtener_conexion(),ObtenerUsuario::get());
if($tipoDeUsuario!=='administrador'){
	echo "<script type='text/javascript'>location.href='http://fotomurcia.tipolisto.es/404.php'</script>";
	die();
}

Conexion::abrir_conexion();
$conexion = Conexion::obtener_conexion();
if ( isset( $_POST[ 'botonFormularioBuscarFoto' ] ) ) {
	$fotos = RepositorioFotos::getWithName( $conexion, $_POST[ 'name' ] );
} else {
	$fotos = RepositorioFotos::getAll( $conexion );
}


	//echo "<h1>".$tipoDeUsuario."</h1>";				
Conexion::cerrar_conexion();




//Pintamos el inicio del documento
include_once( "views/layouts/document-start.inc.php" );
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<form class="form-inline" method="post" action="<?php echo RUTA_GESTOR_FOTOS_VER_TODAS_ADM; ?>">
				<label class="sr-only" for="botonFormularioBuscarFoto">Buscar</label> 
				<input type="text" class="form-control col-md-6" id="inlineFormInput" id='name' name='name' placeholder="Nombre">
				&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-primary" id='botonFormularioBuscarFoto' name='botonFormularioBuscarFoto'>Buscar</button>
			</form>
		</div>
	</div>
	<br>
	<div class="text-center">Administrar fotos</div>
	<br>

<?php
if ( empty( $fotos ) )echo "<div class='container'><br><br><br><p><b>No hay fotos.</b></p></div>";
else {

	?>
	
		<?php
		
		$TOTAL_FOTOS = count( $fotos );
		$FOTOS_POR_PAGINA = 4;
		$PAGINAS = ceil($TOTAL_FOTOS / $FOTOS_POR_PAGINA);
		if ( isset( $pagina ) ) {
			$inicio = $FOTOS_POR_PAGINA*$pagina;
		} else {
			$inicio = 0;
			$pagina=1;
		}
		$final = $inicio + $FOTOS_POR_PAGINA;
		echo "<p>Total fotos: ".$TOTAL_FOTOS.", páginas: ".$PAGINAS.", fotos por página: ".$FOTOS_POR_PAGINA;
		echo ", Ver de la foto ".($inicio+1).", hasta la ".$final."</p>";
		echo "<nav aria-label='Page navigation example'>";
		echo "<ul class='pagination'>";
		for ( $i = 0; $i < $PAGINAS; $i++ ) {
			echo "<li class='page-item'><a class='page-link' href='" . RUTA_GESTOR_FOTOS_VER_TODAS_ADM . "/" . $i . "'>" . ($i+1) . "</a></li>";
		
		}
		echo "</ul>";
		echo "</nav>";
		?>

		<table class="table table-striped">
			<thead>
				<tr>
					<th><i class='fa fa-eye' aria-hidden='true'></i></th>
					<th>Título</th>
					<th>Texto</th>
					<th>Dirección</th>
					<th>Ciudad</th>
					<!--<th>Coordenadas</th>-->
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
						echo "<a href='" . RUTA_VER_FOTO . "/" . $foto->getId() . "'>";
						echo "<img width='100px' src='../../resources/imagesusers/" . $foto->getUser() . "/foto/" . $foto->getName() . "' alt='" . $foto->getName() . "'><br> " . substr( $foto->getName(), 0, strlen( $foto->getName() ) - 4 ) . "</a>";
						echo "</td>";
						//ml2br se utiliza para que php genere los saltos de línea que por defecto no són detectados en php
						echo "<td>" . nl2br($foto->getType()) . "</td>";
						echo "<td>" . nl2br($foto->getText()) . "</td>";
						echo "<td>" . $foto->getAddress() . "</td>";
						echo "<td>" . $foto->getCity() . "</td>";

						echo "<td>" . $foto->getUser() . "</td>";
						echo "<td>" . $foto->getTimeStamp() . "</td>";
						?>
						<td>
						<form method="post" action="<?php echo RUTA_GESTOR_FOTOS_EDITAR_ADM; ?> " style="display: inline">
							<input type="hidden" name="idFoto" value="<?php echo $foto->getId(); ?>">
							<button type='submit' name='editarFoto' class='btn btn-success btn-sm'>Editar</button>
						</form>
						</td>
						<td>
						<form method="post" action="<?php echo RUTA_GESTOR_FOTOS_BORRAR_ADM; ?> "  style="display: inline">
							<input type="hidden" name="idFoto" value="<?php echo $foto->getId(); ?>">
							<button type='submit' name='editarFoto' class='btn btn-danger btn-sm'>Borrar</button>
						</form>
						</td>
						<?php
					}
				}
				?>
			</tbody>
		</table>
		<?php
		echo "<nav aria-label='Page navigation example'>";
		echo "<ul class='pagination'>";
		for ( $i = 0; $i < $PAGINAS; $i++ ) {
			echo "<li class='page-item'><a class='page-link' href='" . RUTA_GESTOR_FOTOS_VER_TODAS_ADM . "/" . $i . "'>" . ($i+1) . "</a></li>";
		
		}
		echo "</ul>";
		echo "</nav>";

		?>
	</div>

	<?php
}
include_once( "views/layouts/document-end.inc.php" );
?>