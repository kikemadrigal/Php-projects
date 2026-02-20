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








//Si $fotos está vacía
if(empty($fotos) || count($fotos)==0){
	echo "<div class='container'>No hay fotos para mostrar</div>";
}else{

?>
<div class="row parte-gestor-entradas">
	<div class="col-md-12">
		<br>
		<h5>Gestión Fotos</h5>
		<br>
		<a href="<?php echo RUTA_MAPA_USUARIO; ?>" class="btn btn-warning btn-sm" role='button'>Subir una foto</a>
	</div>
</div>
<div class="row parte-gestor-entradas text-center">
	<div class="col-md-12">
<?php
		/*****************Rollo paginación*******/
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
		echo "<ul class='pagination text-center'>";
		for ( $i = 0; $i < $PAGINAS; $i++ ) {
			echo "<li class='page-item'><a class='page-link' href='" . RUTA_GESTOR_FOTOS_USUARIO . "/" . $i . "'>" . ($i+1) . "</a></li>&nbsp;&nbsp;";

		}
		echo "</ul>";
		echo "</nav>";
		/******Fin de rollo paginación*********/
?>
	</div>
</div>	
<div class="row parte-gestor-entradas">
	<div class="col-md-12">
		<!-- table-striped es tabla a rayas-->
		<table class="table table-striped">
			<!--table ghead-->
			<thead>
				<tr>
					<th><i class='fa fa-eye' aria-hidden='true'></i></th>
					<th>Nombre</th>
					<th>Texto</th>
					<th>Dirección</th>
					<th>Fecha</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<!--table body-->
			<tbody>
				<?php
				for ( $contador = 0; $contador < count( $fotos ); $contador++ ) {
					if ( $contador >= $inicio && $contador < $final ) {
						$foto = $fotos[ $contador ];
					echo "<tr>";
						echo "<td><a href='".RUTA_VER_FOTO."/".$foto->getId()."'><img src='http://fotomurcia.tipolisto.es/resources/imagesusers/".$foto->getUser()."/foto/".$foto->getName()."' width='100px'></img></a></td>";
						echo "<td>".$foto->getName()."</td>";
						echo "<td>".$foto->getText()."</td>";
						echo "<td>".$foto->getAddress()."</td>";
						echo "<td>".$foto->getTimeStamp()."</td>";
						echo "<td>";
							?>
							<form method="post" action="<?php echo RUTA_EDITAR_FOTO; ?> ">
								<input type="hidden" name="idFoto" value="<?php echo $foto->getId(); ?>">
								<button type='submit' name='editarFoto' class='btn btn-success btn-sm'>Editar</button>
							</form>
						</td>
						<td>
							<form method="post" action="<?php echo RUTA_BORRAR_FOTO; ?> ">
								<input type="hidden" name="idFoto" value="<?php echo $foto->getId(); ?>">
								<button type='submit' name='editarFoto' class='btn btn-danger btn-sm'>Borrar</button>
							</form>
						</td>
					</tr>
					<?php
					}
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<div class="row parte-gestor-entradas text-center">
	<div class="col-md-12">
		<?php
		echo "<nav aria-label='Page navigation example' class='parte-gestor-entradas'>";
		echo "<ul class='pagination'>";
		for ( $i = 0; $i < $PAGINAS; $i++ ) {
			echo "<li class='page-item'><a class='page-link' href='" . RUTA_GESTOR_FOTOS_USUARIO . "/" . $i . "'>" . ($i+1) . "</a></li>&nbsp;&nbsp;";

		}
		echo "</ul>";
		echo "</nav>";
		}//Final de si $fotos está vacía
		?>
	</div>
</div>