<?php
session_start();
if ($_SESSION["claveusuario"] !='1c558dfd6f4148767d40386fa7b59c18e3b8627e') {
    header("Location: ../noautorizdo.php?mensaje=$mensaje");
    exit();
}
	include("admdibujarhtml.php");
	require('../mysql.php');
	require('../Imagen.php');
	
	dibujarhtmladministrador();
	//dibujarMenuUsuarioNivel1();
	
		
	
	
	
	
	
	
	if (isset($_GET['mensaje'])) echo "<br /><span style='color:red'>".$_GET['mensaje']."</span><br /><br />";
	function convertirObjetoParaPasarPorURL(Imagen $objeto){
		//$argumento = urlencode(serialize($objeto));
		$argumento = serialize($objeto);
		return $argumento;	
	}
	function recuperarObjetoPasadoPorURL(Imagen $objeto){
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
		$cadena=html_entity_decode($cadena);
		$cadena= str_replace(" ", "&nbsp;", $cadena);
		return $cadena;
	}

	function obtenerNombreWeb($idWeb){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM webs WHERE idWeb='".$idWeb."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysql_fetch_array($resultado, MYSQL_ASSOC)) 
		{
			return $linea['nombreweb'];
		}
		$basededatos->desconectar();
	}
	function obtenerNombreImagen($idImagen){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM imagenes WHERE idimagen='".$idImagen."'" ;
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysql_fetch_array($resultado, MYSQL_ASSOC)) 
		{
			return $linea['nombreimagen'];
		}
		$basededatos->desconectar();
	}
	function obtenerNombreCategoria($idCategoria){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM imagenes WHERE idCategoria='".$idCategoria."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysql_fetch_array($resultado, MYSQL_ASSOC)) 
		{
			return $linea['nombreimagen'];
		}
		$basededatos->desconectar();
	}
	function obtenerTodosLasImagenes(){
		$imagenes=array();
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = 'SELECT * FROM imagenes';
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysql_fetch_array($resultado, MYSQL_ASSOC)) 
		{
			if($linea['nombreimagen'] != "." || $linea['nombreimagen'] != ".."){
				$imagen=new Imagen($linea['idimagen']);
				$imagen->setNombreImagen($linea['nombreimagen']);
				$imagen->setIdWeb($linea['idweb']);
				$imagenes[]=$imagen;
			}
		}
		$basededatos->desconectar();
		return $imagenes;
	}







	function dibujarLayoutImagenesConArray($imagenes){
		$filasDeImagenes=count($imagenes)/5;
		$contador=0;
		echo "<div id='divimagenes'>";
		echo "<table border=1>";
			echo "<tr>";
			foreach($imagenes as $imagen){
				
				if($contador%4==0) echo "</tr><tr>";
				echo "<td>";
					echo "<br/>Id:".$imagen->getIdImagen().", nombre: ".$imagen->getNombreImagen();
					echo "<br /><img src='../imagenes/webs/".cortarCadena($imagen->getNombreImagen())."' width='300px' ></img>";
					echo "<br />Pertenece a: <font color=red>".$imagen->getIdWeb()."</font>";
					echo "<br />Acciones<br /><a href=admgestionarimagenes.php?accion=4&idImagen=".$imagen->getIdImagen()." >Mostrar</a>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=admgestionarimagenes.php?accion=3&idImagen=".$imagen->getIdImagen()."><img src=../imagenes/eliminar.png></a></img>";
				echo "</td>";
				$contador++;
			}
			echo "</tr>";
		echo "</table>";
		
					
					//$bgcolor='#B3FFF3';
					//$contador++;
					//if (($contador%2)==0)
					//{
						$bgcolor='#FAFEB1';
					//}
					
					//echo "<div class='contenedorimagenes'>".$imagen->getNombreImagen()."<br /><a href=admgestionarimagenes.php?accion=4&idImagen=".$imagen->getIdImagen()." ><img src='../imagenes/webs/".cortarCadena($imagen->getNombreImagen())."' width='100px' ></img></a><br /><a href=admgestionarimagenes.php?accion=3&idImagen=".$imagen->getIdImagen()."><img src=../imagenes/eliminar.png></a></img></div>";
					//echo "<div class='contenedorimagenes'><img src='../imagenes/webs/".cortarCadena($imagen->getNombreImagen())."' width='100px' ></img><br /><a href='#' >hola</a></div>";
					
						//Filas
						
							
		

		echo "</div>";
	}
	
	
	//
	
	
	function crearNuevoImagen(){
		?>
		<br />
		<form method=post action='admgestionarimagenes.php' class='form-horizontal' enctype='multipart/form-data'>
		    <div class='form-group' >
		             <label for='archivo' class='control-label col-md-2'>Imagen: </label> 
		 			  <div class='col-md-10' >
                      	<input type='file' name='archivo' id='archivo' onChange='ver(form.file.value)' />
					 </div> 
		 	</div>
            <input type=hidden name=accion value=12></input>
		    <div class='form-group' > 
		               <div class='col-md-10 col-md-offset-2' >
                       		<input type='submit' value='Insertar nueva imagen' class='btn btn-primary' ></input> 
                       </div>
		    </div> 
			
		  </form> 
        <?php
	}
	

	
	
 	function actualizarImagen($idImagen){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM imagenes WHERE idimagen='".$idImagen."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		echo"<table class='estiloformulario' border=0 width= 500px >";
		echo "<form method='post' action='admgestionarimagenes.php?accion=22'>";
		while ($linea = mysql_fetch_array($resultado, MYSQL_ASSOC)) 
		{
			
				echo"  <tr> ";
				echo"              <th valign='top'>Nombre imagen</th>";
				echo"              <td><input type='text' name='nombreImagen' value='".$linea['nombreimagen']."' /><hr /></td>";
				echo"   </tr>";
				echo"   <tr> ";
				echo"              <th valign='top'>Descricpion:</th>";
			
				echo" 					<td><textarea name=descripcionImagen rows=10 cols=60>".formatearCadena($linea[descripcionimagen])." </textarea></td>";
				echo"    </tr>";
				echo"              <th valign='top'>Fecha</th>";
				echo"              <td><input type='text' name='fechaImagen' value='".$linea['fechaimagen']."' /></td>";
				echo"   </tr>";
				echo"              <th valign='top'>Tags imagen:</th>";
				echo"              <td><input type='text' name='tagsImagen' value='".$linea['tagsimagen']."' /></td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <th valign='top'>Número de votos: </th>";
				echo"              <td><input type='text' name='numeroVotosImagen' value='".$linea['numerovotosimagen']."' /></td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <th valign='top'>Voto: </th>";
				echo"              <td><input type='text' name='mediaVotosImagen' value='".$linea['mediavotosimagen']."' /></td>";
				echo"   </tr>";
				echo"   <tr>";
				echo "            <th>Categoria: </th>";
				echo "			  <td><select name='imagenImagen'> ";
										echo "<option value='".$linea[imagenimagen]."' style='background-color:yellow;'>".obtenerNombreCategoria($linea['imagenimagen'])."</option>";
										$basededatos2= new Mysql();
										$basededatos2->conectar_mysql();
										$consulta2  = 'SELECT * FROM imagenes ORDER BY nivelimagen';
										$resultado2=$basededatos2->ejecutar_sql($consulta2);
										while ($linea2 = mysql_fetch_array($resultado2, MYSQL_ASSOC)) 
										{
												
											
													
														
														$bgcolor='#B3FFF3';
														$contador++;
														if (($contador%2)==0)
														{
															$bgcolor='#FAFEB1';
														}
														
														if($linea2['nivelimagen']==1){
															echo "<option value='".$linea2['idimagen']."' >".$linea2['nombreimagen']."</option>";
														}else if ($linea2['nivelimagen']==2){
															echo "<option value='".$linea2['idimagen']."' > &nbsp;&nbsp;&nbsp;&nbsp;|__".$linea2['nombreimagen']."</option>";
														}else if ($linea2['nivelimagen']==3){
															echo "<option value='".$linea2['idimagen']."' > &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;|__".$linea2['nombreimagen']."</option>";
														}else if ($linea2['nivelimagen']==4){
															echo "<option value='".$linea2['idimagen']."' > &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;|__".$linea2['nombreimagen']."</option>";
														}
											 
										}
										
										$basededatos2->desconectar();
								echo "</select>";
							echo "</td>";
				echo "</tr>";
				echo"  <tr> ";
				echo"              <td><a href=admgestionarimagenes.php?accion=3&idImagen=".$linea['idImagen']." title='Borrar'><img src='../imagenes/borrar.png'></img>Borrar</a></td>";
				echo"              <td><a href=admgestionarimagenes.php?accion=2&idImagen=".$linea['idImagen']." title='Actualizar'><img src='../imagenes/actualizar.png'></img>Actualizar</a></td>";
				echo"   </tr>";
				echo"    <tr>"; 	
				echo" 		   <input type=hidden name=accion value=22></input>";	
				echo" 		   <input type=hidden name=idImagen value=".$idImagen."></input>";
				echo"          <td colspan=2  align=center><input type=submit value=Actualizar class='boton' ></td>";
				echo"    </tr>";
	
			
		}
		echo"</table>";
		$basededatos->desconectar();

		echo" </form>";
		
		
	}
	function confirmarBorrarImagen($idImagen){
		$foto=rand(1, 7);
		echo "<br /><h3>¿Estas seguro que quieres borrar ".obtenerNombreImagen($idImagen)."?, es muy bonito...</h3><br /><img src=../imagenes/bonito".$foto.".jpg></img><br />";
		echo "<h1><a href='admgestionarimagenes.php?accion=5&idImagen=$idImagen'>SI</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<a href='admgestionarimagenes.php?accion=6&idImagen=$idImagen'>NO</a></h1>";	
	}
	function borrarImagen($idImagen){
		
		
			$nombreImagen=obtenerNombreImagen($idImagen);
			$mensaje=obtenerNombreImagen($idImagen)." borrado. ";
			$bd= new Mysql();
			$bd->conectar_mysql();
			$sql="DELETE FROM imagenes WHERE idimagen='$idImagen' LIMIT 1";
			$bd->ejecutar_sql($sql);
			$bd->desconectar();
			$borrada=unlink('../imagenes/webs/'.$nombreImagen);
			if($borrada==false){
				$mensaje=$mensaje.", NO ha sido borrada del directorio del servidor";
			}
			
			echo "<script type='text/javascript'>location.href='admgestionarimagenes.php?mensaje=$mensaje'</script>";
		
		
			
		
	}
	function redirigirPorNoBorrar($idImagen){
		$mensaje=obtenerNombreImagen($idImagen)."No borrado";
		echo "<script type='text/javascript'>location.href='admgestionarimagenes.php?mensaje=$mensaje'</script>";
	}
	
	function mostrarUnImagen($idImagen){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM imagenes WHERE idimagen='".$idImagen."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		echo"<table class='estiloformulario' border=0 width= 500px >";
		while ($linea = mysql_fetch_array($resultado, MYSQL_ASSOC)) 
		{
			
				echo"  <tr> ";
				echo"              <th valign='top'>Nombre imagen</th>";
				echo"              <td><h3>".$linea['nombreimagen']."</h3><hr /></td>";
				echo"   </tr>";
				echo"   <tr> ";
				echo"              <th valign='top'>Descricpion:</th>";
				echo"              <td>".$linea['descripcionimagen']."</td>";
				echo"    </tr>";
				echo"              <th valign='top'>Fecha</th>";
				echo"              <td>".$linea['fechaimagen']."</td>";
				echo"   </tr>";
				echo"              <th valign='top'>Tags imagen:</th>";
				echo"              <td>".$linea['tagsimagen']."</td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <th valign='top'>Número de votos: </th>";
				echo"              <td>".$linea['numerovotosimagen']."</td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <th valign='top'>Voto: </th>";
				echo"              <td>".$linea['mediavotosimagen']."</td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <th valign='top'>Categoria: </th>";
				echo"              <td>".obtenerNombreCategoria($linea['imagenimagen'])."</td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <td><a href=admgestionarimagenes.php?accion=3&idImagen=".$idImagen." title='Borrar'><img src='../imagenes/borrar.png'></img>Borrar</a></td>";
				echo"              <td><a href=admgestionarimagenes.php?accion=2&idImagen=".$idImagen." title='Actualizar'><img src='../imagenes/actualizar.png'></img>Actualizar</a></td>";
				echo"   </tr>";
			
		}
		echo"</table>";
		$basededatos->desconectar();

		
	
	}
	
	function aplicarInsercionImagen(){
						$nombre_archivo = $_FILES['archivo']['name']; 
						$tipo_archivo = $_FILES['archivo']['type']; 
						$nombreImagen=$nombre_archivo;
						//echo "<br />El archivo pasado es: <br />".$nombreImagen;
						$tamano_archivo = $_FILES['archivo']['size']; 
						$bd= new Mysql();
						$bd->conectar_mysql();
						if (!(strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "jpg") || strpos($tipo_archivo, "png") || $tamano_archivo > 900000)) 
						{
							$nombreImagen="sinimagen.png";
							$bd->ejecutar_sql($sql);
							if(!$bd)
							{
								echo "Error al insertar.";	
							}
							echo "La foto no tiene el formato o el tam&ntilde;o correcto, solo se aceptan, jpg o png menores de 90Mb.<br />";
						}else
						{ 
								move_uploaded_file($_FILES['archivo']['tmp_name'], "../imagenes/webs/".$nombreImagen);
								$sql="INSERT INTO imagenes VALUES ( '', '$nombreImagen', '0') ";
								$bd->ejecutar_sql($sql);
								if(!$bd)
								{
									echo "Error al insertar.";	
								}
								$mensaje="Imagen ".$nombreImagen." insertada.";
								echo "<script type='text/javascript'>location.href='admgestionarimagenes.php?mensaje=".$mensaje."';</script>";
   						} 					
						$bd->desconectar();	
	}
	
	
	
	function aplicarActualizacionImagen($idImagen){
		$bd= new Mysql();
		$bd->conectar_mysql();
		$sql="update imagenes set nombreImagen='$_POST[nombreImagen]', descripcionimagen='$_POST[descripcionImagen]', fechaimagen='$_POST[fechaImagen]', tagsimagen='$_POST[tagsImagen]', imagenimagen='$_POST[imagenImagen]' where idimagen='$idImagen'";
		$bd->ejecutar_sql($sql);
		$bd->desconectar();
		$mensaje="Imagen ".obtenerNombreImagen($idImagen)." actualizado. catergoria: ".$_POST['imagenImagen'];
		echo "<script type='text/javascript'>location.href='admgestionarimagenes.php?mensaje=".$mensaje."';</script>";
	}
	
	
	
	
	
	
	
/***************************Main*********************************************/
	
	if (!isset($_GET['accion'])){
		echo "<hr /><a href='admgestionarimagenes.php?accion=1' class='btn btn-danger' >Añadir nueva imagen</a>";
		$imagenes=array();
		$imagenes=obtenerTodosLasImagenes();
		dibujarLayoutImagenesConArray($imagenes);
	}else{
		if ($_GET['accion']==1){
			crearNuevoImagen();
		}else if($_GET['accion']==2){
			actualizarImagen($_GET['idImagen']);
		}else if($_GET['accion']==3){
			confirmarBorrarImagen($_GET['idImagen']);
		}else if($_GET['accion']==5){
			borrarImagen($_GET['idImagen']);
		}else if($_GET['accion']==6){
			redirigirPorNoBorrar($_GET['idImagen']);
		}else if($_GET['accion']==4){
			//$objeto=urldecode(unserialize($_GET['imagen']));
			mostrarUnImagen($_GET['idImagen']);
		}else if($_GET['accion']==7){
			//$objeto=urldecode(unserialize($_GET['imagen']));
			cerrarSesion();
		}
		
	}
	if($_POST['accion'] == 12){
		aplicarInsercionImagen($_FILES);
	}
	if($_POST['accion'] == 22){
			
			aplicarActualizacionImagen($_POST['idImagen'], $_POST);
	}
/****************************************************************************/








	
dibujarPaginaAbajoAdministrador();
?>

