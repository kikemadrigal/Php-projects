<?php 
//showByCategoriesUsers muestra en una vistas elegidas por el usuario los juegos de la tabla usersgames
//Si recibimos un formulario es que hemos solicitado mostrar otra vista
if (isset($_POST['submit'])){
	$view=$_POST['view'];
	$user=UserRepository::getUser($_SESSION['idusuario']);
	$user->setView($view);
	UserRepository::updateUser($user);
}
include_once("./views/templates/document-start.php"); 
?>

<?php
echo "<h3>".$_SESSION['nombreusuario']." games</h3>";
//1:Obtenemos la forma de visualización que tiene guardada el usuario
$view=UserRepository::getViewUser($_SESSION['idusuario']);
$viewName=ViewsUsersRepository::getNameViewUser($view);
?>
<!--Cambiar de vista -->     
<form method="post" action="<?php echo PATHSERVER; ?>game/showByCategoriesUsers" >
	<select name='view' id='view' required> ";
		<option value='<?php echo $view;?>'><?php echo $viewName;?></option>
		<option value='1' >Title</option>
		<option value='2' >Publisher</option>
		<option value='3' >Developer</option>
		<option value='4' >System</option>
		<option value='5' >Broken</option>
	</select>
	<button class="btn btn-outline-success ms-4" type="submit" name="submit" >Change view</button>
</form>
<?php
//Mostramos la borma de visualización
echo "<h4>View by: ".$viewName."</h4>";
if ($viewName=="title"){
	$games=GameUserRepository::getGameUserByTitle($_SESSION['idusuario'],0,50);
	echo "<div class=''>";
		echo count($games);
		echo "<div class='flex-container'>";
			foreach ($games as $posicion=>$game){
				echo "<div class='".Util::getStyleFormat($game)."'>";
				echo "<a href='".PATHSERVER."game/update/".$game->getId()."'>".Util::cortarCadena($game->getTitle())."</a>";
				echo "</div>";
			}
		echo "</div>";
	echo "</div>";		
}else if($viewName=="publisher"){
	echo "<p>With the red frame they don't work</p>";
	//1.Obtenemos todos los publisher del usuario
	$publishers=GameUserRepository::getAllPublisherByUser($_SESSION['idusuario']);
	//Pintamos el mueble
	echo "<div class='flex-container mueble' >";
	foreach ($publishers as $posicion=>$publisher){
			//2.Según el sistema sacamos los juegos
			$games=GameUserRepository::getAllGamesByUserAndField($_SESSION['idusuario'],"publisher",$publisher,0,10);
			echo "<div class='gameSeparator'>";
				echo "<strong>".$publisher.": ".count($games)."</strong><br>";
			echo "</div>";
			foreach ($games as $posicion=>$game){
				if($game->getBroken()==1){
					echo "<div class='juego-roto ".Util::getStyleFormat($game)." '>";
				}else{
					echo "<div class='".Util::getStyleFormat($game)."'>";
				}
					echo "<a href='".PATHSERVER."game/update/".$game->getId()."' >".Util::cortarCadena($game->getTitle())."</a>";
				echo "</div>";
			}
			//echo "</div>";
			//Pintamos una leja por publisher
			echo "<div class='balda'></div>";
	}
	echo "</div>";







echo "</div>";










}else if($viewName=="developer"){
	echo "not implemented";
}else if($viewName=="system"){
	//1.Obtenemos todos los sistemas del usuario
	$systems=GameUserRepository::getAllSystemByUser($_SESSION['idusuario']);
	foreach ($systems as $posicion=>$system){
		echo "<div class='mueble' >";
			echo "<h3>".$system."</h3>";
			//2.Según el sistema sacamos los juegos
			$games=GameUserRepository::getAllGamesByUserAndField($_SESSION['idusuario'],"system",$system,0,10);
			echo count($games);
			echo "<div class='flex-container'>";
			foreach ($games as $posicion=>$game){
				echo "<div class='".Util::getStyleFormat($game)."'>";
				echo "<a href='".PATHSERVER."game/update/".$game->getId()."' >".Util::cortarCadena($game->getTitle())."</a>";
				echo "</div>";
			}
			echo "</div>";
		echo "</div>";
	}
}else if($viewName=="broken"){
	echo "not implemented";
}








include_once("./views/templates/document-end.php"); ?>