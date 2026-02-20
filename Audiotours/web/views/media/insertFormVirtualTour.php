<?php include_once("./views/templates/document-start.php");
if(!isset($_SESSION['idusuario']) || $_SESSION['nivelaccesousuario']!=1){
    header('Location: Error');
    die();
}
?>
<br /><div>
    <p>Tenga en cuenta que cuando se borra un tour, se borran las imágenes asociadas a ese tour</p>
    <p>Please note that when a tour is deleted, the images associated with that tour will be deleted.</p>
<div>

<form method='post' action='<?php echo PATHSERVER."Media/insertVirtualTour"; ?>' class='form-horizontal' enctype='multipart/form-data'>
    <div class="text-center">
        <div class='form-group m-4' >  
            <label for='name' class='control-label'>Url virtual Tour:</label> 
            <div class='col'>
                <input type='text' class='form-control' name='name' id='name' title='name' value='<?php if(isset($this->errors)) echo $this->name; ?>' />
            </div>
        </div> 
        <div class='form-group m-4' >
            <label for='tourId' class='control-label'>Associate with Tour: </label> 
            <select class='m-4' name='tourId' id='tourId' class='form-control' /> 
            <option value='1' >Without tour</option>
            <?php
            if($this->tours!=null){
                foreach ($this->tours as $posicion=>$tour){
                    if($tour->getId()!=1) //kitamos el 1 que es imagen vacía
                        echo "<option value='".$tour->getId()."'>".$tour->getName()."</option>";
                } 
            }
            ?>
            </select>
            
            <?php if($this->tours==null) echo "tours es null";?>
        </div> 
        <div class='form-group m-4' > 
            <div class='col col-md-offset-2' >
                <input type='submit' name='submit'  id='submit' value='Insert' class='btn btn-primary' ></input>
            </div>
        </div> 
    </div>
</form> 




<!-- Validaciones:  Mostramos errores por HTML -->  
<div class='text-center bg-warning' >    
    <?php        
    if (isset($this->errors)&& count($this->errors)>0){
        foreach ($this->errors as $error) {
            echo '<p>' . $error . '</p>';
        } 
    }
    ?> 
</div>  
<!--Fin de validaciones -->
<?php include_once("./views/templates/document-end.php"); ?>