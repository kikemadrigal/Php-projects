<div class="container">
	<div class="row">
		<div class="col-sm-3 col-md-2 sidebar">
			<ul class="navbar-nav">
				<?php
					require_once('app/RepositorioUsuario.php');
					require_once('app/ObtenerUsuario.php');
					require_once('app/Conexion.php');
					Conexion::abrir_conexion();
					if(RepositorioUsuario::obtener_tipo_por_nombre(Conexion::obtener_conexion(),ObtenerUsuario::get())==='administrador'){
						?>
						<li class="nav-item"><a class="nav-link" href="<?php echo RUTA_GESTOR_GENERICO_ADM; ?>"><i class="fa fa-unlock-alt"></i> Administrar</a></li>
						<li class="nav-item"><a class="nav-link" href="<?php echo RUTA_GESTOR_FOTOS_ADM; ?>"><i class="fa fa-image"></i> Fotos</a></li>
						<li class="nav-item"><a class="nav-link" href="<?php echo RUTA_GESTOR_USUARIOS_ADM; ?>"><i class="fa fa-users"></i> Usuarios</a></li>
						<li class="nav-item"><a class="nav-link" href="<?php echo RUTA_GESTOR_COMENTARIOS_ADM; ?>"><i class="fa fa-comments"></i> Comentarios</a></li>
						<li class="nav-item"><a class="nav-link" href="<?php echo RUTA_GESTOR_FAVORITOS_ADM; ?>"><i class="fa fa-star"></i> Favoritos</a></li>
						<li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-map"></i> Mapa</a></li>
						<li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-image"></i> Carrusel</a></li>
						<?php
					}else{
				?>
					<li class="nav-item">
						<a href="<?php echo RUTA_GESTOR; ?>" class="nav-link">Gestor</a>
					</li >
					<li class="nav-item">
						<a href="<?php echo RUTA_GESTOR_FOTOS_USUARIO; ?>" class="nav-link">Fotos</a>
					</li >
					<li class="nav-item">
						<a href="<?php echo RUTA_GESTOR_COMENTARIOS_USUARIO; ?>" class="nav-link">Comentarios</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo RUTA_GESTOR_FAVORITOS_USUARIO; ?>" class="nav-link">Favoritos</a>
					</li>
				<?php
				}
				?>
			</ul>
		</div>
		<div class="col-sm-9 col-md-10 main">
		<!--Se queda sin cerrar, se cerrará en control-panel-end.php-->
