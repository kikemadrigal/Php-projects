<?php include_once(__DIR__ . "/document-start.php");
use App\Repositories\CompeticionesRepository;
$competicionesRepository = new CompeticionesRepository();
if(isset($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 0;
}
$pageReal=$page-1;
$init=$page*10;
$page+=1;


$competiciones=null;

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
    $competiciones= $competicionesRepository->getCompeticionesBySearch($search, $filed, $order, $init);
    $rowCount=$competicionesRepository->countCompeticionesBySearch($search, $filed);
}else{
    $order ="nombre";
    if(isset($_GET['order'])){
        $order = $_GET['order'];
    }
    $competiciones= $competicionesRepository->getAllCompeticiones($order,$init);
    $rowCount=$competicionesRepository->getCountCompeticiones();
}
?>

<form method=post action='competiciones.php' >
    <div class="d-flex ">
        <input type="button" id="mostrarListaOpciones" class="btn btn-outline-primary mi_boton" value="Campo">
        <ul id="miLista" class="form-control" >
            <li>nombre</li>
            <li>sub_tipo</li>
            <li>tipo</li>
            <li>nombre_pais</li>
            <li>codigo_liga_nacional</li>
            <li>confederacion</li>
            <li>es_la_gran_liga_nacional</li>
        </ul>
        <input type='text' class='form-control' id="fieldSearchResult"  name='fieldSearchResult' placeholder='Buscar por nombre' value="nombre"  readonly>
    </div>
    <div class=" d-flex ">
        <input type='buttom' id="mostrarListaOpcionesOrdenacion" class="btn btn-outline-success mi_boton" value="Orden" />
        <ul id="miListaOrdenacion" class="form-control">
            <li>nombre</li>
            <li>sub_tipo</li>
            <li>tipo</li>
            <li>nombre_pais</li>
            <li>codigo_liga_nacional</li>
            <li>confederacion</li>
            <li>es_la_gran_liga_nacional</li>
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
        <li class="page-item"><a class="page-link" href="<?php echo "competiciones.php?page=".$page-2; ?>&order=<?php echo $order; ?>">Previous</a></li>
        <?php } ?>
        <li class="page-item disabled"><a class="page-link" href="#"><?php echo $pageReal;?></a></li>
        <?php if($pageReal+1<$rowCount/10) {?>
        <li class="page-item"><a class="page-link" href="<?php echo "competiciones.php?page=".$pageReal+1; ?>&order=<?php echo $order; ?>"><?php echo $pageReal+1;?></a></li>
        <?php } ?>
        <?php if($pageReal+2<$rowCount/10) {?>
        <li class="page-item"><a class="page-link" href="<?php echo "competiciones.php?page=".$pageReal+2; ?>&order=<?php echo $order; ?>"><?php echo $pageReal+2;?></a></li>
        <?php } ?>
        <?php if($pageReal+3<$rowCount/10) {?>
        <li class="page-item"><a class="page-link" href="<?php echo "competiciones.php?page=".$pageReal+3; ?>&order=<?php echo $order; ?>"><?php echo $pageReal+3;?></a></li>
        <?php } ?>
        <?php if($page<$rowCount/10) {?>
        <li class="page-item"><a class="page-link" href="<?php echo "competiciones.php?page=".$page; ?>&order=<?php echo $order; ?>">Next</a></li>
        <?php } ?>
    </ul>
</nav>
    <p>Competiciones: total: <?php echo $rowCount; ?>, click sobre el titulo para ordenar</p>
    

<table class='table'>
    <thead>
        <tr>
            <th scope="col">competicion_id</th>
            <th scope="col">competicion_codigo</th>
            <th scope="col">nombre</th>
            <th scope="col">sub_tipo</th>
            <th scope="col">tipo</th>
            <th scope="col">id_pais</th>
            <th scope="col">nombre_pais</th>
            <th scope="col">codigo_liga_nacional</th>
            <th scope="col">confederacion</th>
            <th scope="col">url</th>
            <th scope="col">es_la_gran_liga_nacional</th>
        </tr>	
    </thead>
    <?php
    echo "<tbody>";
    foreach ($competiciones as $posicion=>$competicion){
        //competition_id	competition_code	name	sub_type	type	country_id	country_name	domestic_league_code	confederation	url	is_major_national_league
        echo "<tr>";
            echo "<td>{$competicion['competicion_id']}</td>";
            echo "<td>{$competicion['competicion_codigo']}</td>";
            echo "<td>{$competicion['nombre']}</td>";
            echo "<td>{$competicion['sub_tipo']}</td>";
            echo "<td>{$competicion['tipo']}</td>";
            echo "<td>{$competicion['id_pais']}</td>";
            echo "<td>{$competicion['nombre_pais']}</td>";
            echo "<td>{$competicion['codigo_liga_nacional']}</td>";
            echo "<td>{$competicion['confederacion']}</td>";
            echo "<td>{$competicion['url']}</td>";
            echo "<td>{$competicion['es_la_gran_liga_nacional']}</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
  




include_once(__DIR__ . "/document-end.php");