
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Descarga de authorized keys</title>
</head>
<body>
    <p>Bien, ahora vete al servidor ssh y pon la clave dentro del archivo      /home/nombreUsuario/.ssh/authorized_keys      , donde nombreUsuario es tu usuario</p>
    <p>Si quieres también puedes descargar y pegar el archivo "authorized_keys", mantén pulsado el enlace y elige Guardar vinculo</p><br>
    <a href='<?php echo base_url()."public/files/authorized_keys"; ?>' >Descargar</a><br><br><br>
    <div style="width:300px; background:yellow; word-wrap: break-word">
        <?php 
        echo $contenido; 

        ?>
    </div>
    <br>

</body>
</html>
















