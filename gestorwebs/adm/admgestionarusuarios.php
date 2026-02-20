
<?php
session_start();
if ($_SESSION["claveusuario"] !="1c558dfd6f4148767d40386fa7b59c18e3b8627e") {
   header("Location: ../noautorizdo.php?mensaje=$mensaje");
   exit();
}
	include("admdibujarhtml.php");
	require('../Mysql.php');
	REQUIRE('../mysqlusuarios.php');
	include ("../Usuario.php");
	
	
	dibujarhtmladministrador();
	//dibujarMenuUsuarioNivel1();
	
	
	
	echo "<br /><br /><a href='admgestionarusuarios.php?accion=1' class='btn btn-danger'>Crear un nuevo usuario</a>";
	echo "&nbsp;&nbsp;<a href='phpinfo.php' class='btn btn-success'>información php</a><br />";

	function convertirObjetoParaPasarPorURL(usuario $objeto){
		//$argumento = urlencode(serialize($objeto));
		$argumento = serialize($objeto);
		return $argumento;	
	}
	function recuperarObjetoPasadoPorURL(usuario $objeto){
		//$argumento = unserialize(urldecode($objeto));
		$argumento = unserialize($objeto);
		return $argumento;
	}
	function cortarCadena($cadena){
		//Strip_tags: retira las etiquetas HTML y PHP de un String
		//substr($cadena, corta inicio, corta final)
		//strlen: devuelve la longitud de la cadena
		$longitud = 20;
		$stringDisplay = substr(strip_tags($cadena), 0, $longitud);
		if (strlen(strip_tags($cadena)) > $longitud)
        	$stringDisplay .= ' ...';
		return $stringDisplay;
	}
	function formatearCadena($cadena){
		//$arrayDeAsABuscar=array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä');
        //$arrayDeAsSustituidas('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A');
		if($cadena==" " || empty($cadena) || $cadena==null){
			$cadena="&nbsp;";
		}
		$cadena=html_entity_decode($cadena);
		$cadena= str_replace(" ", "&nbsp;", $cadena);
		
		return $cadena;
	}
	function obtenerNombreEmpresa($idEmpresa){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = 'SELECT * FROM empresas WHERE idEmpresa='.$idEmpresa.' ';
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			return $linea['nombreEmpresa'];
		}
		$basededatos->desconectar();
	}
	function obtenerNombreusuario($idusuario){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = 'SELECT * FROM usuarios WHERE idusuario='.$idusuario.' ';
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			return $linea['nombreusuario'];
		}
		$basededatos->desconectar();
	}
	
	
	
	
	
	
	function generarCodigoActivacion($longitud,$especiales){
		// Array con los valores a escoger
		$semilla = array();
		$semilla[] = array('a','e','i','o','u');
		$semilla[] = array('b','c','d','f','g','h','j','k','l','m','n','p','q','r','s','t','v','w','x','y','z');
		$semilla[] = array('0','1','2','3','4','5','6','7','8','9');
		$semilla[] = array('A','E','I','O','U');
		$semilla[] = array('B','C','D','F','G','H','J','K','L','M','N','P','Q','R','S','T','V','W','X','Y','Z');
		$semilla[] = array('0','1','2','3','4','5','6','7','8','9');
 
		// si puede contener caracteres especiales, aumentamos el array $semilla
		if ($especiales) { 
			$semilla[] = array('$','#','%','&amp;','@','-','?','¿','!','¡','+','-','*');
		}
 
		// creamos la clave con la longitud indicada
		for ($bucle=0; $bucle<$longitud; $bucle++)
		{
			// seleccionamos un subarray al azar
			$valor = mt_rand(0, count($semilla)-1);
			// selecccionamos una posición al azar dentro del subarray
			$posicion = mt_rand(0,count($semilla[$valor])-1);
			// cogemos el carácter y lo agregamos a la clave
			$clave .= $semilla[$valor][$posicion];
		}
		// devolvemos la clave
		return $clave;
	}
	
	
	
	function mailActivacion($correousuario, $usuario,$codigoactivacion)//accion 10
	{
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM usuarios WHERE nombreusuario='".$usuario."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		$numeroFilas=mysqli_num_rows($resultado);
		if($numeroFilas==false){
			$basededatos->desconectar();
			$to = "somebody@example.com";
			$subject = "My subject";
			$txt = "<html> <head> <title>Gestorpaginasweb.tipolisto.es</title> </head> <body><p>Usuario: ".$usuario."</p><p>Contrase&ntilde;a: ".$codigoactivacion." </p><p><a href=www.gestorwebs.tipolisto.es/adm/admgestionarusuarios.php?accion=11&codigoactivacion=$codigoactivacion&nombreusuario=$usuario>Alta en Gesorpaginasweb.tipolisto.es</a></p></body></html>";
			$headers = "MIME-Version: 1.0\r\n"; 
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
			$headers .= "From: adm@www.gestorwebs.tipolisto.es" . "\r\n" .
			"CC: somebodyelse@example.com";
			mail($correousuario,$subject,$txt,$headers);
			
			$bd2= new Mysql();
			$bd2->conectar_mysql();
			//$sql2="INSERT INTO usuarios VALUES ('', '$usuario', ' ', 5, '$correousuario', ' ', ' ', ' ', $codigoactivacion) ";
			$sql2="INSERT INTO usuarios (idusuario, nombreusuario, claveusuario, nivelaccesousuario, correousuario, nombrerealusuario, apellidosusuario, webusuario, validadousuario)  VALUES ( '', '$usuario','$codigoactivacion', '$nivelaccesousuario', '$correousuario', '$nombrerealusuario', '$apellidosusuario', '$webusuario', '0') ";
			$bd2->ejecutar_sql($sql2);
			$bd2->desconectar();
		}else{
			echo "<a href=$pagina?accion=9>El usuario ya existe. Volver.</a>";
		}
		$basededatos->desconectar();		
	}
	
	
	function confirmarActivacionPorCorreo(){ //accion 11
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM usuarios WHERE nombreusuario='".$_GET[nombreusuario]."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			if($linea['claveusuario']==$_GET['codigoactivacion']){
				$mensaje="Usuario: ".$_GET['nombreusuario'].", clave: ".$_GET['codigoactivacion'];
				echo "<script type='text/javascript'>location.href='http://www.gestorwebs.tipolisto.es/adm/admgestionarusuarios.php?mensaje=$mensaje&accion=12'</script>";
			}
		}
		$basededatos->desconectar();
		
		
	}
	
	
	
	
	
	
	
	
	function registrarNuevoUsuarioPorCorreo(){ //accion 9
			$codigoActivacion=generarCodigoActivacion(20,false);
		?>
			<p>Reg&iacute;strate en este sitio</p>
			<form name="registerform" id="registerform" action="admgestionarusuarios.php?accion=10" method="post">
				<p>
				<label for="nombreusuario">Nombre de usuario<br>
				<input type="text" name="nombreusuario" id="nombreusuario" value="" size="20" required="required"></label>
				</p>
				<p>
				<label for="correousuario">Correo electr&oacute;nico<br>
				<input type="email" name="correousuario" id="correousuario" class="input" value="" size="25" required="required"></label>
				</p>
				<p>Recibirás una contrase&ntilde;a en este correo electr&oacute;nico.</p>
				<br />
                <input type="hidden" name="codigoActivacion" id="codigoActivacion" value='<?php echo $codigoActivacion; ?>' >
				<p><input type="submit" class="button button-primary button-large" value="Registrarse"></p>
		</form>
				<p>
	<a href="admgestionarusuarios.php?accion=12">Acceder</a> |
	<a href="admgestionarusuarios.php?accion=13" title="Recupera tu contrase&ntilde;a perdida">¿Has perdido tu contrase&ntilde;a?</a>
</p>
	<p><a href="index.php" title="¿Te has perdido?">Volver a Gestor de webs</a></p>
	<?php
		
	}
	
	
	
	
	
	
	
	function menuAccederUsuario(){ //accion 12
		?>
		<form name="loginform" id="loginform" action="controlusuarios.php" method="post">
			<p>
			<label for="nombreusuario">Nombre de usuario<br>
			<input type="text" name="nombreusuario" id="nombreusuario" size="20"></label>
			</p>
			<p>
			<label for="claveusuario">Contrase&ntilde;a<br>
			<input type="password" name="claveusuario" id="claveusuario" size="20"></label>
			</p>
			<p>
			<input type="submit" class="btn btn-primary btn-large" value="Acceder">
			</p>
		</form>
		
		
		
		
		<?php
	}
	
	
	function enviarMensajeConNuevaClavePorOlvidoDeClave(){ //accion 14
		?>
		<p class="message">Por favor, escribe tu correo electr&oacute;nico. Recibir&aacute;s un enlace para crear la contrase&ntilde;a nueva por correo electr&oacute;nico.</p>

		<form name="lostpasswordform" id="lostpasswordform" action=$pagina? ContraseÃ±a perdida.html" method="post">
			<p>
			<label for="correousuario">Correo electr&oacute;nico:<br>
			<input type="text" name="correousuario" id="correousuario" value="" size="20"></label>
			</p>
			<p><input type="submit" class="button button-primary button-large" value="Obtener una contrase&ntilde;a nueva"></p>
		</form>

<p id="nav">
<a href="http://gestorwebs.tipolisto.es/wp-login.php">Acceder</a>
 | <a rel="nofollow" href="http://gestorwebs.tipolisto.es/wp-login.php?action=register">Registrarse</a></p>

	<p id="backtoblog"><a href="http://gestorwebs.tipolisto.es/" title="Â¿Te has perdido?">Â« Volver a Gestor de webs</a></p>

		
		
		<?php
	}
	
	
	function mostrarUnusuario($idusuario){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = 'SELECT * FROM usuarios WHERE idusuario='.$idusuario.' ';
		$resultado=$basededatos->ejecutar_sql($consulta);
		$bgcolor='#BBFFFF';
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			
		
				
		
			echo"<table class='estiloformulario' border=0 width= 500px >";
				echo"  <tr bgcolor=".$bgcolor."> ";
				echo"              <th valign='top'>Id usuario</th>";
				echo"              <td>".$linea['idusuario']."</td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <th valign='top'>Nombre usuario</th>";
				echo"              <td>".$linea['nombreusuario']."</td>";
				echo"   </tr>";
				echo"   <tr bgcolor=".$bgcolor."> ";
				echo"              <th valign='top'>Clave usuario</th>";
				echo"              <td>".$linea['claveusuario']."</td>";
				echo"    </tr>";
				echo "<tr > ";
				echo"              <th valign='top'>Nivel de acceso</th>";
				echo"              <td>".$linea['nivelaccesousuario']."</td>";
				echo"   </tr>";
				echo "<tr bgcolor=".$bgcolor.">";
				echo"              <th valign='top'>Correo electr&oacute;nico:</th>";
				echo"              <td>".$linea['correousuario']."</td>";
				echo"   </tr>";
				
				echo"  <tr > ";
				echo"              <th valign='top'>Nombre real</th>";
				echo"              <td>".$linea['nombrerealusuario']."</td>";
				echo"   </tr>";
				echo"  <tr bgcolor=".$bgcolor."> ";
				echo"              <th valign='top'>Apellidos</th>";
				echo"              <td>".$linea['apellidosusuario']."</td>";
				echo"   </tr>";
				echo"  <tr > ";
				echo"              <th valign='top'>web usuario</th>";
				echo"              <td>".$linea['webusuario']."</td>";
				echo"   </tr>";
				echo"  <tr bgcolor=".$bgcolor."> ";
				echo"              <th valign='top'>Estado</th>";
				echo"              <td>".$linea['validadousuario']."</td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <td><a href=$pagina?accion=3&idusuario=".$linea['idusuario']." title='Borrar'><img src='../imagenes/borrar.png'></img>Borrar</a></td>";
				echo"              <td><a href=$pagina?accion=2&idusuario=".$linea['idusuario']." title='Actualizar'><img src='../imagenes/actualizar.png'></img>Actualizar</a></td>";
				echo"   </tr>";
			echo"</table>";
		}
		$basededatos->desconectar();
	
	
	}
	
	
	
	function obtenerTodosLosusuarios(){
		$usuarios=array();
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = 'SELECT idusuario, nombreusuario, claveusuario, nivelaccesousuario FROM usuarios';
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$usuario=new usuario($linea['idusuario']);
		
			$usuario->setNombreusuario($linea['nombreusuario']);
			$usuario->setClaveUsuario($linea['claveusuario']);
			$usuario->setNivelAccesoUsuario($linea['nivelaccesousuario']);
			
  			
			$usuarios[]=$usuario;
		}
		$basededatos->desconectar();
		return $usuarios;
	}

	function comprobarSiExisteUnusuario($usuario, $clave){ // accion 13
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM usuarios where nombreusuario='".$usuario."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		$total_registros = mysqli_num_rows ($resultado);
		if($total_registros==false){
			$mensaje= "El nombre de usuario no existe.";
			echo "<script type='text/javascript'>location.href='http://www.gestorwebs.tipolisto.es/$pagina?mensaje=$mensaje'</script>";
		}else{
			while ($linea = mysqli_fetch_array($resultado)) 
			{
				$mensaje="¡Hola!: ".$linea['nombreusuario'];
				if($linea['nombreusuario']==$usuario){
					if($linea['idusuario']==$clave){
						   // definimos usuarios_id como IDentificador del usuario en nuestra BD de usuarios
							$_SESSION['idusuario']=$linea['idusuario'];
							//Definimos el nomrbre del usuario en la base de datos
							$_SESSION['nombreusuario']=$linea['nombreusuario'];
							//definimos usuario_nivel con el Nivel de acceso del usuario de nuestra BD de usuarios
							$_SESSION['nivelaccesousuario']=$usuario_datos['nivelaccesousuario'];
							//definimos usuario_password con el password del usuario de la sesión actual (formato md5 encriptado)
							$_SESSION['claveusuario']=$usuario_datos['claveusuario'];
							echo "<script type='text/javascript'>location.href='http://www.gestorwebs.tipolisto.es/$pagina?mensaje=$mensaje'</script>";
					}else{
						echo "<h3>La contrase&ntilde;a de &eacute;ste usuario es incorrecta.</h3>";		
					}
				}else{
					echo "<h3>No he encontrado este usuario</h3>";
				}
				
				
			}
		}
		$basededatos->desconectar();
		
	}






	function dibujarLayoutusuariosConArray($usuarios){
		$contador=0;
		echo "<div id='divusuarios'>";
		echo "Ventana dibujar todos los usuarios.<br />";
		echo "<table class='ventana' width=100% border=0>";
				echo "<tr bgcolor='#FCD9FF'><th>Nombre usuario</th><th>Clave</th><th>Nivel de acceso</th></tr>";
				foreach ($usuarios as $posicion=>$usuario){
					
					$bgcolor='#B3FFF3';
					$contador++;
					if (($contador%2)==0)
					{
						$bgcolor='#FAFEB1';
					}
				echo "<tr bgcolor=".$bgcolor.">";
					echo "<td><a href=admgestionarusuarios.php?accion=4&idusuario=".$usuario->getIdusuario()." >".cortarCadena($usuario->getNombreusuario())."</a></td><td>".$usuario->getClaveUsuario()."</td><td>".$usuario->getNivelAccesoUsuario()."</td>";
					
				echo "</tr>";
		
		}
		echo "</table>\n";
		echo "</div>";
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function crearNuevousuario(){
		?>
        
		<h3>Menu a&ntilde;adir nuevo usuario</h3>
		<form class="form-horizontal" method=post action='admgestionarusuarios.php'>
            <table bgcolor="#DBDBDB">
            	
        		<tr>
            		<th scope="row"><label for="nombreusuario">Nombre de usuario<br /><small>(requerido)</small></label></th>
            		<td><input name="nombreusuario" type="text" id="nombreusuario" value=""  required /></td>
        		</tr>
       			<tr>
            		<th scope="row"><label for="correousuario" >Correo electr&oacutenico<br /> <small>(requerido)</small> </label></th>
            		<td><input name="correousuario" type="email" id="correousuario" value="" required /></td>
       			</tr>
        		<tr >
           			<th scope="row"><br /><label for="nombrerealusuario">Nombre </label></th>
            		<td><input name="nombrerealusuario" type="text" id="nombrerealusuario" value="" /></td>
        		</tr>
        		<tr >
            		<th scope="row"><br /><label for="apellidosusuario">Apellidos </label></th>
            		<td><input name="apellidosusuario" type="text" id="apellidosusuario" value="" /></td>
        		</tr>
        		<tr >
            		<th scope="row"><br /><label for="url">Web</label></th>
            		<td><input name="webusuario" type="text" id="webusuario" /><br /></td>
        		</tr>
        		<tr >
            		<th scope="row"><label for="claveusuario">Contraseña<br /><small>(requerido)</small></label></th>
            		<td>
                		<input class="hidden" name="accion" value=12 /><!-- #24364 workaround -->
                		<input name="claveusuario" type="password" id="claveusuario" autocomplete="off"  required="required"/>
            		</td>
        		</tr>
        		<tr >
            		<th scope="row"><label for="clavedosusuario">Confirmar Contraseña <br /><small>(requerido)</small></label></th>
            		<td>
            			<input name="clavedosusuario" type="password" id="clavedosusuario" autocomplete="off" />
            			<br />
            			<div>Seguridad de la contraseña</div>
            <p><small>Un consejo: La contraseña debe tener, al menos, siete caracteres de longitud. Para hacerla más fuerte, utiliza mayúsculas y minúsculas, números y símbolos como ! " ? $ % ^ &amp; ).</small></p>
            		</td>
        		</tr>
        		<tr>
            		<th scope="row">¿Enviar Contraseña?</th>
            		<td><label for="enviarclave"><input type="checkbox" name="enviarclave" id="enviarclave" value="1"  /> Enviar esta contraseña al nuevo usuario por correo electrónico.</label></td>
        		</tr>
        		<!--<tr class="form-field">
           			<th scope="row"><label for="rollusuario">Perfil</label></th>
            		<td><select name="rollusuario" id="rollusuario">
                
        				<option selected='selected' value='Suscriptor'>Suscriptor</option>
        				<option value='colaborador'>Colaborador</option>
        				<option value='autor'>Autor</option>
        				<option value='editor'>Editor</option>
        				<option value='administrador'>Administrador</option>			</select>
            		</td>
        		</tr>-->
                <tr>
            		<td colspan=2><br /><input type=submit value="A&ntilde;adir nuevo usuario" class="btn btn-default" ></td>
        		</tr>
        	</table>
		</form>
       
        <?php
	}
	












	
	
 	function actualizarusuario($idusuario){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = 'SELECT * FROM usuarios WHERE idusuario='.$idusuario.' ';
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
				$usuario=new usuario($linea['idusuario']);
				$usuario->setNombreusuario($linea['nombreusuario']);
				$usuario->setClaveUsuario($linea['claveusuario']);
				$usuario->setNivelAccesoUsuario($linea['nivelaccesousuario']);
				$usuario->setCorreoUsuario($linea['correousuario']);
				$usuario->setNombreRealUsuario($linea['nombrerealusuario']);
				$usuario->setApellidosUsuario($linea['apellidosusuario']);
				$usuario->setWebUsuario($linea['webusuario']);
				$usuario->setValidadoUsuario($linea['validadousuario']);
		}
		$basededatos->desconectar();
		echo"<p>Menu Actualizar usuario</p>";
	
		echo"<form method=post action=$pagina >";
		echo"<table border= 0 bordercolor=black width=500px >";
		echo"  <tr> ";
		echo"              <th>Usuario:</th>";
		echo"              <td><input type='text'  name='nombreusuario' value='".formatearCadena($usuario->getNombreusuario())."' size='50' title='Se necesita un nombre' required ></input></td>";
		echo"   </tr>";
		echo"   <tr>";
		echo"              <th>Contrase&ntilde;a:</th>";
		echo"              <td><input type='text'  name='claveusuario' value='".formatearCadena($usuario->getClaveUsuario())."' size='50' title='Introduce una clave' required ></input></td>";
		echo"    </tr>";
		echo"   <tr> ";
		echo"              <th>Repita la contrase&ntilde;a:</th>";
		echo"              <td><input type='text'  name='claveusuariodos' value='".formatearCadena($usuario->getClaveUsuario())."' size='50' title='Introduce una clave' required ></input></td>";
		echo"    </tr>";
		echo"  <tr> ";
		echo"              <th>Nombre:</th>";
		echo"              <td><input type='text'  name='nombrerealusuario' value='".formatearCadena($usuario->getNombreRealUsuario())."' size='50' title='Se necesita un nombre' required ></input></td>";
		echo"   </tr>";
		echo"  <tr> ";
		echo"              <th>Apellidos:</th>";
		echo"              <td><input type='text' name='apellidosusuari'o value='".formatearCadena($usuario->getApellidosUsuario())."' size='50' title='Se necesitan los apellidos' required ></input></td>";
		echo"   </tr>";
				echo"  <tr> ";
		echo"              <th>Correo:</th>";
		echo"              <td><input type='text'  name='nombrerealusuario' value='".$usuario->getCorreoUsuario()."' size='50' ></input></td>";
		echo"   </tr>";	
		echo"  <tr> ";
		echo"              <th>Web:</th>";
		echo"              <td><input type='text' name='webusuario' value='".$usuario->getWebUsuario()."' size='50' ></input></td>";
		echo"   </tr>";
		echo"  <tr> ";
		echo"              <th>validado</th>";
		echo"              <td><input type='number' name='webusuario' value='".$usuario->getValidadoUsuario()."' size='50' ></input></td>";
		echo"   </tr>";
		echo"    <tr>"; 	
		echo" 		   <input type=hidden name=accion value=22></input>";	
		echo" 		   <input type=hidden name=idusuario value=".$usuario->getIdusuario()."></input>";
		echo"          <td colspan=2  align=center><input type=submit value=Actualizar class='boton' ></td>";
		echo"    </tr>";
		echo"</table>";
		echo" </form>";
		
		
	}
	
	
	
	
	
	
	
	
	
	
	function confirmarBorrarusuario($idusuario){
		$foto=rand(1, 7);
		echo "<br /><h3>¿Estas seguro que quieres borrar ".obtenerNombreusuario($idusuario)."?, es muy bonito...</h3><br /><img src=../imagenes/bonito".$foto.".jpg></img><br />";
		echo "<h1><a href='admgestionarusuarios.php?accion=5&idusuario=$idusuario'>SI</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<a href='$pagina?accion=6&idusuario=$idusuario'>NO</a></h1>";
	}
	function borrarusuario($idusuario){
			$bd2= new mysqlusuarios();
			$bd2->conectar_mysql();
			$sql2="DROP TABLE categorias_".$idusuario."";
			$sql3="DROP TABLE webs_".$idusuario."";
			$bd2->ejecutar_sql($sql2);
			$bd2->ejecutar_sql($sql3);
			$bd2->desconectar();
		
		
		
			$mensaje=obtenerNombreusuario($idusuario)." borrado. ";
			$bd= new Mysql();
			$bd->conectar_mysql();
			$sql="DELETE FROM usuarios WHERE idusuario='$idusuario' LIMIT 1";
			$bd->ejecutar_sql($sql);
			$bd->desconectar();
			
			
			
			$mensaje="Usuario: ".$idusuario." borrado";
			echo "<script type='text/javascript'>location.href='admgestionarusuarios.php?mensaje=$mensaje'</script>";
	}
	function redirigirPorNoBorrar($idusuario){
		$mensaje=obtenerNombreusuario($idusuario).", no borrado";
		echo "<script type='text/javascript'>location.href='admgestionarusuarios.php?mensaje=$mensaje'</script>";
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function aplicarInsercionusuario(){
		$fecha=date("j/n/Y");
		$_POST[claveusuario]=sha1($_POST[claveusuario]);
		$bd= new Mysql();
		$bd->conectar_mysql();
		$sql="INSERT INTO usuarios (idusuario, nombreusuario, claveusuario, nivelaccesousuario, correousuario, nombrerealusuario, apellidosusuario, webusuario, validadousuario)  VALUES ( '', '$_POST[nombreusuario]','$_POST[claveusuario]', '$_POST[nivelaccesousuario]', '$_POST[correousuario]', '$_POST[nombrerealusuario]', '$_POST[apellidosusuario]', '$_POST[webusuario]', '0') ";
		$bd->ejecutar_sql($sql);
		//echo"<h1>Insertado.</h1>";
		//echo "<a href='admusuarios.php'>Volver</a>";
		$bd->desconectar();
		$mensaje="Usuario nuevo creado.";
		echo "<script type='text/javascript'>location.href='admgestionarusuarios.php?mensaje=$mensaje'</script>";
	}
	
	
	
	function aplicarActualizacionusuario($idusuario){
		$_POST[claveusuario]=sha1($_POST[claveusuario]);
		$mensaje="usuario ".obtenerNombreusuario($idusuario)." actualizado.";
		$bd= new Mysql();
		$bd->conectar_mysql();
		$sql="update usuarios set nombreusuario='$_POST[nombreusuario]', claveusuario='$_POST[claveusuario]', nivelaccesousuario='$_POST[claveusuario]', correousuario='$_POST[correousuario]', nombrerealusuario='$_POST[nombrerealusuario]', apellidosusuario='$_POST[apellidosusuario]', webusuario='$_POST[webusuario]', validadousuario='$_POST[validadousuario]' where idusuario='$idusuario'";
		$bd->ejecutar_sql($sql);
		$bd->desconectar();
		echo "<script type='text/javascript'>location.href='admgestionarusuarios.php?mensaje=$mensaje';</script>";
	}
	
	function cerrarSesion(){
		session_destroy();
		 $mensaje= "Sesion cerrada.";
		echo "<script type='text/javascript'>location.href='http://www.gestorwebs.tipolisto.es/index.php?mensaje=$mensaje'</script>";
	}
	
	
	
	
	
/***************************Main*********************************************/
	$pagina="admgestionarusuarios.php";
	if (!isset($_GET['accion'])){
		$usuarios=array();
		$usuarios=obtenerTodosLosusuarios();
		dibujarLayoutusuariosConArray($usuarios);
	}else{
		if ($_GET['accion']==1){
			crearNuevousuario();
		}else if($_GET['accion']==2){
			actualizarusuario($_GET['idusuario']);
		}else if($_GET['accion']==3){
			confirmarBorrarusuario($_GET['idusuario']);
		}else if($_GET['accion']==5){
			borrarusuario($_GET['idusuario']);
		}else if($_GET['accion']==6){
			redirigirPorNoBorrar($_GET['idusuario']);
		}else if($_GET['accion']==4){
			mostrarUnusuario($_GET['idusuario']);
		}else if($_GET['accion']==8){
			//$objeto=urldecode(unserialize($_GET['usuario']));
			comprobarSiExisteUnusuario($usuario, $clave);
			
		}else if($_GET['accion']==9){
			
			registrarNuevoUsuarioPorCorreo();
		}else if($_GET['accion']==10){
			
			mailActivacion($_POST['correousuario'], $_POST['nombreusuario'],$_POST['codigoActivacion']);
			echo "<br />Revisa tu correo para la activaci&oacute;n.<br /><br /><br /><br /><br /><br />";
			
		}else if($_GET['accion']==11){
			confirmarActivacionPorCorreo();
			
		}else if($_GET['accion']==12){
			menuAccederUsuario();
		}else if($_GET['accion']==13){
			comprobarSiExisteUnusuario($_POST['nombreusuario'], $_POST['claveusuario']);
		}else if($_GET['accion']==14){
			enviarMensajeConNuevaClavePorOlvidoDeClave();
		}
		
		else if($_GET['accion']==7){
			cerrarSesion();
		}
	}
	if($_POST['accion'] == 12){
			aplicarInsercionusuario($_POST);
	}
	if($_POST['accion'] == 22){
			//$usuario=recuperarObjetoPasadoPorURL($_POST['usuario']);
			aplicarActualizacionusuario($_POST['idusuario'], $_POST);
	}
/****************************************************************************/








	
 dibujarPaginaAbajoAdministrador();
?>

