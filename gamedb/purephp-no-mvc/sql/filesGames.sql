CREATE TABLE `filesGames` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(50) NOT NULL,
    `path` varchar(100) NOT NULL,
    `game` int(11) NOT NULL,
    UNIQUE KEY `ID` (`id`),
    PRIMARY KEY (`id`),
    FOREIGN KEY (`game`) REFERENCES gamesUsers(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Drop table filesGames;



INSERT INTO `filesGames` (`id`, `name`,`path`,`game`) VALUES
(1, 'file1','c\rua\1',1),
(2, 'file2','c\rua\1',1),
(3, 'file3','c\rua\1',1),
(4, 'file4','c\rua\1',2);