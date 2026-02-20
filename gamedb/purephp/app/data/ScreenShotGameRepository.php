<?php
class ScreenShotGameRepository{
	public static function getAllByGame($idGame){
		//echo "<h1>".$idGame."</h1>";
		$filesGames=array();
		//echo "<h1>".$idGame."</h1>";
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM screenShotsGames WHERE game='".$idGame."' ORDER BY name";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$fileGame=new FileGame($linea['id']);
			$fileGame->setName($linea['name']);
			$fileGame->setPath($linea['path']);
			$fileGame->setGame($linea['game']);

			$filesGames[]=$fileGame;
		}
		$basededatos->desconectar();
		return $filesGames;
	}
	public static function getPath($idScreenShot){
		$path="";
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT path FROM screenShotsGames WHERE id='".$idScreenShot."' LIMIT 1";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$path=$linea['path'];
		}
		$basededatos->desconectar();
		return $path;
	}
 

	public static function insert($game){
		$bd= new MysqliClient();
		$bd->conectar_mysql();
		echo $game->getName()."', '".$game->getPath()."', '".$game->getGame();
        $sql="INSERT INTO screenShotsGames VALUES ( '', '".$game->getName()."', '".$game->getPath()."', '".$game->getGame()."') ";
        //$bd->ejecutar_sql(addslashes($sql));
        $bd->ejecutar_sql($sql);
		$bd->desconectar();
	}

	public static function delete($id){
        $bd= new MysqliClient();
        $bd->conectar_mysql();
        $sql="DELETE FROM screenShotsGames WHERE id='".$id."' LIMIT 1";
        $bd->ejecutar_sql($sql);
	} 

}