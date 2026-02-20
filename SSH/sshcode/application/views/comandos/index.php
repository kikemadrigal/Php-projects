<br><br><br>
<h4 ><img src='<?= base_url()."public/images/comando.png"; ?>' width='50px' />    Mostrar comandos  </h4>
<hr>
<div class="d-flex justify-content-center">
    <a href="<?php echo base_url()."comandos/form_insert"; ?>" class="btn btn-warning m-2">Nuevo comando</a>
    
    <form class="form-inline" method="post" action="<?= base_url()."comandos/search";?>">
        <div class="form-group m-2">
            <label for="nombre" class="sr-only">buscar comando</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="nombre comando">
        </div>
        <input type="submit" name="submit" value="Buscar comando" class="btn btn-primary m-2" />
    </form>
</div>
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
                    echo "<td><a href='".base_url()."comandos/find/".$comando->id."'>".$comando->nombre."</a></td>";
                    echo "<td>".$comando->datos."</td>";
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
    