<?php
require_once('app/Conexion.php');
require_once('app/config.php');
require_once('app/ObtenerUsuario.php');
require_once('app/RepositorioFotos.php');
require_once('app/Foto.php');
Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();
$fotos=RepositorioFotos::getAllUser($conexion,ObtenerUsuario::get());
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
<div class="col-md-12">
	<br>
	<h5>Gestión Fotos</h5>
	<br>
	<a href="<?php echo RUTA_MAPA_USUARIO; ?>" class="btn btn-warning btn-sm" role='button'>Subir una foto</a>
</div>

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
			echo "<li class='page-item'><a class='page-link' href='" . RUTA_GESTOR_FOTOS_USUARIO . "/" . $i . "'>" . ($i+1) . "</a></li>";
		
		}
		echo "</ul>";
		echo "</nav>";
		?>

		<table class="table table-striped">
			<thead>
				<tr>
					<th><i class="fa fa-thumbs-up"></i></th>
					<th><i class='fa fa-eye' aria-hidden='true'></i> Nombre </th>
					<th>Titulo</th>
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
						echo "<td>0<br>Likes</td>";
						echo "<td>";
						echo "<a href='" . RUTA_VER_FOTO . "/" . $foto->getId() . "'>";
						echo "<img width='100px' src='../../resources/imagesusers/" . $foto->getUser() . "/" . $foto->getName() . "' alt='" . $foto->getName() . "'> <br>" . substr( $foto->getName(), 0, strlen( $foto->getName() ) - 4 ) . "</a>";
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
				?>
			</tbody>
		</table>
		<?php
		echo "<nav aria-label='Page navigation example'>";
		echo "<ul class='pagination'>";
		for ( $i = 0; $i < $PAGINAS; $i++ ) {
			echo "<li class='page-item'><a class='page-link' href='" .RUTA_GESTOR_FOTOS_USUARIO . "/" . $i . "'>" . ($i+1) . "</a></li>";
		
		}
		echo "</ul>";
		echo "</nav>";

		?>
	</div>

	<?php
}
include_once( "views/layouts/document-end.inc.php" );
?>