

CREATE TABLE `viewsUsers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  UNIQUE KEY `ID` (`id`),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- BHorrando la tabla `viewsUsers`
-- No se puede borrar esta tabla si antes no se borra la tabla user que la tiene como foranea
-- Drop table viewsUsers;

INSERT INTO `viewsUsers` (`id`, `name`) VALUES
(1, 'title'),
(2, 'publisher'),
(3, 'developer'),
(4, 'system'),
(5, 'broken');

--delete from viewsUsers;