<br><br><br>
<h4 ><img src='<?= base_url()."public/images/clientes.png"; ?>' width='50px' />   Mostrar clientes  </h4>
<hr>
<div class="d-flex justify-content-center">
    <a href="<?php echo base_url()."clientes/form_insert"; ?>" class="btn btn-warning m-2">Nuevo cliente</a>
    
    <form class="form-inline" method="post" action="<?= base_url()."clientes/search";?>">
        <div class="form-group m-2">
            <label for="nombre" class="sr-only">buscar cliente</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="nombre cliente">
        </div>
        <input type="submit" name="submit" value="Buscar cliente" class="btn btn-primary m-2" />
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
                echo "<td>".$cliente->cif."</td>";
                echo "<td><a href='".base_url()."clientes/find/".$cliente->id."'>".$cliente->nombre."</a></td>";
                echo "<td>".$cliente->datos."</td>";
                echo "<td><a href='".base_url()."clientesComandos/findOneClient/".$cliente->id."'>Ver comandos</a></td>";
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
    