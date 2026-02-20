<?php include_once("./views/templates/document-start.php"); 
//Obtenemos las imágenes del usuario activo
$contador=0;





?>
<div><?php if (!empty($this->message)) echo $this->message ?></div>
 

<nav class="m-4">
	<div class="nav nav-tabs" id="nav-tab" role="tablist">
		<button class="nav-link active" id="nav-images-tab" data-bs-toggle="tab" data-bs-target="#nav-images" type="button" role="tab" aria-controls="nav-images" aria-selected="true">Images</button>
		<button class="nav-link" id="nav-audios-tab" data-bs-toggle="tab" data-bs-target="#nav-audios" type="button" role="tab" aria-controls="nav-audios" aria-selected="false">Audios</button>
		<button class="nav-link" id="nav-videos-tab" data-bs-toggle="tab" data-bs-target="#nav-videos" type="button" role="tab" aria-controls="nav-videos" aria-selected="false">Videos</button>
		<button class="nav-link" id="nav-virtualTours-tab" data-bs-toggle="tab" data-bs-target="#nav-virtualTours" type="button" role="tab" aria-controls="nav-virtualTours" aria-selected="false">Virtual tour</button>
	</div>
</nav>

<div class="tab-content" id="nav-tabContent">

  <div class="tab-pane fade show active" id="nav-images" role="tabpanel" aria-labelledby="nav-images-tab">
  	<?php echo "<br><a href='".PATHSERVER."Media/insertForm' class='btn btn-success m-4'>Insert new image</a>";
	
	?>
 		
  	<table class="table table-striped">
		<thead> 
			<tr>
				<th scope="col">Name</th>
				<th scope="col">Image</th>
				<th scope="col">Tour</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if($this->images!=null){
				foreach ($this->images as $posicion=>$image){
					if ($image->getId()!=1){	
						echo "<tr>";
							echo "<td>";
								if(PRODUCTION==1) echo "<a href='".PATHSERVER."Media/updateFormImage/".$image->getId()."'>";
								else echo "<a href='".PATHSERVER."Media/updateFormImage/".$image->getId()."'>";
									if(PRODUCTION==1)$imageFile=PATHSERVERSININDEX.$image->getPath()."/".$image->getName();
									else $imageFile=PATHSERVER.$image->getPath()."/".$image->getName();
									echo "<img src=".$imageFile." width='100px' /><br>";
								echo "</a>";
							echo "</td>";
							echo "<td>".$image->getName()."</td>";
							$tour=TourRepository::getById($image->getTourId());
							echo "<td>".$tour->getName()."</td>";
							/*
							echo "<td>";
								//Delete image    
								echo "<form method='post' action='".PATHSERVER."Media/deleteImage' >";
								echo "<input type='hidden' name='id' id='id' value='".$image->getId()."' />";
								echo "<button class='btn btn-danger' type='submit' name='submit' >Delete</button> ";
								echo "</form>";
							echo "</td>";
							*/
						echo "</tr>";
					}
				}
			}else{
				 echo "<tr><td>Without images</td></tr>";
			}
			?>
		</tbody>
	</table> 

	
  	</div>
  	<div class="tab-pane fade" id="nav-audios" role="tabpanel" aria-labelledby="nav-audios-tab">
	  	<?php echo "<br><a href='".PATHSERVER."Media/insertForm' class='btn btn-success m-4'>Insert new audio</a>";?>
	  
  		<table class="table table-striped">
			<thead> 
				<tr>
					<th scope="col">Name</th>
					<th scope="col">Audio</th>
					<th scope="col">Tour</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($this->audios!=null){
					foreach ($this->audios as $posicion=>$audio){
						if ($audio->getId()!=1){	
							echo "<tr>";
								echo "<td>";
								if(PRODUCTION==1) echo "<a href='".PATHSERVER."Media/updateFormAudio/".$audio->getId()."'>";
								else echo "<a href='".PATHSERVER."Media/updateFormAudio/".$audio->getId()."'>Update   ";
										if(PRODUCTION==1)$audioFile=PATHSERVERSININDEX.$audio->getPath()."/".$audio->getName();
										else $audioFile=PATHSERVER.$audio->getPath()."/".$audio->getName();
										echo "<audio src=".$audioFile." width='100px' controls></audio>";
									echo "</a>";
								echo "</td>";
								echo "<td>".$audio->getName()."</td>";
								$tour=TourRepository::getById($audio->getTourId());
								echo "<td>".$tour->getName()."</td>";
								/*
								echo "<td>";
								//Delete audio    
								echo "<form method='post' action='".PATHSERVER."Media/deleteAudio' >";
									echo "<input type='hidden' name='id' id='id' value='".$audio->getId()."' />";
									echo "<button class='btn btn-danger' type='submit' name='submit' >Delete</button> ";
								echo "</form>";
								echo "</td>";
								*/
							echo "</tr>";
						}
					}
				}else{
					echo "<tr><td>Without audios</td></tr>";
			   	}
				?>
			</tbody>
		</table>
  	</div>
	<div class="tab-pane fade" id="nav-videos" role="tabpanel" aria-labelledby="nav-videos-tab">
		<?php echo "<br><a href='".PATHSERVER."Media/insertForm' class='btn btn-success m-4'>Insert new video</a>";?>
		<table class="table table-striped">
			<thead> 
				<tr>
					<th scope="col">Name</th>
					<th scope="col">Video</th>
					<th scope="col">Tour</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($this->videos!=null){
					foreach ($this->videos as $posicion=>$video){
						if ($video->getId()!=1){	
							echo "<tr>";
								echo "<td>";
								if(PRODUCTION==1) echo "<a href='".PATHSERVER."Media/updateFormVideo/".$video->getId()."'>";
								else echo "<a href='".PATHSERVER."Media/updateFormVideo/".$video->getId()."'>Update   ";
										if(PRODUCTION==1)$videoFile=PATHSERVERSININDEX.$video->getPath()."/".$video->getName();
										else $videoFile=PATHSERVER.$video->getPath()."/".$video->getName();

										echo "<video width='320' height='240' > <source src='".$videoFile."' type='video/mp4'>Your browser does not support the video tag.</video>";

									echo "</a>";
								echo "</td>";
								echo "<td>".$video->getName()."</td>";
								$tour=TourRepository::getById($video->getTourId());
								echo "<td>".$tour->getName()."</td>";
							echo "</tr>";
						}
					}
				}else{
					echo "<tr><td>Without videos </td></tr>";
			   	}
				?>
			</tbody>
		</table>
	</div>
	<div class="tab-pane fade" id="nav-virtualTours" role="tabpanel" aria-labelledby="nav-virtualTours-tab">
		<?php echo "<br><a href='".PATHSERVER."Media/insertFormVirtualTour' class='btn btn-success m-4'>Insert new virtual tour</a>";
		?>
		<table class="table table-striped">
			<thead> 
				<tr>
					<th scope="col">Name</th>
					<th scope="col">URL</th>
					<th scope="col">Tour</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($this->virtualTours!=null){
					foreach ($this->virtualTours as $posicion=>$virtualTour){
						if ($virtualTour->getId()!=1){	
							echo "<tr>";
								echo "<td>Link:";
									echo "<a href='".$virtualTour->getName()."'>".$virtualTour->getName()."</a>";
								echo "</td>";
								echo "<td>Update:";
								if(PRODUCTION==1) echo "<a href='".PATHSERVER."Media/updateFormVirtualTour/".$virtualTour->getId()."'>";
								else echo "<a href='".PATHSERVER."Media/updateFormVirtualTour/".$virtualTour->getId()."'>Update   ";
										
										echo $virtualTour->getName();

									echo "</a>";
								echo "</td>";

								$tour=TourRepository::getById($virtualTour->getTourId());
								echo "<td>".$tour->getName()."</td>";
							echo "</tr>";
						}
					}
				}else{
					echo "<tr><td>Without virtual tours</td></tr>";
			   	}
				?>
			</tbody>
		</table>

	</div>
</div>
















<?php include_once("./views/templates/document-end.php"); ?>