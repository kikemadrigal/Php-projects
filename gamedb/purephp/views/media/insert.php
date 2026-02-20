<?php
$type=0;
$mensaje="";
$path = "";
if (isset($_POST['submit'])){
    //$text=$_POST['text'];
    $nombreImagen = $_FILES['archivo']['name']; 
    $tipo_archivo = $_FILES['archivo']['type']; 
    $tamano_archivo = $_FILES['archivo']['size']; 


    if (!(strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "jpg") || strpos($tipo_archivo, "png") || $tamano_archivo > 900000)) 
    {
        $nombreImagen="sinimagen.png";
        echo "La foto no tiene el formato o el tam&ntilde;o correcto, solo se aceptan, jpg o png menores de 90Mb.<br />";
    }else
    { 
        //1.Formateamos el nombre de la imagen
        $nombreImagen=Util::formatearTexto($nombreImagen);
        //1.Creamos el path para subir las fotos según los usuarios

        //media/
        if (!file_exists("media")) {
            mkdir("media", 0777, true);
        }
        //media/users/
        if (!file_exists("media/users")) {
            mkdir("media/users", 0777, true);
        }
        //media/users/user186
        if (!file_exists("media/users/user".$_SESSION['idusuario'])) {
            mkdir("media/users/user".$_SESSION['idusuario'], 0777, true);
        }
        
        //type= 1 imagen, 2 audio, 3 video
        $type=1;
        $path="media/users/user".$_SESSION['idusuario']."/".$nombreImagen;
        $game=1;
        move_uploaded_file($_FILES['archivo']['tmp_name'], $path);
        $error=MultimediaRepository::insert($nombreImagen, $path, $type, $_SESSION['idusuario'], $game);
        if (!$error) $mensaje="Imagen ".$nombreImagen." insertada.";
        else $mensaje="Error inserting";
        header('Location: '.PATHSERVER."media/showAll");
        if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."media/showAll';</script>";
    } 					
}








include_once("./views/templates/document-start.php"); 
?>
<script>
    function ver(file){
        document.getElementById('archivo').innerHTML = "<img src='"+file+"'>";
    } 
</script>
<a href="https://www.google.es/imghp?hl=es&ogbl" class='btn btn-success m-4' target="_blanck" >Search images on google </a><br>
<form method='post' action='<?php echo PATHSERVER."media/insert"; ?>' class='form-horizontal' enctype='multipart/form-data'>
    <div class="form-group m-4">
            <label for="error" class="control-label fs-1 fw-bold text-warning"><?php echo $mensaje;?></label>
    </div> 
    <div class='form-group m-4' >
        <label for='archivo' class='control-label'>Multimedia file: </label> 
        <input type='file' class="form-control" name='archivo' id='archivo' onChange='ver(form.file.value)' />
    </div>

    <!--<div class="form-group">
        <label for="text" class="control-label">description: </label>
        <input type="text" class="form-control" name="text" id="text" title="text" />
    </div>-->


    <div class='form-group m-4' > 
        <div class='col col-md-offset-2' >
            <input type='submit' name='submit'  id='submit' value='Insert' class='btn btn-primary' ></input> 
        </div>
    </div> 
</form> 

<?php include_once("./views/templates/document-end.php"); ?>