<?php

class MediaRepository{

    public static function getAll($tableName){
		$medias=array();
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM `".$tableName."` WHERE isHeader=0";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			if($linea['name'] != "." || $linea['name'] != ".."){
				$media=new Media($linea['id']);
				$media->setName($linea['name']);
				$media->setPath($linea['path']);
				$media->setIsHeader($linea['isHeader']);
				$media->setDate($linea['date']);
				$media->setTypeId($linea['typeId']);
				$media->setUserId($linea['userId']);
				$media->setTourId($linea['tourId']);
				$medias[]=$media;
			}
		}
		$basededatos->desconectar();
		return $medias;
	}
    public static function getAllVirtualTours(){
		$medias=array();
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM `virtualTours`";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			if($linea['name'] != "." || $linea['name'] != ".."){
				$media=new Media($linea['id']);
				$media->setName($linea['name']);
				$media->setDate($linea['date']);
				$media->setTypeId($linea['typeId']);
				$media->setUserId($linea['userId']);
				$media->setTourId($linea['tourId']);
				$medias[]=$media;
			}
		}
		$basededatos->desconectar();
		return $medias;
	}
	public static function getCountAutoincrement($tableName){
		$toursAutoincrement=0;
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".DATABASE."' AND TABLE_NAME   = '".$tableName."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$toursAutoincrement=$linea['AUTO_INCREMENT'];
		}
		$basededatos->desconectar();
		return $toursAutoincrement;
	}
	

	/**
	 * Esta función aparece en 
	 * 
	 */
	public static function getAllMediasByTour($tableName,$tourId){
		$images=array();
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		//Rypes=1 images, audios, videos
		$consulta  = "SELECT * FROM `".$tableName."` WHERE tourId='".$tourId."' ORDER BY name";
		$resultado=$basededatos->ejecutar_sql($consulta);
		if($resultado==null) return null;
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$image=new Media($linea['id']);
			$image->setName($linea['name']);
			$image->setPath($linea['path']);
			$image->setIsHeader($linea['isHeader']);
			$image->setDate($linea['date']);
			$image->setTypeId($linea['typeId']);
			$image->setUserId($linea['userId']);
			$image->setTourId($linea['tourId']);
			$images[]=$image;
		}
		$basededatos->desconectar();
		return $images;
	}
	public static function getAllVirtualToursByTour($tourId){
		$audios=array();
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		//Rypes=1 images, audios, videos
		$consulta  = "SELECT * FROM virtualTours WHERE tourId='".$tourId."' ORDER BY name";
		$resultado=$basededatos->ejecutar_sql($consulta);
		if($resultado==null) return null;
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$audio=new Media($linea['id']);
			$audio->setName($linea['name']);
			$audio->setDate($linea['date']);
			$audio->setTypeId($linea['typeId']);
			$audio->setUserId($linea['userId']);
			$audio->setTourId($linea['tourId']);
			$audios[]=$audio;
		}
		$basededatos->desconectar();
		return $audios;
	}

	/**
	* Esta función es llamaa en views/
	*/
	public static function getMedia($tableName,$id){
		$image=null;
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM `".$tableName."` WHERE id='".$id."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$image=new Media($linea['id']);
			$image->setName($linea['name']);
			$image->setPath($linea['path']);
			$image->setIsHeader($linea['isHeader']);
			$image->setDate($linea['date']);
			$image->setTypeId($linea['typeId']);
			$image->setUserId($linea['userId']);
			$image->setTourId($linea['tourId']);
		}
		$basededatos->desconectar();
		return $image;
	}
	public static function getVirtualTour($id){
		$image=null;
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM `virtualTours` WHERE id='".$id."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$image=new Media($linea['id']);
			$image->setName($linea['name']);
			$image->setDate($linea['date']);
			$image->setTypeId($linea['typeId']);
			$image->setUserId($linea['userId']);
			$image->setTourId($linea['tourId']);
		}
		$basededatos->desconectar();
		return $image;
	}
	public static function insertImage($name, $path, $isHeader, $date ,$typeId, $userId, $tourId){
		$lastId=0;
		$basededatos= new MysqliClient();
        $basededatos->conectar_mysql();
		//echo $name."-".$path."-".$date."-".$typeId."-".$userId."-".$tourId;
        $sql="INSERT INTO `images` ( `name`, `path`, `isHeader`, `date`, `typeId`,`userId`, `tourId`) VALUES 
        ( '$name', '$path', ".$isHeader.",'' ,'$typeId', '$userId', '$tourId') ";
		//echo "INSERT INTO `images` ( `name`, `path`, `isHeader`, `date`, `typeId`,`userId`, `tourId`) VALUES  ( '$name', '$path', '$isHeader','' ,'$typeId', '$userId', '$tourId') ";
        $basededatos->ejecutar_sql($sql);
		$lastId=$basededatos->getLastId();
        $basededatos->desconectar();
		return $lastId;
	}
	public static function insertAudio($name, $path, $isHeader, $date ,$typeId, $userId, $tourId){
		$lastId=0;
		//echo $name."-".$path."-".$date."-".$typeId."-".$userId."-".$tourId;
		$sql="INSERT INTO `audios` ( `name`, `path`, `isHeader`, `date`, `typeId`,`userId`, `tourId`) VALUES 
		( '$name', '$path', ".$isHeader.",'' ,'$typeId', '$userId', '$tourId') ";
		//echo "INSERT INTO `audios` ( `name`, `path`, `isHeader`, `date`, `typeId`,`userId`, `tourId`) VALUES ( '$name', '$path', '$isHeader','' ,'$typeId', '$userId', '$tourId') ";
		$basededatos= new MysqliClient();
        $basededatos->conectar_mysql();
        $basededatos->ejecutar_sql($sql);
		$lastId=$basededatos->getLastId();
        $basededatos->desconectar();
		return $lastId;
	}
	public static function insertVideo($name, $path, $isHeader, $date ,$typeId, $userId, $tourId){
		$lastId=0;
		//echo $name."-".$path."-".$date."-".$typeId."-".$userId."-".$tourId;
		$sql="INSERT INTO `videos` ( `name`, `path`, `isHeader`, `date`, `typeId`,`userId`, `tourId`) VALUES 
		( '$name', '$path', ".$isHeader.",'' ,'$typeId', '$userId', '$tourId') ";
		//echo "INSERT INTO `audios` ( `name`, `path`, `isHeader`, `date`, `typeId`,`userId`, `tourId`) VALUES ( '$name', '$path', '$isHeader','' ,'$typeId', '$userId', '$tourId') ";
		$basededatos= new MysqliClient();
        $basededatos->conectar_mysql();
        $basededatos->ejecutar_sql($sql);
		$lastId=$basededatos->getLastId();
        $basededatos->desconectar();
		return $lastId;
	}
	//`id` int(11)     `name`     `date`     `typeId`     `userId`     `tourId` 
	public static function insertVirtualTour($name, $date ,$typeId, $userId, $tourId){
		$lastId=0;
		//echo $name."-".$path."-".$date."-".$typeId."-".$userId."-".$tourId;
		$sql="INSERT INTO `virtualTours` ( `name`, `date`, `typeId`,`userId`, `tourId`) VALUES 
		( '$name', '' ,'$typeId', '$userId', '$tourId') ";
		$basededatos= new MysqliClient();
        $basededatos->conectar_mysql();
        $basededatos->ejecutar_sql($sql);
		$lastId=$basededatos->getLastId();
        $basededatos->desconectar();
		return $lastId;
	}
	public static function updateImage($media){
        $bd= new MysqliClient();
        $bd->conectar_mysql();
		//echo $name."-".$path."-".$date."-".$typeId."-".$userId."-".$tourId;
		$sql="update `images` set name='".$media->getName()."', path='".$media->getPath()."', isHeader=".$media->getIsHeader().", date='".$media->getDate()."', typeId='".$media->getTypeId()."', userId='".$media->getUserId()."', tourId='".$media->getTourId()."' WHERE id='".$media->getId()."'";
        $success=$bd->ejecutar_sql($sql);
        $bd->desconectar();
		return $success;
    }
	public static function updateAudio($media){
        $bd= new MysqliClient();
        $bd->conectar_mysql();
		//echo $name."-".$path."-".$date."-".$typeId."-".$userId."-".$tourId;
		$sql="update `audios` set name='".$media->getName()."', path='".$media->getPath()."', isHeader=".$media->getIsHeader().", date='".$media->getDate()."', typeId='".$media->getTypeId()."', userId='".$media->getUserId()."', tourId='".$media->getTourId()."' WHERE id='".$media->getId()."'";
        $success=$bd->ejecutar_sql($sql);
        $bd->desconectar();
		return $success;
    }
	public static function updateVideo($media){
        $bd= new MysqliClient();
        $bd->conectar_mysql();
		//echo $name."-".$path."-".$date."-".$typeId."-".$userId."-".$tourId;
		$sql="update `videos` set name='".$media->getName()."', path='".$media->getPath()."', isHeader=".$media->getIsHeader().", date='".$media->getDate()."', typeId='".$media->getTypeId()."', userId='".$media->getUserId()."', tourId='".$media->getTourId()."' WHERE id='".$media->getId()."'";
        $success=$bd->ejecutar_sql($sql);
        $bd->desconectar();
		return $success;
    }
	public static function updateVirtualTour($media){
        $bd= new MysqliClient();
        $bd->conectar_mysql();
		//echo $name."-".$path."-".$date."-".$typeId."-".$userId."-".$tourId;
		$sql="update `virtualTours` set name='".$media->getName()."', date='".$media->getDate()."', typeId='".$media->getTypeId()."', userId='".$media->getUserId()."', tourId='".$media->getTourId()."' WHERE id='".$media->getId()."'";
        $success=$bd->ejecutar_sql($sql);
        $bd->desconectar();
		return $success;
    }
	/**
 	* Esta dunción es llamada en views/media/
 	*/
	public static function deleteMedia($tableName,$id){
        $bd= new MysqliClient();
        $bd->conectar_mysql();
        $sql="DELETE FROM `".$tableName."` WHERE id='".$id."' LIMIT 1";
        $success=$bd->ejecutar_sql($sql);
        $bd->desconectar();
		return $success;
    }
	public static function deleteVirtualTour($id){
        $bd= new MysqliClient();
        $bd->conectar_mysql();
        $sql="DELETE FROM `virtualTours` WHERE id='".$id."' LIMIT 1";
        $success=$bd->ejecutar_sql($sql);
        $bd->desconectar();
		return $success;
    }

}

?>