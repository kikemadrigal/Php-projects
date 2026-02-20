<?php
//showUser.php muestra los datos del juego almacenado en la tabla usersgames
//La variable idGame se obtiene en el index.php
$idGame=$this->param[0];
$game=GameUserRepository::getGame($idGame); 
include_once("./views/templates/document-start.php"); 
?>
<!-- Patrones: para campos con números: pattern='[0-9]{1,10000}'-->
<!--<h3>Show user game </h3>-->

<div class="row text-center m-4">
    <div class="col">
        <h3><?php echo $game->getTitle(); ?></h3>
    </div>
</div>
<div class="row text-center">
    <div class="col">
        <!--Obtener foto --> 
        <?php
        if (!empty($game->getCover())) $image=MultimediaRepository::getImage($game->getCover());
        if(empty($image) || $image==null || $image->getId()==1){
            if(PRODUCTION==1){
                echo "<img src='".PATHSERVERSININDEX."media/sinImagen.jpg' class='max-height300' /><br>";
            }else{
                echo "<img src='".PATHSERVER."media/sinImagen.jpg' class='max-height300' /><br>";
            }
        }else{
            if(PRODUCTION==1){
                echo "<img src=".PATHSERVERSININDEX.$image->getPath()." class='max-height300' /><br>";
            }else{
                echo "<img src=".PATHSERVER.$image->getPath()." class='max-height300' /><br>";
            }
        }
        ?>   
    </div>
</div>


<nav class="m-4">
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Information</button>
    <button class="nav-link" id="nav-files-tab" data-bs-toggle="tab" data-bs-target="#nav-files" type="button" role="tab" aria-controls="nav-files" aria-selected="false">Files</button>
    <button class="nav-link" id="nav-screenshots-tab" data-bs-toggle="tab" data-bs-target="#nav-screenshots" type="button" role="tab" aria-controls="nav-screenshots" aria-selected="false">Screenshot</button>
    <button class="nav-link" id="nav-videos-tab" data-bs-toggle="tab" data-bs-target="#nav-videos" type="button" role="tab" aria-controls="nav-videos" aria-selected="false">URl videos</button>
    <button class="nav-link" id="nav-webs-tab" data-bs-toggle="tab" data-bs-target="#nav-webs" type="button" role="tab" aria-controls="nav-webs" aria-selected="false">URl webs</button>
    <button class="nav-link" id="nav-comments-tab" data-bs-toggle="tab" data-bs-target="#nav-comments" type="button" role="tab" aria-controls="nav-comments" aria-selected="false" disabled>Comments</button>  
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
      <p>Instructions: <?php echo $game->getInstructions(); ?></p>
      <p>Countru: <?php echo $game->getCountry(); ?></p>
      <p>Publisher: <?php echo $game->getPublisher(); ?></p>
      <p>Developer: <?php echo $game->getDeveloper(); ?></p>
      <p>Year: <?php echo $game->getYear(); ?></p>
      <p>Format: <?php echo $game->getFormat(); ?></p>
      <p>Genre: <?php echo $game->getGenre(); ?></p>
      <p>System: <?php echo $game->getSystem(); ?></p>
      <p>Control: <?php echo $game->getControl(); ?></p>
      <p>Players: <?php echo $game->getPlayers(); ?></p>
      <p>Languages: <?php echo $game->getLanguages(); ?></p>
      <p>Observations / Cheats: <?php echo $game->getObservations(); ?></p>
      <p></p>
  </div>
  <div class="tab-pane fade" id="nav-screenshots" role="tabpanel" aria-labelledby="nav-screenshots-tab">
    <?php
    $screenShotsGames=ScreenShotGameRepository::getAllByGame($game->getId());
    foreach ($screenShotsGames as $posicion=>$screenShot){
        if(PRODUCTION==1){
            echo "<a href='".PATHSERVERSININDEX.$screenShot->getPath()."' >";
                echo "<img src='".PATHSERVERSININDEX.$screenShot->getPath()."' width='100px' />";
            echo "</a>"; 
        }else{
            echo "<a href='".PATHSERVER.$screenShot->getPath()."' >";
                echo "<img src='".PATHSERVER.$screenShot->getPath()."' width='100px' />";
            echo "</a>";
        }
    }
    ?>
  </div>
  <div class="tab-pane fade" id="nav-files" role="tabpanel" aria-labelledby="nav-files-tab">
    <?php $filesGames=FileGameRepository::getAllByGame($game->getId());
    foreach ($filesGames as $posicion=>$file){
        if(PRODUCTION==1){
            echo "<a href='".PATHSERVERSININDEX.$file->getPath()."' >".$file->getName()."</a>"; 
        }else{
            echo "<a href='".PATHSERVER.$file->getPath()."' >".$file->getName()."</a>";
        }   
    }
    ?>
  </div>
  <div class="tab-pane fade" id="nav-videos" role="tabpanel" aria-labelledby="nav-videos-tab">
    <?php 
    $VideosGames=VideoGameRepository::getAllByGame($game->getId());
    foreach ($VideosGames as $posicion=>$video){
        echo "<a href='".$video->getText()."' target='_blanck'>".$video->getText()."</a>";       
    }
    ?>
  </div>
  <div class="tab-pane fade" id="nav-webs" role="tabpanel" aria-labelledby="nav-webs-tab">
    <?php $websGames=WebGameRepository::getAllByGame($game->getId());
    foreach ($websGames as $posicion=>$web){
        echo "<a href='".$web->getText()."' target='_blanck'>".$web->getText()."</a>";
    }
    ?>
  </div>
  <div class="tab-pane fade" id="nav-comments" role="tabpanel" aria-labelledby="nav-comments-tab">
        <p>comments 1</p>
        <p>comments 2</p>
        <p>comments 3</p>
  </div>
</div>





<?php include_once("./views/templates/document-end.php"); ?>