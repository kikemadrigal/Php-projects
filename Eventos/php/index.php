<?php
//https://murciadevs.tipolisto.es/files/eventos/?nombre_evento=striptis
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("env.php");
require_once("database.php");
require_once("Participante.php");
require_once("MysqliClient.php");
$mysqliClient=new MysqliClient();
$mysqliClient->conectar_mysql();

if(!isset($_GET)){
  echo "No se ha recibido el evento por la URL";
  die();
}

$evento=null;
//Enrutador
if(!isset($_GET['nombre_evento'])){
  echo "No se ha recibido el evento por la URL, escriba <a href='https://murciadevs.tipolisto.es/files/eventos/?nombre_evento=cena'> https://murciadevs.tipolisto.es/files/eventos/?nombre_evento=cena</a> ";
  die();
}else{
  $nombre_evento=$_GET['nombre_evento'];
}
//Lo primero es compribar con el nombre, si existe ese nombre en la tabla eventos de la base de datos
$evento=$mysqliClient->get_evento($nombre_evento);
  if ($evento==null){
    echo "Evento no encontrado, escriba <a href='https://murciadevs.tipolisto.es/files/eventos/?nombre_evento=cena'> https://murciadevs.tipolisto.es/files/eventos/?nombre_evento=cena</a>";
    die();
  }
$id_evento=$evento['id'];

//Ahora obtenemos todos los participantes del evento
$participantes=$mysqliClient->get_all_participantes_evento($id_evento);

//Función auxiliar para obtener el participantes del array participantes
function dame_paricipante($nombre, $participantes){
  $participante_encontrado=null;
  foreach ($participantes as $posicion=>$participante){
    //echo $participante->get_nombre()."<br>";
    if($participante->get_nombre()==$nombre){
      $participante_encontrado=$participante;
    }
  }
  return $participante_encontrado;
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
    <link rel="icon" href="images/icon.ico" type="image/x-icon">
    <title><?php echo $evento['nombre']; ?></title>
    <script src="main.js"></script>
  </head>
  <body>
    <div class="container clase">

        <!-- Informacion del evento que sale en la parte superior-->
        <div class="row g-3 container mb-3 bg-light">
          <div class="col">
            <label for="caca" class="visually-hidden">Id: </label>
              <input type="text" readonly class="form-control-plaintext" id="caca" value="Evento: " >
            </div>
          <div class="col">
            <label for="id_evento" class="visually-hidden">Id: </label>
            <input type="text" readonly class="form-control-plaintext " id="id_evento" value="<?php echo $evento['id']; ?>">
          </div>
          <div class="col">
            <b class="form-control-plaintext"> <?php echo strtoupper($evento['nombre']);?></b>
          </div>
          <div class="col">
            <label for="fecha_evento" class="visually-hidden">fecha:</label>
            <input type="text" readonly class="form-control-plaintext" id="fecha_evento" value="<?php echo $evento['fecha']; ?>">
          </div>
          <div class="col-6">
            <label for="direccion_evento" class="visually-hidden">direccion:</label>
            <input type="text" readonly class="form-control-plaintext" id="direccion_evento" value="<?php echo $evento['direccion']; ?>">
          </div>
        </div>


        <!-- El formulario con el precio total, la cantidad de participantes y la media por cada participante-->
        <!-- la clase informacion_evento está en main.css y tiene una foto-->
        <div class="row informacion_evento">
          <div class="col flex">
              <div class="col-md-4">
                <label for="precioTotal" class="pizarra">Valor total</label>
                <?php //borrado onchange=actualizar_evento() ?>
                <input type="text" class="form-control pizarra" id="precioTotal"  placeholder="0" value="<?php echo $evento['precio']; ?>" >
                <label for="cantidad-participantes" class="pizarra">Cantidad participantes</label>
                <input type="text" class="form-control pizarra" id="cantidadParticipantes" placeholder="0" value="<?php echo $evento['cantidad_participantes']; ?>">
                <label for="porCabeza" class="pizarra">Nos toca a cada uno</label>
                <input type="text" class="form-control pizarra" id="porCabeza" placeholder="0">
              </div>
              <div class="d-flex d-flex justify-content-center">
                  <div class="mx-auto">
                      <!-- Loreto -->     
                      <? $participante=dame_paricipante("Loreto", $participantes);?>  
                      <div class="form-group">
                        <input class="form-text" type="text" placeholder="Di algo!!" value="<?php echo $participante->get_comentario(); ?>" id="<?php echo $participante->get_nombre()?>-comentario" onchange="actualizar_comentario(this)">
                      </div>       
                      <img src="images/<?php echo $participante->get_nombre()?>.png" alt="" width="150" height="150">
                      <p><h3><?php echo $participante->get_nombre()?></h3></p>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="<?php echo $participante->get_nombre()?>-asistencia" <?php if ($participante->get_asistencia()==1){echo "checked";}?> onclick=checkBox_asistencia_o_pagado_click(this)>
                        <label class="form-check-label" for="fran-cocinero-asistencia">Asistencia</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="<?php echo $participante->get_nombre()?>-pagado" <?php if ($participante->get_pagado()==1){echo "checked";}?> onclick=checkBox_asistencia_o_pagado_click(this)>
                        <label class="form-check-label" for="fran-cocinero-pagado"  id="<?php echo $participante->get_nombre()?>-pagado-label">Pagado </label>
                      </div>
                  </div>
                  <div class="mx-auto my-5">
                      <!-- Laura -->     
                      <? $participante=dame_paricipante("Laura", $participantes);?>    
                      <div class="form-group">
                        <input class="form-text" type="text" value="<?php echo $participante->get_comentario(); ?>" id="<?php echo $participante->get_nombre()?>-comentario" onchange="actualizar_comentario(this)">
                      </div>     
                      <img src="images/<?php echo $participante->get_nombre()?>.png" alt="" width="150" height="150">
                      <p><h3><?php echo $participante->get_nombre()?></h3></p>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="<?php echo $participante->get_nombre()?>-asistencia" <?php if ($participante->get_asistencia()==1){echo "checked";}?> onclick=checkBox_asistencia_o_pagado_click(this)>
                        <label class="form-check-label" for="fran-cocinero-asistencia">Asistencia</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="<?php echo $participante->get_nombre()?>-pagado" <?php if ($participante->get_pagado()==1){echo "checked";}?> onclick=checkBox_asistencia_o_pagado_click(this)>
                        <label class="form-check-label" for="fran-cocinero-pagado"  id="<?php echo $participante->get_nombre()?>-pagado-label">Pagado </label>
                      </div>
                  </div>
              </div>
          </div>
        </div><!-- Final del div informacion_evento (precio total, cantidad de participantes y media) -->
  
        <div class="container">
        <?php
            $contador=0;
            echo "<div class='row'>";
            foreach ($participantes as $posicion=>$participante){
              if($participante->get_nombre()=="Laura" || $participante->get_nombre()=="Loreto") continue;
              //echo $contador;
              $contador++;
              //Hacemos saltos de línea cuando nos salga de la picha
              if($contador==5 || $contador==8 || $contador==11 || $contador==14 || $contador==16 || $contador==18){
                echo "<div class='row'></div>";
              }
              ?>
                <div class="col m-2">                      
                    <div class="form-group">
                      <input class="form-text" type="text" placeholder="Di algo!!" value="<?php echo $participante->get_comentario(); ?>" id="<?php echo $participante->get_nombre()?>-comentario" onchange="actualizar_comentario(this)">
                    </div>
                    <img src="images/<?php echo $participante->get_nombre()?>.png" alt="" width="150" height="150">
                    <p><h3><?php echo $participante->get_nombre()?></h3></p>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="<?php echo $participante->get_nombre()?>-asistencia" <?php if ($participante->get_asistencia()==1){echo "checked";}?> onclick=checkBox_asistencia_o_pagado_click(this)>
                      <label class="form-check-label" for="fran-cocinero-asistencia">Asistencia</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="<?php echo $participante->get_nombre()?>-pagado" <?php if ($participante->get_pagado()==1){echo "checked";}?> onclick=checkBox_asistencia_o_pagado_click(this)>
                      <label class="form-check-label" for="fran-cocinero-pagado"  id="<?php echo $participante->get_nombre()?>-pagado-label">Pagado </label>
                    </div>
                </div>
              <?php              
            }
            echo "</div >";
            ?>
        </div><!-- Final del div id clase-->
    </div><!-- container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>