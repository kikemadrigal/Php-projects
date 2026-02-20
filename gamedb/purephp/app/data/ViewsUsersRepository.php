<?php

class ViewsUsersRepository {
	public static function getNameViewUser($idView){
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT name FROM viewsUsers WHERE id='".$idView."' LIMIT 1";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			return $linea['name'];
		}
		$basededatos->desconectar();
	}
}

?>