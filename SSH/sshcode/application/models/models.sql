
--Creando la base de datos ssh

CREATE SCHEMA `ssh` DEFAULT CHARACTER SET utf8 ;

--CReando las tablas
-----------------------------------------------
-----------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cif` varchar(50) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `datos` varchar(255),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--Tambien es posible esto:
/*
CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `cif` varchar(50) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `datos` varchar(255) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/


--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `cif`, `nombre`, `datos`) VALUES
(1, '01', 'cliente01', 'telefono 55555, calle avenida del mar'),
(2, '02', 'cliente02', 'teléfono 4444, calle Europa'),
(3, '03', 'cliente03', 'teléfono 2222, calle general');



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comandos`
--

CREATE TABLE `comandos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `datos` varchar(255),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comandos`
--

INSERT INTO `comandos` (`id`, `nombre`, `datos`) VALUES
(1, 'ls', 'comando par alistar el contenido de un directorio'),
(2, 'pwd', 'Comando para ver el distorio actual'),
(3, 'php -v', 'comando para ver la versión de php instalada');


-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `clientes-comandos`
--
/*
CREATE TABLE `clientes-comandos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `id_comando` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;*/
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



--
-- Volcado de datos para la tabla `clientes-comandos`
--

INSERT INTO `clientes-comandos` (`id`, `id_cliente`, `id_comando`) VALUES
(1, 1, 2),
(2, 1, 3),
(3, 2, 1);

