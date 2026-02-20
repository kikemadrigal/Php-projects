<?php include_once(__DIR__ . "/document-start.php");

use App\Repositories\ClubesRepository;



$clubesRepository = new ClubesRepository();
if(isset($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 0;
}
$pageReal=$page-1;
$init=$page*10;
$page+=1;


$clubes=null;

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
    $clubes= $clubesRepository->getClubesBySearch($search, $filed, $order, $init);
    $rowCount=$clubesRepository->countClubesBySearch($search, $filed);
}else{
    $order ="nombre";
    if(isset($_GET['order'])){
        $order = $_GET['order'];
    }
    $clubes= $clubesRepository->getAllClubes($order,$init);
    $rowCount=$clubesRepository->getCountClubes();
}
?>


<form method=post action='clubes.php' >
    <div class="d-flex ">
        <input type="button" id="mostrarListaOpciones" class="btn btn-outline-primary mi_boton" value="Campo">
        <ul id="miLista" class="form-control" >
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
        <input type='text' class='form-control' id="fieldSearchResult"  name='fieldSearchResult' placeholder='Buscar por nombre' value="nombre"  readonly>
    </div>
    <div class=" d-flex ">
        <input type='buttom' id="mostrarListaOpcionesOrdenacion" class="btn btn-outline-success mi_boton" value="Orden" />
        <ul id="miListaOrdenacion" class="form-control">
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
        <input type='text' class='form-control' id="fieldOrder"  name='fieldOrder' placeholder='Ordenar por nombre' value="nombre"  readonly>
   
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
        <li class="page-item"><a class="page-link" href="<?php echo "clubes.php?page=".$page-2; ?>&order=<?php echo $order; ?>">Previous</a></li>
        <?php } ?>
        <li class="page-item disabled"><a class="page-link" href="#"><?php echo $pageReal;?></a></li>
        <?php if($pageReal+1<$rowCount/10) {?>
        <li class="page-item"><a class="page-link" href="<?php echo "clubes.php?page=".$pageReal+1; ?>&order=<?php echo $order; ?>"><?php echo $pageReal+1;?></a></li>
        <?php } ?>
        <?php if($pageReal+2<$rowCount/10) {?>
        <li class="page-item"><a class="page-link" href="<?php echo "clubes.php?page=".$pageReal+2; ?>&order=<?php echo $order; ?>"><?php echo $pageReal+2;?></a></li>
        <?php } ?>
        <?php if($pageReal+3<$rowCount/10) {?>
        <li class="page-item"><a class="page-link" href="<?php echo "clubes.php?page=".$pageReal+3; ?>&order=<?php echo $order; ?>"><?php echo $pageReal+3;?></a></li>
        <?php } ?>
        <?php if($page<$rowCount/10) {?>
        <li class="page-item"><a class="page-link" href="<?php echo "clubes.php?page=".$page; ?>&order=<?php echo $order; ?>">Next</a></li>
        <?php } ?>
    </ul>
</nav>
    <p>clubes: total: <?php echo $rowCount; ?>, click sobre el titulo para ordenar</p>
    









<table class='table'>
    <thead>
        <tr>
            <th scope="col">club_id</th>
            <th scope="col">codigo_club</th>
            <th scope="col">nombre</th>
            <th scope="col">nombre_estadio</th>
            <th scope="col">competicion_id</th>
            <th scope="col">valor_total_mercado</th>
            <th scope="col">tamanio_plantilla</th>
            <th scope="col">edad_promedio</th>
            <th scope="col">numero_extranjeros</th>
            <th scope="col">porcentaje_extranjeros</th>
            <th scope="col">jugadores_del_equipo_nacional</th>
            <th scope="col">capacidad_estadio</th>
            <th scope="col">registro_transferencias</th>
            <th scope="col">nombre_del_entrenador</th>
            <th scope="col">ultima_temporada</th>
            <th scope="col">nombre_archivo</th>
            <th scope="col">url_club</th>
        </tr>	
    </thead>
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

