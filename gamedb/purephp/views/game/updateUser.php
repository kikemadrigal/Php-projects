<?php 

$mensaje="";
$path = "";
if (isset($_POST['submit'])){
    if(isset($_POST['broken'])) $broken=1;
    else  $broken=0;
    if(isset($_POST['iGoIt'])) $iGoIt=1;
    else  $iGoIt=0;
    $game=new Game($_POST['id']);
    $game->setTitle($_POST['title']);
    $game->setCover($_POST['cover']);
    $game->setInstructions($_POST['instructions']);
    $game->setCountry($_POST['country']);
    $game->setPublisher($_POST['publisher']);
    $game->setDeveloper($_POST['developer']);
    $game->setYear($_POST['year']);
    $game->setFormat($_POST['format']);
    $game->setGenre($_POST['genre']);
    $game->setSystem($_POST['system']);
    $game->setProgramming($_POST['programming']);
    $game->setSound($_POST['sound']);
    $game->setControl($_POST['control']);
    $game->setPlayers($_POST['players']);
    $game->setLanguages($_POST['languages']);
    $game->setIGoIt($iGoIt);
    $game->setBroken($broken);
    $game->setObservations($_POST['observations']);
    if ($game!=null){
        GameUserRepository::update($game);
        header("location: ".PATHSERVER."Game/update/".$_POST['id']."");
        if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Game/update/".$_POST['id']."';</script>";
    }else{
        echo "Update could not be completed";  
    }
    die();
}else if (isset($_POST['submitFileDelete'])){
    $path =FileGameRepository::getPath($idFileGame);
    unlink($path);
    $error=FileGameRepository::delete($idFileGame);
    if (!$error) $mensaje="File insert.";
    else $mensaje="Error inserting";
    header('Location: '.PATHSERVER."Game/update/".$idGame);
    if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Game/update/".$idGame."</script>";
}else if(isset($_POST['submitInsertFile'])){
    $fileName = $_FILES['archivo']['name']; 
    $tipo_archivo = $_FILES['archivo']['type']; 
    $tamano_archivo = $_FILES['archivo']['size']; 
    //txt: text/plain
    //cas: application/octet-stream
    if (!(strpos($tipo_archivo, "plain") || strpos($tipo_archivo, "pdf") || strpos($tipo_archivo, "doc") || strpos($tipo_archivo, "docx") || strpos($tipo_archivo, "octet-stream") || strpos($tipo_archivo, "rom") || strpos($tipo_archivo, "dsk") || strpos($tipo_archivo, "tsx") || $tamano_archivo > 900000)) 
    {
        echo "<h1>".$tipo_archivo."</h1>";
        $fileName="sinimagen.png";
        echo "El archivo no tiene el formato o el tam&ntilde;o correcto, solo se aceptan, pdf, txt, doc y docx menores de 90Mb.<br />";
    }else { 
        $fileName=Util::formatearTexto($fileName);
        if (!file_exists("media")) {
            mkdir("media", 0777, true);
        }
        if (!file_exists("media/users")) {
            mkdir("media/users", 0777, true);
        }
        if (!file_exists("media/users/user".$_SESSION['idusuario'])) {
            mkdir("media/users/user".$_SESSION['idusuario'], 0777, true);
        }
        $path="media/users/user".$_SESSION['idusuario']."/".$fileName;
        move_uploaded_file($_FILES['archivo']['tmp_name'], $path);
        $fileGame=new FileGame(0);
        $fileGame->setName($fileName);
        $fileGame->setPath($path);
        //La variable $idGame aparece en el index
        $fileGame->setGame($idGame);
        $error=FileGameRepository::insert($fileGame);
        if (!$error) $mensaje="File ".$fileName." insert.";
        else $mensaje="Error inserting";
        header('Location: '.PATHSERVER."Game/update/".$idGame);
        echo "<script type='text/javascript'>location.href='".PATHSERVER."Game/update/".$idGame."'</script>";
    } 			
    
}else if (isset($_POST['submitDeleteScreenShot'])){
    $error="";
    $path =ScreenShotGameRepository::getPath($idScreenShotGame);
    if (!unlink($path)) {
        echo ("$path cannot be deleted due to an error");
    }
    else {
        echo ("$path has been deleted");
    }
    $error=ScreenShotGameRepository::delete($idScreenShotGame);
    if (!$error) $mensaje="File insert.";
    else $mensaje="Error inserting";
    header('Location: '.PATHSERVER."Game/update/".$idGame);
    if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Game/update/".$idGame."</script>";  
}else if(isset($_POST['submitInsertScreenShot'])){
    $fileName = $_FILES['archivo']['name']; 
    $tipo_archivo = $_FILES['archivo']['type']; 
    $tamano_archivo = $_FILES['archivo']['size']; 
    if (!(strpos($tipo_archivo, "jpg") || strpos($tipo_archivo, "png") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "bmp") || $tamano_archivo > 900000)) 
    {
        $fileName="sinimagen.png";
        echo "El archivo no tiene el formato o el tam&ntilde;o correcto, solo se aceptan, jpg, jpeg, png y bmp menores de 90Mb.<br />";
    }else
    { 
        $fileName=Util::formatearTexto($fileName);
        if (!file_exists("media")) {
            mkdir("media", 0777, true);
        }
        if (!file_exists("media/users")) {
            mkdir("media/users", 0777, true);
        }
        if (!file_exists("media/users/user".$_SESSION['idusuario'])) {
            mkdir("media/users/user".$_SESSION['idusuario'], 0777, true);
        }
        $path="media/users/user".$_SESSION['idusuario']."/".$fileName;
        move_uploaded_file($_FILES['archivo']['tmp_name'], $path);
        $fileGame=new FileGame(0);
        $fileGame->setName($fileName);
        $fileGame->setPath($path);
        $fileGame->setGame($idGame);
        $error=ScreenShotGameRepository::insert($fileGame);
        if (!$error) $mensaje="File ".$fileName." insert.";
        else $mensaje="Error inserting";
        header('Location: '.PATHSERVER."Game/update/".$idGame);
        echo "<script type='text/javascript'>location.href='".PATHSERVER."Game/update/".$idGame."'</script>";
    } 	           
    
}else if (isset($_POST['submitDeleteVideo'])){
    $error=VideoGameRepository::delete($idVideoGame);
    if (!$error) $mensaje="File insert.";
    else $mensaje="Error inserting";
    header('Location: '.PATHSERVER."Game/update/".$idGame);
    if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Game/update/".$idGame."'</script>";       
}else if(isset($_POST['submitInsertVideo'])){
    $videoGame=new VideoGame(0);
    $videoGame->setText($text);
    $videoGame->setGame($idGame);
    $error=VideoGameRepository::insert($videoGame);
    if (!$error) $mensaje="Video ".$videoGame->getText()." insert.";
    else $mensaje="Error inserting";
    header('Location: '.PATHSERVER."Game/update/".$idGame);
    if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Game/update/".$idGame."'</script>";
}else if (isset($_POST['submitDeleteWeb'])){
    $error=WebGameRepository::delete($idWebGame);
    if (!$error) $mensaje="File insert.";
    else $mensaje="Error inserting";
    header('Location: '.PATHSERVER."Game/update/".$idGame);
    if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Game/update/".$idGame."</script>";
}else if(isset($_POST['submitInsertWeb'])){
    $webGame=new WebGame(0);
    $webGame->setText($text);
    $webGame->setGame($idGame);
    $error=WebGameRepository::insert($webGame);
    if (!$error) $mensaje="Web ".$webGame->getText()." insert.";
    else $mensaje="Error inserting";
    header('Location: '.PATHSERVER."Game/update/".$idGame);
    if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Game/update/".$idGame."'</script>";    
}
//El param es obtenido en el GameController
$idGame=$this->param;
if (empty($idGame)) {
    echo "idGame is empty";
    die();
}
$game=GameUserRepository::getGame($idGame);
include_once("./views/templates/document-start.php"); 
?>
<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Estas seguro que quieres borrar el juego? / Are you sure you want to delete the game?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="<?php echo PATHSERVER; ?>Game/delete/<?php echo $idGame; ?>" class="btn btn-primary">   SI   </a>
            </div>
        </div>
    </div>
</div>


<h3>Update game 
    <?php 
    $game=GameUserRepository::getGame($idGame); 
    echo $game->getTitle();
    ?>
</h3>
<!----------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------ FORMULARIO ACTUALIZAR------------------------------------------------->
<!----------------------------------------------------------------------------------------------------------------------->
<!-- Patrones: para campos con números: pattern='[0-9]{1,10000}'-->
<form method=post action='<?php echo PATHSERVER."Game/update"?>' class='form-horizontal background-pink' enctype='multipart/form-data'>
    <div class='form-group m-4' >
        <label for='title' class='control-label '>title:</label>
        <div class='col'>
            <input type='text' class='form-control' name='title' id='title' size=80 title='title is required' value='<?php echo $game->getTitle(); ?>' required  />
        </div>
    </div> 








    <!--Cover -->  
    <div class='text-center' > 
        <div class='col'>
            <!--Obtener foto --> 
            <?php
            $image=MultimediaRepository::getImage($game->getCover());

            if($image==null){
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
            <a href='<?php echo PATHSERVER;?>media/showAll' target='_blanck' >Management</a><br>      
           <!--Fin de obtener foto -->         
            <?php $images=MultimediaRepository::getAllImagesByUser($_SESSION['idusuario']);?>
            <select class="m-4" name='cover' id='cover' > ";
                <?php
               
                if ($image==null){
                    echo "<option value='1' >Sin imagen</option>";
                }else{
                    echo "<option value='".$image->getId()."' >".$image->getName()."</option>";
                    
                }
                foreach ($images as $posicion=>$image){
                    echo "<option value='".$image->getId()."' >".$image->getName()."</option>";
                }

                ?>
            </select>       
        </div>
    </div>
    <!-- Fin cover -->  















    <div class='form-group m-4' >
        <label for='instructions' class='control-label '>Instructions:</label>
        <div class='col'>
            <textarea type='text' class='form-control' name='instructions' id='instructions' rows=3 cols=60 title='Enter instructions' ><?php echo $game->getInstructions(); ?></textarea>
        </div>
    </div> 
    <div class='form-group m-4' >  
        <label for='system' class='control-label '>System: MSX, amstrad, Spectrum, PS4, etc</label> 
        <div class='col'>
            <input type='text' class='form-control' name='system' id='system' title='system' value='<?php echo $game->getSystem(); ?>' required />
        </div>
    </div> 
    <div class='form-group m-4' >
        <label for='publisher' class='control-label '>Publisher: Erbe, Zigurate, toposoft, etc</label> 
        <div class='col'>
            <input type='text' class='form-control' name='publisher' id='publisher' title='Publisher' value='<?php echo $game->getPublisher(); ?>' required />
        </div>
    </div> 
    <div class='form-group m-4' >  
        <label for='developer' class='control-label '>Developer: </label> 
        <div class='col'>
            <input type='text' class='form-control' name='developer' id='developer' title='Developer' value='<?php echo $game->getDeveloper(); ?>' required />
        </div>
    </div> 
    <div class='form-group m-4' > 
        <label for='country' class='control-label '>Country:</label> 
        <div class='col'>
            <input type='text' class='form-control' name='country' id='country' size=80 value='<?php echo $game->getCountry(); ?>' />
        </div>
    </div> 
    <div class='form-group m-4' >  
        <label for='year' class='control-label '>year: </label> 
        <div class='col'>
            <input type='number' class='form-control' name='year' id='year' title='year' value='<?php echo $game->getYear(); ?>'  />
        </div>
    </div> 
    <div class='form-group m-4' >  
        <label for='format' class='control-label '>Format: Tape, Tape deluxe, Cardbridge, Disk, CD, DVD, Blueray</label> 
        <div class='col'>
            <input type='text' class='form-control' name='format' id='format' title='format' value='<?php echo $game->getFormat(); ?>'  />
        </div>
    </div> 
    <div class='form-group m-4' >  
        <label for='genre' class='control-label '>genre: Platform, Puzzle, Strategy, Sport</label> 
        <div class='col'>
            <input type='text' class='form-control' name='genre' id='genre' title='genre' value='<?php echo $game->getProgramming(); ?>'  />
        </div>
    </div> 

    <div class='form-group m-4' >  
        <label for='programming' class='control-label '>programming: MSX Basic, assembler</label> 
        <div class='col'>
            <input type='text' class='form-control' name='programming' id='programming' title='programming' value='<?php echo $game->getControl(); ?>'  />
        </div>
    </div> 
    <div class='form-group m-4' >  
        <label for='sound' class='control-label '>sound: psg, scc, fm</label> 
        <div class='col'>
            <input type='text' class='form-control' name='sound' id='sound' title='sound' value='<?php echo $game->getSound(); ?>' />
        </div>
    </div> 
    <div class='form-group m-4' >  
        <label for='control' class='control-label '>control: keyboard, joystick</label> 
        <div class='col'>
            <input type='text' class='form-control' name='control' id='control' title='control' value='<?php echo $game->getControl(); ?>' />
        </div>
    </div> 
    <div class='form-group m-4' >  
        <label for='players' class='control-label '>players: 1,2</label> 
        <div class='col'>
            <input type='number' class='form-control' name='players' id='players' title='players' value='<?php echo $game->getPlayers(); ?>'  />
        </div>
    </div> 
    <div class='form-group m-4' >  
        <label for='languages' class='control-label '>languages: spanish, english</label> 
        <div class='col'>
            <input type='text' class='form-control' name='languages' id='languages' title='languages' value='<?php echo $game->getLanguages(); ?>'  />
        </div>
    </div> 
    <div class="form-check m-4">
        <label class="form-check-label" for="iGoIt">iGoIt</label>
        <?php 
        if($game->getIGoIt()==1) $valor="checked";
        else  $valor="";
        ?>
        <input class="form-check-input" type="checkbox" name='iGoIt' id='iGoIt' title='iGoIt' value="iGoIt" <?php echo $valor;?>>
    </div>
    <div class="form-check m-4">
        <label class="form-check-label" for="broken">broken</label>
        <?php 
        if($game->getBroken()==1) $valor="checked";
        else  $valor="";
        ?>
        <input class="form-check-input" type="checkbox" name='broken' id='broken' title='broken' value="broken" <?php echo $valor;?>>
    </div>
    <div class='form-group m-4' >  
        <label for='observations' class='control-label '>observations: </label> 
        <div class='col'>
            <textarea type='text' class='form-control' name='observations' id='observations' title='observations' rows='3' cols='60' ><?php echo $game->getObservations(); ?></textarea>
        </div>
    </div>   
    <div class='form-group m-4' > 
        <div class='col col-md-offset-2' >
            <input type="hidden" name="id" id="id" value='<?php echo $idGame ?>' />
            <input type='submit' name="submit" id="submit" value='Update' class='btn btn-primary' ></input> 
            <!--<input type='button' name="remove" id="remove" value='Remove' class='btn btn-danger' data-toggle="modal" data-target="#deleteModal" ></input> -->
            <a href="<?php echo PATHSERVER; ?>Game/delete/<?php echo $idGame; ?>" class="btn btn-danger">   Delete   </a>
        </div>
    </div> 
</form>
<!----------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------FINAL DEL FORMULARIO ACTUALIZAR------------------------------------------------->
<!----------------------------------------------------------------------------------------------------------------------->












<!------------------------------------- ADD ELEMENTS ------------------------------------------>
<br><br>
<h1>ADD ELEMENTS</h1>
<div class='form-group m-4' >  
    <label for='archivo' class='control-label '><h3>file (rom, cas, dsk, tsx, txt, doc, docx, pdf): </h3></label> 
    <div class='col'>
        <form class="form-horizontal" action="<?php echo PATHSERVER."Game/update"?>" method="post" enctype="multipart/form-data">
            <input type='file' class="form-control" name='archivo' id='archivo' onChange='ver(form.file.value)' required />
            <input type="hidden" name="idGame" value="<?php echo $game->getId() ?>" />
            <input type="submit" name="submitInsertFile" class="button btn-primary btn-large" value="Add file" />
        </form>
        <?php $filesGames=FileGameRepository::getAllByGame($game->getId());
        foreach ($filesGames as $posicion=>$file){
            ?>
            <form class='form-horizontal' action='<?php echo PATHSERVER; ?>Game/update' method='post'>
                <input type='hidden' name='idGame' value='<?php echo $game->getId(); ?>' />
                <input type='hidden' name='idFileGame' value='<?php echo $file->getId(); ?>' />
                <?php
                if(PRODUCTION==1){
                    echo "<a href='".PATHSERVERSININDEX.$file->getPath()."' >".$file->getName()."</a>"; 
                }else{
                    echo "<a href='".$file->getPath()."' >".$file->getName()."</a>";
                }
                ?>
                <input type='submit' name='submitFileDelete' class='button btn-danger' value='X' />
            </form>
            <?php
        }
        ?>
    </div>
</div> 
<hr>
<!-- SCREENSHOTS-->
<div class='form-group m-4' >  
    <label for='archivo' class='control-label '><h3>screenshot (png, jpg, jpeg, bmp): </h3></label> 
    <div class='col'>
        <form class="form-horizontal" action="<?php echo PATHSERVER."Game/update"?>" method="post" enctype="multipart/form-data">
            <input type='file' class="form-control" name='archivo' id='archivo' onChange='ver(form.file.value)' required />
            <input type="hidden" name="idGame" value="<?php echo $game->getId() ?>" />
            <input type="submit" name="submitInsertScreenShot" class="button btn-primary btn-large" value="Add screenshot" />
        </form>
        <?php $screenShotsGames=ScreenShotGameRepository::getAllByGame($game->getId());
        foreach ($screenShotsGames as $posicion=>$screenShot){
            ?>
            <form class='form-horizontal flex-container' action='<?php echo PATHSERVER; ?>Game/update' method='post'>
                <input type='hidden' name='idGame' value='<?php echo $game->getId(); ?>' />
                <input type='hidden' name='idScreenShotGame' value='<?php echo $screenShot->getId(); ?>' />
                <?php
                if(PRODUCTION==1){
                    echo "<a href='".PATHSERVERSININDEX.$screenShot->getPath()."' >";
                        echo "<img src='".PATHSERVERSININDEX.$screenShot->getPath()."' width='100px' />";
                    echo "</a>"; 
                }else{
                    echo "<a href='".PATHSERVER.$screenShot->getPath()."' >";
                        echo "<img src='".PATHSERVER.$screenShot->getPath()."' width='100px' />";
                    echo "</a>";
                }
                ?>
                <input type='submit' name='submitDeleteScreenShot' class='button btn-danger' value='X' />
            </form>
            <?php
        }
        ?>
    </div>
</div>     
<hr>
<!-- VIDEOS -->
<div class='form-group m-4' >  
    <label for='text' class='control-label '><h3>URL video:</h3> </label> 
    <div class='col'>
        <form class="form-horizontal" action="<?php echo PATHSERVER."Game/update"?>" method="post">
            <input type="text" class="form-control"  name="text" id="text" title='Se necesita un texto' required /><br>
            <input type="hidden" name="idGame" value="<?php echo $game->getId() ?>" />
            <input type="submit" name="submitInsertVideo" class="button btn-primary btn-large" value="Add Video" />
        </form>
        <?php $VideosGames=VideoGameRepository::getAllByGame($game->getId());
        foreach ($VideosGames as $posicion=>$video){
            ?>
            <form class='form-horizontal' action='<?php echo PATHSERVER; ?>Game/update' method='post'>
                <input type='hidden' name='idGame' value='<?php echo $game->getId(); ?>' />
                <input type='hidden' name='idVideoGame' value='<?php echo $video->getId(); ?>' />
                <a href="<?php echo $video->getText(); ?>" target="_blanck"><?php echo $video->getText(); ?></a>
                <input type='submit' name='submitDeleteVideo' class='button btn-danger' value='X' />
            </form>
            <?php
        }
        ?>
    </div>
</div>  
<hr>
<!-- WEBS--> 
<div class='form-group m-4' >  
    <label for='text' class='control-label '><h3>URL web:</h3> </label> 
    <div class='col'>
        <form class="form-horizontal" action="<?php echo PATHSERVER."game/update"?>" method="post">
            <input type="text" class="form-control"  name="text" id="text" title='Se necesita un texto' required /><br>
            <input type="hidden" name="idGame" value="<?php echo $game->getId() ?>" />
            <input type="submit" name="submitInsertWeb" class="button btn-primary btn-large" value="Add web" />
        </form>
        <?php $websGames=WebGameRepository::getAllByGame($game->getId());
        foreach ($websGames as $posicion=>$web){
            ?>
            <form class='form-horizontal' action='<?php echo PATHSERVER; ?>Game/update' method='post'>
                <input type='hidden' name='idGame' value='<?php echo $game->getId(); ?>' />
                <input type='hidden' name='idWebGame' value='<?php echo $web->getId(); ?>' />
                <a href="<?php echo $web->getText(); ?>" target="_blanck"><?php echo $web->getText(); ?></a>
                <input type='submit' name='submitDeleteWeb' class='button btn-danger' value='X' />
            </form>
            <?php
        }
        ?>
    </div>
</div>  


<?php include_once("./views/templates/document-end.php"); ?>