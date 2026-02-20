<br><br><br>
<h4 >Mostrar clientesComandos del cliente <?= $cliente->nombre; ?></h4>
<hr>

<div class="d-flex justify-content-center">
    <!--Mostraremos todos los comandos en un select para que se pueden añadir si se desea -->
    <form method="post" action='<?php echo base_url()."clientesComandos/insert" ?>'>
        <select id="idComando" name="idComando">
        <?php
            foreach($comandos as $comando){
                echo "<option value='".$comando->id."'>".$comando->nombre."</option>";
            }
        ?>
        </select>
        <input type="hidden" id="idCliente" name="idCliente" value="<?php echo $cliente->id ?>" />
        <input type='submit' name='submit' value='Añadir comando' class='btn btn-warning m-2' />
    </form>
</div>
<div class="d-flex justify-content-center col-md-6">
    <table class="table table-striped ">
        <thead>
            <tr>
                <!--<th scope="col">id</th>-->
                <!--<th scope="col">idCliente</th>-->
                <th scope="col">Nombre</th>
                <th scope="col">Acción</th>
            </tr>
        </thead>
        <tbody>
        <?php
            //Esto es para borrar un clienteComando
            foreach ( $clientesComandos as $clientesComando ) {
            ?>
                <tr>
                    <td><?php echo $clientesComando->nombre; ?></td>
                    <td>
                         <a href="<?php echo base_url()."clientesComandos/delete/".$clientesComando->id."/".$clientesComando->idCliente;?>" type="button" class="btn btn-danger">Borrar</a>
                    </td>
                </tr>
            <?php
            }
        ?>
        </tbody>
    </table>
</div>