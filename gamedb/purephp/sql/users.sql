--Tipos de datos en Mysql
--Numericos: bit, boolean, smallint,int, float, double, real
--Cadena: char, varchar, tinytext,text, longtext
--fecha: date, datetime, timestamp time, year 
--json: json

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
-- Para crear esta tabla 1 tendrás que crear la tabla viewsUsers

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `email` varchar(100) NOT NULL,
  `realName` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `web` varchar(100) NOT NULL,
  `validate` varchar(20) NOT NULL,
  `counter` int(100) NOT NULL,
  `date` varchar(500) NOT NULL,
  `view` int(11) NOT NULL,
  `token` varchar(100) NOT NULL,
  `observations` longtext NOT NULL,
  UNIQUE KEY `ID` (`id`),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`view`) REFERENCES viewsUsers(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci; 


--
-- BHorrando la tabla `usuarios`
-- Para poder borrar la tabla users primero tendrás que borrar las tablas game, gameUsers y multimedia que tienen el id como clave foranea
-- Drop table users;
 
--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `users` (`id`, `name`, `password`, `role`, `email`, `realName`, `surname`, `web`, `validate`, `counter`, `date`, `view`, `token`, `observations`) VALUES
(92, 'adeline', '1c558dfd6f4148767d40386fa7b59c18e3b8627e', 1, 'ada@gestorwebs.tipolisto.es', '', '', '', '1', 0, '', 1, '', ''),
(96, 'ada', '1c558dfd6f4148767d40386fa7b59c18e3b8627e', 3, 'pepi@gestorwebs.tipolisto.es', '', '', '', '1', 0, '', 1, '', ''),
(98, 'lucas', '8b08a87c980d75add89798754899184c196b1a50', 3, 'lucas@gmail.com', '', '', '', '1', 0, '', 1, '', ''),
(185, 'perico', '3885b8a5e5c5087b42086a494b7cc26210721602', 3, 'kikemadrigal@lucas.com', 'Enrique', 'Madrigal', 'tipolisto.es', '1', 0, '11/01/2018', 1, '', '41434143'),
(186, 'kike', '58746b54a4c7e856562f17e9bc6d2a07861da891', 3, 'kikemadrigal@hotmail.com', ' ', ' ', ' ', '1', 0, '29/04/2022', 1, '', 'clave generada por defecto');

--delete from users;

--
-- Modificando la estructura de la tabla
--
--ALTER TABLE `usuarios`
--  ADD PRIMARY KEY (`idusuario`),
--  ADD UNIQUE KEY `ID` (`idusuario`);
--
--ALTER TABLE `usuarios`
--  MODIFY `idusuario` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;
--COMMIT;


