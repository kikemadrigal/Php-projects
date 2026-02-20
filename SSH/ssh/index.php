<?php
include_once('util/util.php');
include_once('config/env.php');

//Si la conexion existe redireccionamos a mostrar clientes
$conn = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
if (mysqli_connect_errno()) {
    //Si no existen las variables significa que no se han escrito los datos de la database en el archivo config/env.php
    if(!empty(SERVER) && SERVER !="SERVER" && !empty(USER)  && USER!="USER" && !empty(PASSWORD) && PASSWROD!="PASSWORD"){
        $mensajeSinConexion .="Direccion servidor: ".SERVER."<br>Usuario: ".USER."<br>Password: ".PASSWORD."<br>";
    }else{
       //Si no están las variables de SERVER, USER Y PASSWORD, comprobamos los permisos
       //33060 -r--r--r-- 
        //33188 -rw-r--r-- 
        //33204 -rw-rw-r--
        //33206 -rw-rw-rw-
        
        $permisos = fileperms("config/env.php");
        
        if($permisos !=33206){
            echo $permisos."  <h2>Le faltan los permisos al archivo config/env.php, por favor pon chmod 666 env.php </h2>";
            die();
        }
    }
}else{
    //echo "hola";
    //Sino está vacío significa que se han escrito los datos en el archivo config/env.php, tenemmos que probar la conexión
    $conn = mysqli_connect(SERVER, USER, PASSWORD, null);
    if (mysqli_connect_errno()) {
        echo "<h1>No sepudo conectar conla base de datos: ".SERVER.", Usuario: ".USER.",contrseña: ". PASSWORD.", base de datos: ". DATABASE.", no existe la base de datos.".mysqli_connect_error();
    }else{
        $conn = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
        if (mysqli_connect_errno()) {
            //$mensajeNoExisteBaseDeDatos= "No Existe la base de datos".mysqli_connect_error();
            echo "<h1>Servidor: ".SERVER.", Usuario: ".USER.",contrseña: ". PASSWORD.", base de datos: ". DATABASE.", no existe la base de datos.";
        }else{
            header( 'Location: http://'.obtenerIpLocal().'/ssh/views/clientes/show.php' ) ;
            die();
        }
    }
    
}
//header( 'Location: http://'.obtenerIpLocal().'/ssh/views/clientes/show.php' ) ;



if ( isset( $_POST[ 'botonFormularioProbarConexion' ] ) ) {
    $servername = $_POST['servidor'];
    $username = $_POST['usuario'];
    $password = $_POST['password'];
    $conn = mysqli_connect($servername, $username, $password, null);
    if (mysqli_connect_errno()) {
        $mensajeSinConexion="No se pudo conectar con la base de datos: ".mysqli_connect_error();
    }else{
        $conn = mysqli_connect($servername, $username, $password, "ssh");
        if (mysqli_connect_errno()) {
            $mensajeNoExisteBaseDeDatos= "No Existe la base de datos".mysqli_connect_error();
        }else{
            guardarDatosBaseDedatosEnArchivo($servername,$username,$password);
            sleep(5);
            header( 'Location: http://'.obtenerIpLocal().'/ssh/views/clientes/show.php' ) ;
        }
    }
    //$conn->close();
}
if ( isset( $_POST[ 'botonCrearBaseDeDatos' ] ) ) {
    
    $servername = $_POST['servidor'];
    $username = $_POST['usuario'];
    $password = $_POST['password'];
    $conexion = new mysqli($servername , $username , $password,null);
    $conexion->query("SET NAMES 'utf8'");
    if (mysqli_connect_errno()) {
        echo "<p>Error al conectar con el servidor.</p>";
    }else{

        //$sql="CREATE SCHEMA `ssh` DEFAULT CHARACTER SET utf8;";
        $sql="CREATE SCHEMA `ssh` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci ;";
       
        $resultado=$conexion->query($sql);
		if (!$resultado) {
			echo "<p>Error al crear la base de datos ssh</p>" .$servername.", ".$username.", ". $password ;
		}else{
            //Nos conectamos a la tabla ssh
           $conexionConTabla=new mysqli($servername , $username , $password,"ssh");
           if (mysqli_connect_errno()) {
                echo "<p>Error al conectar con la tabla ssh.</p>";
            }else{
                crearTablaClientes($conexionConTabla);
                crearTablaComandos($conexionConTabla);
                crearTablaClientesComandos($conexionConTabla);
                guardarDatosBaseDedatosEnArchivo($servername,$username,$password);
                $mensajeBaseDeDatosCreada="Base de datos creada y guardada configuración en config/env.php <h4><a href='./'>Ir a la página principal</a></h4>";
            }
            $conexionConTabla->close();
        
        }
    }
    $conexion->close();
}

function guardarDatosBaseDedatosEnArchivo($servername,$username,$password){
    $direccionArchivo="config/env.php";
    if(file_exists($direccionArchivo)){
        if($archivo = fopen($direccionArchivo, "a"))
        {
            $texto="
            define('SERVER', '$servername');
            define('USER', '$username');
            define('PASSWORD', '$password');
            define('DATABASE','ssh');
            ";
            if(fwrite($archivo,$texto))
            {
                $mensaje ="Se ha ejecutado correctamente";
            }
            else
            {
                $mensaje= "Ha habido un problema al crear el archivo";
            }

            fclose($archivo);
        }else{
            echo "El archivo no existe";
        }
    }else{
        echo "Archivo de variables no encontrado";
    }
}


function crearTablaClientes($conexion){
    $sql="    
        
    CREATE TABLE `clientes` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `cif` varchar(50) NOT NULL,
        `nombre` varchar(255) NOT NULL,
        `datos` varchar(255),
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
    ";
    $resultado=$conexion->query($sql);
    if (!$resultado) {
        echo "<p>Error al crear la tabla clientes</p>";
    }

    $sqlInsert="
    INSERT INTO `clientes` (`id`, `cif`, `nombre`, `datos`) VALUES
    (1, '01', 'cliente01', 'telefono 55555, calle avenida del mar'),
    (2, '02', 'cliente02', 'teléfono 4444, calle Europa'),
    (3, '03', 'cliente03', 'teléfono 2222, calle general');
    ";
    $resultadoInsert=$conexion->query($sqlInsert);
    if (!$resultadoInsert) {
        echo "<p>Error al crear los onsert de la tabla clientes</p>";
    }
}

function crearTablaComandos($conexion){
    $sql="    
        
    CREATE TABLE `comandos` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `nombre` varchar(255) NOT NULL,
        `datos` varchar(255),
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
    ";
    $resultado=$conexion->query($sql);
    if (!$resultado) {
        echo "<p>Error al crear la tabla comandos</p>";
    }

    $sqlInsert="
    INSERT INTO `comandos` (`id`, `nombre`, `datos`) VALUES
    (1, 'ls', 'comando par alistar el contenido de un directorio'),
    (2, 'pwd', 'Comando para ver el distorio actual'),
    (3, 'php -v', 'comando para ver la versión de php instalada');
    ";
    $resultadoInsert=$conexion->query($sqlInsert);
    if (!$resultadoInsert) {
        echo "<p>Error al crear los insert de la tabla comandos</p>";
    }

}

function crearTablaClientesComandos($conexion){
    $sql="    
        
    CREATE TABLE `clientesComandos` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `idCliente` int(11) NOT NULL,
        `idComando` int(11) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `fkClientesComandosClientes` (`idCliente`),
        KEY `fk_clientesComandosComandos` (`idComando`),
        CONSTRAINT `fkClientesComandosClientes` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT `fk_clientesComandosComandos` FOREIGN KEY (`idComando`) REFERENCES `comandos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
      ) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
    
    
    ";
    $resultado=$conexion->query($sql);
    if (!$resultado) {
        echo "<p>Error al crear la tabla comandos</p>";
    }

    $sqlInsert="
    INSERT INTO `clientesComandos` (`id`, `idCliente`, `idComando`) VALUES
    (1, 1, 2),
    (2, 1, 3),
    (3, 2, 1);
    ";
    $resultadoInsert=$conexion->query($sqlInsert);
    if (!$resultadoInsert) {
        echo "<p>Error al crear los insert de la tabla cliente-comandos</p>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SSH-instalador</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <br>
        <br>
        <br>
        <h4 class="d-flex justify-content-center">Configura la conexion con la base de datos</h4>
        <br><br><br>
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                <form method="POST" action="">
                    <div class="form-group">
                        <?php
                        if(isset($_POST['servidor'])){
                        ?>
                            <input type="text" class="form-control" id="servidor" name="servidor" placeholder="Dirección del servidor MYSQL/MariaDB pruba con localhost" pattern="{2,64}" value='<?=$_POST[servidor] ?>' required  />
                        <?php
                        }else{
                        ?>
                            <input type="text" class="form-control" id="servidor" name="servidor" placeholder="Dirección del servidor MYSQL/MariaDB pruba con localhost" pattern="{2,64}" required />      
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <?php
                        if(isset($_POST['usuario'])){
                        ?>
                            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" pattern="{2,64}" value='<?=$_POST[usuario] ?>' required  />
                        <?php
                        }else{
                        ?>
                            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" pattern="{2,64}" value='<?=$_POST[usuario] ?>' required />      
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                    <?php
                        if(isset($_POST['password'])){
                        ?>
                            <input type="text" class="form-control" id="password" name="password" placeholder="Contraseña" pattern="{2,64}" value='<?=$_POST[password] ?>' required  />
                        <?php
                        }else{
                        ?>
                            <input type="text" class="form-control" id="password" name="password" placeholder="Contraseña" pattern="{2,64}" value='<?=$_POST[password] ?>' required />      
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group d-flex justify-content-center">
                        <input type="submit" class="btn btn-primary btn btn-success m-5" id='botonFormularioProbarConexion' name='botonFormularioProbarConexion' value="Probar conexión" data-toggle="modal" data-target="#clienteModal" />
                    </div>
                    
                    
                </form>
            </div>
        </div>
        <div class="row">
        <div class="col-md-12">
            <?php if(!empty($mensajeSinConexion)) echo "<br><div class='alert alert-danger' role='alert'>".$mensajeSinConexion."</div>";?>
        </div>
        <div class="col-md-12">
            <?php 
            if(!empty($mensajeNoExisteBaseDeDatos)) {
            ?>
                <br><div class='alert alert-danger' role='alert'>No existe la base de datos SSH</div>
                <form method="POST" action="">
                    <input type='hidden' name='servidor' id='servidor' value='<?=$_POST[servidor]?>'/>
                    <input type='hidden' name='usuario' id='usuario' value='<?=$_POST[usuario]?>'/>
                    <input type='hidden' name='password' id='password' value='<?=$_POST[password]?>'/>
                    <input type="submit" class="btn btn-primary btn btn-success m-5" id='botonCrearBaseDeDatos' name='botonCrearBaseDeDatos' value="Crear base de datos">
                </form>
            <?php
            }
            ?>   
        </div>
        <div class="col-md-12">
            <?php if(!empty($mensajeBaseDeDatosCreada)) echo "<br><div class='alert alert-danger' role='alert'>".$mensajeBaseDeDatosCreada."</div>";?>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>









<!-- Modal -->
<div class="modal fade" id="clienteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     
      <div class="modal-body">
       Escribiendo datos.
       <img src="images/esperar.gif" width='100px' alt="espera" />
      </div>
      
    </div>
  </div>
</div>




</body>
</html>