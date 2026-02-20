<?php
session_start();
if(isset($_COOKIE['idusuario'])){
	require('../Mysql.php');
	//echo "<h1>usuario:".$_COOKIE['idusuario']."</h1>";
	 abrirSesionUsuario($_COOKIE['idusuario']);
}
if (!isset($_SESSION["idusuario"])) {
    header("Location: ../noautorizado.php?mensaje=$mensaje");
   exit();
}
function abrirSesionUsuario($idusuario){
	$basededatos= new Mysql();
	$basededatos->conectar_mysql();
	$consulta  = "SELECT * FROM usuarios WHERE idusuario='".$idusuario."' LIMIT 1";
	$resultado=$basededatos->ejecutar_sql($consulta); 
	while ($linea = mysqli_fetch_array($resultado )) 
	{
			$_SESSION['claveusuario']=$linea['claveusuario'];
			$_SESSION['idusuario']=$linea['idusuario'];
			$_SESSION['nombreusuario']=$linea['nombreusuario'];
			$_SESSION['nivelaccesousuario']=$linea['nivelaccesousuario'];
			$_SESSION['validadousuario']=$linea['validadousuario'];			
	}
}

	include("usuariosdibujarhtml.php");
	require('../mysqlusuarios.php');
	require('../Categoria.php');
	dibujarhtmlUsuarios();
	
	
	echo "<div id='menuadministrador'>";
		echo "<table width=100% border=0>";
				echo "<tr><td>";
		echo "<a href='usuariosgestionarcategorias.php?accion=1' id='aparecercategorias' class='btn btn-danger'>Añadir categoria nueva</a>";
		
		//echo "&nbsp;<a href='usuariosgestionarcategorias.php?accion=7' ><img src='../imagenes/cerrarsesion.png' ></img></a>";
		echo "</td></tr>";
		echo "</table>";
	echo "</div>";
	
	
	
	
	
	if (isset($_GET['mensaje'])) echo "<br /><span style='color:red'>".$_GET['mensaje']."</span><br />";
	function convertirObjetoParaPasarPorURL(Categoria $objeto){
		//$argumento = urlencode(serialize($objeto));
		$argumento = serialize($objeto);
		return $argumento;	
	}
	function recuperarObjetoPasadoPorURL(Categoria $objeto){
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
	function obtenerTotalRegistros(){
		$basededatos= new mysqlusuarios();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM webs_".$_SESSION['idusuario']." ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		$total_registros=mysqli_num_rows($resultado);
		return $total_registros;
		$basededatos->desconectar();
	}
	function obtenerNombreCategoria($idCategoria){
		$basededatos= new mysqlusuarios();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM categorias_".$_SESSION['idusuario']." WHERE idCategoria='".$idCategoria."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			return $linea['nombrecategoria'];
		}
		$basededatos->desconectar();
	}
	
	
	function obtenerIdPadreCategoria($idCategoria){
		$basededatos= new mysqlusuarios();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT idpadrecategoria FROM categorias_".$_SESSION['idusuario']." WHERE idCategoria='".$idCategoria."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			return $linea['idpadrecategoria'];
		}
		$basededatos->desconectar();
	}
	function obtenerNivelCategoria($idCategoria){
		
		
		$basededatos= new mysqlusuarios();
		$basededatos->conectar_mysql();
		$consulta  ="SELECT nivelcategoria FROM categorias_".$_SESSION['idusuario']." WHERE idcategoria='".$idCategoria."' LIMIT 1 ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		$num_reg=mysqli_num_rows($resultado);
		if($num_reg==null){
			 echo "<br />No hubo resultados en nivel categorias<br />";
			 $nivelcategoria=null;
			 return $nivelcategoria;
		}
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			return $linea['nivelcategoria'];
		}
		$basededatos->desconectar();
		
		
		
	}
	
	
	
	function obtenerTodasLasCategorias(){
		$categorias=array();
		$basededatos= new mysqlusuarios();
		$basededatos->conectar_mysql();
		$consulta  = 'SELECT * FROM categorias_".$_SESSION[idusuario]." ORDER BY nivelcategoria';
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$categoria=new Categoria($linea['idcategoria']);
		
			$categoria->setNombreCategoria($linea['nombrecategoria']);
			$categoria->setTituloCategoria($linea['tituloCategoria']);
			$categoria->setCategoriaEsHijaDe($linea['categoriaeshijade']);
			$categoria->setIdPadreCategoria($linea['idpadrecategoria']);
			$categoria->setNivelCategoria($linea['nivelcategoria']);
			$categorias[]=$categoria;
		}
		$basededatos->desconectar();
		return $categorias;
	}
	
	/*function recorrerCategorias($nivelCategoria, $categoriaeshijade){
		echo "has entrado en recorrer categorias, usuario: ".$_SESSION['idusuario']."<br>";
		$nivelCategoria++;
		$basededatos1= new mysqlusuarios();
		$basededatos1->conectar_mysql();
		$consulta1  = "SELECT * FROM categorias_".$_SESSION['idusuario']." WHERE nivelcategoria='".$nivelCategoria."' && categoriaeshijade='".$categoriaeshijade."' ORDER BY nombrecategoria";

		
		$resultado1=$basededatos1->ejecutar_sql($consulta1);
		echo count($resultado1);
		for($i=2;$i<$nivelCategoria;$i++){
			$espacios=$espacios."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		while ($linea1 = mysqli_fetch_array($resultado1)) 
		{
			echo var_dump($linea1);
			echo "<li>".$espacios."|__  <a href=usuariosgestionarcategorias.php?accion=2&idCategoria=$linea1[idcategoria] > ".$linea1['nombrecategoria']."</a>&nbsp;&nbsp;<a href=usuariosgestionarcategorias.php?accion=3&idCategoria=$linea1[idcategoria]><img src='../imagenes/eliminar.png'></img></a></li>";
			if ($linea1['categoriaeshijade'] != null){
				//recorrerCategorias($nivelCategoria, $linea1['nombrecategoria'] );	
				echo "hay va el nuvel ".$nivelCategoria." es hija de: ".$categoriaeshijade."<br>";				
			}
		}
		$basededatos1->desconectar();
	}*/

	function recorrerCategorias($nivelCategoria, $idpadrecategoria){
		//echo "has entrado en recorrer categorias, usuario: ".$_SESSION['idusuario']."<br>";
		$nivelCategoria++;
		$basededatos1= new mysqlusuarios();
		$basededatos1->conectar_mysql();
		$consulta1  = "SELECT * FROM categorias_".$_SESSION['idusuario']."  ORDER BY nombrecategoria";
		//$consulta1  = "SELECT * FROM categorias_".$_SESSION['idusuario']."  WHERE nivelcategoria=".$nivelCategoria." ORDER BY nombrecategoria";
		//$consulta1  = "SELECT * FROM categorias_".$_SESSION['idusuario']." WHERE nivelcategoria=".$nivelCategoria." AND idpadrecategoria=".$idpadrecategoria." ORDER BY nombrecategoria";
		$resultado1=$basededatos1->ejecutar_sql($consulta1);
		//echo count($resultado1);
		for($i=2;$i<$nivelCategoria;$i++){
			$espacios=$espacios."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		while ($linea1 = mysqli_fetch_array($resultado1)) 
		{
			//echo var_dump($linea1);
			echo "<li>".$espacios."|__  <a href=usuariosgestionarcategorias.php?accion=2&idCategoria=$linea1[idcategoria] > ".$linea1['nombrecategoria']."</a>&nbsp;&nbsp;<a href=usuariosgestionarcategorias.php?accion=3&idCategoria=$linea1[idcategoria]><img src='../imagenes/eliminar.png'></img></a></li>";
			if ($linea1['categoriaeshijade'] != null){
				recorrerCategorias($nivelCategoria, $linea1['idpadrecategoria']  );	
				//echo "hay va el nuvel ".$nivelCategoria." es hija de: ".$categoriaeshijade."<br>";				
			}
		}
		$basededatos1->desconectar();
	}



	function dibujarLayoutCategoriasDos(){
		$nivelCategoria=1;
		echo "<div class='divcategorias'>";
			$basededatos= new mysqlusuarios();
			$basededatos->conectar_mysql();
			$consulta= "SELECT * FROM categorias_".$_SESSION['idusuario']." WHERE nivelcategoria=".$nivelCategoria." ORDER BY nombrecategoria";
			$resultado=$basededatos->ejecutar_sql($consulta);
			echo "<ul style='list-style:none'>";
					while ($linea = mysqli_fetch_array($resultado)) 
					{
							echo "<li>".$linea['nombrecategoria']."</li>";
							//echo "hay va el nuvel ".$nivelCategoria." el nombre: ".$linea['nombrecategoria'] ."<br>";
							recorrerCategorias($nivelCategoria,0 );	
					}
					$basededatos->desconectar();
			echo "</ul>";
		echo "</div>";
	}

		















/*****************************************prueba****************************************************/

	function recorrerCategoriasPrueba($categoriaeshijade){
		$nivelCategoria++;
		$basededatos1= new mysqlusuarios();
		$basededatos1->conectar_mysql();
		$consulta1  = "SELECT * FROM categorias_".$_SESSION['idusuario']." WHERE categoriaeshijade='".$categoriaeshijade."' ORDER BY nombrecategoria";
		$resultado1=$basededatos1->ejecutar_sql($consulta1);
		for($i=2;$i<$nivelCategoria;$i++){
			$espacios=$espacios."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		while ($linea1 = mysqli_fetch_array($resultado1)) 
		{
			echo "<li>".$espacios."|__  <a href=usuariosgestionarcategorias?accion=2&idCategoria=$linea1[idcategoria] > ".$linea1['nombrecategoria']."</a>&nbsp;&nbsp;<a href=usuariosgestionarcategorias?accion=3&idCategoria=$linea1[idcategoria]><img src='../imagenes/eliminar.png'></img></a></li>";
			if ($linea1['categoriaeshijade'] != null){
				recorrerCategorias($linea1['nombrecategoria'] );							
			}
		}
		$basededatos1->desconectar();
	}

	function dibujarLayoutCategorias(){
		$nivelCategoria=1;
		echo "<div class='divcategorias'>";
			$basededatos= new mysqlusuarios();
			$basededatos->conectar_mysql();
			$consulta= "SELECT * FROM categorias_".$_SESSION['idusuario']." ORDER BY nombrecategoria";
			$resultado=$basededatos->ejecutar_sql($consulta);
			echo "<ul style='list-style:none'>";
					while ($linea = mysqli_fetch_array($resultado)) 
					{
							echo "<li>".$linea['nombrecategoria']."</li>";
							recorrerCategoriasPrueba($linea['nombrecategoria'] );	
					}
					$basededatos->desconectar();
			echo "</ul>";
		echo "</div>";
	}
/******************************************************************************************************/

			
	
	function recorrerCategoriasConSelect($nivelCategoria, $categoriaeshijade){
		$nivelCategoria++;
		
		$basededatos1= new mysqlusuarios();
		$basededatos1->conectar_mysql();
		$consulta1  = "SELECT * FROM categorias_".$_SESSION['idusuario']." WHERE nivelcategoria='".$nivelCategoria."' && idpadrecategoria='".$categoriaeshijade."' ORDER BY nombrecategoria";
		$resultado1=$basededatos1->ejecutar_sql($consulta1);
		for($i=1;$i<$nivelCategoria;$i++){
			$espacios=$espacios."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		while ($linea1 = mysqli_fetch_array($resultado1)) 
		{
			echo "<option value='".$linea1['idcategoria']."' >".$espacios.$linea1['nombrecategoria']."</option>";
			if ($linea1['categoriaeshijade'] != null){
				 recorrerCategoriasConSelect($nivelCategoria, $linea1[idcategoria] );			
			}
		}
		$basededatos1->desconectar();
	}
			

	
	function crearNuevaCategoria(){
		
		echo"<p>Menu insertar nueva categoria</p>";
		echo"<form method=post action='usuariosgestionarcategorias.php' class='form-horizontal'>";
	
		echo" <div class='form-group' > ";
				echo"<label for='nombreCategoria' class='control-label'>Nombre categoria:</label>";
					echo" <div  > ";
						echo"<input type='text' class='form-control'  name='nombreCategoria'  title='El nombre debe de contener entre 4 y 50 letras o números' pattern='[a-zA-Z0-9\d_- áéíóúÁÉÍÓÚÑñ]{4,50}' placeholder='Nombre:'  required />";
					echo" </div> ";
					echo"<label for='tituloCategoria' class='control-label'>Titulo:</label>";
					echo" <div  > ";
						echo"<input type='text' class='form-control'  name='tituloCategoria'  id='tituloCategoria' title='El t&iacute;tulo debe de contener entre 4 y 5000 letras o números' pattern='[a-zA-Z0-9\d_- áéíóúÁÉÍÓÚÑñ]{4,5000}' placeholder='Nombre:'  required />";
					echo" </div> ";
		echo" </div>";
		echo" <div class='form-group' > ";
			echo "<label for='categoriaEsHijaDe' class='control-label '>Es hija de:</label>";
			echo" <div  > ";
				echo "<select name='categoriaEsHijaDe' class='form-control' required> ";
								//echo "<option value='Base' >Base</option>";
								$nivelCategoria=1;
								$basededatos= new mysqlusuarios();
								$basededatos->conectar_mysql();
								$consulta= "SELECT * FROM categorias_".$_SESSION['idusuario']." WHERE nivelcategoria=".$nivelCategoria." ORDER BY nombrecategoria";
								$resultado=$basededatos->ejecutar_sql($consulta);
								while ($linea = mysqli_fetch_array($resultado)) 
								{
										echo "<option value='".$linea['idcategoria']."' >".$linea['nombrecategoria']."</option>";
										recorrerCategoriasConSelect($nivelCategoria, $linea[idcategoria] );
								}
								$basededatos->desconectar();
						echo "</select>";
			echo" </div> ";
		echo" </div> ";
		echo" <div class='form-group' > ";
			echo "<div class='col-md-offset-2' >";
				echo "<input type=hidden name=accion value=12></input> ";
				echo"<input type=submit value='Insertar nueva categoria' class='btn btn-primary btn-large' ></input>";
			echo"    </div>";
		echo"    </div>";
		echo" </form>";
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
 	/*function actualizarCategoria($idCategoria){
		$basededatos= new mysqlusuarios();
		$basededatos->conectar_mysql();
		$consulta  = 'SELECT * FROM categorias_".$_SESSION['idusuario']." WHERE idCategoria='.$idCategoria.' ';
		$resultado=$basededatos->ejecutar_sql($consulta);
		$categoria=null;
		while ($linea = mysqli_fetch_array($resultado)) 
		{
				$categoria=new Categoria($linea['idcategoria']);
				$categoria->setNombreCategoria($linea['nombrecategoria']);
				$categoria->setNivelCategoria($linea['nivelcategoria']);
				$categoria->setCategoriaEsHijaDe($linea['categoriaeshijade']);
				$categoria->setIdPadreCategoria($linea['idpadrecategoria']);
		
		}
		$basededatos->desconectar();
		echo"<p>Menu Actualizar categoria</p>";
	
		echo"<form method=post action='usuariosgestionarcategorias.php' >";
		
		echo" <div class='form-group' > ";
				echo" <label for='nombreCategoria' class='control-label'>Nombre categoria:</label>";
				echo" <div  > ";
					echo"<input type= text  name=nombreCategoria value='".$categoria->getNombreCategoria()."' class='form-control' title='El nombre debe de contener entre 4 y 15 letras o números' placeholder='Nombre:' pattern='[a-zA-Z0-9\d_]{4,15}' required></input>";
				echo" </div> ";
		echo" </div> ";
		echo" <div class='form-group' > ";
		
			echo " <label for='categoriaEsHijaDe' class='control-label '>Cambiar a hija de:</label>";
			echo" <div  > ";
				//echo "Asignado:<p>".$categoria->getCategoriaEsHijaDe()."</p>";
				echo "<select name='categoriaEsHijaDe' class='form-control' required> ";
								echo "<option value='".$categoria->getIdCategoria()."' >".$categoria->getCategoriaEsHijaDe()."</option>";
								//echo "<option value='Base' >Base</option>";
								$nivelCategoria=1;
								$basededatos= new mysqlusuarios();
								$basededatos->conectar_mysql();
								$consulta= "SELECT * FROM categorias_".$_SESSION['idusuario']." WHERE nivelcategoria=".$nivelCategoria." ORDER BY nombrecategoria";
								$resultado=$basededatos->ejecutar_sql($consulta);
								while ($linea = mysqli_fetch_array($resultado)) 
								{
										echo "<option value='".$linea['idcategoria']."' >".$linea['nombrecategoria']."</option>";
										recorrerCategoriasConSelect($nivelCategoria, $linea[idcategoria] );
								}
								$basededatos->desconectar();
				echo "</select>";
			echo" </div> ";
		echo" </div> ";
		echo" <div class='form-group' > ";
			echo "<div class='col-md-offset-2' >";
				echo" 		   <input type=hidden name=accion value=22></input>";	
				echo" 		   <input type=hidden name=idCategoria value=".$_GET['idCategoria']."></input>";
				echo"          <input type=submit value=Actualizar class='btn btn-primary btn-large' >";
			echo"    </div>";
		echo"    </div>";
	
		echo" </form>";
		
		
	}
	*/
	
	
	
	
	
	
	
	
		
	
 	function actualizarCategoriaDos($idCategoria){
		// echo "vamos a ver la categoria: ".$idCategoria;
		
		$basededatos= new mysqlusuarios();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM categorias_".$_SESSION['idusuario']." WHERE idCategoria='".$idCategoria."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		$categoria=null;
		while ($linea = mysqli_fetch_array($resultado)) 
		{
				$categoria=new Categoria($linea['idcategoria']);
				$categoria->setNombreCategoria($linea['nombrecategoria']);
				$categoria->setTituloCategoria($linea['titulocategoria']);
				$categoria->setNivelCategoria($linea['nivelcategoria']);
				$categoria->setCategoriaEsHijaDe($linea['categoriaeshijade']);
				$categoria->setIdPadreCategoria($linea['idpadrecategoria']);
		
		}
		$basededatos->desconectar();
		echo"<p>Menu Actualizar categoria: ".obtenerNombreCategoria($categoria->getIdCategoria())."</p>";
	
		echo"<form method=post action='usuariosgestionarcategorias.php' >";
				echo" <label for='nombreCategoria' class='control-label'>Nombre categoria:</label>";
				echo"<input type= text  name='nombreCategoria' id='nombreCategoria' value='".$categoria->getNombreCategoria()."' class='form-control' title='El nombre debe de contener entre 4 y 50 letras o números' placeholder='Nombre:' pattern='[a-zA-Z0-9\d_- áéíóúÁÉÍÓÚÑñ]{4,50}' required></input>";
				echo"<input type=hidden name=accion value=22></input>";	
				echo"<input type=hidden name=idCategoria value='".$categoria->getIdCategoria()."'></input>";
				echo"<input type=submit value='Actualizar nombre' class='btn btn-primary btn-large' >";
		echo" </form>";
		
		echo"<form method=post action='usuariosgestionarcategorias.php' >";
				echo" <label for='tituloCategoria' class='control-label'>T&iacute;tulo:</label>";
				echo"<input type= text  name='tituloCategoria' id='tituloCategoria' value='".$categoria->getTituloCategoria()."' class='form-control' title='El t&iacute;tulo debe de contener entre 4 y 5000 letras o números' placeholder='Nombre:' pattern='[a-zA-Z0-9\d_- áéíóúÁÉÍÓÚÑñ]{4,5000}' required></input>";
				echo"<input type=hidden name=accion value=24></input>";	
				echo"<input type=hidden name=idCategoria value='".$categoria->getIdCategoria()."'></input>";
				echo"<input type=submit value='Actualizar t&iacute;tulo' class='btn btn-primary btn-large' >";
		echo" </form>";
		
		
		echo"<form method=post action='usuariosgestionarcategorias.php' >";
		echo" <div class='form-group' > ";
		
			echo " <label for='categoriaEsHijaDe' class='control-label '>Cambiar a hija de:</label>";
			echo" <div  > ";
				//echo "Asignado:<p>".$categoria->getCategoriaEsHijaDe()."</p>";
				echo "<select name='categoriaEsHijaDe' class='form-control' required> ";
								echo "<option value='".$categoria->getIdCategoria()."' >".$categoria->getCategoriaEsHijaDe()."</option>";
								//echo "<option value='Base' >Base</option>";
								$nivelCategoria=1;
								$basededatos= new mysqlusuarios();
								$basededatos->conectar_mysql();
								$consulta= "SELECT * FROM categorias_".$_SESSION['idusuario']." WHERE nivelcategoria=".$nivelCategoria." ORDER BY nombrecategoria";
								$resultado=$basededatos->ejecutar_sql($consulta);
								while ($linea = mysqli_fetch_array($resultado)) 
								{
										echo "<option value='".$linea['idcategoria']."' >".$linea['nombrecategoria']."</option>";
										recorrerCategoriasConSelect($nivelCategoria, $linea[idcategoria] );
								}
								$basededatos->desconectar();
				echo "</select>";
			echo" </div> ";
		echo" </div> ";
		echo" <div class='form-group' > ";
			echo "<div  >";
				echo" 		   <input type=hidden name=accion value=23></input>";	
				echo" 		   <input type=hidden name=idCategoria value=".$_GET['idCategoria']."></input>";
				echo"          <input type=submit value='Actualizar grupo' class='btn btn-primary btn-large' >";
			echo"    </div>";
		echo"    </div>";
	
		echo" </form>";
				
	}
	
	
	
	
	
	
	
	
	function confirmarBorrarCategoria($idCategoria){
		$foto=rand(1, 7);
		echo "<br /><h3>¿Estas seguro que quieres borrar ".obtenerNombreCategoria($idCategoria)."?, es muy bonita...</h3><br /><img src=../imagenes/bonito".$foto.".jpg></img><br />";
		echo "<h1><a href='usuariosgestionarcategorias.php?accion=5&idCategoria=$idCategoria'>SI</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<a href='usuariosgestionarcategorias.php?accion=6&idCategoria=$idCategoria'>NO</a></h1>";	
	}
	
	
	
	function comprobarSiOtrasTienenEstaCategoriaComoPadre($idCategoria){
		$basededatos= new mysqlusuarios();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM categorias_".$_SESSION['idusuario']." WHERE idpadrecategoria='".$idCategoria."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		if(mysqli_num_rows($resultado)>0){
			return true;
		}else{
			return false;	
		}
		$basededatos->desconectar();
		
	}
	
	
	
	function borrarCategoria($idCategoria){
			$comprobacionPadre=comprobarSiOtrasTienenEstaCategoriaComoPadre($idCategoria);
			if($comprobacionPadre==true){
				$mensaje=" La categoria: ".obtenerNombreCategoria($idCategoria).", tiene hijos y no puede ser borrada.";
				echo "<script type='text/javascript'>location.href='usuariosgestionarcategorias.php?mensaje=$mensaje'</script>";
			}else{
		
				
					$mensaje=obtenerNombreCategoria($idCategoria)." borrada. ";
					$bd= new mysqlusuarios();
					$bd->conectar_mysql();
					$sql="DELETE FROM categorias_".$_SESSION['idusuario']." WHERE idCategoria='".$idCategoria."' LIMIT 1";
					$bd->ejecutar_sql($sql);
					$bd->desconectar();
					echo "<script type='text/javascript'>location.href='usuariosgestionarcategorias.php?mensaje=$mensaje'</script>";
		
		}
			
		
	}
	function redirigirPorNoBorrar($idCategoria){
		$mensaje=obtenerNombreCategoria($idCategoria).", no borrado";
		echo "<script type='text/javascript'>location.href='usuariosgestionarcategorias.php?mensaje=$mensaje'</script>";
	}
	
	/*function mostrarUnCategoria($idCategoria){
		$basededatos= new mysqlusuarios();
		$basededatos->conectar_mysql();
		$consulta  = 'SELECT * FROM categorias_".$_SESSION['idusuario']." WHERE idCategoria='.$idCategoria.' ';
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			echo"<table class='estiloformulario' border=0 width= 500px >";
				echo"  <tr> ";
				echo"              <th valign='top'>Nombre categoria</th>";
				echo"              <td><h3>".$linea['nombreCategoria']."</h3><hr /></td>";
				echo"   </tr>";
				echo"   <tr> ";
				echo"              <th valign='top'>Experiencia:</th>";
				echo"              <td>".$linea['experienciaCategoria']."</td>";
				echo"    </tr>";
				echo"              <th valign='top'>Fecha</th>";
				echo"              <td>".$linea['fechaCategoria']."</td>";
				echo"   </tr>";
				echo"              <th valign='top'>Descripcion</th>";
				echo"              <td>".$linea['descripcionCategoria']."</td>";
				echo"   </tr>";
				
				echo"  <tr> ";
				echo"              <th valign='top'>Comentario</th>";
				echo"              <td>".$linea['comentarioCategoria']."</td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <th valign='top'>Empresa</th>";
				echo"              <td>".obtenerNombreEmpresa($linea['idEmpresa'])."</td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <td><a href=usuariosgestionarcategorias.php?accion=3&idCategoria=".$linea['idCategoria']." title='Borrar'><img src='imagenes/borrar.png'></img>Borrar</a></td>";
				echo"              <td><a href=usuariosgestionarcategorias.php?accion=2&idCategoria=".$linea['idCategoria']." title='Actualizar'><img src='imagenes/actualizar.png'></img>Actualizar</a></td>";
				echo"   </tr>";
			echo"</table>";
		}
		$basededatos->desconectar();
		
	
	}*/
	
	function aplicarInsercionCategoria(){
		if(obtenerTotalRegistros()>1000){
			$mensaje="Categoría no insertada, no puedes meter más de 20 categorías.";
			echo "<script type='text/javascript'>location.href='usuariosgestionarwebs.php?mensaje=".$mensaje."';</script>";
		}else{
			$nivelCategoria=obtenerNivelCategoria($_POST[categoriaEsHijaDe]);
			$nivelCategoria++;
			$nombrePadre=obtenerNombreCategoria($_POST[categoriaEsHijaDe]);
			$bd2= new mysqlusuarios();
			$bd2->conectar_mysql();
			$sql2="INSERT INTO categorias_".$_SESSION['idusuario']." VALUES ( '', '$_POST[nombreCategoria]', '$_POST[tituloCategoria]','$nombrePadre', '$_POST[categoriaEsHijaDe]', '$nivelCategoria') ";
			$bd2->ejecutar_sql($sql2);
			$bd2->desconectar();
			$mensaje="Categoria ".$_POST[nombreCategoria]." nueva insertada.";
			echo "<script type='text/javascript'>location.href='usuariosgestionarcategorias.php?mensaje=".$mensaje."';</script>";
		}
	}
	
	
	
	
	function actualizarTodosLosNombreConElIdPadreCategoria($idCategoria){
		
		$nombreNuevoCategoria=obtenerNombreCategoria($idCategoria);
		$bd2= new mysqlusuarios();
		$bd2->conectar_mysql();
		$sql2="update categorias_".$_SESSION['idusuario']." set categoriaeshijade='$nombreNuevoCategoria' where idpadrecategoria='$idCategoria'";
		$bd2->ejecutar_sql($sql2);
		$bd2->desconectar();
		
		
		
		
		
	}
	
	
	
	
	function aplicarActualizacionNombreCategoria($idCategoria){
		$bd= new mysqlusuarios();
		$bd->conectar_mysql();
		$sql="update categorias_".$_SESSION['idusuario']." set nombrecategoria='$_POST[nombreCategoria]' where idcategoria='$idCategoria'";
		$bd->ejecutar_sql($sql);
		$bd->desconectar();
		actualizarTodosLosNombreConElIdPadreCategoria($idCategoria);
		$mensaje="Categoria ".obtenerNombreCategoria($idCategoria)." actualizada.";
		echo "<script type='text/javascript'>location.href='usuariosgestionarcategorias.php?mensaje=".$mensaje."';</script>";
	}
	
	function aplicarActualizacionTituloCategoria($idCategoria){
		$bd= new mysqlusuarios();
		$bd->conectar_mysql();
		$sql="update categorias_".$_SESSION['idusuario']." set titulocategoria='$_POST[tituloCategoria]' where idcategoria='$idCategoria'";
		$bd->ejecutar_sql($sql);
		$bd->desconectar();
		$mensaje="Titulo de la categoria ".obtenerNombreCategoria($idCategoria)." actualizado.";
		echo "<script type='text/javascript'>location.href='usuariosgestionarcategorias.php?mensaje=".$mensaje."';</script>";
	}
	
	
	
	function aplicarActualizacionPadreCategoria($idCategoria){
		if($_POST[categoriaEsHijaDe] != $idCategoria){
			$nombreCategoria=obtenerNombreCategoria($idCategoria);
			$nivelCategoria=obtenerNivelCategoria($_POST[categoriaEsHijaDe]);
			$nivelCategoria++;
			$nombrePadre=obtenerNombreCategoria($_POST[categoriaEsHijaDe]);	
			$bd= new mysqlusuarios();
			$bd->conectar_mysql();
			$sql="update categorias_".$_SESSION['idusuario']." set nombrecategoria='$nombreCategoria', categoriaeshijade='$nombrePadre', idpadrecategoria='$_POST[categoriaEsHijaDe]', nivelcategoria='$nivelCategoria' where idcategoria='$idCategoria'";
			/*$sql="update categorias_".$_SESSION['idusuario']." set nombrecategoria='$nombreCategoria', categoriaeshijade='$nombrePadre', idpadrecategoria='$_POST[categoriaEsHijaDe]', nivelcategoria='$nivelCategoria' where idcategoria='$idCategoria'";*/
			$bd->ejecutar_sql($sql);
			$bd->desconectar();
			actualizarTodosLosNombreConElIdPadreCategoria($idCategoria);
			$mensaje="Categoria ".obtenerNombreCategoria($idCategoria)." actualizada.";
			echo "<script type='text/javascript'>location.href='usuariosgestionarcategorias.php?mensaje=".$mensaje."';</script>";
		}else{
			echo "<script type='text/javascript'>location.href='usuariosgestionarcategorias.php?';</script>";
		}
	}
	
	function cerrarSesion(){
		session_destroy();
		$mensaje="Sesion de administrador cerrada.";
		echo "<script type='text/javascript'>location.href='..index.php?mensaje=".$mensaje."';</script>";
		
	}
	
	
	
	
	
/***************************Main*********************************************/

	if (!isset($_GET['accion'])){
		dibujarLayoutCategoriasDos();
		//echo "NO existe accion";
		//dibujarLayoutCategorias();
	}else{
		if ($_GET['accion']==1){
			crearNuevaCategoria();
		}else if($_GET['accion']==2){
			actualizarCategoriaDos($_GET['idCategoria']);
		}else if($_GET['accion']==3){
			confirmarBorrarCategoria($_GET['idCategoria']);
		}else if($_GET['accion']==5){
			borrarCategoria($_GET['idCategoria']);
		}else if($_GET['accion']==6){
			redirigirPorNoBorrar($_GET['idCategoria']);
		}/*else if($_GET['accion']==4){
			mostrarUnacategoria($_GET['idCategoria']);
		}*/else if($_GET['accion']==7){
			cerrarSesion();
		}
		
	}
	if($_POST['accion'] == 12){
			aplicarInsercionCategoria($_POST);
	}else if($_POST['accion'] == 22){
		//echo "<p>Pasa por el if de actualizar nombre</p>";
			aplicarActualizacionNombreCategoria($_POST['idCategoria']);
	}else if($_POST['accion'] == 23){
			aplicarActualizacionPadreCategoria($_POST['idCategoria']);
	}else if($_POST['accion'] == 24){
		aplicarActualizacionTituloCategoria($_POST['idCategoria']);
	}
/****************************************************************************/








	
 dibujarPaginaAbajoUsuarios();
?>

