<?php
class WebGameRepository{
	public static function getAllByGame($idGame){
		$websGames=array();
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		//Rypes=1 images, audios, videos
		$consulta  = "SELECT * FROM websGames WHERE game='".$idGame."' ORDER BY text";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$webGame=new WebGame($linea['id']);
			$webGame->setText($linea['text']);
			$webGame->setGame($linea['game']);

			$websGames[]=$webGame;
		}
		$basededatos->desconectar();
		return $websGames;
	}

	public static function insert($game){
		$bd= new MysqliClient();
		$bd->conectar_mysql();
		//echo $game->getName()."', '".$game->getPath()."', '".$game->getGame();
        $sql="INSERT INTO websGames VALUES ( '', '".$game->getText()."', '".$game->getGame()."') ";
        //$bd->ejecutar_sql(addslashes($sql));
        $bd->ejecutar_sql($sql);
		$bd->desconectar();
	}

	public static function delete($id){
        $bd= new MysqliClient();
        $bd->conectar_mysql();
        $sql="DELETE FROM websGames WHERE id='".$id."' LIMIT 1";
        $bd->ejecutar_sql($sql);
        $bd->desconectar();
	}

}