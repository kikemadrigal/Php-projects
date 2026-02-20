
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
    <a href="../../files/authorized_keys" >Descargar</a><br><br><br>
    <div style="width:300px; background:yellow; word-wrap: break-word">
    <?php 
    //$ruta_archivo="resources/files/";
    $nombre_archivo = "../../files/authorized_keys";  //variable con el nombre del archivo que vamos a crear
 
    /* 1.- Si el archivo existe mostramos en el navegador el contenido con
     * "file_get_contents" que nos devuelve lo que hay en el archivo
     * logs.txt.
     * 2.-forzamos con nl2br que los saltos de linea "\n" los muestre en HTML <br />
    */
    if(file_exists($nombre_archivo)) 
    {
        echo  nl2br(file_get_contents($nombre_archivo));
    }
    else
    {
        $mensaje = "El archivo no existe";
    }
 
 
    ?>


    </div>
    <br>

</body>
</html>
















