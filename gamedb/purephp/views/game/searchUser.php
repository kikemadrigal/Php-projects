<?php
include_once("./views/templates/document-start.php"); 
//Obtenemos los 10 últimos juegos
//El text search lo obtenemos en el index
//getAllGamesByUserAndField($idUser, $field, $value, $start, $end)
$games=GameUserRepository::getAllGamesByUserAndField($_SESSION['idusuario'],"title",$search,0,100);

echo "<div class=''>";
	echo "<div class='flex-container'>";
		foreach ($games as $posicion=>$game){
			echo "<div class='".Util::getStyleFormat($game)."'>";
				echo "<a href='".PATHSERVER."Game/update/".$game->getId()."'>".Util::cortarCadena($game->getTitle())."</a>";
			echo "</div>";
		}
	echo "</div>";
echo "</div>";		
include_once("./views/templates/document-end.php"); 

?>