<div class="container">

	<?php
	Conexion::abrir_conexion();
	$conexion = Conexion::obtener_conexion();
	$fotos = RepositorioFotos::getAll( $conexion );
	Conexion::cerrar_conexion();
	if ( count( $fotos ) == 0 ) {
		echo "No hay fotos.";
	} else {
		//echo "<h1>Contador ".count( $fotos )."</h1>";
		$contador=0;
		echo "<div id='carouselExampleSlidesOnly' class='carousel slide' data-ride='carousel'>";
		echo "<div class='carousel-inner'>";
			foreach ( $fotos as $foto ) {
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
				if($contador===1){
					echo "<div class='carousel-item active'>";
						echo "<img class='d-block w-100' src='resources/imagesusers/" . $foto->getUser() . "/" . $foto->getName() . "' alt='" . $foto->getName() . "'>";
					echo "</div>";
				}else{
					echo "<div class='carousel-item'>";
						echo "<img class='d-block w-100' src='resources/imagesusers/" . $foto->getUser() . "/" . $foto->getName() . "' alt='" . $foto->getName() . "'>";
					echo "<div class='carousel-caption d-none d-md-block'>";
    					echo "<h5>".$foto->getText."</h5>";
    					echo "<span style='background-color: white; color: black'>".$foto->getAddress().", ".$foto->getCity().", ".$foto->getTimeStamp()."</span>";	
					echo "</div>";
					echo "</div>";
				}
				$contador=$contador+1;
		
			}
		echo " </div>";
		echo "<a class='carousel-control-prev' href='#carouselExampleControls' role='button' data-slide='prev'>";
		echo "<span class='carousel-control-prev-icon' aria-hidden='true'></span>";
		echo "<span class='sr-only'>Previous</span>";
	    echo "</a>";
	    echo "<a class='carousel-control-next' href='#carouselExampleControls' role='button' data-slide='next'>";
		echo "<span class='carousel-control-next-icon' aria-hidden=vtrue'></span>";
		echo "<span class='sr-only'>Next</span>";
	    echo "</a>";
		echo "</div>";
	}
	?> 





</div>