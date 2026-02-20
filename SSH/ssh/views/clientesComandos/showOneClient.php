<?php
include_once('../../config/imports.php');
$id=$_POST['id'];
iniciarDocumento();
Conexion::abrir_conexion();
$conexion=Conexion::obtener_conexion();

if(isset($_POST['botonAnadirComandoACliente'])){
	//echo $_POST['id'].",   ".$_POST['cif'].",   ".$_POST['nombre'].",   ".$_POST['datos'];
	$creadoNuevoComandoCliente=RepositorioClientesComandos::crearClientesComando($conexion,$_POST['idCliente'],$_POST['idComando']);
	if($creadoNuevoComandoCliente){
        $mensajeActualizacion="Comando añadido";
	}else{
		$mensajeActualizacion="El comando no pudo añadirse al cliente.";
    }
    $id=$_POST['idCliente'];
}else if(isset($_POST['botonBorrarComandoCliente'])){
    $borrada=RepositorioClientesComandos::eliminarClientesComando($conexion,$_POST['id'] );
    if($borrada){
        $mensajeActualizacion="Comando borrado";
	}else{
		$mensajeActualizacion="El comando no pudo borrarse al cliente.";
    }
    $id=$_POST['idCliente'];
}





$comandosDeUnCliente=RepositorioClientesComandos::mostrarLosClientesComandosDeUnCliente($conexion, $id);
if(count($comandosDeUnCliente)==0){
    $mensajeActualizacion="Este cliente no tiene comandos";
}

?>
<div class="container ">
<br><br><br>
<h4 >Mostrar los comandos del cliente: <?php echo RepositorioClientes::mostrarNombreCliente($conexion,$id) ?></h4>
<hr>
<div class="d-flex justify-content-center">
    <form method="POST" id='formularioActualizarCliente' name='formularioActualizarCliente' action="<?php //echo RUTA_CLIENTE_COMANNDO_ACTUALIZAR; ?>" enctype="multipart/form-data">
        <select id="idComando" name="idComando">
        <?php
            $comandos=RepositorioComandos::obtenerTodosLosComandos($conexion);
            foreach($comandos as $comando){
                echo "<option value='".$comando['id']."'>".$comando['nombre']."</option>";
            }
        ?>
        </select>
        <input type="hidden" id="idCliente" name="idCliente" value="<?php echo $id ?>">
        <input type='submit' name='botonAnadirComandoACliente' id='botonAnadirComandoACliente' value='Añadir comando' class='btn btn-warning m-2' />
    </form>
</div>



<div class="row d-flex justify-content-center">
	<div class="col-md-6">
        <table class="table table-striped ">
                <thead>
                    <tr>
                    <th scope="col">Comando</th>
                    <!--<th scope="col">Nombre</th>-->
                    <th scope="col">Acción</th>
                    </tr>
                </thead>
                <tbody>
        <?php

        foreach ( $comandosDeUnCliente as $comando ) {
            ?>
            <tr>
                <td><?php echo RepositorioComandos::mostrarNombreDeUnComando($conexion, $comando['idComando']) ?></td>
                <td>
                    <form method="POST" id='formularioBorrarComandoCliente' name='formularioBorrarComandoCliente' action="<?php //echo RUTA_CLIENTE_COMANNDO_ACTUALIZAR; ?>" enctype="multipart/form-data">
                        <input type="hidden" id="id" name="id" value="<?php echo $comando['id'] ?>">
                        <input type="hidden" id="idCliente" name="idCliente" value="<?php echo $id ?>">
                        <input type='submit' name='botonBorrarComandoCliente' id='botonBorrarComandoCliente' value='Borrar comando' class='btn btn-danger' />
                    </form>
                </td>
            </tr>
            <?php
        }
        ?>
            </tbody>
        </table>
    </div><!--Final dev de columna 6-->
</div><!--Final div de row -->

<div class="row">
    <div class="col-md-12">
        <?php if(!empty($mensajeActualizacion)) echo "<br><div class='alert alert-danger' role='alert'>".$mensajeActualizacion."</div>"; ?>
    </div>
</div>
</div><!--final del container-->
<?php
Conexion::cerrar_conexion();
finalizarDocumento();
?>