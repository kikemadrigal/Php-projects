
<!---------------------------------Barra Menu---------------------------------->

    <ol class='breadcrumb'>
        <!--Estos enlaces van a la direccion http://www.gestorwebs.tipolisto.es/gestionarwebs.php?idCategoria=66 por ejemplo
        Pero han sido sobreescritos con mod_rewrite del archivo .htacces fichero de configuración de apache-->
        <!--<li><a href='http://www.gestorwebs.tipolisto.es/gestionarpasear.php'><span class='text-danger'>Pasear</span></a></li>-->
        <li><a href='http://www.google.es' target='_blank'><span class='text-danger font-weight-bold'>Buscardor Google</span></a></li>
        <li><a href='<?php echo PATHSERVER;?>gestionarwebs.php?idCategoria=190'>Bancos</a></li>
        <li><a href='<?php echo PATHSERVER;?>gestionarwebs.php?idCategoria=187'>Compras de inform&aacute;tica</a></li>
        <li><a href='<?php echo PATHSERVER;?>gestionarwebs.php?idCategoria=196'>Compra venta 2ª mano</a></li>
        <li><a href='<?php echo PATHSERVER;?>gestionarwebs.php?idCategoria=175'>Compra venta y alquiler de casas</a></li>
        <li><a href='<?php echo PATHSERVER;?>gestionarwebs.php?idCategoria=53'>Correo</a></li>
        <li><a href='<?php echo PATHSERVER;?>gestionarwebs.php?idCategoria=77'>De compras</a></li>
        <li><a href='<?php echo PATHSERVER;?>gestionarwebs.php?idCategoria=78'>Enciclopedias</a></li>
        <li><a href='<?php echo PATHSERVER;?>gestionarwebs.php?idCategoria=165'>Generalistas</a></li>
        <li><a href='<?php echo PATHSERVER;?>gestionarwebs.php?idCategoria=66'>Noticias</a></li>
        <li><a href='<?php echo PATHSERVER;?>gestionarwebs.php?idCategoria=81'>Not.Deportivas</a></li>
        <li><a href='<?php echo PATHSERVER;?>gestionarwebs.php?idCategoria=253'>Not. de Ciencia</a></li>
        <li><a href='<?php echo PATHSERVER;?>gestionarwebs.php?idCategoria=68'>Pelis torrent</a></li>
        <li><a href='<?php echo PATHSERVER;?>gestionarwebs.php?idCategoria=200'>Porno</a></li>
        
        
        <li><a href='<?php echo PATHSERVER;?>gestionarwebs.php?idCategoria=76'>Redes sociales</a></li>
        <li><a href='<?php echo PATHSERVER;?>gestionarwebs.php?idCategoria=83'>Trabajo</a></li>
        <li><a href='<?php echo PATHSERVER;?>gestionarwebs.php?idCategoria=65'>Traductores online</a></li>
        <li><a href='<?php echo PATHSERVER;?>gestionarwebs.php?idCategoria=176'>Viajar</a></li>
        <li><a href='<?php echo PATHSERVER;?>gestionarwebs.php?idCategoria=59'>V&iacute;deos</a></li>
        
        <li><a href='<?php echo PATHSERVER;?>gestionarcategorias.php'><span class='glyphicon glyphicon-plus'></span></a> </li>
        
    </ol>

        
      
 
		
    <!------------------------------Fin barra Menu------------------------------->
    <?php	if(isset($_GET['mensaje'])) echo "<h4><span class='label label-danger'>".$_GET['mensaje']."</span></h4>";?>