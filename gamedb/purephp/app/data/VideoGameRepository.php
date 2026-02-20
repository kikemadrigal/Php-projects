<?php
class VideoGameRepository {
	public static function getAllByGame($idGame){
		$filesGames=array();
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		//Rypes=1 images, audios, videos
		$consulta  = "SELECT * FROM videosGames WHERE game='".$idGame."' ORDER BY text";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$fileGame=new VideoGame($linea['id']);
			$fileGame->setText($linea['text']);
			$fileGame->setGame($linea['game']);

			$filesGames[]=$fileGame;
		}
		$basededatos->desconectar();
		return $filesGames;
	}

	public static function insert($videoGame){
		$bd= new MysqliClient();
		$bd->conectar_mysql();
		//echo $videoGame->getText()."', '".$videoGame->getGame();
        $sql="INSERT INTO videosGames VALUES ( '', '".$videoGame->getText()."', '".$videoGame->getGame()."') ";
        //$bd->ejecutar_sql(addslashes($sql));
        $bd->ejecutar_sql($sql);
		$bd->desconectar();
	}

	public static function delete($id){
        $bd= new MysqliClient();
        $bd->conectar_mysql();
        $sql="DELETE FROM videosGames WHERE id='".$id."' LIMIT 1";
        $bd->ejecutar_sql($sql);
        $bd->desconectar();
	}

}