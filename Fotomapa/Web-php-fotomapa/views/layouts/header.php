<!--
	Archivo que se inluirá en el document-start.inc.php
	Fotomapa.es
	tipolisto.es
-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<a class="navbar-brand" href="<?php echo RUTA_SERVER; ?>"><i class="fa fa-home" aria-hidden="true"></i> Indice</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

	<div class="collapse navbar-collapse" id="navbarText">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item">
				<a class="nav-link" href="<?php echo RUTA_VER_TODAS_LAS_FOTOS; ?>"><i class="fa fa-camera" aria-hidden="true"></i> Buscar</a>
			</li>


			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users"></i>
								Social
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
					<a class="dropdown-item" href="http://aventurero.tipolisto.es" target="_blank"><i class="fa fa-wordpress"></i> Blog</a>
					<a class="dropdown-item" href="http://www.chat.tipolisto.es/chat.php?idchat=35" target="_blank"><i class="fa fa-comments"></i> Chat</a>
					<a class="dropdown-item" href="#"><i class="fa fa-facebook"></i> Facebook</a>
					<a class="dropdown-item" href="#"><i class="fa fa-twitter"></i> Twiter</a>
					<a class="dropdown-item" href="#"><i class="fa fa-instagram"></i> Instagram</a>
					<a class="dropdown-item" href="#"><i class="fa fa-youtube"></i> Youtube</a>	
				</div>
			</li>

			

			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-plus"></i>
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
					<a class="dropdown-item" href="<?php echo RUTA_CONTACTA ?>"><i class="fa fa-envelope-square"></i> Contacta conmigo</a>	
					<a class="dropdown-item" href="<?php echo RUTA_DESCARGAS_APP; ?>"><i class="fa fa-download" aria-hidden="true"></i> Android app</a>
					<a class="dropdown-item" href="https://www.photobox.es/fotos-online-digital/imprimir/prints-classic" target="_blank"><i class="fa fa-print" aria-hidden="true"></i> Imprimir y llevar</a>
					<a class="dropdown-item" href="<?php echo RUTA_INFO; ?>"><i class="fa fa-info-circle"></i> Sobre esta web.</a>	
				</div>
			</li>



			
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<?php 
			if(ControlSesion::comprobar_sesion_iniciada()){
				echo "<li class='nav-item'>";
						echo "<i class='fa fa-user' aria-hidden='true'></i> <span class='navbar-brand'>".ControlSesion::getNameUsuario()."</span>";
				echo "</li>";
			}
			?>
			<li class="nav-item dropdown">
						<?php
						//Conexion::abrir_conexion();
						//if(RepositorioUsuario::obtener_tipo_por_nombre(Conexion::obtener_conexion(),ObtenerUsuario::get())==='administrador'){
						if(ControlSesion::comprobar_sesion_iniciada()){
							?>
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-cog" aria-hidden="true"></i> Gestor
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
								<a class="dropdown-item" href="<?php echo RUTA_GESTOR_GENERICO_ADM; ?>"><i class="fa fa-unlock-alt"></i> Administrar</a>
								<a class="dropdown-item" href="<?php echo RUTA_GESTOR_FOTOS_ADM; ?>"><i class="fa fa-unlock-alt"></i> Fotos</a>
								<a class="dropdown-item" href="<?php echo RUTA_GESTOR_USUARIOS_ADM; ?>"><i class="fa fa-unlock-alt"></i> Usuarios</a>
								<a class="dropdown-item" href="<?php echo RUTA_GESTOR_COMENTARIOS_ADM; ?>"><i class="fa fa-unlock-alt"></i> Comentarios</a>
								<a class="dropdown-item" href="<?php echo RUTA_GESTOR_FAVORITOS_ADM; ?>"><i class="fa fa-unlock-alt"></i> Favoritos</a>
							</div>
							<?php
						}
						?>
					
			</li>
			<?php
			if(ControlSesion::comprobar_sesion_iniciada()){
				echo "<li class='nav-item'>";
					echo "<a class='navbar-brand' href='".RUTA_LOGOUT."'><i class='fa fa-sign-out' aria-hidden='true'></i></a>";
				echo "</li>";
			}else{
				?>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo RUTA_REGISTRO; ?>"><i class="fa fa-registered" aria-hidden="true"></i> Registro</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo RUTA_LOGIN; ?>"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a>
				</li>
			<?php
			}
			?>
			
		</ul>
	</div>
</nav>