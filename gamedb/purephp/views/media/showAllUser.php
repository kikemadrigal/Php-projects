<?php include_once("./views/templates/document-start.php"); 
//Obtenemos las imágenes del usuario activo
$contador=0;

echo "<br><a href='".PATHSERVER."media/insert' class='btn btn-success m-4'>Insert new multimedia</a>";
echo "<h3>Images</h3>";
$images=MultimediaRepository::getAllImagesByUser($_SESSION['idusuario']);
echo "<div class='flex-container'>";
foreach ($images as $posicion=>$image){
	echo "<div class='show-picture' >";
		echo "<a href='".PATHSERVER."media/update/".$image->getId()."'>";
		if(PRODUCTION==1){
			echo "<img src=".PATHSERVERSININDEX.$image->getPath()." class='max-height300' /><br>";
		}else{
			echo "<img src=".PATHSERVER.$image->getPath()." class='max-height300' /><br>";
		}
		
		echo $image->getPath()."<br>";
		echo "</a><br>";
		
		?>
		    <!--Delete media -->     
			<form class="" method="post" action='<?php echo PATHSERVER; ?>media/delete' >
                <input type="hidden" name="id" id="id" value="<?php echo $image->getId();?>" />
                <button class="btn btn-danger" type="submit" name="submit" >Delete</button>
            </form>
		<?php
		
	echo "</div>";
}
echo "</div>";

?>
<?php include_once("./views/templates/document-end.php"); ?>