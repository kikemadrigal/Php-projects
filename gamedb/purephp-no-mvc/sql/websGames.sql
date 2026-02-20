CREATE TABLE `websGames` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `text` varchar(50) NOT NULL,
    `game` int(11) NOT NULL,
    UNIQUE KEY `ID` (`id`),
    PRIMARY KEY (`id`),
    FOREIGN KEY (`game`) REFERENCES gamesUsers(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Drop table websGames;



INSERT INTO `websGames` (`id`, `text`,`game`) VALUES
(1, 'www.tipoloco.es',1),
(2, 'www-monoloco',1),
(3, 'ww.jilipoichi',1),
(4, 'www.locomoco',2);