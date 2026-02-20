
<?php
session_start();
if ($_SESSION["claveusuario"] !="1c558dfd6f4148767d40386fa7b59c18e3b8627e") {
   header("Location: ../noautorizdo.php");
   exit();
}
	include("admdibujarhtml.php");
	require('../mysql.php');
	require('../Comentario.php');
	
	$pagina="admgestionarusuarios.php";
	dibujarhtmladministrador();
	dibujarMenuUsuarioNivel1();
	
	
	
	if (isset($_GET['mensaje'])) echo "<br /><span style='color:red'>".$_GET['mensaje']."</span><br /><br />";
	function convertirObjetoParaPasarPorURL(Comentario $objeto){
		//$argumento = urlencode(serialize($objeto));
		$argumento = serialize($objeto);
		return $argumento;	
	}
	function recuperarObjetoPasadoPorURL(Comentario $objeto){
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
	function obtenerNombreEmpresa($idEmpresa){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = 'SELECT * FROM empresas WHERE idEmpresa='.$idEmpresa.' ';
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysql_fetch_array($resultado, MYSQL_ASSOC)) 
		{
			return $linea['nombreEmpresa'];
		}
		$basededatos->desconectar();
	}
	function obtenerNombreComentario($idComentario){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM comentarios WHERE idComentario='".$idComentario."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysql_fetch_array($resultado, MYSQL_ASSOC)) 
		{
			return $linea['nombrecomentario'];
		}
		$basededatos->desconectar();
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
	function obtenerTodasLosComentarios(){
		$comentarios=array();
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = 'SELECT * FROM comentarios';
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysql_fetch_array($resultado, MYSQL_ASSOC)) 
		{
			$comentario=new Comentario($linea['idcomentario']);
		
			$comentario->setNombreComentario($linea['nombrecomentario']);
			$comentario->setTextoComentario($linea['textocomentario']);
			$comentario->setFechaComentario($linea['fechacomentario']);
			$comentario->setValidadoComentario($linea['validadocomentario']);
			$comentario->setIdWebComentario($linea['idwebcomentario']);
			$comentarios[]=$comentario;
		}
		$basededatos->desconectar();
		return $comentarios;
	}







	
	
	function dibujarLayoutComentarios($comentarios){
		$contador=0;
		echo "<div id='divcomentarios'>";
		echo "<h3>Ventana Comentarios.<br /></h3>";
		echo "<table class='ventana' width=100% border=0>";
				echo "<tr bgcolor='#FCD9FF'><th>Nombre comentario</th><th>texto</th><th>Fecha</th><th>Validado</th><th>web</th></tr>";
					foreach ($comentarios as $posicion=>$comentario){
						
						$bgcolor='#B3FFF3';
						$contador++;
						if (($contador%2)==0)
						{
							$bgcolor='#FAFEB1';
						}
					echo "<tr bgcolor=".$bgcolor.">";
					
							
							echo "<td>".$comentario->getNombreComentario()."<a href=admgestionarcomentarios.php?accion=3&idComentario=".$comentario->getIdComentario()." ><img src=../imagenes/borrar.png /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=admgestionarcomentarios.php?accion=2&idComentario=".$comentario->getIdComentario()." ><img src=../imagenes/actualizar.png /></a></td><td>".$comentario->getTextoComentario()."</td><td>".$comentario->getFechaComentario()."</td><td>".$comentario->getValidadoComentario()."</td><td>".obtenerNombreWeb($comentario->getIdWebComentario())."</td>";
						
						
						echo "</tr>";
			
					}
		echo "</table>\n";
		echo "</div>";
		
		
		
	}
	
	
	//
	
	
	function crearNuevaComentario($idWeb){
		?>
		<form method=post action='admgestionarcomentarios.php' class='form-horizontal'>
		
			<div class='form-group' >
		             <label for='nombreComentario' class='control-label col-md-2'>Nombre o direccion web:</label>
		            <div class='col-md-10'>
        						<input type='text' class='form-control' name='nombreComentario' id='nombreComentario' size=80 title='Se necesita un nombre' required >
                    </div>
		    </div> 
		    <div class='form-group' >
		               <label for='textoComentario' class='control-label col-md-2'>Descripcion:</label> 
		                <div class='col-md-10'>
                        	<textarea class='form-control' name='textoComentario' id='textoComentario' rows=10 cols=60></textarea>
                        </div>
		    </div>
		    <input type=hidden name='idWeb' value=$idWeb></input>  
		 	<input type=hidden name=accion value=12></input>  
		    <div class='form-group' > 
		          <div class='col-md-10 col-md-offset-2' >
                       <input type='submit' value='Insertar' class='btn btn-primary' ></input> 
                   </div>
		    </div> 
		
		  </form> 
        
        
        
        <?php
	}
	
	//
	
	
 	function actualizarComentario($idComentario){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = 'SELECT * FROM comentarios WHERE idComentario='.$idComentario.' ';
		$resultado=$basededatos->ejecutar_sql($consulta);
		$comentario=null;
		while ($linea = mysql_fetch_array($resultado, MYSQL_ASSOC)) 
		{
			$comentario=new Comentario($linea['idcomentario']);
		
			$comentario->setNombreComentario($linea['nombrecomentario']);
			$comentario->setTextoComentario($linea['textocomentario']);
			$comentario->setFechaComentario($linea['fechacomentario']);
			$comentario->setValidadoComentario($linea['validadocomentario']);
			$comentario->setIdWebComentario($linea['idwebcomentario']);
			
		
		}
		$basededatos->desconectar();
		echo"<h1>Menu Actualizar comentario</h1>";
	
		echo"<form method=post action='admgestionarcomentarios.php' >";
		echo"<table border= 0 bordercolor=black width=500px >";
		echo"  <tr> ";
		echo"              <th>Nombre comentario</th>";
		echo"              <td><input type= text  name=nombreComentario value='".$comentario->getNombreComentario()."' size=100 title='Se necesita un nombre' required ></input></td>";
		echo"   </tr>";
		echo"  <tr> ";
		echo"              <th>Nivel</th>";
		echo"              <td><textarea  name=textoComentario size=100 >".$comentario->getTextoComentario()."</textarea></td>";
		echo"   </tr>";
		echo"    <tr>"; 	
		echo" 		   <input type=hidden name=accion value=22></input>";
		echo" 		   <input type=hidden name=fechaComentario value='".$comentario->getFechaComentario()."'></input>";			
		echo" 		   <input type=hidden name=idComentario value='".$comentario->getIdComentario()."'></input>";	
		echo" 		   <input type=hidden name=idWebComentario value='".$comentario->getIdWebComentario()."'></input>";
		echo"          <td colspan=2  align=center><input type=submit value=Actualizar class='btn btn-primary' ></td>";
		echo"    </tr>";
		echo"</table>";
		echo" </form>";
		
		
	}
	function confirmarBorrarComentario($idComentario){
		$foto=rand(1, 7);
		echo "<br /><h3>¿Estas seguro que quieres borrar el comentario de ".obtenerNombreComentario($idComentario)."?, es muy bonito...</h3><br /><img src=../imagenes/bonito".$foto.".jpg></img><br />";
		echo "<h1><a href='admgestionarcomentarios.php?accion=5&idComentario=$idComentario'>SI</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<a href='admgestionarcomentarios.php?accion=6&idComentario=$idComentario'>NO</a></h1>";	
	}
	function borrarComentario($idComentario){
		
		
		
			$mensaje=obtenerNombreComentario($idComentario)." borrada. ";
			$bd= new Mysql();
			$bd->conectar_mysql();
			$sql="DELETE FROM comentarios WHERE idComentario='".$idComentario."' LIMIT 1";
			$bd->ejecutar_sql($sql);
			$bd->desconectar();
			echo "<script type='text/javascript'>location.href='admgestionarcomentarios.php?mensaje=$mensaje'</script>";
		
		
			
		
	}
	function redirigirPorNoBorrar($idComentario){
		$mensaje=obtenerNombreComentario($idComentario).", no borrado";
		echo "<script type='text/javascript'>location.href='admcomentarios.php?mensaje=$mensaje'</script>";
	}
	
	function mostrarUnComentario($idComentario){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = 'SELECT * FROM comentarios WHERE idComentario='.$idComentario.' ';
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysql_fetch_array($resultado, MYSQL_ASSOC)) 
		{
			echo"<table class='estiloformulario' border=0 width= 500px >";
				echo"  <tr> ";
				echo"              <th valign='top'>Nombre comentario</th>";
				echo"              <td><h3>".$linea['nombreComentario']."</h3><hr /></td>";
				echo"   </tr>";
				echo"   <tr> ";
				echo"              <th valign='top'>Experiencia:</th>";
				echo"              <td>".$linea['experienciaComentario']."</td>";
				echo"    </tr>";
				echo"              <th valign='top'>Fecha</th>";
				echo"              <td>".$linea['fechaComentario']."</td>";
				echo"   </tr>";
				echo"              <th valign='top'>Descripcion</th>";
				echo"              <td>".$linea['descripcionComentario']."</td>";
				echo"   </tr>";
				
				echo"  <tr> ";
				echo"              <th valign='top'>Comentario</th>";
				echo"              <td>".$linea['comentarioComentario']."</td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <th valign='top'>Empresa</th>";
				echo"              <td>".obtenerNombreEmpresa($linea['idEmpresa'])."</td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <td><a href=admcomentarios.php?accion=3&idComentario=".$linea['idComentario']." title='Borrar'><img src='imagenes/borrar.png'></img>Borrar</a></td>";
				echo"              <td><a href=admcomentarios.php?accion=2&idComentario=".$linea['idComentario']." title='Actualizar'><img src='imagenes/actualizar.png'></img>Actualizar</a></td>";
				echo"   </tr>";
			echo"</table>";
		}
		$basededatos->desconectar();
		
	
	}
	
	function aplicarInsercionComentario(){
		//obtenemos el nivel de la comentario
		$nivelComentario=obtenerNivelComentario($_POST[comentarioEsHijaDe]);
		$nivelComentario =$nivelComentario+1;
		$fecha=date("j/n/Y");
		$bd2= new Mysql();
		$bd2->conectar_mysql();
		$sql2="INSERT INTO comentarios VALUES ( '', '$_POST[nombreComentario]','$_POST[comentarioEsHijaDe]', '$_POST[comentarioEsPadreDe]', '$nivelComentario') ";
		$bd2->ejecutar_sql($sql2);
		$bd2->desconectar();
		$mensaje="Comentario nueva insertado. hija de: ".$_POST[comentarioEsHijaDe].", nivel: ".$nivelComentario ;
		echo "<script type='text/javascript'>location.href='admgestionarcomentarios.php?mensaje=".$mensaje."';</script>";
	}
	
	
	
	function aplicarActualizacionComentario($idComentario){
		$bd= new Mysql();
		$bd->conectar_mysql();
		$sql="update comentarios set nombreComentario='$_POST[nombreComentario]', textocomentario='$_POST[textoComentario]', fechacomentario='$_POST[fechaComentario]', validadocomentario='0', idwebcomentario='$_POST[idWebComentario]' where idcomentario='$idComentario'";
		$bd->ejecutar_sql($sql);
		$bd->desconectar();
		$mensaje="Comentario ".obtenerNombreComentario($idComentario)." actualizada.";
		echo "<script type='text/javascript'>location.href='admgestionarcomentarios.php?mensaje=".$mensaje."';</script>";
	}
	
	function cerrarSesion(){
		session_destroy();
		$mensaje="Sesion de administrador cerrada.";
		echo "<script type='text/javascript'>location.href='http://www.tipolisto.es/?mensaje=".$mensaje."';</script>";
		
	}
	
	
	
	
	
/***************************Main*********************************************/
	
	if (!isset($_GET['accion'])){
		$comentarios=array();
		$comentarios=obtenerTodasLosComentarios();
		dibujarLayoutComentarios($comentarios);
	}else{
		if ($_GET['accion']==1){
			crearNuevaComentario();
		}else if($_GET['accion']==2){
			actualizarComentario($_GET['idComentario']);
		}else if($_GET['accion']==3){
			echo "<br />La comentario es: ".$_GET['idComentario']."<br />";
			confirmarBorrarComentario($_GET['idComentario']);
		}else if($_GET['accion']==5){
			borrarComentario($_GET['idComentario']);
		}else if($_GET['accion']==6){
			redirigirPorNoBorrar($_GET['idComentario']);
		}else if($_GET['accion']==4){
			//$objeto=urldecode(unserialize($_GET['comentario']));
			mostrarUnacomentario($_GET['idComentario']);
		}else if($_GET['accion']==7){
			//$objeto=urldecode(unserialize($_GET['comentario']));
			cerrarSesion();
		}
		
	}
	if($_POST['accion'] == 12){
			aplicarInsercionComentario($_POST);
	}
	if($_POST['accion'] == 22){
			//$comentario=recuperarObjetoPasadoPorURL($_POST['comentario']);
			aplicarActualizacioncomentario($_POST['idComentario'], $_POST);
	}
/****************************************************************************/








	
dibujarPaginaAbajoAdministrador();
?>

