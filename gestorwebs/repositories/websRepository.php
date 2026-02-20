<?php
	//session_start();
	function obtenerTotalRegistros(){
		
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM webs ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		$total_registros=mysqli_num_rows($resultado);
		return $total_registros;
		$basededatos->desconectar();
	}
	

	
	

	function obtenerNombreWeb($idWeb){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM webs WHERE idWeb='".$idWeb."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			return $linea['nombreweb'];
		}
		$basededatos->desconectar();
	}
	function obtenerTodosLasUltimasCincoWebsAdm(){
		$webs=array();
		$mysql=new Mysql();
		$mysql->conectar_mysql();
		$consulta  = "SELECT * FROM webs WHERE idUsuario='1' ORDER BY idweb DESC LIMIT 5";
		$resultado=$mysql->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) {
			$web=new Web($linea['idweb']);
			$web->setNombreWeb($linea['nombreweb']);
			$web->setTituloWeb($linea['tituloweb']);
			$web->setDescripcionWeb($linea['descripcionweb']);
			$web->setFechaWeb($linea['fechaweb']);
			$web->setTagsWeb($linea['tagsweb']);
			$web->setCategoriaWeb($linea['idCategoria']);
			$web->setNumeroVotosWeb($linea['numerovotosweb']);
  			$web->setMediaVotosWeb($linea['mediavotosweb']);
			$web->setImagenWeb($linea['imagenweb']);
			$web->setContadorWeb($linea['contadorweb']);
			$webs[]=$web;
		}
		$mysql->desconectar();
		/*$mysql=new mysqli('db591523582.db.1and1.com', 'dbo591523582', '41434143','db591523582');
		$consulta  = "SELECT * FROM webs ORDER BY idweb DESC LIMIT 3";
		$resultado=$mysql->query($consulta);
		while ($linea = mysqli_fetch_array($resultado)) {
			$web=new Web($linea['idweb']);
			$web->setNombreWeb($linea['nombreweb']);
			$web->setTituloWeb($linea['tituloweb']);
			$web->setDescripcionWeb($linea['descripcionweb']);
			$web->setFechaWeb($linea['fechaweb']);
			$web->setTagsWeb($linea['tagsweb']);
			$web->setCategoriaWeb($linea['idCategoria']);
			$web->setNumeroVotosWeb($linea['numerovotosweb']);
  			$web->setMediaVotosWeb($linea['mediavotosweb']);
			$web->setImagenWeb($linea['imagenweb']);
			$web->setContadorWeb($linea['contadorweb']);
			$webs[]=$web;
		}
		$mysql->close();*/
		return $webs;		
	}
	
	
	



	
	function dibujarLayoutWebs($webs){
			$contador=0;
			foreach ($webs as $posicion=>$web){
				$bgcolor='#B3FFF3';
				$contador++;
				if (($contador%2)==0){
						$bgcolor='#FAFEB1';
				}
				echo "<div class='contenedorimagenesdewebs' >";
				echo "<center ><a href='http://".$web->getNombreWeb()."' target='_blank' class='tituloweb' >";
				echo cortarCadena($web->getTituloWeb())."";
				echo "<br /><span style='color:black; font-size:10px;'>Enlace: ".cortarCadena($web->getNombreWeb())."</span></a>";
				echo "<br /><pre class='contenedorcomentarios'>".$web->getDescripcionWeb()."</pre>";
				echo "<br /><a href='http://".$web->getNombreWeb()."' target='_blanck' class='tituloweb' ><img src='imagenes/webs/".$web->getImagenWeb()."'  class='img-responsive' width='500px' /></a></center>";
				echo "<br /><span>".$web->getMediaVotosWeb()." <a href='".PATHSERVER."gestionarwebs.php?accion=4&idWeb=".$web->getIdWeb()."'> Votar</a></span >";
				echo "<br /><a href='".PATHSERVER."gestionarwebs.php?accion=1&idWeb=".$web->getIdWeb()." >Detalles...</a><br />";
				echo "<br />";
				if($_SESSION['nivelaccesousuario']==1){
						echo "<a href='".PATHSERVER."adm/admgestionarwebs.php?accion=2&idWeb=".$web->getIdWeb()."'>Editar, <span style='color:red'> solo administrador</span></a>";
				}
				echo "</div>";
				echo "<br />";
			}
	}





		function enviarMensajeAEstrellaParaValidarComentarioWeb($codigoValidacion, $idWeb){
		//<a href="http://Www.tipolisto.es" target="_blank">Www.tipolisto.es</a>
		$direccion="www.gestorwebs.tipolisto.es/gestionarcomentariosweb.php?accion=2&codigoValidacion=$codigoValidacion&idWeb=$idWeb";
		
		$subject = "Ada";
		$txt = "<html> <head> <title>www.gestorwebs.tipolisto.es</title> </head> <body><p>".$direccion."</p><p>Este es un mensaje que han dejado en la web: ".obtenerNombreWeb($idWeb).", tienes que decir si lo quieres grabar o no pinchando en el enlace de arriba.</p><br /><br /><br /><br /><a href='".$direccion."' target='_blank'>Validar</body></html>";
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
		$headers .= "From: ada@gestorwebs.tipolisto.es" . "\r\n";
		//mail("ada@gestorwebs.tipolisto.es",$subject,$txt,$headers);
		mail("ada@gestorwebs.tipolisto.es",$subject,$txt,$headers);
	}
	

	function enviarMensajeAEstrellaParaValidarComentarioCategoria($codigoValidacion, $idCategoria){
		//<a href="http://Www.tipolisto.es" target="_blank">Www.tipolisto.es</a>
		$direccion="www.gestorwebs.tipolisto.es/gestionarcomentarioscategoria.php?accion=2&codigoValidacion=$codigoValidacion&idCategoria=$idCategoria";
		
		$subject = "Ada";
		$txt = "<html> <head> <title>www.gestorwebs.tipolisto.es</title> </head> <body><p>".$direccion."</p><p>Este es un mensaje que han dejado en la categoria: ".obtenerNombreCategoria($idCategoria).", tienes que decir si lo quieres grabar o no pinchando en el enlace de arriba.</p><br /><br /><br /><br /><a href='".$direccion."' target='_blank'>Validar</body></html>";
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
		$headers .= "From: ada@gestorwebs.tipolisto.es" . "\r\n";
		//mail("ada@gestorwebs.tipolisto.es",$subject,$txt,$headers);
		mail("ada@gestorwebs.tipolisto.es",$subject,$txt,$headers);
	}
	







	
	function aplicarInsercionComentarioWeb(){
		$fechaComentarioWeb=date("d-m-Y H:i:s");
		$bd= new Mysql();
		$bd->conectar_mysql();
		$sql="INSERT INTO comentariosweb VALUES ( '', '$_POST[nombreComentarioWeb]','$_POST[textoComentarioWeb]', '$fechaComentarioWeb', '0', '$_POST[idWeb]' ) ";
		$result=$bd->ejecutar_sql($sql);
		//$codigoValidacion=mysqli_insert_id();
		$codigoValidacion=$bd->enlace->insert_id;
		enviarMensajeAEstrellaParaValidarComentarioWeb($codigoValidacion, $_POST[idWeb]);
		$bd->desconectar();
		$mensaje="Comentario web nuevo insertado.";
		echo "<script type='text/javascript'>location.href='".PATHSERVER."gestionarwebs.php?accion=1&idWeb=$_POST[idWeb]&mensaje=".$mensaje."';</script>";
	}
	
	
	
	
	
	
	
	
	function aplicarInsercionComentarioCategoria(){
		if($_POST['codigosecreto']=='locoweb'){
			$fechaComentarioCategoria=date("Y-m-d H:i:s");
			$bd= new Mysql();
			$bd->conectar_mysql();
			$sql="INSERT INTO comentarioscategoria VALUES ( '', '$_POST[nombreComentarioCategoria]','$_POST[textoComentarioCategoria]', '$fechaComentarioCategoria', '0', '$_POST[idCategoria]' ) ";
			$result=$bd->ejecutar_sql($sql);
			$codigoValidacion=$bd->enlace->insert_id;		
			//Paraece que un grupo de locas está utilizando la categoría 11 - paginasweb - para hablar entre ellas
			//Si es la categoría 11 no me envies mensajes
			if($_POST[idCategoria]!=11 && $_POST[idCategoria]!=136  && $_POST[idCategoria]!=78  && $_POST[idCategoria]!=151){
				//enviarMensajeAEstrellaParaValidarComentarioCategoria($codigoValidacion, $_POST[idCategoria]);
			}
			$bd->desconectar();
			$mensaje="Comentario categoria nuevo insertado.";
			echo "<script type='text/javascript'>location.href='".PATHSERVER."gestionarwebs.php?idCategoria=$_POST[idCategoria]&mensaje=".$mensaje."';</script>";
		}else{
			echo "<script type='text/javascript'>location.href='".PATHSERVER."noautorizado.php';</script>";
		}
	}
	
	
	
	
	
	
	
	
	
	
	function obtenerTodasLosComentariosDeUnaWeb($idWeb){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM comentariosweb WHERE idwebcomentarioweb='".$idWeb."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{

		
			echo "<div class='contenedorcomentarios' >";
								echo "<b>Fecha: ".$linea['fechacomentarioweb']."</b>";
								echo "<br /><strong>De: <font color=red>".$linea['nombrecomentarioweb']."</font></strong>";
								echo "<br />".$linea['textocomentarioweb'];
								echo "<br />---------------------";
			echo "</div>";
			
		}
		$basededatos->desconectar();
		return $comentarios;
	}
	
	/**********************************Comentarios categoria********************************/
	function buscarUnaRutaDeFoto($cadena){
		$buscada="[[";
		$seEncuentraUnaRutaDeFoto=strpos($cadena, $buscada);	
		return $seEncuentraUnaRutaDeFoto;
	}
	function cambiarRutasPorFotos($cadena){
		$finalCadena=strlen($cadena);
		$posicionAbrirBarras=strpos($cadena, "[[");
		$posicionCerrarBarras=strpos($cadena, "]]");
		$cadenaAnterior=substr($cadena, 0, $posicionAbrirBarras);
		$imagen=substr($cadena, $posicionAbrirBarras+2,$posicionCerrarBarras-3);
		if(strpos($imagen, "]]")!=false){
			$posicionnueva=strpos($imagen, "]]");
			$imagen=substr($imagen, 0,$posicionnueva);
			//$imagen="";
		}
		$comprobar=substr($imagen, 0,5);
		if ($comprobar =='natur'){
			$imagen="<img src=http://chat.tipolisto.es/imagenes/emoticonos/naturaleza/".$imagen. " width='30' height='30'/>";
		}
		if ($comprobar =='smile'){
			$imagen="<img src=http://chat.tipolisto.es/imagenes/emoticonos/smiley/".$imagen. " width='30' height='30'/>";
		}
		if ($comprobar =='orte-'){
			$imagen="<img src=http://chat.tipolisto.es/imagenes/emoticonos/lugares/".$imagen. " width='30' height='30'/>";
		}
		if ($comprobar =='objec'){
			$imagen="<img src=http://chat.tipolisto.es/imagenes/emoticonos/objetos/".$imagen. " width='30' height='30'/>";
		}
		if ($comprobar =='symbo'){
			$imagen="<img src=http://chat.tipolisto.es/imagenes/emoticonos/simbolos/".$imagen. " width='30' height='30'/>";
		}
		$cadenaPosterior=substr($cadena, $posicionCerrarBarras+3, $finalCadena);
		if(buscarUnaRutaDeFoto($cadenaPosterior)!=false){
			$cadenaPosterior=cambiarRutasPorFotos($cadenaPosterior);
		}
		$nuevaCadena=$cadenaAnterior.$imagen.$cadenaPosterior;
		return $nuevaCadena;		
	}
	
	function obtenerTodasLosComentariosDeUnaCategoria($idCategoria){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM comentarioscategoria WHERE idwebcomentariocategoria='".$idCategoria."' ORDER BY fechacomentariocategoria DESC";
		$resultado=$basededatos->ejecutar_sql($consulta);
		echo "<div>";
		$rutaSinFotos="";
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			if(buscarUnaRutaDeFoto($linea[textocomentariocategoria])!=false){
				$rutaSinFotos=cambiarRutasPorFotos($linea[textocomentariocategoria]);
			}else{
				$rutaSinFotos=$linea[textocomentariocategoria];
			}
					
		
								echo "<pre class='contenedorcomentarios'>";
								echo "<br /><b>Fecha: ".$linea['fechacomentariocategoria']."</b>";
								echo "<br /><strong>De: <font color=red>".$linea['nombrecomentariocategoria']."</font></strong>";
								echo "<br />".$rutaSinFotos;
								echo "</pre>";
								echo "<br />---------------------";
				
			
		}
		$basededatos->desconectar();
		echo "</div>";
	}
	function obtenerNumeroDeComentariosDeUnaCategoria($idCategoria){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM comentarioscategoria WHERE idwebcomentariocategoria='".$idCategoria."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		$resultados=mysqli_num_rows ($resultado);
		$basededatos->desconectar();
		return $resultados;
	}
	function borraElUltimoComentarioSiHayMasDeDiezEnUnaCategoria($idCategoria){
		echo "<p>Borrado el *** comentario. Cteagoria: ".$idCategoria."</p>";
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		//$consulta  = "DELETE FROM comentarioscategoria WHERE idComentarioCategoria='$idCategoria' LIMIT 10" ;
		$consulta="DELETE FROM comentarioscategoria WHERE idwebcomentariocategoria='".$idCategoria."' LIMIT 5";
		$resultado=$basededatos->ejecutar_sql($consulta);

		//echo "<p>".$resultado."</p>";
		$basededatos->desconectar();






	}
	
	/****************************Fin de comenatarios categoria***************************************/







	function cortarString($string){
			$posicion=strrpos($string, ">");
			$longitud=strlen($string);
			$nombreCortado=substr($string, $posicion+1 ,$longitud);
			$restoString=substr($string, 0 ,$posicion);
			$nombreWeb=obtenerNombreCategoria($nombreCortado);
			if($nombreWeb!="Base"){
				echo "<li><a href='".PATHSERVER."gestionarwebs.php?idCategoria=$nombreCortado'>".$nombreWeb."</a></li>";
			}
		
			if((strrpos($restoString, ">"))>1) {
				cortarString($restoString);
			}else{
				echo "<li><a href='".PATHSERVER."gestionarwebs.php?idCategoria=$restoString'>".obtenerNombreCategoria($restoString)."</a></li>";
			}
	}
	
	
	
	function dibujarLayoutWebsConArray($webs, $idCategoria){
				$contador=0;
				obtenerArbolDeCategorias($idCategoria);
				echo "<ol class='breadcrumb'>";
				cortarString($idCategoria.$GLOBALS["ruta"]);
				echo "</ol>";
				echo "<p>&nbsp;&nbsp;&nbsp;".obtenerTituloCategoria($idCategoria)."</p>";
				foreach ($webs as $posicion=>$web){
					$contador++;
					echo"<center>";
					echo "<div class='contenedorimagenesdewebs' >";
								echo "<table class='table-responsive'>";
									echo "<tr><td>";
										if($contador==1 && !isset($_GET['pagina'])){
											echo" <img src='".PATHSERVER."imagenes/medallaoro.png' width='100px'></img>";
										}else if($contador==2 && !isset($_GET['pagina'])){
											echo" <img src='".PATHSERVER."imagenes/medallaplata.png' width='100px'></img>";
										}else if($contador==3 && !isset($_GET['pagina'])){
											echo" <img src='".PATHSERVER."imagenes/medallabronce.png' width='100px'></img>";
										}
									echo "</td><td>";
										echo "<a href='http://".$web->getNombreWeb()."' target='_blank' class='tituloweb' >";
										echo cortarCadena($web->getTituloWeb())."";
										echo "<br /><span style='color:black; font-size:10px;'>Enlace: ".cortarCadena($web->getNombreWeb())."</span></a>";
									echo "</td></tr>";
								echo "</table>";
								
								echo "<br /><pre class='contenedorcomentarios'>".$web->getDescripcionWeb()."</pre>";
								echo "<br /><a href='http://".$web->getNombreWeb()."' target='_blanck' class='tituloweb' ><img src='".PATHSERVER."imagenes/webs/".$web->getImagenWeb()."' width='500px' /></a>";
								echo "<br /><span>".$web->getMediaVotosWeb()." <a href='".PATHSERVER."gestionarwebs.php?accion=4&idWeb=".$web->getIdWeb()."'> Votar</a></span>";
								
								echo "<br /><a href='".PATHSERVER."gestionarwebs.php?accion=1&idWeb=".$web->getIdWeb()." >Detalles...</a><br />";
								//echo "<br />";
								if($_SESSION['nivelaccesousuario']==1){
									echo "<a href='".PATHSERVER."adm/admgestionarwebs.php?accion=2&idWeb=".$web->getIdWeb()."'>Editar, <span style='color:red'> solo administrador</span></a>";
								}
							echo "</div>";
							echo "</center>";
							//require_once ('Mobile_Detect.php');
							$detect = new Mobile_Detect();
							if ($detect->isMobile()==false) {
								$url="http://".$web->getNombreWeb();
								$existe=url_exists($url);
								if($existe){
									echo "<div class='hidden-xs' style='max-width:1000px'>";
									echo "<iframe src='http://".$web->getNombreWeb()."' name='iframe1' width='100%' height='1000' scrolling='auto' frameborder='1'> <p>Texto alternativo para navegadores que no aceptan iframes.</p></iframe>";
									echo "</div>";
								}else{
									echo "<p>No se pudo abrir el enlace";
								}
							}
							
				}
				/*pedirComentarioCategoria($idCategoria);
				obtenerTodasLosComentariosDeUnaCategoria($idCategoria);
				if(obtenerNumeroDeComentariosDeUnaCategoria($idCategoria)>25){
					borraElUltimoComentarioSiHayMasDeDiezEnUnaCategoria($idCategoria);
				}*/
				
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function mostrarUnWeb($idWeb){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM webs WHERE idWeb='".$idWeb."' AND idUsuario='".$_SESSION['idusuario']."' ORDER BY mediavotosweb DESC";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			echo "<div class='contenedorimagenesdewebs' >";
				echo "<center ><a href='http://".quitarEspaciosEnBlancoPrincipioYFinal($linea['nombreweb'])."' target='_blanck' class='tituloweb' >".cortarCadena($linea['nombreweb'])."</a></center><br />";
				echo "<br>$linea[imagenweb]";
				echo "<img src='".PATHSERVER."imagenes/webs/".$linea['imagenweb']."' width='500px' /></center>";
				echo "<br /><span>".$linea['mediavotosweb']." <a href='".PATHSERVER."gestionarwebs.php?accion=4&idWeb=".$linea['idweb']."'> Votar</a></span >";
				echo "<br /><pre>".$linea['descripcionweb']."</pre>";
				echo "<br />Fecha: ".$linea['fechaweb'];
				echo "<br />Tags: ".$linea['tagsweb'];
				/*pedirComentarioWeb($linea['idweb']);
				obtenerTodasLosComentariosDeUnaWeb($linea['idweb']);*/
			echo "</div>";
		}
		$basededatos->desconectar();
		
	}
	
	function obtenerNombreFotoWeb($idWeb){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM webs WHERE idWeb='".$idWeb."' AND idUsuario='".$_SESSION['idusuario']."' ORDER BY mediavotosweb DESC";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			return $linea['imagenweb'];
		}
		$basededatos->desconectar();
		
	}
	





	
	
	
	
	
	
	
	
	
	
	function consultarTags($tagsWeb){
		$contador=0;
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM webs WHERE tagsWeb LIKE '%".$tagsWeb."%' ORDER BY mediavotosweb DESC ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		$total_registros=mysqli_num_rows($resultado);
		if($total_registros==FALSE){
			echo" <p>No se obtuvo ning&uacute;n resultado de ".$tagsWeb.".</p>"	;
		//echo "<br />Total registros ".$total_registros."<br />";
		}else{
			
			while ($linea = mysqli_fetch_array($resultado)) 
			{
				$contador++;
				echo "<div class='contenedorimagenesdewebs' >";
									echo "<center ><a href='http://".$linea[nombreweb]."' target='_blanck' class='tituloweb' >";
									echo cortarCadena($linea[tituloweb])."";
									echo "<br /><span style='color:black; font-size:10px;'>Enlace: ".cortarCadena($linea[nombreweb])."</span></a>";
									echo "<br /><pre>".$linea[descripcionweb]."</pre>";
									echo "<br /><a href='http://".$linea[nombreweb]."' target='_blanck' class='tituloweb' ><img src='imagenes/webs/".$linea[imagenweb]."' width='500px' /></a></center>";
									echo "<br /><span>".$linea[mediavotosweb]." <a href='".PATHSERVER."gestionarwebs.php?accion=4&idWeb=".$linea[idweb]."'> Votar</a></span >";
									
									echo "<br /><a href=gestionarwebs.php?accion=1&idWeb=".$linea[idweb]." >Detalles...</a><br />";
									echo "<br />";
									if($_SESSION['nivelaccesousuario']==1){
										echo "<a href='".PATHSERVER."adm/admgestionarwebs.php?accion=2&idWeb=".$linea[idweb]."'>Editar, <span style='color:red'> solo administrador</span></a>";
									}
				echo "</div>";
				echo "<br />";
				
			}
		}
		$basededatos->desconectar();
		
		
		
	}
	
	
	
	
	
	
	
	
	
	function votarUnaWeb($idWeb){
		?>
		<form method=post action='<?php echo PATHSERVER; ?>gestionarwebs.php'>
        <div class='form-group' >
        	<label for='Introduce tu voto:' class='control-label col-md-2'>Introduce tu voto:</label>
		    <div class='col-md-2'>            
                 <input type='text' class='form-control' name='nuevoVotoWeb' id='nuevoVotoWeb' size=10  maxlength='10'  title='Se necesita un voto' required >
            </div>    
      	</div> 
		<input type=hidden name=idWeb value='<?php echo $idWeb; ?>'></input> 
		<input type=hidden name=accion value=5></input> 
		     <div class='form-group' > 
		           <div class='col-md-2' >
                       <input type=submit value=Votar class='btn btn-primary' ></input>
				  </div>
		    </div> 
		 </form>
		<?php
	}
	
	
	
	
	
	
	
		
	
	
	
	
	
	
	
	function actualizarPorVotarUnaWeb($idWeb,$nuevoVotoWeb){
		//Obtenemos el numero total de votos
		$numeroVotosWeb;
		$idCategoria;
		$mediaVotosWeb;
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM webs WHERE idWeb='".$idWeb."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$numeroVotosWeb=$linea['numerovotosweb'];
			$mediaVotosWeb=$linea['mediavotosweb'];
			$idCategoria=$linea['idCategoria'];
		}
		$basededatos->desconectar();
		//Sumamos uno al numero total de votos
		$nuevoNumeroVotosWeb=$numeroVotosWeb+1;
		$nuevaMediaWeb=(($mediaVotosWeb*$numeroVotosWeb)+$nuevoVotoWeb)/$nuevoNumeroVotosWeb;
		//Actualizamos el numero de votos web y le ponemos la nueva media
		
		$bd= new Mysql();
		$bd->conectar_mysql();
		$sql="update webs set numerovotosweb='$nuevoNumeroVotosWeb', mediavotosweb='$nuevaMediaWeb' where idweb='$idWeb'";
		$bd->ejecutar_sql($sql);
		$bd->desconectar();
		$mensaje="Web ".obtenerNombreWeb($idWeb).", votada, voto: ".$nuevoVotoWeb;
		echo "<script type='text/javascript'>location.href='".PATHSERVER."gestionarwebs.php?mensaje=".$mensaje."&idCategoria=".$idCategoria."';</script>";
	}
	
	
	
	

	function recorrerCategoriasUsuario($nivelCategoria, $categoriaeshijade){//Esta funcion es solo par alos usuarios registrados
		$idUsuario=1;
		if(isset($_SESSION['idusuario']))$idUsuario=$_SESSION['idusuario'];
		$nivelCategoria++;
		$basededatos1= new Mysql();
		$basededatos1->conectar_mysql();
		$consulta1  = "SELECT * FROM categorias WHERE nivelcategoria='".$nivelCategoria."' AND idpadrecategoria='".$categoriaeshijade."' AND idUsuario='".$idUsuario."' ORDER BY nombrecategoria";
		$resultado1=$basededatos1->ejecutar_sql($consulta1);
		for($i=2;$i<$nivelCategoria;$i++){
			$espacios=$espacios."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		while ($linea1 = mysqli_fetch_array($resultado1)) {
		
			echo "<li>".$espacios."|__  <a href='".PATHSERVER."gestionarwebs.php?categoriaweb=$linea1[idcategoria]'> ".$linea1['nombrecategoria']."</a></li>";
			if ($linea1['categoriaeshijade'] != null){
				recorrerCategoriasUsuario($nivelCategoria, $linea1['idcategoria'] );							
			}
		}
		$basededatos1->desconectar();
	}



	function dibujarLayoutCategoriasUsuario(){//Esta funcion es para los usuaros registrados
		$idUsuario=1;
		if(isset($_SESSION['idusuario']))$idUsuario=$_SESSION['idusuario'];
		$nivelCategoria=1;
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta= "SELECT * FROM categorias WHERE nivelcategoria=".$nivelCategoria." AND idUsuario='".$idUsuario."' ORDER BY nombrecategoria";
		$resultado=$basededatos->ejecutar_sql($consulta);
		echo "<ul style='list-style:none'>";
				while ($linea = mysqli_fetch_array($resultado)) 
				{
						echo "<li> <a href='".PATHSERVER."gestionarwebs.php?categoriaweb=$linea[idcategoria]'> ".$linea['nombrecategoria']."</a></li>";
						recorrerCategoriasUsuario($nivelCategoria, $linea['idcategoria'] );	
				}
				$basededatos->desconectar();
		echo "</ul>";
	}




	function obtenerTituloCategoria($idCategoria){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT titulocategoria FROM categorias WHERE idcategoria='".$idCategoria."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			return $linea['titulocategoria'];
		}
		$basededatos->desconectar();
	}
	
	
	
	
	
	function paginacion($idCategoria, $inicio, $TAMANO_PAGINA){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta2  = "SELECT * FROM webs WHERE idCategoria='".$idCategoria."' ORDER BY mediavotosweb DESC ";
		$consulta  = "SELECT * FROM webs WHERE idCategoria='".$idCategoria."' ORDER BY mediavotosweb DESC limit ".$inicio .", ".$TAMANO_PAGINA." ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		$resultado2=$basededatos->ejecutar_sql($consulta2);
		$total_registros=mysqli_num_rows($resultado);
		if($total_registros==FALSE){
			echo" <p>No se obtuvo ning&uacute;n resultado.</p>"	;
		}else{
				$total_registros_sin_limitacion=mysqli_num_rows($resultado2);
				$resultado=$basededatos->ejecutar_sql($consulta);
				$total_paginas = ceil($total_registros_sin_limitacion / $TAMANO_PAGINA); 
				if ($total_paginas > 1){
						for ($i=1;$i<=$total_paginas;$i++){
								if ( $inicio == $i){
									//si muestro el índice de la página actual, no coloco enlace
									echo  $inicio . " ";
								}
								else{
									//si el índice no corresponde con la página mostrada actualmente, coloco el enlace para ir a esa página
									echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='".PATHSERVER."gestionarwebs.php?idCategoria=$idCategoria&pagina=" . $i ."' ><span style='font-size:24px;color:red;'>" . $i . "</span></a> ";
								}
						}
				}
		}	
		
	}
	
		
	function obtenerTodosLasWebsDeUnUsuario($idUsuario, $inicio, $TAMANO_PAGINA){
		$webs=array();
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM webs WHERE idUsuario='".$idUsuario."' ORDER BY mediavotosweb DESC limit ".$inicio .", ".$TAMANO_PAGINA." ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$web=new Web($linea['idweb']);
			$web->setNombreWeb($linea['nombreweb']);
			$web->setTituloWeb($linea['tituloweb']);
			$web->setDescripcionWeb($linea['descripcionweb']);
			$web->setFechaWeb($linea['fechaweb']);
			$web->setTagsWeb($linea['tagsweb']);
			$web->setCategoriaWeb($linea['idCategoria']);
			$web->setNumeroVotosWeb($linea['numerovotosweb']);
  			$web->setMediaVotosWeb($linea['mediavotosweb']);
			$web->setImagenWeb($linea['imagenweb']);
			$webs[]=$web;
		}
		$basededatos->desconectar();
		return $webs;
	}
	
	
	
	
	function obtenerTodosLasWebsDeUnaCategoria($idCategoria, $inicio, $TAMANO_PAGINA){
		
		$webs=array();
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM webs WHERE idCategoria='".$idCategoria."' ORDER BY mediavotosweb DESC limit ".$inicio .", ".$TAMANO_PAGINA." ";
		
		$resultado=$basededatos->ejecutar_sql($consulta);
		
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$web=new Web($linea['idweb']);
			$web->setNombreWeb($linea['nombreweb']);
			$web->setTituloWeb($linea['tituloweb']);
			$web->setDescripcionWeb($linea['descripcionweb']);
			$web->setFechaWeb($linea['fechaweb']);
			$web->setTagsWeb($linea['tagsweb']);
			$web->setCategoriaWeb($linea['idCategoria']);
			$web->setNumeroVotosWeb($linea['numerovotosweb']);
  			$web->setMediaVotosWeb($linea['mediavotosweb']);
			$web->setImagenWeb($linea['imagenweb']);
			$webs[]=$web;
		}
		$basededatos->desconectar();
		return $webs;
	}

	global $ruta;
	function obtenerArbolDeCategorias($idCategoria){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT idpadrecategoria FROM categorias WHERE idcategoria='".$idCategoria."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$idPadreCategoria=$linea['idpadrecategoria'];
			$GLOBALS["ruta"] .=">".$idPadreCategoria;
			if($idPadreCategoria != null){
				obtenerArbolDeCategorias($idPadreCategoria);
			}
		}
		$basededatos->desconectar();
	}
	
	
	
	function mostrarArbolDeCategorias($arbol){
		foreach ($arbol as $posicion=>$hoja){
			echo "<li><a href='#'>".$hoja."</a></li>";
		}
	}
	
	

	function pedirComentarioWeb($idWeb){
		
	?>
		<form method=post action='<?php echo PATHSERVER; ?>gestionarwebs.php' class='form-horizontal'>
		
			<div class='form-group contenedorcomentarios' style='font-size:14px' >
		            <label for='nombreComentarioWeb' class='control-label col-md-4'>Nombre:</label>
		            <div class='col-md-12'>
        						<input type='text' class='form-control' name='nombreComentarioWeb' id='nombreComentarioWeb'  title='Nombre de 3 a 5 carácteres alfanuméricos' pattern='[a-zA-Z0-9\d_ ]{3,50}' placeholder="Tu nombre:"  required >
                    </div>
		    </div> 
		    <div class='form-group' style='font-size:14px' >
		               <label for='textoComentarioWeb' class='control-label col-md-4'>Descripcion:</label>
		                <div class='col-md-12'>
                        	<textarea class='form-control' name='textoComentarioWeb' id='textoComentarioWeb'  title='De 3 a un motón de carácteres alfanuméricos sin símbolos raros ' pattern='[a-zA-Z0-9\d_]{3,50000}' placeholder="Comentario:" required></textarea>
                        </div>
		    </div>
		    <input type=hidden name='idWeb' value='<?php echo $idWeb;?>'></input>  
		 	<input type=hidden name='accion' value=6></input>  
		    <div class='form-group' > 
		          <div class='col-md-10 col-md-offset-4' >
                       <input type='submit' value='Insertar' class='btn btn-primary' ></input> 
                   </div>
		    </div> 
		
		  </form> 
         
		<?php	
		
		
		
	}


	
	
	
	
	function pedirComentarioCategoria($idCategoria){
	?>
		<form method=post action='<?php echo PATHSERVER; ?>gestionarwebs.php' class='form-horizontal'>
			<div class='form-group'>
            	<label for='nombreComentarioCategoria' class='control-label '>Nombre:</label>
                <div class='col-md-12'>
                        <input type='text' class='form-control' name='nombreComentarioCategoria' id='nombreComentarioCategoria'  title='Nombre de 3 a 5 carácteres alfanuméricos' pattern='[a-zA-Z0-9\d_ ]{3,50}' placeholder="Tu nombre:"  required >
                
                 </div>
                 <div class='form-group'>
						<label for='textoComentarioWeb' class='control-label '>Descripcion:</label>
                        <div class='col-md-12'>
                        	<textarea class='form-control' name='textoComentarioCategoria' id='textoComentarioCategoria'  title='De 3 a un motón de carácteres alfanuméricos sin símbolos raros ' pattern='[a-zA-Z0-9\d_]{3,50000}' placeholder="Comentario:" required></textarea>
                         </div>
                 </div>
                 <input type=hidden name='idCategoria' value='<?php echo $idCategoria;?>'></input>  
                 <input type=hidden name='accion' value=7></input>  
                 <input type=hidden name='codigosecreto' value='locoweb'></input>
		 		 <div class='col-xs-2 col-sm-2 col-md-2'>
                    <img class="botonemoticono"  src='/imagenes/emoticonos/smiley/Smiley-03.png' width="30" height="30"></img>
                 </div>
                 <div class='col-xs-10 col-sm-10 col-md-10'>
                    <input type='submit' value='Comentar' class='form-control btn btn-primary' ></input> 
                 </div>
		
		</form> 
		<br />
		<br />
		<br />
		<div id="capaemoticonos">
			 	<img src='/imagenes/emoticonos/smiley/Smiley-01.png' id='botonemoticonossmiley' width='30' height='30'></img>
                <img src='/imagenes/emoticonos/naturaleza/Natur-01.png' id='botonemoticonosperro' width='30' height='30'></img>
                <img src='/imagenes/emoticonos/lugares/Orte-01.png' id='botonemoticonoslugar' width='30' height='30'></img>
                <img src='/imagenes/emoticonos/objetos/Objects-23.png' id='botonemoticonosobjetos' width='30' height='30'></img>
                <img src='/imagenes/emoticonos/simbolos/Symbols-183.png' id='botonemoticonossimbolos' width='30' height='30'></img>
                <img src='/imagenes/borrar.png' class='botonemoticono' width='30' height='30' class="pull-right"></img>
			 	<div id="subcapaemoticonos">
                </div>
             </div>
         <div id="respuestaServidor" style='color:red;font-size:16px'></div>
         <br />
         <br />

	<?php	
		
		
		
	}





	


function obtenerTodasLasWebsDeUnaCategoria($idCategoria){
		$idUsuario=1;
		if(isset($_SESSION['idusuario']))$idUsuario=$_SESSION['idusuario'];
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT nombreweb,tituloweb FROM webs WHERE idcategoria='".$idCategoria."' AND idUsuario='".$idUsuario."' ORDER BY mediavotosweb DESC ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		echo "<ul>";
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			echo "<li><a href='http://".$linea['nombreweb']."' target='_blank' ><span style='font-size:12px; color:red'>".$linea['tituloweb']."</span></a></li>";
		}
		echo "</ul>";
		$basededatos->desconectar();
}


function drawWebUsers(){
	$idUsuario=1;
	if(isset($_SESSION['idusuario']))$idUsuario=$_SESSION['idusuario'];
	?>
		<a href='<?php echo PATHSERVER; ?>gestionarwebs.php?accion=1' class='btn btn-danger'>Crear nueva web</a>&nbsp;&nbsp;
		<a href="#" id="mostrarOculatr" class="btn btn-info">Configuraci&oacute;n</a>&nbsp;&nbsp;
		
		<?php
	$TAMANO_PAGINA = 10;
	if (isset($_GET["ordenar"])){
		$ordenar=$_GET["ordenar"];
	}else{
		$ordenar="idCategoria";
	}
	
	$pagina=1;
	if(isset($_GET['pagina']))$pagina = $_GET["pagina"];
	
	if (!$pagina) {
		$inicio = 0;
		$pagina=1;
	}
	else {
		$inicio = ($pagina - 1) * $TAMANO_PAGINA;
	} 
				
	$basededatos= new Mysql();
	$basededatos->conectar_mysql();
	if(isset($_POST['categoriaweb'])){
		$consulta  = "SELECT * FROM webs WHERE idCategoria='".$_POST['categoriaweb']."' AND idUsuario='".$idUsuario."' GROUP BY ".$ordenar." DESC limit " . $inicio . "," . $TAMANO_PAGINA."";
		$consulta2  = "SELECT * FROM webs WHERE idCategoria='".$_POST['categoriaweb']."' AND idUsuario='".$idUsuario."' GROUP BY ".$ordenar." DESC ";
	}else if(isset($_GET['categoriaweb'])){
		$consulta  = "SELECT * FROM webs WHERE idCategoria='".$_GET['categoriaweb']."' AND idUsuario='".$idUsuario."' ORDER BY ".$ordenar." DESC limit " . $inicio . "," . $TAMANO_PAGINA."";
		$consulta2  = "SELECT * FROM webs WHERE idCategoria='".$_GET['categoriaweb']."' AND idUsuario='".$idUsuario."' ORDER BY ".$ordenar." DESC ";
	}else if(isset($_POST['tituloWeb'])){
		$consulta  = "SELECT * FROM webs WHERE tituloweb LIKE '%".$_POST['tituloWeb']."%' AND idUsuario='".$idUsuario."' ORDER BY ".$ordenar." DESC limit " . $inicio . "," .$TAMANO_PAGINA."";
		$consulta2  = "SELECT * FROM webs WHERE tituloweb LIKE '%".$_POST['tituloWeb']."%' AND idUsuario='".$idUsuario."' ORDER BY ".$ordenar." DESC";
	}else{
		$consulta  = "SELECT * FROM webs WHERE idUsuario='".$idUsuario."' ORDER BY ".$ordenar." DESC limit " . $inicio . "," .$TAMANO_PAGINA."";
		$consulta2  = "SELECT * FROM webs WHERE idUsuario='".$idUsuario."' ORDER BY ".$ordenar." DESC ";
	}
	
	$resultado=$basededatos->ejecutar_sql($consulta);
	$resultado2=$basededatos->ejecutar_sql($consulta2);
	$total_registros=mysqli_num_rows($resultado);
	if($total_registros==FALSE){
		echo" <p>No se obtuvo ning&uacute;n resultado.</p>"	;
	}else{
			$total_registros_sin_limitacion=mysqli_num_rows($resultado2);
			$resultado=$basededatos->ejecutar_sql($consulta);
			$total_paginas = ceil($total_registros_sin_limitacion / $TAMANO_PAGINA); 
			if ($total_paginas > 1){
				for ($i=1;$i<=$total_paginas;$i++){
					if ( $pagina == $i){
						//si muestro el índice de la página actual, no coloco enlace
						echo  $pagina . " ";
					}
					else{
						//si el índice no corresponde con la página mostrada actualmente, coloco el enlace para ir a esa página
						echo "<a href='".PATHSERVER."gestionarwebs.php?accion=9&pagina=" . $i ."&ordenar=$ordenar' >" . $i . " </a> ";
					}
				}
			}
			echo "<div class='table-responsive'>";
				echo "<table class='table table-responsive table-hover table-condensed' >";
					echo "<tr class='danger'><th>Grupo</th><th>Nombre</th><th>Descripción</th><th>Fecha</th><th>Num. votos</th><th>Media</th><th>Acciones</th></tr>";
					$variableCategoriaWeb="";
					$colorFila=array("warning", "warning", "info", "success", "danger", "active");
					$color="";
					$posicion=0;
					//$contadorSalto=0;
					while ($linea = mysqli_fetch_array($resultado )) 
					{
						//Aqui le pones el color e fondo a las filas
						if ($linea['idCategoria']!=$variableCategoriaWeb){
							if($posicion==count($colorFila)){
								$posicion=0;
							}
							$posicion++;
							$color=$colorFila[$posicion];
						}
						echo "<tr class='".$color."'><td class='col-md-1'><div class='rotar'>";
						
						if($linea['idCategoria']!=$variableCategoriaWeb){
							echo cortarCadena(obtenerNombreCategoria($linea['idCategoria']));
						}								
						echo "</div>
						</td>
						<td class='col-md-3'><a href='http://".$linea['nombreweb']."' target='_blank' >".$linea['tituloweb']."</a></td>
						<td class='col-md-4'> ".cortarCadena($linea['descripcionweb'])."</td>
						<td>".cortarCadena($linea['fechaweb'])."</td>
						<td> ".$linea['numerovotosweb']."</td>
						<td>".$linea['mediavotosweb']."</td>
						<td class='col-md-2'>
							<a href=".PATHSERVER."gestionarwebs.php?accion=4&idWeb=$linea[idweb]>
								<img src='".PATHSERVER."imagenes/ojo.png' width='20' height='20'/>
							</a>&nbsp;
							<a href=".PATHSERVER."gestionarwebs.php?accion=2&idWeb=$linea[idweb]>
								<img src='".PATHSERVER."imagenes/actualizar.png' width='20' height='20'/>
							</a>&nbsp;
							<a href=".PATHSERVER."gestionarwebs.php?accion=3&idWeb=$linea[idweb]>
								<img src='".PATHSERVER."imagenes/eliminar.png' width='20' height='20'/>
							</a>&nbsp;
							
						</td></tr>";
						$variableCategoriaWeb=$linea['idCategoria'];
					}
				echo "</table>\n";
			echo "</div>";
			$basededatos->desconectar();
	}
	
}

//Esta función aparece es llamada por actualizaWerb que a su ves es llamada en gestionarweb.php
function dibujarLayoutCategoriasMostrandoLaCategoriaAsignada($categoriaAsignada){
				
	echo "<select name='categoriaweb' class='form-control col-md-6' required> ";
		echo "<option value='".$categoriaAsignada."' style='background:yellow'>".obtenerNombreCategoria($categoriaAsignada)."</option>";
				$nivelCategoria=1;
				$basededatos= new mysqlusuarios();
				$basededatos->conectar_mysql();
				$consulta= "SELECT * FROM categorias WHERE nivelcategoria=".$nivelCategoria." AND idUsuario=".$_SESSION['idusuario']." ORDER BY nombrecategoria";
				$resultado=$basededatos->ejecutar_sql($consulta);
				while ($linea = mysqli_fetch_array($resultado )) 
				{
						echo "<option value='".$linea['idcategoria']."' >".$linea['nombrecategoria']."</option>";
						recorrerCategoriasConSelect($nivelCategoria, $linea['idcategoria'] );
				}
				$basededatos->desconectar();
	echo "</select>";
				
}







	function crearNuevoWeb(){
		?>
		<form method='post' action='".PATHSERVER."gestionarwebs.php' class='form-horizontal'>
		
			<div class='form-group' >
		             <label for='nombreWeb' class='control-label col-md-2'>URL o direccion web:</label>
		            <div class='col-md-10'>
        						<input type='text' class='form-control' name='nombreWeb' id='nombreWeb' size=80 title='Se necesita un nombre' required >
                    </div>
		    </div> 
            <div class='form-group' >
		             <label for='tituloWeb' class='control-label col-md-2'>Nombre de la web:</label>
		            <div class='col-md-10'>
        						<input type='text' class='form-control' name='tituloWeb' id='tituloWeb' size=80 title='Se necesita un título' required >
                    </div>
		    </div> 
		    <div class='form-group' >
		               <label for='descripcionWeb' class='control-label col-md-2'>Descripcion:</label> 
		                <div class='col-md-10'>
                        	<textarea class='form-control' name='descripcionWeb' id='descripcionWeb' rows=10 cols=60></textarea>
                        </div>
		    </div>
		    <div class='form-group' >
		               <label for='numeroVotosWeb' class='control-label col-md-2'>Número de votos: </label> 
		               <div class='col-md-10'>
                        	<!--<input type='number' class='form-control' name='numeroVotosWeb' id='numeroVotosWeb' title='De 1 a 10000' pattern='[0-9]{1,5}' placeholder='Num. votos:' required />-->
                            <input type='text' class='form-control' name='numeroVotosWeb' value='' title='De 1 a 10000' pattern='[0-9]{1,5}' placeholder='Num. votos:' required />
                       </div>
		    </div> 
		    <div class='form-group' >  
		              <label for='mediaVotosWeb' class='control-label col-md-2'>Media: </label> 
		              <div class='col-md-10'>
                       		<!-- <input type='number' class='form-control' name='mediaVotosWeb' id='mediaVotosWeb' title='De 1 a 10' pattern='[0-9]{1}' placeholder='Media:' required /> -->
                            <input type='text' class='form-control' name='mediaVotosWeb' value='' title='De 1 a 10' pattern='[0-9]{1}' placeholder='Num. votos:' required />
                      </div>
		    </div> 
		    <div class='form-group' >
		             <label for='categoriaweb' class='control-label col-md-2'>Categoria: </label> 
		 			  <div class='col-md-10' >
						<?php echo dibujarLayoutCategoriasMostrandoLaCategoriaAsignada(1);?>
                      </div> 
             </div><!-- final del form-group del select idcategoria -->
             <input type=hidden name=accion value=12></input>  
               <div class='form-group' > 
                           <div class='col-md-10 col-md-offset-2' >
                                <input type='submit' value='Crear nueva web con estos datos!' class='btn btn-primary' ></input> 
                           </div>
                </div> 
            
              </form> 
            <?php
	}
	
	function aplicarInsercionWeb(){
		if(obtenerTotalRegistros()>1000){
			$mensaje="Web no insertada, no puedes meter más de 20 webs.";
		echo "<script type='text/javascript'>location.href='".PATHSERVER."usuariosgestionarwebs.php?mensaje=".$mensaje."';</script>";
		}else{
	
			$nombre=$_POST['nombreWeb'];
			$nombreacortar=substr($nombre, 0, 7);
			$nombreacortar2=substr($nombre, 0, 8);
			if($nombreacortar=='http://'){
				$nombreCortado=substr($nombre,7 ,strlen($nombre));
			}else if($nombreacortar2=='https://'){
				$nombreCortado=substr($nombre,8 ,strlen($nombre));
			}else{
				$nombreCortado=$_POST['nombreWeb'];
			}
			//$_POST[imagen]="nada";
			$fecha=date("j/n/Y");
			$_POST['numerovotosweb']=$_POST['numerovotosweb']+1;
			$bd= new mysqlusuarios();
			$bd->conectar_mysql();
			//idweb`, `nombreweb`, `tituloweb`, `descripcionweb`, `fechaweb`, `tagsweb`, `numerovotosweb`, `mediavotosweb`, `contadorweb`, `imagenweb`, `idCategoria`, `idUsuario`
			$sql="INSERT INTO webs VALUES ( '', 
										'$nombreCortado', 
										'$_POST[tituloWeb]',
										'$_POST[descripcionWeb]',
										'$fecha', 
										'$_POST[tagsWeb]', 
										'$_POST[numeroVotosWeb]',
										'$_POST[mediaVotosWeb]', 
										'0',
										'sinimagen1.jpg',
										'$_POST[categoriaweb]',
										'$_SESSION[idusuario]') ";
			$bd->ejecutar_sql($sql);
	
			$bd->desconectar();
			$mensaje="Web ".$nombreCortado." nueva insertada.";
			echo "<script type='text/javascript'>location.href='".PATHSERVER."usuariosgestionarwebs.php?mensaje=".$mensaje."';</script>";
		}
	}
	









function actualizarWeb($idWeb){
		$basededatos= new mysqlusuarios();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM webs WHERE idweb='".$idWeb."' AND idUsuario='".$_SESSION['idusuario']."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		echo"<table class='estiloformulario' border=0 width= 500px >";
		echo "<form method='post' action='".PATHSERVER."gestionarwebs.php' class='form-horizontal'>";
		while ($linea = mysqli_fetch_array($resultado )) 
		{
				
				echo"  <tr> ";
				echo"              <th valign='top'>URL odirecci&oacute;n</th>";
				echo"              <td><input type='text' class='form-control' name='nombreWeb' value='".$linea['nombreweb']."' required /><hr /></td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <th valign='top'>Nombre</th>";
				echo"              <td><input type='text' class='form-control' name='tituloWeb' value='".$linea['tituloweb']."' /><hr /></td>";
				echo"   </tr>";
				echo"   <tr> ";
				echo"              <th valign='top'>Descricpion:</th>";
			
				echo" 					<td><textarea class='form-control' name=descripcionWeb rows=10 cols=60>".$linea['descripcionweb']." </textarea></td>";
				echo"    </tr>";
				echo"              <th valign='top'>Fecha</th>";
				echo"              <td><input type='text' class='form-control' name='fechaWeb' value='".$linea['fechaweb']."' /></td>";
				echo"  <tr> ";
				echo"              <th valign='top'>Nº de votos: </th>";
				echo"              <td><input type='text' class='form-control' name='numeroVotosWeb' value='".$linea['numerovotosweb']."' title='De 1 a 10000' pattern='[0-9]{1,5}' placeholder='Num. votos:' required /></td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <th valign='top'>Media: </th>";
				echo"              <td><input type='text' class='form-control' name='mediaVotosWeb' value='".$linea['mediavotosweb']."' title='De 1 a 10' pattern='[0-9]{1}' placeholder='Num. votos:' required /></td>";
				echo"   </tr>";
				echo"              <th valign='top'>Contador: </th>";
				echo"              <td><input type='text' class='form-control' name='contadorWeb' value='".$linea['contadorweb']."' title='De 1 a 10000' pattern='[0-9]{1,5}' placeholder='Num. visitas:' required /></td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <th valign='top'>Tags: </th>";
				echo"              <td><input type='text' class='form-control' name='tagsWeb' value='".$linea['tagsweb']."' title='Tags separados por comas' placeholder='Tags separados por comas:'  /></td>";
				echo"   </tr>";
				echo"   <tr>";
				echo "            <th>Categoria: </th>";
				echo "			  <td> ";
                          						echo dibujarLayoutCategoriasMostrandoLaCategoriaAsignada($linea['idCategoria']);
                      			
							echo "</td>";
				echo "</tr>";
				echo"    <tr>"; 	
				echo" 		   <input type=hidden name='accion' value=22></input>";	
				echo" 		   <input type=hidden name='idWeb' value=".$idWeb."></input>";
				echo"          <td align=center><a href=".PATHSERVER."gestionarwebs.php?accion=3&idWeb=".$linea['idweb']." title='Borrar' class='btn btn-primary btn-large'><img src='".PATHIMAGES."borrar.png'></img>Borrar</a></td>";
				echo"          <td align=center><input type=submit value='Actualizar' class='btn btn-primary btn-large' ></td>";
				echo"    </tr>";
	
			
		}
		echo"</table>";
		$basededatos->desconectar();

		echo" </form>";
		
		
	}

	//Función solo llamada por gestorwebs.php que a su vez la llamo por POST webResposity.php (actualizarweb())
	function aplicarActualizacionWeb($idWeb){
		//$nombreCortado="";
		$nombre=$_POST['nombreWeb'];
		$nombreacortar=substr($nombre, 0, 7);
		$nombreacortar2=substr($nombre, 0, 8);
		if($nombreacortar=='http://'){
			$nombreCortado=substr($nombre,7 ,strlen($nombre));
		}else if($nombreacortar2=='https://'){
			$nombreCortado=substr($nombre,8 ,strlen($nombre));
		}else{
			$nombreCortado=$_POST['nombreWeb'];
		}
		$bd= new mysqlusuarios();
		$bd->conectar_mysql();
		$sql="update webs set nombreWeb='$nombreCortado', 
							   tituloweb='$_POST[tituloWeb]', 
							   descripcionweb='$_POST[descripcionWeb]', 
							   fechaweb='$_POST[fechaWeb]', 
							   tagsweb='$_POST[tagsWeb]', 
							   numerovotosweb='$_POST[numeroVotosWeb]', 
							   mediavotosweb='$_POST[mediaVotosWeb]', 
							   contadorweb='$_POST[contadorWeb]', 
							   imagenweb='sinimagen1.jpg',
							   idCategoria='$_POST[categoriaweb]' 
							   where idweb='$idWeb' AND idUsuario='".$_SESSION['idusuario']."'";
		$bd->ejecutar_sql($sql);
		$bd->desconectar();
		$mensaje="Web ".obtenerNombreWeb($idWeb)." updated.";
		echo "<script type='text/javascript'>location.href='".PATHSERVER."gestionarwebs.php?accion=2&idWeb=$idWeb&mensaje=$mensaje';</script>";
	}
	










	function confirmarBorrarWeb($idWeb){
		$foto=rand(1, 7);
		echo "<br /><h3>¿Estas seguro que quieres borrar ".obtenerNombreWeb($idWeb)."?</h3><br /><img src='".PATHSERVER."imagenes/bonito".$foto.".jpg' class='img-responsive' /><br />";
		echo "<h1><a href='".PATHSERVER."gestionarwebs.php?accion=5&idWeb=$idWeb'>SI</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<a href='".PATHSERVER."gestionarwebs.php?accion=6&idWeb=$idWeb'>NO</a></h1>";	
	}

	function borrarWeb($idWeb){
		//borramos la foto del servidor
		$nombreFoto=obtenerNombreFotoWeb($idWeb);
		$pathFoto=$_SERVER['DOCUMENT_ROOT']."/gestorwebs/imagenes/webs/".$nombreFoto;
		//echo "El nombre de la foto es: ".PATHSERVER."imagenes/webs/".$nombreFoto;
		if(file_exists($pathFoto)){
			//sinimagen1.jpg
			//sinimagen1.jpg
			if($nombreFoto!="sinimagen1.jpg" && $nombreFoto!="sinimagen.jpg" && $nombreFoto!='')unlink(PATHSERVER."imagenes/webs/".$nombreFoto);
			//Borramos la foto de la base de datos
			$bd= new mysqlusuarios();
			$bd->conectar_mysql();
			$sql="DELETE FROM webs WHERE idWeb='$idWeb' AND idUsuario='".$_SESSION['idusuario']."' LIMIT 1";
			$bd->ejecutar_sql($sql);
			$bd->desconectar();
			$mensaje=obtenerNombreWeb($idWeb)." deleted. ";
		}else{
			$mensaje.="La foto ".$pathFoto." no existe y no se pudo borrar la foto del servidor.";
		}
		echo "<script type='text/javascript'>location.href='".PATHSERVER."gestionarwebs.php?accion=9&mensaje=$mensaje'</script>";
	}
	
			

	function redirigirPorNoBorrarWeb($idWeb){
		$mensaje=obtenerNombreWeb($idWeb)." not deleted";
		echo "<script type='text/javascript'>location.href='".PATHSERVER."gestionarwebs.php?mensaje=$mensaje'</script>";
	}
	