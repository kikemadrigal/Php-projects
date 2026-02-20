
<?php
session_start();
if ($_SESSION["claveusuario"] !="1c558dfd6f4148767d40386fa7b59c18e3b8627e") {
    header("Location: ../noautorizado.php?mensaje=$mensaje");
   exit();
}
	include("admdibujarhtml.php");
	require('../mysql.php');
	
	
	
	
	
	
	
	/*function convertirObjetoParaPasarPorURL(Categoria $objeto){
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
	}*/
	
	function obtenerNombreCategoria($idCategoria){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM pasear WHERE idPasear='".$idCategoria."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysql_fetch_array($resultado, MYSQL_ASSOC)) 
		{
			return $linea['nombrecategoria'];
		}
		$basededatos->desconectar();
	}
	
	
	function obtenerNombreWeb($idWeb){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT nombreweb FROM webs WHERE idweb='".$idWeb."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysql_fetch_array($resultado, MYSQL_ASSOC)) 
		{
			return $linea['nombreweb'];
		}
		$basededatos->desconectar();
	}
	
	
	
	
	


	function dibujarLayoutCategoriasDos(){
		$contador=0;
		echo "<div class='divpasear'>";
			$basededatos= new Mysql();
			$basededatos->conectar_mysql();
			$consulta= "SELECT * FROM pasear";
			$resultado=$basededatos->ejecutar_sql($consulta);
			$total_registros=mysql_num_rows($resultado);
			if($total_registros>50){
				$bd= new Mysql();
				$bd->conectar_mysql();
				$sql="DELETE FROM pasear WHERE idpasear>50";
				$bd->ejecutar_sql($sql);
				$bd->desconectar();
			}
			while ($linea = mysql_fetch_array($resultado, MYSQL_ASSOC)) 
			{
				echo "<br />";
				echo "ID pasear: ".$linea['idpasear'];
				echo ", ".obtenerNombreWeb($linea['idwebpasear'])."<a href='admgestionarpasear.php?accion=3&idPasear=$linea[idpasear]'><img src='../imagenes/borrar.png'></img></a>" ;
			}
			$basededatos->desconectar();
		echo "</div>";
	}








	function dameWebPasear(){
			echo"<form method=post action='admgestionarpasear.php' >";
				echo" <label for='nombreCategoria' class='control-label'>Dame la id de la web a incluir en pasear:</label>";
				echo"<input type='number'  name='idWeb' class='form-control' title='El id debe de contener entre 1 y 50 letras o números' placeholder='id:' pattern='[0-9]{1,50}' required></input>";
				echo"<input type=hidden name=accion value=2></input>";	
				echo" <input type=submit value='Meter en pasear' class='btn btn-primary btn-large' >";
			echo" </form>";
	}
		

	
	function aplicarInsercionPasear($idWeb){
		$bd= new Mysql();
		$bd->conectar_mysql();
		$sql="INSERT INTO pasear VALUES ( '', '$idWeb','') ";
		$bd->ejecutar_sql($sql);
		$bd->desconectar();
		$mensaje="Web ".obtenerNombreWeb($idWeb)." incluida en pasear.";
		echo "<script type='text/javascript'>location.href='admgestionarpasear.php?mensaje=".$mensaje."';</script>";
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		
	
	
	
	
	function confirmarBorrarPasear($idPasear){
		$foto=rand(1, 7);
		echo "<br /><h3>¿Estas seguro que quieres borrar ".$idPasear."?, es muy bonita...</h3><br /><img src=../imagenes/bonito".$foto.".jpg></img><br />";
		echo "<h1><a href='admgestionarpasear.php?accion=5&idPasear=$idPasear'>SI</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<a href='admgestionarpasear.php?accion=6&idPasear=$idPasear'>NO</a></h1>";	
	}
	function borrarPasear($idPasear){
		$mensaje=$idPasear." borrada. ";
		$bd= new Mysql();
		$bd->conectar_mysql();
		$sql="DELETE FROM pasear WHERE idpasear='".$idPasear."' LIMIT 1";
		$bd->ejecutar_sql($sql);
		$bd->desconectar();
		echo "<script type='text/javascript'>location.href='admgestionarpasear.php?mensaje=$mensaje'</script>";
	}
	function redirigirPorNoBorrar($idPasear){
		$mensaje=$idPasear.", no borrado";
		header('Location: http://www.gestorwebs.tipolisto.es/adm/admgestionarpasear.php?mensaje=$mensaje');
	}
	
	
	

	

	
	
/***************************Main*********************************************/
	
	if (!isset($_GET['accion'])){
		dibujarhtmladministrador();
		echo "<a href='admgestionarpasear.php?accion=1' id='aparecerpasear' class='btn btn-danger'>Añadir nueva web en pasear</a>";
		//echo "<a href='admgestionarpasear.php?accion=2' id='aparecerpasear' class='btn btn-danger'>Añadir nueva categor&iacute;a en pasear</a>";
		if (isset($_GET['mensaje'])) echo "<br /><span style='color:red'>".$_GET['mensaje']."</span><br /><br />";
		dibujarLayoutCategoriasDos();
	}else{
		if ($_GET['accion']==1){
			dibujarhtmladministrador();
			dameWebPasear();
		}else if($_GET['accion']==3){ //muestra menu para borrar una categoría
			dibujarhtmladministrador();
			confirmarBorrarPasear($_GET['idPasear']);
		}else if($_GET['accion']==5){
			borrarPasear($_GET['idPasear']);
		}else if($_GET['accion']==6){
			dibujarhtmladministrador();
			redirigirPorNoBorrar($_GET['idPasear']);
		}else if($_GET['accion']==7){
			cerrarSesion();
		}
		
	}
	if($_POST['accion'] ==2){
			aplicarInsercionPasear($_POST['idWeb']);
	}/*else if($_POST['accion'] == 22){
		cho "<p>Pasa por el if de actualizar nombre</p>";
			aplicarActualizacionNombreCategoria($_POST['idPasear']);
	}else if($_POST['accion'] == 23){
			aplicarActualizacionPadreCategoria($_POST['idPasear']);
	}*/
/****************************************************************************/








	
dibujarPaginaAbajoAdministrador();
?>

