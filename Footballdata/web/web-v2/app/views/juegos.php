<?php include_once(__DIR__ . "/document-start.php");
$juegosRepository = new JuegosRepository();
$total_registers=0;
$juegos=[];

// Si se ha recibido algo del formaulario de confirguración
if(isset($_POST['submit'])){
    $page=0;
    if (isset($_POST['page'])) {
        $page = $_POST['page'];
    }
    $juegos=$juegosRepository->get_juegos($page*10, $_POST['where_name'],$_POST['where_value']);
    $total_registers= $juegosRepository->get_count_juegos( $_POST['where_name'],$_POST['where_value']);
}else{
    //Si no se ha recibido nada del formulariod e configuración pero se ha recibido al por la URL
    if(isset($_GET['where_name'])){
        if (isset($_GET['order_by'])) {
            $juegos=$juegosRepository->get_juegos($_GET['page']*10, $_GET['where_name'],$_GET['where_value'], $_GET['order_by']);
            $total_registers= $juegosRepository->get_count_juegos( $_GET['where_name'],$_GET['where_value'], $_GET['order_by']);
        } else {
            $juegos=$juegosRepository->get_juegos($_GET['page']*10, $_GET['where_name'],$_GET['where_value']);
            $total_registers= $juegosRepository->get_count_juegos($_GET['where_name'],$_GET['where_value']);
        }
    }else{
        $juegos=$juegosRepository->get_juegos();
        $total_registers= $juegosRepository->get_count_juegos();
    }
}
?>

<!-------------------------------------------->
<!----------Formaulario de configuración------>
<!--------------------------------------------->
<form method=post action='juegos.php' >
    <!--Parte de li utilizando bootstrap-->
    <div class="dropdown d-flex">
        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
            Search in
        </a>
        <ul  id="list" class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <li>estadio</li>
            <li>estacion</li>
            <li>asalto</li>
            <li>fecha</li>
            <li>nombre_gerente_club_casa</li>
            <li>nombre_gerente_club_visitante</li>
            <li>arbrito</li>
            <li>nombre_club_casa</li>
            <li>nombre_club_visitante</li>
            <li>tipo_competicion</li>
            </ul>
        <input type='text' class='form-control' id="where_name"  name='where_name' placeholder='texto to search' value="estadio"  readonly>
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
    $order_by= 'juego_id';
}
pagination($page, $total_registers/10, $where_name, $where_value, $order_by);
echo $page*10 . " de " . $total_registers;
if (count($juegos)==0) {
    die(", no hay juegos");
}
?>
<table class='table'>
    <thead>
        <tr>
            <th scope="col"><a href=<?php echo "juegos.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=juego_id";?>>juego_id</a></th>
            <th scope="col"><a href=<?php echo "juegos.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=competicion_id";?>>competicion_id</a></th>
            <th scope="col"><a href=<?php echo "juegos.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=temporada";?>>temporada</a></th>
            <th scope="col"><a href=<?php echo "juegos.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=ronda";?>>ronda</a></th>
            <th scope="col"><a href=<?php echo "juegos.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=fecha";?>>fecha</a></th>
            <th scope="col"><a href=<?php echo "juegos.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=club_casa_id";?>>club_casa_id</a></th>
            <th scope="col"><a href=<?php echo "juegos.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=club_visita_id";?>>club_visita_id</a></th>
            <th scope="col"><a href=<?php echo "juegos.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=goles_club_casa";?>>goles_club_casa</a></th>
            <th scope="col"><a href=<?php echo "juegos.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=goles_club_visita";?>>goles_club_visita</a></th>
            <th scope="col"><a href=<?php echo "juegos.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=club_casa_posicion";?>>club_casa_posicion</a></th>
            <th scope="col"><a href=<?php echo "juegos.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=club_visitante_posicion";?>>club_visitante_posicion</a></th>
            <th scope="col"><a href=<?php echo "juegos.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=nombre_gerente_club_casa";?>>nombre_gerente_club_casa</a></th>
            <th scope="col"><a href=<?php echo "juegos.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=nombre_gerente_club_visitante";?>>nombre_gerente_club_visitante</a></th>
            <th scope="col"><a href=<?php echo "juegos.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=estadio";?>>estadio</a></th>
            <th scope="col"><a href=<?php echo "juegos.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=asistencia";?>>asistencia</a></th>
            <th scope="col"><a href=<?php echo "juegos.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=arbrito";?>>arbrito</a></th>
            <th scope="col"><a href=<?php echo "juegos.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=url";?>>url</a></th>
            <th scope="col"><a href=<?php echo "juegos.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=formacion_club_casa";?>>formacion_club_casa</a></th>
            <th scope="col"><a href=<?php echo "juegos.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=formacion_club_visitante";?>>formacion_club_visitante</a></th>
            <th scope="col"><a href=<?php echo "juegos.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=nombre_club_casa";?>>nombre_club_casa</a></th>
            <th scope="col"><a href=<?php echo "juegos.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=nombre_club_visitante";?>>nombre_club_visitante</a></th>
            <th scope="col"><a href=<?php echo "juegos.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=agregado";?>>agregado</a></th>
            <th scope="col"><a href=<?php echo "juegos.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=tipo_competicion";?>>tipo_competicion</a></th>
        </tr>	
    </thead>
    <!--*****************************
            -Fin paginación 
    ******************************-->
    <?php
    echo "<tbody>";
    foreach ($juegos as $posicion=>$juego){
    //club_id	codigo_club	nombre	competicion_id	valor_total_mercado	tamanio_plantilla	edad_promedio	numero_extranjeros	porcentaje_extranjeros	jugadores_del_equipo_nacional	nombre_estadio	capacidad_estadio	registro_transferencias	nombre_del_entrenador	ultima_temporada	nombre_archivo	url_club
    echo "<tr>";
        echo "<td>{$juego['juego_id']}</td>";
        echo "<td>{$juego['competicion_id']}</td>";
        echo "<td>{$juego['temporada']}</td>";
        echo "<td>{$juego['ronda']}</td>";
        echo "<td>{$juego['fecha']}</td>";
        echo "<td>{$juego['club_casa_id']}</td>";
        echo "<td>{$juego['club_visita_id']}</td>";
        echo "<td>{$juego['goles_club_casa']}</td>";
        echo "<td>{$juego['goles_club_visita']}</td>";
        echo "<td>{$juego['club_casa_posicion']}</td>";
        echo "<td>{$juego['club_visitante_posicion']}</td>";
        echo "<td>{$juego['nombre_gerente_club_casa']}</td>";
        echo "<td>{$juego['nombre_gerente_club_visitante']}</td>";
        
        echo "<td>{$juego['estadio']}</td>";
        echo "<td>{$juego['asistencia']}</td>";
        echo "<td>{$juego['arbrito']}</td>";
        echo "<td>{$juego['url']}</td>";
        echo "<td>{$juego['formacion_club_casa']}</td>";
        echo "<td>{$juego['formacion_club_visitante']}</td>";
        
        echo "<td>{$juego['nombre_club_casa']}</td>";
        echo "<td>{$juego['nombre_club_visitante']}</td>";
        echo "<td>{$juego['agregado']}</td>";
        echo "<td>{$juego['tipo_competicion']}</td>";
    echo "</tr>";
    }
    echo "</tbody>";
echo "</table>";
include_once(__DIR__ . "/document-end.php");