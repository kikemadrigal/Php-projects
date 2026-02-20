<?php include_once(__DIR__ . "/document-start.php");
$jugadoresRepository = new JugadoresRepository();
$total_registers=0;
$jugadores=[];

// Si se ha recibido algo del formaulario de confirguración
if(isset($_POST['submit'])){
    $page=0;
    if (isset($_POST['page'])) {
        $page = $_POST['page'];
    }
    $jugadores=$jugadoresRepository->get_jugadores($page*10, $_POST['where_name'],$_POST['where_value']);
    $total_registers= $jugadoresRepository->get_count_jugadores( $_POST['where_name'],$_POST['where_value']);
}else{
    //Si no se ha recibido nada del formulariod e configuración pero se ha recibido al por la URL
    if(isset($_GET['where_name'])){
        if (isset($_GET['order_by'])) {
            $jugadores=$jugadoresRepository->get_jugadores($_GET['page']*10, $_GET['where_name'],$_GET['where_value'], $_GET['order_by']);
            $total_registers= $jugadoresRepository->get_count_jugadores( $_GET['where_name'],$_GET['where_value'], $_GET['order_by']);
        } else {
            $jugadores=$jugadoresRepository->get_jugadores($_GET['page']*10, $_GET['where_name'],$_GET['where_value']);
            $total_registers= $jugadoresRepository->get_count_jugadores($_GET['where_name'],$_GET['where_value']);
        }
    }else{
        $jugadores=$jugadoresRepository->get_jugadores();
        $total_registers= $jugadoresRepository->get_count_jugadores();
    }
}


?>

<!-------------------------------------------->
<!----------Formaulario de configuración------>
<!--------------------------------------------->
<form method=post action='jugadores.php' >
    <!--Parte de li utilizando bootstrap-->
    <div class="dropdown d-flex">
        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
            Search in
        </a>
        <ul  id="list" class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <li class="dropdown-item">nombre_completo</li>
            <li class="dropdown-item">ultima_temporada</li>
            <li class="dropdown-item">pais_de_nacimiento</li>
            <li class="dropdown-item">ciudad_de_nacimiento</li>
            <li class="dropdown-item">pais_de_ciudadania</li>
            <li class="dropdown-item">fecha_de_nacimiento</li>
            <li class="dropdown-item">sub_posicón</li>
            <li class="dropdown-item">posición</li>
            <li class="dropdown-item">pie</li>
            <li class="dropdown-item">altura_en_centimetros</li>
            <li class="dropdown-item">fecha_de_vencimiento_del_contrato</li>
            <li class="dropdown-item">nombre_del_agente</li>
            <li class="dropdown-item">nombre_del_club_actual</li>
            <li class="dropdown-item">valor_de_mercado_en_euros</li>
            <li class="dropdown-item">valor_de_mercado_más_alto_en_euros</li>
        </ul>
        <input type='text' class='form-control' id="where_name"  name='where_name' placeholder='texto to search' value="nombre_completo"  readonly>
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
    $order_by= 'player_id';
}
pagination($page, $total_registers/10, $where_name, $where_value, $order_by);
echo $page*10 . " de " . $total_registers;
if (count($jugadores)==0) {
    die(", no hay jugadores");
}
?>
<table class='table'>
    <thead>
        <tr>
            <th scope="col">player_id</th>
            <th scope="col">Url Image</th>
            <th scope="col">Url player</th>
            <th scope="col"><a href=<?php echo "jugadores.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=nombre";?>>nombre</a></th>
            <th scope="col"><a href=<?php echo "jugadores.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=apellido";?>>apellido</a></th>
            <th scope="col"><a href=<?php echo "jugadores.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=nombre_completo";?>>nombre_completo</a></th>
            <th scope="col"><a href=<?php echo "jugadores.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=ultima_temporada";?>>ultima_temporada</a></th>
            <th scope="col"><a href=<?php echo "jugadores.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=actual_club_id";?>>actual_club_id</a></th>
            <th scope="col"><a href=<?php echo "jugadores.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=codigo_player";?>>codigo_player</a></th>
            <th scope="col"><a href=<?php echo "jugadores.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=pais_de_nacimiento";?>>pais_de_nacimiento</a></th>
            <th scope="col"><a href=<?php echo "jugadores.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=ciudad_de_nacimiento";?>>ciudad_de_nacimiento</a></th>
            <th scope="col"><a href=<?php echo "jugadores.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=pais_de_ciudadania";?>>pais_de_ciudadania</a></th>
            <th scope="col"><a href=<?php echo "jugadores.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=fecha_de_nacimiento";?>>fecha_de_nacimiento</a></th>
            <th scope="col"><a href=<?php echo "jugadores.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=sub_posicón";?>>sub_posicón</a></th>
            <th scope="col"><a href=<?php echo "jugadores.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=posición";?>>posición</a></th>
            <th scope="col"><a href=<?php echo "jugadores.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=pie";?>>pie</a></th>
            <th scope="col"><a href=<?php echo "jugadores.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=altura_en_centimetros";?>>altura_en_centimetros</a></th>
            <th scope="col"><a href=<?php echo "jugadores.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=fecha_de_vencimiento_del_contrato";?>>fecha_de_vencimiento_del_contrato</a></th>
            <th scope="col"><a href=<?php echo "jugadores.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=nombre_del_agente";?>>nombre_del_agente</a></th>
            <th scope="col"><a href=<?php echo "jugadores.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=id_de_competición_nacional_del_club_actual";?>>id_de_competición_nacional_del_club_actual</a></th>
            <th scope="col"><a href=<?php echo "jugadores.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=nombre_del_club_actual";?>>nombre_del_club_actual</a></th>
            <th scope="col"><a href=<?php echo "jugadores.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=valor_de_mercado_en_euros";?>>valor_de_mercado_en_euros</a></th>
            <th scope="col"><a href=<?php echo "jugadores.php?page={$page}&where_name={$where_name}&where_value={$where_value}&order_by=valor_de_mercado_más_alto_en_euros";?>>valor_de_mercado_más_alto_en_euros</a></th>
        </tr>	
    </thead>
    <!--*****************************
            -Fin paginación 
    ******************************-->
    <?php
    echo "<tbody>";
    foreach ($jugadores as $posicion=>$jugador){
        echo "<tr>";
            echo "<td>{$jugador['player_id']}</td>";
            echo "<td><img src='{$jugador['url_imagen']}'></td>";
            echo "<td><a href='{$jugador['url_player']}' target='_blanck'>https//www...<a></td>";
            echo "<td>{$jugador['nombre']}</td>";
            echo "<td>{$jugador['apellido']}</td>";
            echo "<td>{$jugador['nombre_completo']}</td>";
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
            echo "<td>{$jugador['nombre_del_club_actual']}</td>";
            echo "<td>{$jugador['valor_de_mercado_en_euros']}</td>";
            echo "<td>{$jugador['valor_de_mercado_más_alto_en_euros']}</td>";
        echo "</tr>";
    }
    echo "</tbody>";
echo "</table>";
include_once("document-end.php");