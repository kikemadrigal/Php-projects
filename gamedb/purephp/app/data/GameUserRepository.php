<?php

class GameUserRepository{
    public static function getAllGamesByUser($user, $start, $end){
        $games=array();
        $basededatos= new MysqliClient();
        $basededatos->conectar_mysql();
        if (!$basededatos->checkExitsGamesUsersTable()){
            echo "gamesUsers table not exists";
            die();
        }
        $consulta  = "SELECT * FROM gamesUsers WHERE user='".$user."' ORDER BY title limit ".$start .", ".$end." ";
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
     * Esta función aparece en views/game/showByCategoriesUser
     * aparece en views/game/showByCategoriesUser

     */

    public static function getAllGamesByUserAndField($idUser, $field, $value, $start, $end){
        $games=array();
        $basededatos= new MysqliClient();
        $basededatos->conectar_mysql();
        if (!$basededatos->checkExitsGamesUsersTable()){
            echo "gamesUsers table not exists";
            die();
        }
        $consulta  = "SELECT * FROM gamesUsers WHERE user='".$idUser."' AND ".$field." LIKE '%".$value."%' ORDER BY title limit ".$start .", ".$end." ";
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
     * Aparece en views/updateUser 2 veces, 1 para la recepción del form y otra para obtener el nombre del game
     */
    public static function getGame($idGame){
        $game=null;
        $basededatos= new MysqliClient();
        $basededatos->conectar_mysql();
        if (!$basededatos->checkExitsGamesUsersTable()){
            echo "gamesUsers table not exists";
            die();
        }
        $consulta  = "SELECT * FROM gamesUsers WHERE id='$idGame' LIMIT 1 ";
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
    /**
    * Esta función aparece en views/game/showByCategoriesUser
    */
    public static function getAllSystemByUser($idUser){
        $systems=array();
        $basededatos= new MysqliClient();
        $basededatos->conectar_mysql();
        if (!$basededatos->checkExitsGamesUsersTable()){
            echo "gamesUsers table not exists";
            die();
        }
        $consulta  = "SELECT DISTINCT system FROM gamesUsers WHERE user='".$idUser."'";
        $resultado=$basededatos->ejecutar_sql($consulta);
        while ($linea = mysqli_fetch_array($resultado)) 
        {
            $systems[]=$linea['system'];
        }
        return $systems;
    }
    /**
    * Esta función aparece en views/game/showByCategoriesUser
    */
    public static function getAllPublisherByUser($idUser){
        $systems=array();
        $basededatos= new MysqliClient();
        $basededatos->conectar_mysql();
        if (!$basededatos->checkExitsGamesUsersTable()){
            echo "gamesUsers table not exists";
            die();
        }
        $consulta  = "SELECT DISTINCT publisher FROM gamesUsers WHERE user='".$idUser."' ORDER BY publisher";
        $resultado=$basededatos->ejecutar_sql($consulta);
        while ($linea = mysqli_fetch_array($resultado)) 
        {
            $systems[]=$linea['publisher'];
        }
        return $systems;
    }
    /*
    INSERT INTO gamesUsers VALUES ( '', 'title', 'Cove', 'Instructions', 'Country()', 'Publisher', 'Developer', 'Year', 'Format', 'Genre', 'System', 'Programming', 'Sound', 'Control', '1', 'Languages', '1', '1', '1', '1', '1', '0' , 'Observations', '186');
    */
    public static function insert($game,$idUser){
		$bd= new MysqliClient();
		$bd->conectar_mysql();
        if (!$bd->checkExitsGamesUsersTable()){
            echo "gamesUsers table not exists";
            die();
        }
        $sql="INSERT INTO gamesUsers VALUES ( '', '".$game->getTitle()."', '".$game->getCover()."', '".$game->getInstructions()."', '".$game->getCountry()."', '".$game->getPublisher()."', '".$game->getDeveloper()."', '".$game->getYear()."', '".$game->getFormat()."', '".$game->getGenre()."', '".$game->getSystem()."', '".$game->getProgramming()."', '".$game->getSound()."', '".$game->getControl()."', '".$game->getPlayers()."', '".$game->getLanguages()."', '1', '1', '1', '1', '".$game->getIGoIt()."', '".$game->getBroken()."' , '".$game->getObservations()."', '".$idUser."') ";
        //Escapamos los signos especiales para que no de error
        //$bd->ejecutar_sql(addslashes($sql));
        $bd->ejecutar_sql($sql);
		$bd->desconectar();
	}

    public static function update($game){
        $bd= new MysqliClient();
        $bd->conectar_mysql();
        if (!$bd->checkExitsGamesUsersTable()){
            echo "gamesUsers table not exists";
            die();
        }
        //echo "<3>title='".$game->getTitle()."', cover='".$game->getCover()."', instructions='".$game->getInstructions()."', country='".$game->getCountry()."', publisher='".$game->getPublisher()."', developer='".$game->getDeveloper()."', year='".$game->getYear()."', format='".$game->getFormat()."', genre='".$game->getGenre()."', system='".$game->getSystem()."', programming='".$game->getProgramming()."', sound='".$game->getSound()."', control='".$game->getControl()."', players='".$game->getPlayers()."', languages='".$game->getLanguages()."', file='1', screenshot='1', video='1', web='1', iGoIt='".$game->getIGoIt()."' , broken='".$game->getBroken()."', observations='".$game->getObservations()."' where id='".$game->getId()."'";
        //update gamesUsers set title='tawara', cover='1', instructions='instrucciones', country='', publisher='ASCII', developer='ASCII', year='1986', format='cassette', genre='platform', system='NSX', programming='', sound='', control='', players='', languages='', file='1', screenshot='1', video='1', web='1', iGoIt='0' , broken='0', observations='' where id='19';
        $sql="update gamesUsers set title='".$game->getTitle()."', cover='".$game->getCover()."', instructions='".$game->getInstructions()."', country='".$game->getCountry()."', publisher='".$game->getPublisher()."', developer='".$game->getDeveloper()."', year='".$game->getYear()."', format='".$game->getFormat()."', genre='".$game->getGenre()."', system='".$game->getSystem()."', programming='".$game->getProgramming()."', sound='".$game->getSound()."', control='".$game->getControl()."', players='".$game->getPlayers()."', languages='".$game->getLanguages()."', file='1', screenshot='1', video='1', web='1', iGoIt='".$game->getIGoIt()."' , broken='".$game->getBroken()."', observations='".$game->getObservations()."' where id='".$game->getId()."'";
        //$bd->ejecutar_sql(addslashes($sql));
        $bd->ejecutar_sql($sql);
        $bd->desconectar();
    }
	/**
	 * Esta función es llamaa en views/game/updateUser.php
	 */
	public static function setFileToGame($idGame, $idFile){
        $bd= new MysqliClient();
        $bd->conectar_mysql();
        if (!$bd->checkExitsGamesUsersTable()){
            echo "gamesUsers table not exists";
            die();
        }
        $sql="update gamesUsers set file='".$idFile."' where id='".$idGame."'";
        $bd->ejecutar_sql($sql);
        $bd->desconectar();
    }
    public static function setScreenShootToGame($idGame, $idScreenShot){
        $bd= new MysqliClient();
        $bd->conectar_mysql();
        if (!$bd->checkExitsGamesUsersTable()){
            echo "gamesUsers table not exists";
            die();
        }
        $sql="update gamesUsers set screenshot='".$idScreenShot."' where id='".$idGame."'";
        $bd->ejecutar_sql($sql);
        $bd->desconectar();
    }
    public static function setVideoToGame($idGame, $idVideo){
        $bd= new MysqliClient();
        $bd->conectar_mysql();
        if (!$bd->checkExitsGamesUsersTable()){
            echo "gamesUsers table not exists";
            die();
        }
        $sql="update gamesUsers set video='".$idVideo."' where id='".$idGame."'";
        $bd->ejecutar_sql($sql);
        $bd->desconectar();
    }
    public static function setWebToGame($idGame, $idWeb){
        $bd= new MysqliClient();
        $bd->conectar_mysql();
        if (!$bd->checkExitsGamesUsersTable()){
            echo "gamesUsers table not exists";
            die();
        }
        $sql="update gamesUsers set web='".$idWeb."' where id='".$idGame."'";
        $bd->ejecutar_sql($sql);
        $bd->desconectar();
    }
    	
    public static function delete($id){
        $bd= new MysqliClient();
        $bd->conectar_mysql();
        if (!$bd->checkExitsGamesUsersTable()){
            echo "gamesUsers table not exists";
            die();
        }
        $sql="DELETE FROM gamesUsers WHERE id='".$id."' LIMIT 1";
        $bd->ejecutar_sql($sql);
        $bd->desconectar();
    }
}

?>