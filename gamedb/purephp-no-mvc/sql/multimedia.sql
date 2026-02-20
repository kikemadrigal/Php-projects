-- Para crear esta tabla 1 tendrás que crear las tablas users y mulmediaType
CREATE TABLE `multimedia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `path` varchar(100) NOT NULL,
  `type` smallint(3) NOT NULL,
  `user` int(11) NOT NULL,
  `game` int(11) NOT NULL DEFAULT '1',
  UNIQUE KEY `ID` (`id`),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`type`) REFERENCES multimediaType(`id`),
  FOREIGN KEY (`user`) REFERENCES users(`id`),
  FOREIGN KEY (`game`) REFERENCES gamesUsers(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Borrar tabla multimedia
-- drop table `multimedia`;
--
INSERT INTO `multimedia` (`id`, `name`, `path`, `type`, `user`, `game`) VALUES
(1, 'sin imagen', 'media/sinImagen.jpg', 1, 186, 1),
(5, 'coly36.jpg', 'media/users/user186/coly36.jpg', 1, 186, 1),
(6, 'madmixgame.jpg', 'media/users/user186/madmixgame.jpg', 1, 186, 1),
(7, 'spirits.jpg', 'media/users/user186/spirits.jpg', 1, 186, 1),
(8, 'startdump.jpg', 'media/users/user186/startdump.jpg', 1, 186, 1),
(9, 'tuareg.jpg', 'media/users/user186/tuareg.jpg', 1, 186, 1),
(10, 'gauntlet.jpg', 'media/users/user186/gauntlet.jpg', 1, 186, 1),
(11, 'outrun.jpg', 'media/users/user186/outrun.jpg', 1, 186, 1),
(12, 'world-games.jpg', 'media/users/user186/world-games.jpg', 1, 186, 1),
(13, 'winter-games.jpg', 'media/users/user186/winter-games.jpg', 1, 186, 1),
(14, 'head-over-heels.jpg', 'media/users/user186/head-over-heels.jpg', 1, 186, 1),
(15, 'donkey-kong.jpg', 'media/users/user186/donkey-kong.jpg', 1, 186, 1),
(16, 'arkanoid.jpg', 'media/users/user186/arkanoid.jpg', 1, 186, 1),
(17, 'grogs-revenge.jpg', 'media/users/user186/grogs-revenge.jpg', 1, 186, 1),
(18, 'emilio-butragueno.jpg', 'media/users/user186/emilio-butragueno.jpg', 1, 186, 1),
(19, 'nuclear-bowls.jpg', 'media/users/user186/nuclear-bowls.jpg', 1, 186, 1),
(20, 'robocop.jpg', 'media/users/user186/robocop.jpg', 1, 186, 1),
(21, 'javato.jpg', 'media/users/user186/javato.jpg', 1, 186, 1),
(24, 'arquimedesXXI.jpg', 'media/users/user186/arquimedesXXI.jpg', 1, 186, 1),
(25, 'el-misterio-del-nilo.jpg', 'media/users/user186/el-misterio-del-nilo.jpg', 1, 186, 1),
(26, 'renegade-III.jpg', 'media/users/user186/renegade-III.jpg', 1, 186, 1),
(27, 'double-dragon.jpg', 'media/users/user186/double-dragon.jpg', 1, 186, 1),
(28, 'tetris.jpg', 'media/users/user186/tetris.jpg', 1, 186, 1),
(29, 'formula-1.jpg', 'media/users/user186/formula-1.jpg', 1, 186, 1),
(30, 'manc-miner.jpg', 'media/users/user186/manc-miner.jpg', 1, 186, 1),
(31, 'gridtrap.jpg', 'media/users/user186/gridtrap.jpg', 1, 186, 1),
(33, 'tawara.jpg', 'media/users/user186/tawara.jpg', 1, 186, 1),
(34, 'showjumper.JPG', 'media/users/user186/showjumper.JPG', 1, 186, 1),
(35, 'MSX-software-n-12.jpg', 'media/users/user186/MSX-software-n-12.jpg', 1, 186, 1),
(36, 'mr-wong.jpg', 'media/users/user186/mr-wong.jpg', 1, 186, 1),
(37, 'driller-tank.jpg', 'media/users/user186/driller-tank.jpg', 1, 186, 1),
(38, 'afteriods.jpg', 'media/users/user186/afteriods.jpg', 1, 186, 1),
(39, 'international karate.jpg', 'media/users/user186/international karate.jpg', 1, 186, 1),
(40, 'meganova.jpg', 'media/users/user186/meganova.jpg', 1, 186, 1),
(41, 'decathlon.jpg', 'media/users/user186/decathlon.jpg', 1, 186, 1),
(42, 'Les-flics.jpg', 'media/users/user186/Les-flics.jpg', 1, 186, 1),
(43, 'MSX-software-n-2.jpg', 'media/users/user186/MSX-software-n-2.jpg', 1, 186, 1),
(44, 'MSX-software-n-3.jpg', 'media/users/user186/MSX-software-n-3.jpg', 1, 186, 1),
(45, 'MSX-software-n-4.jpg', 'media/users/user186/MSX-software-n-4.jpg', 1, 186, 1),
(46, 'MSX-software-n-5.jpg', 'media/users/user186/MSX-software-n-5.jpg', 1, 186, 1),
(47, 'MSX-software-n-9.jpg', 'media/users/user186/MSX-software-n-9.jpg', 1, 186, 1),
(48, 'choplifter.jpg', 'media/users/user186/choplifter.jpg', 1, 186, 1),
(49, 'lode-runner.jpg', 'media/users/user186/lode-runner.jpg', 1, 186, 1),
(50, 'chicogos80-coliseum-titanic-psychopig-operationwol', 'media/users/user186/chicogos80-coliseum-titanic-psychopig-operationwolf.jpg', 1, 186, 1),
(51, 'data-MSX-n-9.jpg', 'media/users/user186/data-MSX-n-9.jpg', 1, 186, 1),
(52, 'data-MSX-n-10.jpg', 'media/users/user186/data-MSX-n-10.jpg', 1, 186, 1),
(53, 'turbo-MSX-n-2.jpg', 'media/users/user186/turbo-MSX-n-2.jpg', 1, 186, 1),
(54, 'El-mejor-MSX-n-7-escalador.jpg', 'media/users/user186/El-mejor-MSX-n-7-escalador.jpg', 1, 186, 1),
(55, 'MSX-club-u-boot.jpg', 'media/users/user186/MSX-club-u-boot.jpg', 1, 186, 1),
(56, 'kset-MSX-N-1.jpg', 'media/users/user186/kset-MSX-N-1.jpg', 1, 186, 1);






-- Borrado de todas las filas
--
-- delete from multimedia;
--