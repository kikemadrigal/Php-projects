CREATE TABLE `videosGames` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `text` varchar(50) NOT NULL,
    `game` int(11) NOT NULL,
    UNIQUE KEY `ID` (`id`),
    PRIMARY KEY (`id`),
    FOREIGN KEY (`game`) REFERENCES gamesUsers(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Drop table videosGames;



INSERT INTO `videosGames` (`id`, `text`,`game`) VALUES
(1, 'www.youtube.es/videossdfs<slkjsfdjsdkl',1),
(2, 'www.youtube.es/videlkjsfdjsdkl',1),
(3, 'www.youtube.es/dfsdfsdfdsffdjsdkl',1),
(4, 'www.youtube.es/dfdfdfdfdfdfdf<slkjsfdjsdkl',2);