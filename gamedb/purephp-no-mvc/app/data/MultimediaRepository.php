<?php

class MultimediaRepository{
    public static function getAll(){
		$imagenes=array();
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = 'SELECT * FROM multimedia';
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
	/**
	 * Esta función aparece en media/showAll
	 * también aparece en views/game/updateUser.php
	 */
	public static function getAllImagesByUser($idUser){
		$images=array();
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		//Rypes=1 images, audios, videos
		$consulta  = "SELECT * FROM multimedia WHERE type=1 AND user='".$idUser."' ORDER BY name";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$image=new Multimedia($linea['id']);
			$image->setName($linea['name']);
			$image->setType($linea['type']);
			$image->setPath($linea['path']);
			$image->setUser($linea['user']);
			$image->setgame($linea['game']);
			$images[]=$image;
		}
		$basededatos->desconectar();
		return $images;
	}
	/**
	* Esta función es llamaa en views/game/updateUser.php
	*/
	public static function getImage($id){
		$image=null;
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		//tYPES=1 images, audios, videos
		$consulta  = "SELECT * FROM multimedia WHERE type=1 AND id='".$id."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$image=new Multimedia($linea['id']);
			$image->setName($linea['name']);
			$image->setType($linea['type']);
			$image->setPath($linea['path']);
			$image->setUser($linea['user']);
			$image->setgame($linea['game']);
		}
		$basededatos->desconectar();
		return $image;
	}
	public static function insert($name, $path, $type, $isUser, $game){
		$basededatos= new MysqliClient();
        $basededatos->conectar_mysql();
        $sql="INSERT INTO `multimedia` (`id`, `name`, `path`, `type`, `user`, `game`) VALUES 
        ( '', '$name', '$path', '$type', '$isUser', '$game') ";
        $basededatos->ejecutar_sql($sql);
        $basededatos->desconectar();
		if(!$basededatos) return false;	
        else return true;
	}
	/**
 	* Esta dunción es llamada en views/media/delete.php 
 	*/
	public static function delete($id){
        $bd= new MysqliClient();
        $bd->conectar_mysql();
        $sql="DELETE FROM multimedia WHERE id='".$id."' LIMIT 1";
        $bd->ejecutar_sql($sql);
        $bd->desconectar();
    }
}

?>