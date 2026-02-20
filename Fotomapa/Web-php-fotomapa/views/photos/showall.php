<?php
require_once( "app/config.php" );
require_once( "app/Conexion.php" );
require_once( "app/ControlSesion.php" );
require_once( "app/RepositorioFotos.php" );
require_once( "app/RepositorioUsuario.php" );
require_once( "app/ObtenerUsuario.php" );


Conexion::abrir_conexion();
$conexion = Conexion::obtener_conexion();
if ( isset( $_POST[ 'botonFormularioBuscarFoto' ] ) ) {
	$fotos = RepositorioFotos::getWithName( $conexion, $_POST[ 'name' ] );
} else {
	$fotos = RepositorioFotos::getAll( $conexion );
}

//Obtenemos el tipo de usuario
$tipoDeUsuario=RepositorioUsuario::obtener_tipo_por_nombre(Conexion::obtener_conexion(),ObtenerUsuario::get());
	//echo "<h1>".$tipoDeUsuario."</h1>";				
Conexion::cerrar_conexion();




//Pintamos el inicio del documento
include_once( "views/layouts/document-start.inc.php" );
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<form class="form-inline" method="post">
				<label class="sr-only" for="botonFormularioBuscarFoto">Buscar</label> 
				<input type="text" class="form-control col-md-6" id="inlineFormInput" id='name' name='name' placeholder="Nombre">
				&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-primary" id='botonFormularioBuscarFoto' name='botonFormularioBuscarFoto'>Buscar</button>
			</form>
		</div>
	</div>

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
			echo "<li class='page-item'><a class='page-link' href='" . RUTA_VER_TODAS_LAS_FOTOS . "/" . $i . "'>" . ($i+1) . "</a></li>";
		
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
					<th>&nbsp;</th><th>&nbsp;</th>
					
					
					
				</tr>
			</thead>
			<tbody>
				<?php
				for ( $contador = 0; $contador < count( $fotos ); $contador++ ) {
					if ( $contador >= $inicio && $contador < $final ) {
						$foto = $fotos[ $contador ];
						/**************Rollo datos estructurados de schema y utilizando Json ltd**********************/
						?>
						<script type="application/ld+json">"@context": "http://schema.org",
							"@type": "ImageObject",
							"author": "<?php echo $foto->getUser();?>",
							"contentLocation": "<?php echo $foto->getAddress();?>, <?php echo $foto->getCity();?>, <?php echo $foto->getCountry();?>",
							"contentUrl": "<?php echo $foto->getName();?>",
							"datePublished": "<?php echo $foto->getTimeStamp();?>",
							"description": "<?php echo $foto->getText();?>",
							"name": "<?php echo $foto->getName();?>"
							
						</script>
						<?php
						/*********************Fin de rollo datos estructurados**********************************/

						echo "<tr>";
						echo "<td>";
						echo "<a href='" . RUTA_VER_FOTO . "/" . $foto->getId() . "'>";
						echo "<img width='100px' src='../../resources/imagesusers/" . $foto->getUser() . "/" . $foto->getName() . "' alt='" . $foto->getName() . "'><br> " . substr( $foto->getName(), 0, strlen( $foto->getName() ) - 4 ) . "</a>";
						echo "</td>";
						//ml2br se utiliza para que php genere los saltos de línea que por defecto no són detectados en php
						echo "<td>" . nl2br($foto->getType()) . "</td>";
						echo "<td>" . nl2br($foto->getText()) . "</td>";
						echo "<td>" . $foto->getAddress() . "</td>";
						echo "<td>" . $foto->getCity() . "</td>";
						//echo "<td>".$foto->getCountry."</td>";
						//echo "<td>" . $foto->getLat() . "," . $foto->getLng() . "</td>";
						echo "<td>" . $foto->getUser() . "</td>";
						echo "<td>" . $foto->getTimeStamp() . "</td>";
						//Si es el creador de la foto
						Conexion::abrir_conexion();
						$conexion = Conexion::obtener_conexion();
						if ( Repositoriousuario::obtener_nombre_de_usuario_por_id($conexion,$foto->getUser()) == ControlSesion::getNameUsuario() ){
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
						}else{
							echo "<td>&nbsp;</td><td>&nbsp;</td>";
						}
						Conexion::cerrar_conexion();
						?>
						
						
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
			echo "<li class='page-item'><a class='page-link' href='" . RUTA_VER_TODAS_LAS_FOTOS . "/" . $i . "'>" . ($i+1) . "</a></li>";
		
		}
		echo "</ul>";
		echo "</nav>";

		?>
	</div>

	<?php
}
include_once( "views/layouts/document-end.inc.php" );
?>