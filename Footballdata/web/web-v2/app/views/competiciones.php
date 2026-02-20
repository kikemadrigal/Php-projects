<?php include_once(__DIR__ . "/document-start.php");
$competitionsRepository = new CompeticionesRepository();
$total_registers=0;
$competitions=[];
// Si se ha recibido algo del formaulario de confirguración
if(isset($_POST['submit'])){
    $page=0;
    if (isset($_POST['page'])) {
        $page = $_POST['page'];
    }
    $competitions=$competitionsRepository->get_competitions($page*10, $_POST['where_name'],$_POST['where_value']);
    $total_registers= $competitionsRepository->get_count_competitions( $_POST['where_name'],$_POST['where_value']);
}else{
    //Si no se ha recibido nada del formulariod e configuración pero se ha recibido al por la URL
    if(isset($_GET['where_name'])){
        if (isset($_GET['order_by'])) {
            $competitions=$competitionsRepository->get_competitions($_GET['page']*10, $_GET['where_name'],$_GET['where_value'], $_GET['order_by']);
            $total_registers= $competitionsRepository->get_count_competitions( $_GET['where_name'],$_GET['where_value'], $_GET['order_by']);
        } else {
            $competitions=$competitionsRepository->get_competitions($_GET['page']*10, $_GET['where_name'],$_GET['where_value']);
            $total_registers= $competitionsRepository->get_count_competitions($_GET['where_name'],$_GET['where_value']);
        }
    }else{
        $competitions=$competitionsRepository->get_competitions();
        $total_registers= $competitionsRepository->get_count_competitions();
    }
}
?>
<!-------------------------------------------->
<!----------Formaulario de configuración------>
<!--------------------------------------------->
<form method=post action='competiciones.php' >
    <!--Parte de li utilizando bootstrap-->
    <div class="dropdown d-flex">
        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
            Search in
        </a>
        <ul  id="list" class="dropdown-menu" aria-labelledby="dropdownMenuLink">
               <li>nombre</li>
            <li>sub_tipo</li>
            <li>tipo</li>
            <li>nombre_pais</li>
            <li>codigo_liga_nacional</li>
            <li>confederacion</li>
            <li>es_la_gran_liga_nacional</li>
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
    $order_by= 'competicion_id';
}
pagination($page, $total_registers/10, $where_name, $where_value, $order_by);
echo $page*10 . " de " . $total_registers;
if (count($competitions)==0) {
    die(", no hay competiciones");
} 
?>
<table class='table'>
    <thead>
        <tr>
            <th scope="col"><a href=<?php echo "competiciones.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=competicion_id";?>>competicion_id</a></th>
            <th scope="col"><a href=<?php echo "competiciones.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=competicion_codigo";?>>competicion_codigo</a></th>
            <th scope="col"><a href=<?php echo "competiciones.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=nombre";?>>nombre</a></th>
            <th scope="col"><a href=<?php echo "competiciones.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=sub_tipo";?>>sub_tipo</a></th>
            <th scope="col"><a href=<?php echo "competiciones.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=tipo";?>>tipo</a></th>
            <th scope="col"><a href=<?php echo "competiciones.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=id_pais";?>>id_pais</a></th>
            <th scope="col"><a href=<?php echo "competiciones.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=nombre_pais";?>>nombre_pais</a></th>
            <th scope="col"><a href=<?php echo "competiciones.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=codigo_liga_nacional";?>>codigo_liga_nacional</a></th>
            <th scope="col"><a href=<?php echo "competiciones.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=confederacion";?>>confederacion</a></th>
            <th scope="col"><a href=<?php echo "competiciones.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=url";?>>url</a></th>
            <th scope="col"><a href=<?php echo "competiciones.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=es_la_gran_liga_nacional";?>>es_la_gran_liga_nacional</a></th>
        </tr>	
    </thead>
    <?php
    echo "<tbody>";
    foreach ($competitions as $posicion=>$competicion){
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