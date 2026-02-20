<?php
//Show.php permite visualizar los datos de un juego alamcenado en la tabla games
//La variable param se obtiene en el GameController.php

$tour=$this->tour;
include_once("./views/templates/document-start.php"); 
?>
<!-- Patrones: para campos con números: pattern='[0-9]{1,10000}'-->
<!--<h3>Show user tour </h3>-->


<div class="row text-center">
    <div class="col">
        <!--Obtener foto --> 
        <?php
        $image=$this->image;
        $audio=$this->audio;
        $imagesByTour=$this->imagesByTour;
        $audiosByTour=$this->audiosByTour;
        $videosByTour=$this->videosByTour;
        $virtualToursByTour=$this->virtualToursByTour;
        $audioFile="media/withoutAudio.mp3";
        $imageFile="media/withoutImage.png";
        if(PRODUCTION==1){
            $audioFile=PATHSERVERSININDEX.$audio->getPath()."/".$audio->getName();
            $imageFile=PATHSERVERSININDEX.$image->getPath()."/".$image->getName();
          }
          else{
            $audioFile=PATHSERVER.$audio->getPath()."/".$audio->getName();
            $imageFile=PATHSERVER.$image->getPath()."/".$image->getName();
        } 
        if($image!=null) $path=$image->getPath();
        else $path="";
        if(PRODUCTION==1){
            if (file_exists($path)){
                echo "<br /><img class='img-fluid mx-4' src='".$imageFile."' width='200px' />";
                echo "<br /><audio src='".$audioFile."' style='width: 200px;' controls >Your browser does not support the <code>audio</code> element.</audio>";
            }else{
                echo "<br /><img class='img-fluid mx-4' src='".PATHSERVERSININDEX."media/sinImagen.jpg' width='200px' />&nbsp;&nbsp;";
                echo "<audio src='".PATHSERVERSININDEX."media/withoutAudio.mp3' style='width: 200px;' controls >Your browser does not support the <code>audio</code> element.</audio>";
            }
        }else{
            if (file_exists($path)){
                echo "<br /><img class='img-fluid img-fluid mx-4'  src='".$imageFile."' width='200px' />";
                echo "<br /><audio src='".$audioFile."' style='width: 200px;' controls >Your browser does not support the <code>audio</code> element.</audio>";
            }else{
                echo "<br /><img class='img-fluid mx-4' src='".PATHSERVER."media/sinImagen.jpg' width='200px' />&nbsp;&nbsp;";
                echo "<br /><audio src='".PATHSERVER."media/withoutAudio.mp3' style='width: 200px;' controls >Your browser does not support the <code>audio</code> element.</audio>";
            }
        }
        echo "<h4>".$tour->getName()."</h4>";
        ?>  
    </div>
</div>


<nav class="m-4">
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Information</button>
    <button class="nav-link" id="nav-images-tab" data-bs-toggle="tab" data-bs-target="#nav-images" type="button" role="tab" aria-controls="nav-images" aria-selected="false">Images</button>
    <button class="nav-link" id="nav-audios-tab" data-bs-toggle="tab" data-bs-target="#nav-audios" type="button" role="tab" aria-controls="nav-audios" aria-selected="false">Audios</button>
    <button class="nav-link" id="nav-videos-tab" data-bs-toggle="tab" data-bs-target="#nav-videos" type="button" role="tab" aria-controls="nav-videos" aria-selected="false">Videos</button>
    <button class="nav-link" id="nav-virtual-tab" data-bs-toggle="tab" data-bs-target="#nav-virtual" type="button" role="tab" aria-controls="nav-virtual" aria-selected="false">Virtual tour</button>
   </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
      <p>Name: <?php echo $tour->getName(); ?></p>
      <p>Address: <?php echo $tour->getAddress(); ?></p>
      <p>Phone: <?php echo $tour->getPhone(); ?></p>
      <p>Web: <a href="<?php echo $tour->getWeb(); ?>"><?php echo $tour->getWeb(); ?></a></p>
      <p>Blog Url:<a href="<?php echo $tour->getBlogUrl(); ?>"> <?php echo $tour->getBlogUrl(); ?></a></p>
      <p>Description: <pre><?php echo $tour->getDescription(); ?></pre></p>
      <p></p>
  </div>
  <div class="tab-pane fade" id="nav-images" role="tabpanel" aria-labelledby="nav-images-tab">
        <div class="row">
            <?php 
            foreach ($imagesByTour as $posicion=>$image){
                echo "<div class='col-md-3 text-center'>";
                    echo "<div ><a href='".PATHSERVER.$image->getPath()."/".$image->getName()."'><img class='show-picture' src='".PATHSERVER.$image->getPath()."/".$image->getName()."'  height='200px' /></a></div>";
                echo "</div>";
            }
            ?>  
        </div>
  </div>
  <div class="tab-pane fade" id="nav-audios" role="tabpanel" aria-labelledby="nav-audios-tab">
     
      <?php 
        foreach ($audiosByTour as $posicion=>$audio){
            echo "<audio src='".PATHSERVER.$audio->getPath()."/".$audio->getName()."' style='width: 200px;' controls >Your browser does not support the <code>audio</code> element.</audio>&nbsp&nbsp&nbsp&nbsp&nbsp";
        }
      ?>

  </div>
  <div class="tab-pane fade" id="nav-videos" role="tabpanel" aria-labelledby="nav-videos-tab">
    
      <?php 
        foreach ($videosByTour as $posicion=>$video){
            echo "<video width='320' height='240' controls><source src='".PATHSERVER.$video->getPath()."/".$video->getName()."' type='video/mp4'>Your browser does not support the video tag.</video>";
        }
      ?>

  </div>
  <div class="tab-pane fade" id="nav-virtual" role="tabpanel" aria-labelledby="nav-virtual-tab">
      
      <?php 
       foreach ($virtualToursByTour as $posicion=>$virtualTour){
            echo "<p><a href='".$virtualTour->getName()."' target='_blanck'>".$virtualTour->getName()."</a></p>";
       }
      ?>

  </div>
</div>





<?php include_once("./views/templates/document-end.php"); ?>