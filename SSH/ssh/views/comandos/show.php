<?php
include_once('../../config/imports.php');
iniciarDocumento();

Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();
$comandos=RepositorioComandos::obtenerTodosLosComandos($conexion);

?>

<div class="container ">

<br><br><br>
<h4 ><img src='<?= RUTA_IMAGENES?>/comando.png' width='50px' />  Mostrar comandos</h4>
<hr>
<h4 class="d-flex justify-content-center"><a href=<?php echo RUTA_COMANDO_NUEVO ?> class='btn btn-warning m-2'>Nuevo comando</a></h4>
<table class="table table-striped ">
        <thead>
            <tr>
            <th scope="col">nombre</th>
            <th scope="col">datos</th>
            </tr>
        </thead>
        <tbody>
<?php

foreach ( $comandos as $comando ) {
    echo "<tr>";
        echo "<td>".crearFormulario(RUTA_COMANDO_ACTUALIZAR, $comando[id],$comando['nombre'])."</td>";
        echo "<td>".$comando['datos']."</td>";
    echo "</tr>";
}
?>
        </tbody>
    </table>
</div><!--final del container-->
<?php
Conexion::cerrar_conexion();
finalizarDocumento();
?>