<?php
include_once('../../config/imports.php');
iniciarDocumento();

Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();

if(isset($_POST['botonBuscarClientes'])){
    $clientes=RepositorioClientes::obtenerTodosLosClientesConElNombre($conexion, $_POST['nombre']);
}else{
    $clientes=RepositorioClientes::obtenerTodosLosClientes($conexion);
}

Conexion::cerrar_conexion();
?>

<br><br><br>
<h4 ><img src='<?= RUTA_IMAGENES?>/clientes.png' width='50px' />   Mostrar clientes  </h4>
<hr>
<div class="d-flex justify-content-center">
    <a href=<?php echo RUTA_CLIENTE_NUEVO ?> class="btn btn-warning m-2">Nuevo cliente</a>
    
    <form class="form-inline" method="POST" id='formularioBuscarClientes' name='formularioBuscarClientes' action="<?php //echo RUTA_MOSTRAR_CLINETES; ?>">
    <div class="form-group m-2">
        <label for="nombre" class="sr-only">buscar cliente</label>
        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="nombre ciente">
    </div>
    <button type="submit" id="botonBuscarClientes" name="botonBuscarClientes" class="btn btn-primary m-2">Buscar cliente</button>
    </form>
</div>
<table class="table table-striped ">
    <thead>
        <tr>
        <th scope="col">cif</th>
        <th scope="col">nombre</th>
        <th scope="col">datos</th>
        <th scope="col">comandos asignados</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach ( $clientes as $cliente ) {
        echo "<tr>";
        echo "<td>".$cliente['cif']."</td>";
        //echo "<td><a href='". RUTA_CLIENTE_ACTUALIZAR ."?id=$cliente[id]'>".$cliente['nombre']."</a></td>";
        echo "<td>".crearFormulario(RUTA_CLIENTE_ACTUALIZAR, $cliente[id],$cliente[nombre])."</td>";
        echo "<td>".$cliente['datos']."</td>";
        //echo "<td><a href='". RUTA_CLIENTECOMANDOS_MOSTRAR_COMANDOS_DE_UN_CLIENTE ."?id=$cliente[id]'>Ver comandos <img src='".RUTA_IMAGENES."/comando.png' width='20px' /> </a></td>";
        echo "<td>".crearFormulario(RUTA_CLIENTECOMANDOS_MOSTRAR_COMANDOS_DE_UN_CLIENTE, $cliente[id],"Ver comandos")."</td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>

<?php
finalizarDocumento();
?>