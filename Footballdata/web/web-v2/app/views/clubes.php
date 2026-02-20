<?php include_once(__DIR__ . "/document-start.php");
$clubesRepository = new ClubesRepository();
$total_registers=0;
$clubes=[];

// Si se ha recibido algo del formaulario de confirguración
if(isset($_POST['submit'])){
    $page=0;
    if (isset($_POST['page'])) {
        $page = $_POST['page'];
    }
    $clubes=$clubesRepository->get_clubes($page*10, $_POST['where_name'],$_POST['where_value']);
    $total_registers= $clubesRepository->get_count_clubes( $_POST['where_name'],$_POST['where_value']);
}else{
    //Si no se ha recibido nada del formulariod e configuración pero se ha recibido al por la URL
    if(isset($_GET['where_name'])){
        if (isset($_GET['order_by'])) {
            $clubes=$clubesRepository->get_clubes($_GET['page']*10, $_GET['where_name'],$_GET['where_value'], $_GET['order_by']);
            $total_registers= $clubesRepository->get_count_clubes( $_GET['where_name'],$_GET['where_value'], $_GET['order_by']);
        } else {
            $clubes=$clubesRepository->get_clubes($_GET['page']*10, $_GET['where_name'],$_GET['where_value']);
            $total_registers= $clubesRepository->get_count_clubes($_GET['where_name'],$_GET['where_value']);
        }
    }else{
        $clubes=$clubesRepository->get_clubes();
        $total_registers= $clubesRepository->get_count_clubes();
    }
}
?>

<!-------------------------------------------->
<!----------Formaulario de configuración------>
<!--------------------------------------------->
<form method=post action='clubes.php' >
    <!--Parte de li utilizando bootstrap-->
    <div class="dropdown d-flex">
        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
            Search in
        </a>
        <ul  id="list" class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <li>nombre</li>
            <li>valor_total_mercado</li>
            <li>tamanio_plantilla</li>
            <li>edad_promedio</li>
            <li>numero_extranjeros</li>
            <li>porcentaje_extranjeros</li>
            <li>jugadores_del_equipo_nacional</li>
            <li>nombre_estadio</li>
            <li>capacidad_estadio</li>
            <li>ultima_temporada</li>
            </ul>
        <input type='text' class='form-control' id="where_name"  name='where_name' placeholder='texto to search' value="nombre"  readonly>
    </div>

    <input type='text' class='form-control ' name='where_value' id='where_value' size=80 title='Se necesita un nombre' placeholder='Escribe el texto del campo de búsqeda'  required >
    <input type='submit' name="submit" id="submit" value='Buscar' class='btn btn-outline-danger mi_boton' ></input> 
</form>
<!-------------------------------------------->
<!----Fin deFormaulario de configuración------>
<!--------------------------------------------->
<hr>
<!--*****************************
        - paginación 
******************************-->

<?php
$where_name="";
$where_value="";
if(isset($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 0;
}
//Si se ha enviado una petición por el formulario
if(isset($_POST['submit'])){
    $where_name= $_POST['where_name'];
    $where_value= $_POST['where_value'];
}else{
    //Si se ha pasado por la URL
    if(isset($_GET['where_name'])){
        $where_name= $_GET['where_name'];
        $where_value= $_GET['where_value'];
    }
}
if(isset($_GET['order_by'])){
    $order_by= $_GET['order_by'];
}else{
    $order_by= 'club_id';
}
pagination($page, $total_registers/10, $where_name, $where_value, $order_by);
echo $page*10 . " de " . $total_registers;
if (count($clubes)==0) {
    die(", no hay clubes");
}
?>



<table class='table'>
    <thead>
        <tr>
            <th scope="col"><a href=<?php echo "clubes.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=club_id";?>>club_id</a></th>
            <th scope="col"><a href=<?php echo "clubes.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=codigo_club";?>>codigo_club</a></th>
            <th scope="col"><a href=<?php echo "clubes.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=nombre";?>>nombre</a></th>
            <th scope="col"><a href=<?php echo "clubes.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=nombre_estadio";?>>nombre_estadio</a></th>
            <th scope="col"><a href=<?php echo "clubes.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=competicion_id";?>>competicion_id</a></th>
            <th scope="col"><a href=<?php echo "clubes.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=valor_total_mercado";?>>valor_total_mercado</a></th>
            <th scope="col"><a href=<?php echo "clubes.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=tamanio_plantilla";?>>tamanio_plantilla</a></th>
            <th scope="col"><a href=<?php echo "clubes.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=edad_promedio";?>>edad_promedio</a></th>
            <th scope="col"><a href=<?php echo "clubes.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=numero_extranjeros";?>>numero_extranjeros</a></th>
            <th scope="col"><a href=<?php echo "clubes.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=porcentaje_extranjeros";?>>porcentaje_extranjeros</a></th>
            <th scope="col"><a href=<?php echo "clubes.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=jugadores_del_equipo_nacional";?>>jugadores_del_equipo_nacional</a></th>
            <th scope="col"><a href=<?php echo "clubes.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=capacidad_estadio";?>>capacidad_estadio</a></th>
            <th scope="col"><a href=<?php echo "clubes.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=registro_transferencias";?>>registro_transferencias</a></th>
            <th scope="col"><a href=<?php echo "clubes.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=nombre_del_entrenador";?>>nombre_del_entrenador</a></th>
            <th scope="col"><a href=<?php echo "clubes.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=ultima_temporada";?>>ultima_temporada</a></th>
            <th scope="col"><a href=<?php echo "clubes.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=nombre_archivo";?>>nombre_archivo</a></th>
            <th scope="col"><a href=<?php echo "clubes.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=url_club";?>>url_club</a></th>
        </tr>	
    </thead>
    <!--*****************************
            -Fin paginación 
    ******************************-->
    <?php
    echo "<tbody>";
    foreach ($clubes as $posicion=>$club){
    //club_id	codigo_club	nombre	competicion_id	valor_total_mercado	tamanio_plantilla	edad_promedio	numero_extranjeros	porcentaje_extranjeros	jugadores_del_equipo_nacional	nombre_estadio	capacidad_estadio	registro_transferencias	nombre_del_entrenador	ultima_temporada	nombre_archivo	url_club
    echo "<tr>";
        echo "<td>{$club['club_id']}</td>";
        echo "<td>{$club['codigo_club']}</td>";
        echo "<td>{$club['nombre']}</td>";
        echo "<td>{$club['nombre_estadio']}</td>";
        echo "<td>{$club['competicion_id']}</td>";
        echo "<td>{$club['valor_total_mercado']}</td>";
        echo "<td>{$club['tamanio_plantilla']}</td>";
        echo "<td>{$club['edad_promedio']}</td>";
        echo "<td>{$club['numero_extranjeros']}</td>";
        echo "<td>{$club['porcentaje_extranjeros']}</td>";
        echo "<td>{$club['jugadores_del_equipo_nacional']}</td>";
        echo "<td>{$club['capacidad_estadio']}</td>";
        echo "<td>{$club['registro_transferencias']}</td>";
        echo "<td>{$club['nombre_del_entrenador']}</td>";
        echo "<td>{$club['ultima_temporada']}</td>";
        echo "<td>{$club['nombre_archivo']}</td>";
        echo "<td>{$club['url_club']}</td>";
    echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";


include_once(__DIR__ . "/document-end.php");

