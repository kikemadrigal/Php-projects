CREATE TABLE `multimediaType` (
    `id` smallint(3) NOT NULL AUTO_INCREMENT,
    `name` varchar(50) NOT NULL,
    UNIQUE KEY `ID` (`id`),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Drop table multimediaType;



INSERT INTO `multimediaType` (`id`, `name`) VALUES
(1, 'image'),
(2, 'audio'),
(3, 'video'),
(4, 'pdf'),
(5, 'doc'),
(6, 'access'),
(7, 'csv'),
(8, 'json');