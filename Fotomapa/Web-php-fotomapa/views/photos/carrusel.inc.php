<div class="container">

	<?php
	Conexion::abrir_conexion();
	$conexion = Conexion::obtener_conexion();
	$fotos = RepositorioFotos::getAll( $conexion );
	Conexion::cerrar_conexion();
	$contadorLi=0;
	$contadorImagenes=0;
	if ( count( $fotos ) == 0 ) {
		echo "No hay fotos.";
	} else { 
	?>
		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
		  <ol class="carousel-indicators">
		  	<?php foreach ( $fotos as $foto ) { ?>
		  		<?php if($contadorLi==0) { ?>
		  			<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $contador; ?>" class="active"></li>
		  		<?php } ?>
		    <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $contador; ?>"></li>
		    <?php $contadorLi++; } ?>
		  </ol>
		  <div class="carousel-inner">
		  	<?php foreach ( $fotos as $foto ) { ?>
		  		<?php if($contadorImagenes==0) { ?>
			  		<div class="carousel-item  active">
				      <img class="d-block w-100" src="resources/imagesusers/<?php echo $foto->getUser(); ?>/<?php echo $foto->getName();?>" alt="<?php echo $foto->getName(); ?>">
				    </div>
			    <?php } ?>
			    <div class="carousel-item">
			      <img class="d-block w-100" src="resources/imagesusers/<?php echo $foto->getUser(); ?>/<?php echo $foto->getName();?>" alt="<?php echo $foto->getName(); ?>">
			      <div class='carousel-caption d-none d-md-block'>
    				<h5><?php echo $foto->getText(); ?></h5>
    				<span style='background-color: white; color: black'><?php echo $foto->getAddress().", ".$foto->getCity().", ".$foto->getTimeStamp()?></span>	
				  </div>
			    </div>
		    <?php $contadorImagenes++; } ?>
		  </div>
		  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
		    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
		    <span class="carousel-control-next-icon" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>
		</div>
	<?php
	}
	?> 





</div>