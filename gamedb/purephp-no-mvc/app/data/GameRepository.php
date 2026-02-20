<?php
class GameRepository{ 



/**********************************************************************************************
* 										SELECT
**********************************************************************************************/
/**
 * Esta función es utilizada en updateUser
 */
public static function getTitleById($id){
	$basededatos= new MysqliClient();
	$basededatos->conectar_mysql();
	$consulta  = "SELECT title FROM games WHERE id='".$id."' ";
	$resultado=$basededatos->ejecutar_sql($consulta);
	while ($linea = mysqli_fetch_array($resultado)) 
	{
		return $linea['title'];
	}
	$basededatos->desconectar();
}
public static function getAuthorById($id){
	$basededatos= new MysqliClient();
	$basededatos->conectar_mysql();
	$consulta  = "SELECT author FROM games WHERE id='$id' ";
	$resultado=$basededatos->ejecutar_sql($consulta);
	while ($linea = mysqli_fetch_array($resultado)) 
	{
		return $linea['author'];
	}
	$basededatos->desconectar();
}




/**
 * Parametros:
 * start registro de inicio
 * end: maximos registros a buscar
 */
 
public static function getAll($start, $end){
	$games=array();
	$basededatos= new MysqliClient();
	$basededatos->conectar_mysql();
	$consulta  = "SELECT * FROM games ORDER BY title limit ".$start .", ".$end."";
	$resultado=$basededatos->ejecutar_sql($consulta);
	while ($linea = mysqli_fetch_array($resultado)) 
	{
		$game=new Game($linea['id']);
		$game->setTitle($linea['title']);
		$game->setCover($linea['cover']);
		$game->setInstructions($linea['instructions']);
		$game->setCountry($linea['country']);
		$game->setPublisher($linea['publisher']);
		$game->setDeveloper($linea['developer']);
		$game->setYear($linea['year']);
		$game->setFormat($linea['format']);
		$game->setGenre($linea['genre']);
		$game->setSystem($linea['system']);
		$game->setProgramming($linea['programming']);
		$game->setSound($linea['sound']);
		$game->setControl($linea['control']);
		$game->setPlayers($linea['players']);
		$game->setLanguages($linea['languages']);
		$game->setFile($linea['file']);
		$game->setScreenshot($linea['screenshot']);
		$game->setVideo($linea['video']);
		$game->setWeb($linea['web']);
		$game->setIGoIt($linea['iGoIt']);
		$game->setBroken($linea['broken']);
		$game->setObservations($linea['observations']);
		$games[]=$game;
	}
	$basededatos->desconectar();
	return $games;
}

public static function getAllByLetter($letter,$start, $end){
	$games=array();
	$basededatos= new MysqliClient();
	$basededatos->conectar_mysql();
	$consulta  = "SELECT * FROM games WHERE title LIKE '".$letter."%' ORDER BY title limit ".$start .", ".$end."";
	$resultado=$basededatos->ejecutar_sql($consulta);
	while ($linea = mysqli_fetch_array($resultado)) 
	{
		$game=new Game($linea['id']);
		$game->setTitle($linea['title']);
		$game->setCover($linea['cover']);
		$game->setInstructions($linea['instructions']);
		$game->setCountry($linea['country']);
		$game->setPublisher($linea['publisher']);
		$game->setDeveloper($linea['developer']);
		$game->setYear($linea['year']);
		$game->setFormat($linea['format']);
		$game->setGenre($linea['genre']);
		$game->setSystem($linea['system']);
		$game->setProgramming($linea['programming']);
		$game->setSound($linea['sound']);
		$game->setControl($linea['control']);
		$game->setPlayers($linea['players']);
		$game->setLanguages($linea['languages']);
		$game->setFile($linea['file']);
		$game->setScreenshot($linea['screenshot']);
		$game->setVideo($linea['video']);
		$game->setWeb($linea['web']);
		$game->setIGoIt($linea['iGoIt']);
		$game->setBroken($linea['broken']);
		$game->setObservations($linea['observations']);
		$games[]=$game;
	}
	$basededatos->desconectar();
	return $games;
}
public static function getAllNumbersTittles($start, $end){
	$games=array();
	$basededatos= new MysqliClient();
	$basededatos->conectar_mysql();
	$consulta  = "SELECT * FROM games WHERE title REGEXP '^[0-9]+$'  ORDER BY title limit ".$start .", ".$end."";
	$resultado=$basededatos->ejecutar_sql($consulta);
	while ($linea = mysqli_fetch_array($resultado)) 
	{
		$game=new Game($linea['id']);
		$game->setTitle($linea['title']);
		$game->setCover($linea['cover']);
		$game->setInstructions($linea['instructions']);
		$game->setCountry($linea['country']);
		$game->setPublisher($linea['publisher']);
		$game->setDeveloper($linea['developer']);
		$game->setYear($linea['year']);
		$game->setFormat($linea['format']);
		$game->setGenre($linea['genre']);
		$game->setSystem($linea['system']);
		$game->setProgramming($linea['programming']);
		$game->setSound($linea['sound']);
		$game->setControl($linea['control']);
		$game->setPlayers($linea['players']);
		$game->setLanguages($linea['languages']);
		$game->setFile($linea['file']);
		$game->setScreenshot($linea['screenshot']);
		$game->setVideo($linea['video']);
		$game->setWeb($linea['web']);
		$game->setIGoIt($linea['iGoIt']);
		$game->setBroken($linea['broken']);
		$game->setObservations($linea['observations']);
		$games[]=$game;
	}
	$basededatos->desconectar();
	return $games;
}

/**
 * Esta función aparece en views/game/show
 */
public static function getGame($idGame){
	$game=null;
	$basededatos= new MysqliClient();
	$basededatos->conectar_mysql();
	$consulta  = "SELECT * FROM games WHERE id='$idGame' LIMIT 1 ";
	$resultado=$basededatos->ejecutar_sql($consulta);
	while ($linea = mysqli_fetch_array($resultado)) 
	{
		$game=new Game($linea['id']);
		$game->setTitle($linea['title']);
		$game->setCover($linea['cover']);
		$game->setInstructions($linea['instructions']);
		$game->setCountry($linea['country']);
		$game->setPublisher($linea['publisher']);
		$game->setDeveloper($linea['developer']);
		$game->setYear($linea['year']);
		$game->setFormat($linea['format']);
		$game->setGenre($linea['genre']);
		$game->setSystem($linea['system']);
		$game->setProgramming($linea['programming']);
		$game->setSound($linea['sound']);
		$game->setControl($linea['control']);
		$game->setPlayers($linea['players']);
		$game->setLanguages($linea['languages']);
		$game->setFile($linea['file']);
		$game->setScreenshot($linea['screenshot']);
		$game->setVideo($linea['video']);
		$game->setWeb($linea['web']);
		$game->setIGoIt($linea['iGoIt']);
		$game->setBroken($linea['broken']);
		$game->setObservations($linea['observations']);
	}
	$basededatos->desconectar();
	return $game;
}
public static function getSearchGameByTitle($search){
	$games=array();
	$basededatos= new MysqliClient();
	$basededatos->conectar_mysql();
	$consulta  = "SELECT * FROM games WHERE title LIKE '%".$search."%' LIMIT 100";
	$resultado=$basededatos->ejecutar_sql($consulta);
	while ($linea = mysqli_fetch_array($resultado)) 
	{
		$game=new Game($linea['id']);
		$game->setTitle($linea['title']);
		$game->setCover($linea['cover']);
		$game->setInstructions($linea['instructions']);
		$game->setCountry($linea['country']);
		$game->setPublisher($linea['publisher']);
		$game->setDeveloper($linea['developer']);
		$game->setYear($linea['year']);
		$game->setFormat($linea['format']);
		$game->setGenre($linea['genre']);
		$game->setSystem($linea['system']);
		$game->setProgramming($linea['programming']);
		$game->setSound($linea['sound']);
		$game->setControl($linea['control']);
		$game->setPlayers($linea['players']);
		$game->setLanguages($linea['languages']);
		$game->setFile($linea['file']);
		$game->setScreenshot($linea['screenshot']);
		$game->setVideo($linea['video']);
		$game->setWeb($linea['web']);
		$game->setIGoIt($linea['iGoIt']);
		$game->setBroken($linea['broken']);
		$game->setObservations($linea['observations']);
		$games[]=$game;
	}
	$basededatos->desconectar();
	return $games;
}

/*
function dibujarLayoutWebsConArray($webs, $idCategoria){
	//include_once("Utils.php");
	$contador=0;
	//obtenerArbolDeGames($idCategoria);
	echo "<ol class='breadcrumb'>";
	cortarCadena($idCategoria.$GLOBALS["ruta"]);
	echo "</ol>";
	echo "<p>&nbsp;&nbsp;&nbsp;".obtenerTituloCategoria($idCategoria)."</p>";
	foreach ($webs as $posicion=>$web){
		$contador++;
		echo"<center>";
		echo "<div class='contenedorimagenesdewebs' >";
					echo "<table class='table-responsive'>";
						echo "<tr><td>";
							if($contador==1 && !isset($_GET['pagina'])){
								echo" <img src='../imagenes/medallaoro.png' width='100px'></img>";
							}else if($contador==2 && !isset($_GET['pagina'])){
								echo" <img src='../imagenes/medallaplata.png' width='100px'></img>";
							}else if($contador==3 && !isset($_GET['pagina'])){
								echo" <img src='../imagenes/medallabronce.png' width='100px'></img>";
							}
						echo "</td><td>";
							echo "<a href='http://".$web->getNombreWeb()."' target='_blank' class='tituloweb' >";
							echo cortarCadena($web->getTituloWeb())."";
							echo "<br /><span style='color:black; font-size:10px;'>Enlace: ".cortarCadena($web->getNombreWeb())."</span></a>";
						echo "</td></tr>";
					echo "</table>";
					
					echo "<br /><pre class='contenedorcomentarios'>".$web->getDescripcionWeb()."</pre>";
					echo "<br /><a href='http://".$web->getNombreWeb()."' target='_blanck' class='tituloweb' ><img src='/imagenes/webs/".$web->getImagenWeb()."' width='500px' /></a>";
					echo "<br /><span>".$web->getMediaVotosWeb()." <a href='gestionarwebs?accion=4&idWeb=".$web->getIdWeb()."'> Votar</a></span>";
					
					echo "<br /><a href=/gestionarwebs.php?accion=1&idWeb=".$web->getIdWeb()." >Detalles...</a><br />";
					//echo "<br />";
					if(isset($_SESSION['nivelaccesousuario']) && $_SESSION['nivelaccesousuario']==1){
						echo "<a href='/adm/admgestionarwebs.php?accion=2&idWeb=".$web->getIdWeb()."'>Editar, <span style='color:red'> solo administrador</span></a>";
					}
				echo "</div>";
				echo "</center>";
				require_once ('Mobile_Detect.php');
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
}

function dibujarLayoutGamesDos(){
	$nivelCategoria=1;
	echo "<div class='divgames'>";
		//include_once("./app/MysqliClient.php");
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta= "SELECT * FROM games WHERE nivelcategoria=".$nivelCategoria." ORDER BY nombrecategoria";
		$resultado=$basededatos->ejecutar_sql($consulta);
		echo "<ul style='list-style:none'>";
				while ($linea = mysqli_fetch_array($resultado)) 
				{
						echo "<li>".$linea['nombrecategoria']."</li>";
						CategoryRepository::recorrerGames($nivelCategoria, $linea['nombrecategoria'] );	
				}
				$basededatos->desconectar();
		echo "</ul>";
	echo "</div>";
}


public static function getAllOnMysqliResult(){
	$basededatos= new MysqliClient();
	$basededatos->conectar_mysql();
	$consulta= "SELECT * FROM gamesusuarios WHERE nivelcategoria=1 && idusuario='".$_SESSION['idusuario']."'  ORDER BY nombrecategoria";
	$games=$basededatos->ejecutar_sql($consulta);
	$basededatos->desconectar();
	return $games;
}


		


function crearNuevaCategoria(){
	
	echo"<p>Menu insertar nueva categoria</p>";
	echo"<form method=post action='admgames.php' class='form-horizontal'>";

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
							$basededatos= new MysqliClient();
							$basededatos->conectar_mysql();
							$consulta= "SELECT * FROM games WHERE nivelcategoria=".$nivelCategoria." ORDER BY nombrecategoria";
							$resultado=$basededatos->ejecutar_sql($consulta);
							while ($linea = mysqli_fetch_array($resultado)) 
							{
									echo "<option value='".$linea['idcategoria']."' >".$linea['nombrecategoria']."</option>";
									recorrerGamesConSelect($nivelCategoria, $linea[idcategoria] );
							}
							$basededatos->desconectar();
					echo "</select>";
		echo" </div> ";
	echo" </div> ";
	echo" <div class='form-group' > ";
		echo"<label for='redireccionCategoria' class='control-label'>Es una redirección a:</label>";
		echo" <div  > ";
			echo"<input type='number' class='form-control'  name='redireccionCategoria'  id='redireccionCategoria' title='Debe ser un número' placeholder='redirección a la categoria: (deja en blanco para no redirección)'  />";
		echo"    </div>";
	echo"    </div>";
	echo" <div class='form-group' > ";
		echo "<div class='col-md-offset-2' >";
			echo "<input type=hidden name=accion value=12></input> ";
			echo"<input type=submit value='Insertar nueva categoria' class='btn btn-primary btn-large' ></input>";
		echo"    </div>";
	echo"    </div>";
	echo" </form>";
}





























	



public static function actualizarCategoria($idCategoria){
	$basededatos= new MysqliClient();
	$basededatos->conectar_mysql();
	echo "la categoria es ".$idCategoria;
	$consulta  = "SELECT * FROM games WHERE idcategoria='$idCategoria' ";
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
			$categoria->setRedireccionCategoria($linea['redireccionaidcategoria']);
	}
	$basededatos->desconectar();
	return $categoria;
}
//Aparece en wiews/adm/category/updateByUser.php
public static function actualizarCategoriaUsuarios($idCategoria){
	$basededatos= new MysqliClient();
	$basededatos->conectar_mysql();
	echo "la categoria es ".$idCategoria;
	$consulta  = "SELECT * FROM gamesusuarios WHERE idcategoria='$idCategoria' ";
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
			$categoria->setRedireccionCategoria($linea['redireccionaraidcategoria']);
	}
	$basededatos->desconectar();
	return $categoria;
}









//Esta función es llamada en views/category/delete.php
public static function comprobarSiOtrasTienenEstaCategoriaComoPadre($idCategoria){
	$basededatos= new MysqliClient();
	$basededatos->conectar_mysql();
	$consulta  = "SELECT * FROM games WHERE idpadrecategoria='".$idCategoria."'";
	$resultado=$basededatos->ejecutar_sql($consulta);
	if(mysql_num_rows($resultado)>0){
		return true;
	}else{
		return false;	
	}
	$basededatos->desconectar();
	
}







function redirigirPorNoBorrar($idCategoria){
	$mensaje=obtenerNombreCategoria($idCategoria).", no borrado";
	echo "<script type='text/javascript'>location.href='admgames.php?mensaje=$mensaje'</script>";
}



function aplicarInsercionCategoria(){
	$nivelCategoria=obtenerNivelCategoria($_POST[categoriaEsHijaDe]);
	$nivelCategoria++;
	$nombrePadre=obtenerNombreCategoria($_POST[categoriaEsHijaDe]);
	$bd2= new MysqliClient();
	$bd2->conectar_mysql();
	$sql2="INSERT INTO games VALUES ( '', '$_POST[nombreCategoria]', '$_POST[tituloCategoria]','$nombrePadre', '$_POST[categoriaEsHijaDe]', '$nivelCategoria', '$_POST[redireccionCategoria]') ";
	$bd2->ejecutar_sql($sql2);
	$bd2->desconectar();
	$mensaje="Categoria ".$_POST[nombreCategoria]." nueva insertada.";
	echo "<script type='text/javascript'>location.href='admgames.php?mensaje=".$mensaje."';</script>";
}




function actualizarTodosLosNombreConElIdPadreCategoria($idCategoria){
	
	$nombreNuevoCategoria=obtenerNombreCategoria($idCategoria);
	$bd2= new MysqliClient();
	$bd2->conectar_mysql();
	$sql2="update games set categoriaeshijade='$nombreNuevoCategoria' where idpadrecategoria='$idCategoria'";
	$bd2->ejecutar_sql($sql2);
	$bd2->desconectar();
	
	
	
	
	
}




function aplicarActualizacionNombreCategoria($idCategoria){
	$bd= new MysqliClient();
	$bd->conectar_mysql();
	$sql="update games set nombrecategoria='$_POST[nombreCategoria]' where idcategoria='$idCategoria'";
	$bd->ejecutar_sql($sql);
	$bd->desconectar();
	actualizarTodosLosNombreConElIdPadreCategoria($idCategoria);
	$mensaje="Categoria ".obtenerNombreCategoria($idCategoria)." actualizada.";
	echo "<script type='text/javascript'>location.href='admgames.php?mensaje=".$mensaje."';</script>";
}

function aplicarActualizacionTituloCategoria($idCategoria){
	$bd= new MysqliClient();
	$bd->conectar_mysql();
	$sql="update games set titulocategoria='$_POST[tituloCategoria]' where idcategoria='$idCategoria'";
	$bd->ejecutar_sql($sql);
	$bd->desconectar();
	$mensaje="Titulo de la categoria ".obtenerNombreCategoria($idCategoria)." actualizado.";
	echo "<script type='text/javascript'>location.href='admgames.php?mensaje=".$mensaje."';</script>";
}



function aplicarActualizacionPadreCategoria($idCategoria){
	if($_POST[categoriaEsHijaDe] != $idCategoria){
		$nombreCategoria=obtenerNombreCategoria($idCategoria);
		$nivelCategoria=obtenerNivelCategoria($_POST[categoriaEsHijaDe]);
		$nivelCategoria++;
		$nombrePadre=obtenerNombreCategoria($_POST[categoriaEsHijaDe]);	
		$bd= new MysqliClient();
		$bd->conectar_mysql();
		$sql="update games set nombrecategoria='$nombreCategoria', categoriaeshijade='$nombrePadre', idpadrecategoria='$_POST[categoriaEsHijaDe]', nivelcategoria='$nivelCategoria' where idcategoria='$idCategoria'";
		$bd->ejecutar_sql($sql);
		$bd->desconectar();
		actualizarTodosLosNombreConElIdPadreCategoria($idCategoria);
		$mensaje="Categoria ".obtenerNombreCategoria($idCategoria)." actualizada.";
		echo "<script type='text/javascript'>location.href='admgames.php?mensaje=".$mensaje."';</script>";
	}else{
		echo "<script type='text/javascript'>location.href='admgames.php?';</script>";
	}
}







	function buscarCategoria($tagsCategoria){
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM games WHERE nombrecategoria LIKE '%".$tagsCategoria."%' ||  titulocategoria LIKE '%".$tagsCategoria."%' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		$total_registros=mysqli_num_rows($resultado);
		if($total_registros==FALSE){
			echo" <p>No se obtuvo ning&uacute;n resultado de ".$tagsCategoria.".</p>"	;
		}else{
			while ($linea = mysqli_fetch_array($resultado)) 
			{
			
				echo "<div>";
					if($linea['redireccionaidcategoria']!=0) echo "<center ><a href='categoria/$linea[redireccionaidcategoria]'>".$linea[titulocategoria]."</a></center>";
					else echo "<center ><a href='categoria/$linea[idcategoria]'>".$linea[titulocategoria]."</a></center>";				
				echo "</div>";
				echo "<br />";
				
			}
		}
		$basededatos->desconectar();
	}
	

}

*/


//Insert
//INSERT INTO gamesUsers VALUES ( '', 'title', 'Cover', 'Instructions', 'Country()', 'Publisher', 'Developer', 'Year', 'Format', 'Genre', 'System', 'Programming', 'Sound', 'Control', '1', 'Languages', '1', '1', '1', '1', '1', '1' , 'observations', '92');

	public static function delete($id){
		$bd= new MysqliClient();
		$bd->conectar_mysql();
		$sql="DELETE FROM games WHERE id='".$id."' LIMIT 1";
		$bd->ejecutar_sql($sql);
		$bd->desconectar();
	}

}
?>