<?php

//Necesitamos una conexión a la base de datos
require_once( "app/Conexion.php" );
//Necesitamos trabajar con el modelo Fotos
require_once( "app/RepositorioFotos.php" );
//Para las rutas
require_once( "app/config.php" );
require_once( "app/ControlSesion.php" );
Conexion::abrir_conexion();
$conexion = Conexion::obtener_conexion();
$user='';
if(ControlSesion::comprobar_sesion_iniciada()){
	$user=$_SESSION['nombre'];
}else{
	$user="Anónimo_" . $_SERVER[ 'REMOTE_ADDR' ];
}
$fotos = RepositorioFotos::getAllUser( $conexion ,$user);

Conexion::cerrar_conexion();




//Pintamos el inicio del documento
include_once( "views/layouts/document-start.inc.php" );
?>
<div class="container">
	<br>
	<form class="form-inline" method="post">
		<!--<label class="sr-only" for="inlineFormInput">Nombre</label>-->
		<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="inlineFormInput" id='name' name='name' placeholder="Nombre">
		<button type="submit" class="btn btn-primary" id='botonFormularioInsertarFoto' name='botonFormularioInsertarFoto'>Buscar</button>
	</form>
	<br>

<?php
	
if ( empty( $fotos ) )echo "<div class='container'><br><br><br><p><b>No hay fotos.</b></p></div>";
else {

	?>
	
		<?php
		//$inicio=1;
		$TOTAL_FOTOS = count( $fotos );
		$FOTOS_POR_PAGINA = 5;
		$PAGINAS = $TOTAL_FOTOS / $FOTOS_POR_PAGINA;
		if ( isset( $_GET[ 'pagina' ] ) ) {
			$inicio = $PAGINAS * $_GET[ 'pagina' ];
		} else {
			$inicio = 0;
		}
		$final = $inicio + $FOTOS_POR_PAGINA;
		//echo "<p>Fotos de la ".$inicio." a la ".$final."</p>";
		echo "<nav aria-label='Page navigation example'>";
		echo "<ul class='pagination'>";
		for ( $i = 1; $i <= $PAGINAS; $i++ ) {
			if ( $i == 1 ) {
				echo "<li class='page-item'><a class='page-link' href='" . $_SERVER[ 'PHP_SELF' ] . "'>" . $i . "</a></li>";
			} else {
				echo "<li class='page-item'><a class='page-link' href='" . $_SERVER[ 'PHP_SELF' ] . "?pagina=" . $i . "'>" . $i . "</a></li>";
			}
		}
		echo "</ul>";
		echo "</nav>";
		?>

		<table class="table">
			<thead>
				<tr>
					<th><i class='fa fa-eye' aria-hidden='true'></i> Nombre </th>
					<th>Texto</th>
					<th>Tipo</th>
					<th>Dirección</th>
					<th>Ciudad</th>
					<th>Coordenadas</th>
					<th>Usuario</th>
					<th>Fecha</th>
					<th>Action </th>
				</tr>
			</thead>
			<tbody>
				<?php





				for ( $contador = 0; $contador < count( $fotos ); $contador++ ) {
					if ( $contador >= $inicio && $contador <= $final ) {
						$foto = $fotos[ $contador ];
						echo "<tr>";
						echo "<td>";
						echo "<a href='" . RUTA_VER_FOTO . "/" . $foto->getId() . "'> " . substr( $foto->getName(), 0, strlen( $foto->getName() ) - 4 ) . "<br>";
						echo "<img width='100px' src='../../resources/imagesusers/" . $foto->getUser() . "/foto/" . $foto->getName() . "' alt='" . $foto->getName() . "'></a>";
						echo "</td>";
						//ml2br se utiliza para que php genere los saltos de línea que por defecto no són detectados en php
						echo "<td>" . nl2br($foto->getText()) . "</td>";
						echo "<td>" . $foto->getType() . "</td>";
						echo "<td>" . $foto->getAddress() . "</td>";
						echo "<td>" . $foto->getCity() . "</td>";
						//echo "<td>".$foto->getCountry."</td>";
						echo "<td>" . $foto->getLat() . "," . $foto->getLng() . "</td>";
						echo "<td>" . $foto->getUser() . "</td>";
						echo "<td>" . $foto->getTimeStamp() . "</td>";
						echo "<td><a href='" . RUTA_EDITAR_FOTO . "/" . $foto->getId() . "'><i class='fa fa-pencil-square-o' aria-hidden='true'></i> Editar</a>  <a href='" . RUTA_BORRAR_FOTO . "/" . $foto->getId() . "' ><i class='fa fa-eraser' aria-hidden='true'></i> Borrar</a></td>";
						echo "</tr>";
					}
				}





				?>
			</tbody>
		</table>
		<?php
		echo "<nav aria-label='Page navigation example'>";
		echo "<ul class='pagination'>";
		for ( $i = 1; $i <= $PAGINAS; $i++ ) {
			if ( $i == 1 ) {
				echo "<li class='page-item'><a class='page-link' href='" . $_SERVER[ 'PHP_SELF' ] . "'>" . $i . "</a></li>";
			} else {
				echo "<li class='page-item'><a class='page-link' href='" . $_SERVER[ 'PHP_SELF' ] . "?pagina=" . $i . "'>" . $i . "</a></li>";
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