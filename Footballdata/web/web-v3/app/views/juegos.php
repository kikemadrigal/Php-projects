<?php include_once("document-start.php");
use App\Repositories\JuegosRepository;
$juegosRepository = new JuegosRepository();
if(isset($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 0;
}
$pageReal=$page-1;
$init=$page*10;
$page+=1;


$juegos=null;

if(isset($_POST['submit'])){
    //El texto ha buscar
    $search = $_POST['search'];
    if($search==""){
        $search="?";
    }
    //El campo de búsqeda
    $filed = $_POST['fieldSearchResult'];
    //El orden de la búsqeda
    $order = $_POST['fieldOrder'];
    $juegos= $juegosRepository->getJuegosBySearch($search, $filed, $order, $init);
    $rowCount=$juegosRepository->countJuegosBySearch($search, $filed);
}else{
    $order ="nombre_club_casa";
    if(isset($_GET['order'])){
        $order = $_GET['order'];
    }
    $juegos= $juegosRepository->getAllJuegos($order,$init);
    $rowCount=$juegosRepository->getCountJuegos();
}



        /*
        game_id', 'competition_id', 'season', 'round', 'date', 'home_club_id',
       'away_club_id', 'home_club_goals', 'away_club_goals',
       'home_club_position', 'away_club_position', 'home_club_manager_name',
       'away_club_manager_name', 'stadium', 'attendance', 'referee', 'url',
       'home_club_formation', 'away_club_formation', 'home_club_name',
       'away_club_name', 'aggregate', 'competition_type

        */
        //game_id	competition_id	season	   round	date	home_club_id	away_club_id	home_club_goals	away_club_goals	          home_club_position	away_club_position      	home_club_manager_name            away_club_manager_name                 stadium	attendance	referee	 url	home_club_formation	  away_club_formation	      home_club_name	away_club_name	       aggregate	competition_type
        //juego_id  competicion_id  estacion  asalto    fecha  club_casa_id  club_visitante_id  club_casa_goles club_visitante_goles      club_casa_posicion    club_visitante_posicion     nombre_gerente_club_casa          nombre_gerente_club_visitante          estadio    asistencia  arbrito  url    formacion_club_casa   formacion_club_visitante    nombre_club_casa  nombre_club_visitante  agregado     tipo_competicion
?>


<form method=post action='juegos.php' >
    <div class="d-flex ">
        <input type="button" id="mostrarListaOpciones" class="btn btn-outline-primary mi_boton" value="Campo">
        <ul id="miLista" class="form-control" >
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
        <input type='text' class='form-control' id="fieldSearchResult"  name='fieldSearchResult' placeholder='Buscar por nombre' value="nombre"  readonly>
    </div>
    <div class=" d-flex ">
        <input type='buttom' id="mostrarListaOpcionesOrdenacion" class="btn btn-outline-success mi_boton" value="Orden" />
        <ul id="miListaOrdenacion" class="form-control">
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
        <input type='text' class='form-control' id="fieldOrder"  name='fieldOrder' placeholder='Ordenar por nombre' value="nombre_club_casa"  readonly>
   
    </div>

     <input type='text' class='form-control ' name='search' id='search' size=80 title='Se necesita un nombre' placeholder='Escribe el texto del campo de búsqeda o dejalo en blanco' >
    <input type='submit' name="submit" id="submit" value='Buscar' class='btn btn-outline-danger mi_boton' ></input> 
</form>

<hr>


<?php
if($rowCount==0){
    echo "No hay clunes que mostrar";
    die();
}
?>


<nav class="navbar">
    <ul class="pagination">
        <?php if($pageReal>0) {?>
        <li class="page-item"><a class="page-link" href="<?php echo "juegos.php?page=".$page-2; ?>&order=<?php echo $order; ?>">Previous</a></li>
        <?php } ?>
        <li class="page-item disabled"><a class="page-link" href="#"><?php echo $pageReal;?></a></li>
        <?php if($pageReal+1<$rowCount/10) {?>
        <li class="page-item"><a class="page-link" href="<?php echo "juegos.php?page=".$pageReal+1; ?>&order=<?php echo $order; ?>"><?php echo $pageReal+1;?></a></li>
        <?php } ?>
        <?php if($pageReal+2<$rowCount/10) {?>
        <li class="page-item"><a class="page-link" href="<?php echo "juegos.php?page=".$pageReal+2; ?>&order=<?php echo $order; ?>"><?php echo $pageReal+2;?></a></li>
        <?php } ?>
        <?php if($pageReal+3<$rowCount/10) {?>
        <li class="page-item"><a class="page-link" href="<?php echo "juegos.php?page=".$pageReal+3; ?>&order=<?php echo $order; ?>"><?php echo $pageReal+3;?></a></li>
        <?php } ?>
        <?php if($page<$rowCount/10) {?>
        <li class="page-item"><a class="page-link" href="<?php echo "juegos.php?page=".$page; ?>&order=<?php echo $order; ?>">Next</a></li>
        <?php } ?>
    </ul>
</nav>
    <p>Juegos: total: <?php echo $rowCount; ?>, click sobre el titulo para ordenar</p>
    









<table class='table'>
    <thead>
        <tr>
            <th scope="col">juego_id</th>
            <th scope="col">competicion_id</th>
            <th scope="col">estacion</th>
            <th scope="col">asalto</th>
            <th scope="col">fecha</th>
            <th scope="col">club_casa_id</th>
            <th scope="col">club_visitante_id</th>
            <th scope="col">club_casa_goles</th>
            <th scope="col">club_visitante_goles</th>
            <th scope="col">club_casa_posicion</th>
            <th scope="col">club_visitante_posicion</th>
            <th scope="col">nombre_gerente_club_casa</th>
            <th scope="col">nombre_gerente_club_visitante</th>
            <th scope="col">estadio</th>
            <th scope="col">asistencia</th>
            <th scope="col">arbrito</th>
            <th scope="col">url</th>
            <th scope="col">formacion_club_casa</th>
            <th scope="col">formacion_club_visitante</th>
            <th scope="col">nombre_club_casa</th>
            <th scope="col">nombre_club_visitante</th>
            <th scope="col">agregado</th>
            <th scope="col">tipo_competicion</th>
        </tr>	
    </thead>
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

include_once("document-end.php");
?>
