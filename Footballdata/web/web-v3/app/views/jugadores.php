<?php
include_once(__DIR__ . "/document-start.php");
use App\Repositories\JugadoresRepository;
$jugadoresRepository = new JugadoresRepository();
if(isset($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 0;
}
$pageReal=$page-1;
$init=$page*10;
$page+=1;
$jugadores=null;
if(isset($_POST['submit'])){
    //El texto ha buscar
    $search = $_POST['search'];
    //El campo de búsqeda
    $filed = $_POST['fieldSearchResult'];
    //El orden de la búsqeda
    $order = $_POST['fieldOrder'];
    $jugadores= $jugadoresRepository->getJugadoresBySearch($search, $filed, $order, $init);
    $rowCount=$jugadoresRepository->countJugadoresBySearch($search, $filed);
}else{
    $order ="nombre_completo";
    if(isset($_GET['order'])){
        $order = $_GET['order'];
    }
    $jugadores= $jugadoresRepository->getAllJugadores($order,$init);
    $rowCount=$jugadoresRepository->countJugadores();
}















    /*
    "player_id","nombre","apellido", "nombre_completo","ultima_temporada", 
    "actual_club_id", "codigo_player", "pais_de_nacimiento", "ciudad_de_nacimiento", 
    "pais_de_ciudadania", "fecha_de_nacimiento","sub_posicón","posición",
    "pie","altura_en_centimetros","fecha_de_vencimiento_del_contrato", "nombre_del_agente","url_imagen",
    "url_player", "id_de_competición_nacional_del_club_actual", "nombre_del_club_actual","valor_de_mercado_en_euros","valor_de_mercado_más_alto_en_euros"]

    */
    ?>
<form method=post action='jugadores.php' >
    <div class="d-flex ">
        <input type="button" id="mostrarListaOpciones" class="btn btn-outline-primary mi_boton" value="Campo">
        <ul id="miLista" class="form-control" >
            <li>nombre_completo</li>
            <li>ultima_temporada</li>
            <li>pais_de_nacimiento</li>
            <li>ciudad_de_nacimiento</li>
            <li>pais_de_ciudadania</li>
            <li>fecha_de_nacimiento</li>
            <li>sub_posicón</li>
            <li>posición</li>
            <li>pie</li>
            <li>altura_en_centimetros</li>
            <li>fecha_de_vencimiento_del_contrato</li>
            <li>nombre_del_agente</li>
            <li>nombre_del_club_actual</li>
            <li>valor_de_mercado_en_euros</li>
            <li>valor_de_mercado_más_alto_en_euros</li>
        </ul>
        <input type='text' class='form-control' id="fieldSearchResult"  name='fieldSearchResult' placeholder='Buscar por nombre' value="nombre_completo"  readonly>
    </div>
    <div class=" d-flex ">
        <input type='buttom' id="mostrarListaOpcionesOrdenacion" class="btn btn-outline-success mi_boton" value="Orden" />
        <ul id="miListaOrdenacion" class="form-control">
            <li>nombre_completo</li>
            <li>ultima_temporada</li>
            <li>pais_de_nacimiento</li>
            <li>ciudad_de_nacimiento</li>
            <li>pais_de_ciudadania</li>
            <li>fecha_de_nacimiento</li>
            <li>sub_posicón</li>
            <li>posición</li>
            <li>pie</li>
            <li>altura_en_centimetros</li>
            <li>fecha_de_vencimiento_del_contrato</li>
            <li>nombre_del_agente</li>
            <li>nombre_del_club_actual</li>
            <li>valor_de_mercado_en_euros</li>
            <li>valor_de_mercado_más_alto_en_euros</li>
        </ul>
        <input type='text' class='form-control' id="fieldOrder"  name='fieldOrder' placeholder='Ordenar por nombre' value="nombre_completo"  readonly>
   
    </div>

     <input type='text' class='form-control ' name='search' id='search' size=80 title='Se necesita un nombre' placeholder='Escribe el texto del campo de búsqeda'  required >
    <input type='submit' name="submit" id="submit" value='Buscar' class='btn btn-outline-danger mi_boton' ></input> 
</form>

<hr>


<?php
if($rowCount==0){
    echo "No hay jugadores que mostrar";
    die();
}
?>


<nav class="navbar">
    <ul class="pagination">
        <?php if($pageReal>0) {?>
        <li class="page-item"><a class="page-link" href="<?php echo "jugadores.php?page=".$page-2; ?>&order=<?php echo $order; ?>">Previous</a></li>
        <?php } ?>
        <li class="page-item disabled"><a class="page-link" href="#"><?php echo $pageReal;?></a></li>
        <?php if($pageReal+1<$rowCount/10) {?>
        <li class="page-item"><a class="page-link" href="<?php echo "jugadores.php?page=".$pageReal+1; ?>&order=<?php echo $order; ?>"><?php echo $pageReal+1;?></a></li>
        <?php } ?>
        <?php if($pageReal+2<$rowCount/10) {?>
        <li class="page-item"><a class="page-link" href="<?php echo "jugadores.php?page=".$pageReal+2; ?>&order=<?php echo $order; ?>"><?php echo $pageReal+2;?></a></li>
        <?php } ?>
        <?php if($pageReal+3<$rowCount/10) {?>
        <li class="page-item"><a class="page-link" href="<?php echo "jugadores.php?page=".$pageReal+3; ?>&order=<?php echo $order; ?>"><?php echo $pageReal+3;?></a></li>
        <?php } ?>
        <?php if($page<$rowCount/10) {?>
        <li class="page-item"><a class="page-link" href="<?php echo "jugadores.php?page=".$page; ?>&order=<?php echo $order; ?>">Next</a></li>
        <?php } ?>
    </ul>
</nav>
    <p>Jugadores: total: <?php echo $rowCount; ?>, click sobre el titulo para ordenar</p>
    <table class='table'>
        <thead>
            <tr>
                <th scope="col">player_id</th>
                <th scope="col">Url Image</th>
                <th scope="col">Url player</th>
                <th scope="col"><a href='<?php echo$_SERVER['PHP_SELF']; ?>?order=nombre'>nombre</a></th>
                <th scope="col">apellido</th>
                <th scope="col">nombre_completo</th>
                <th scope="col"><a href='<?php echo$_SERVER['PHP_SELF']; ?>?order=nombre_del_club_actual'>nombre_del_club_actual</a></th>
                <th scope="col">ultima_temporada</th>
                <th scope="col">actual_club_id</th>
                <th scope="col">codigo_player</th>
                <th scope="col">pais_de_nacimiento</th>
                <th scope="col">ciudad_de_nacimiento</th>
                <th scope="col">pais_de_ciudadania</th>
                <th scope="col">fecha_de_nacimiento</th>
                <th scope="col">sub_posicón</th>
                <th scope="col">posición</th>
                <th scope="col">pie</th>
                <th scope="col">altura_en_centimetros</th>
                <th scope="col">fecha_de_vencimiento_del_contrato</th>
                <th scope="col">nombre_del_agente</th>
                <th scope="col">id_de_competición_nacional_del_club_actual</th>
                <th scope="col">valor_de_mercado_en_euros</th>
                <th scope="col">valor_de_mercado_más_alto_en_euros</th>
            </tr>	
        </thead>
        <?php
        echo "<tbody>";
        foreach ($jugadores as $posicion=>$jugador){
            echo "<tr>";
                echo "<td>{$jugador['player_id']}</td>";
                echo "<td><img src='{$jugador['url_imagen']}'></td>";
                echo "<td><a href='{$jugador['url_player']}' target='_blanck'>https//www...</a></td>";
                echo "<td>{$jugador['nombre']}</td>";
                echo "<td>{$jugador['apellido']}</td>";
                echo "<td>{$jugador['nombre_completo']}</td>";
                echo "<td>{$jugador['nombre_del_club_actual']}</td>";
                echo "<td>{$jugador['ultima_temporada']}</td>";
                echo "<td>{$jugador['actual_club_id']}</td>";
                echo "<td>{$jugador['codigo_player']}</td>";
                echo "<td>{$jugador['pais_de_nacimiento']}</td>";
                echo "<td>{$jugador['ciudad_de_nacimiento']}</td>";
                echo "<td>{$jugador['pais_de_ciudadania']}</td>";
                echo "<td>{$jugador['fecha_de_nacimiento']}</td>";
                echo "<td>{$jugador['sub_posicion']}</td>";
                echo "<td>{$jugador['posicion']}</td>";
                echo "<td>{$jugador['pie']}</td>";
                echo "<td>{$jugador['altura_en_centimetros']}</td>";
                echo "<td>{$jugador['fecha_de_vencimiento_del_contrato']}</td>";
                echo "<td>{$jugador['nombre_del_agente']}</td>";
                echo "<td>{$jugador['id_de_competición_nacional_del_club_actual']}</td>";
                echo "<td>{$jugador['valor_de_mercado_en_euros']}</td>";
                echo "<td>{$jugador['valor_de_mercado_más_alto_en_euros']}</td>";
            echo "</tr>";
            //echo "<tr><td>{$row['id']}</td><td>{$row['nombre_completo']}</td><td>{$row['pais_de_nacimiento']}</td><td>{$row['posicion']}</td><td>{$row['nombre_del_club_actual']}</td></tr>";
            //echo "Nombre: {$row['nombre_completo']}, pais de origen: {$row['pais_de_nacimiento']}, posición: {$row['posicion']}, club actual: {$row['nombre_del_club_actual']}<br>\n";
        }
    echo "</tbody>";
    echo "</table>";

include_once(__DIR__ . "/document-end.php");