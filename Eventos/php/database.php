<?php

function crear_tabla_eventos() {
    $sql= "
        CREATE TABLE `eventos` (
        `id` int(11) NOT NULL,
        `nombre` text NOT NULL,
        `fecha` varchar(255) NOT NULL,
        `direccion` text NOT NULL,
        `cantidad_participantes` int(11) NOT NULL,
        `precio` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    
    ";
}


function crear_tabla_participantes() {
    $sql= "
        CREATE TABLE `participantes` (
        `id` int(11) NOT NULL,
        `nombre` text NOT NULL,
        `asistencia` smallint(6) NOT NULL,
        `pagado` smallint(6) NOT NULL,
        `comentario` text NOT NULL,
        `id_evento` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
}



function insert_eventos2() {
    $sql= "
       INSERT INTO `eventos` (`id`, `nombre`, `fecha`, `direccion`, `cantidad_participantes`, `precio`) VALUES
                            (1, 'cena', '19/12/2024 20:30', 'La Pierotti Pizzería - Ronda de Levante\r\nRda. de Levante, 8 · 968 94 09 66', 0, 0),
                            (2, 'striptis', '19/12/2024 22:00', 'restaurante pierotti', 0, 0);
    ";
}

function insert_participantes_base(){
    $sql= "INSERT INTO `participantes` (`id`, `nombre`, `asistencia`, `pagado`, `comentario`, `id_evento`) VALUES
        (5, 'Francocinero', 0, 0, '', 1),
        (6, 'Kike', 0, 0, '', 1),
        (7, 'Pablo', 0, 0, '', 1),
        (8, 'Teo', 0, 0, '', 1),
        (9, 'Emili', 0, 0, '', 1),
        (10, 'Davidmusico', 0, 0, '', 1),
        (11, 'Deivid', 0, 0, '', 1),
        (12, 'Charls', 0, 0, '', 1),
        (13, 'JoseLuis', 0, 0, '', 1),
        (14, 'Marcos', 0, 0, '', 1),
        (15, 'Fernanda', 0, 0, '', 1),
        (16, 'Chema', 0, 0, '', 1),
        (17, 'Kaloyan', 0, 0, '', 1),
        (18, 'Sergio', 0, 0, '', 1),
        (19, 'Frandeportista', 0, 0, '', 1),
        (20, 'Angel', 0, 0, '', 1),
        (21, 'Pablojoven', 0, 0, '', 1),
        (22, 'Fran', 0, 0, '', 1),
        (23, 'Virginia', 0, 0, '', 1),
        (24, 'Laura', 0, 0, '', 1),
        (25, 'Loreto', 0, 0, '', 1),
        (26, 'Francocinero', 0, 0, '', 2),
        (27, 'Kike', 0, 0, '', 2),
        (28, 'Pablo', 0, 0, '', 2),
        (29, 'Teo', 0, 0, '', 2),
        (30, 'Emili', 0, 0, '', 2),
        (31, 'Davidmusico', 0, 0, '', 2),
        (32, 'Deivid', 0, 0, '', 2),
        (33, 'Charls', 0, 0, '', 2),
        (34, 'JoseLuis', 0, 0, '', 2),
        (35, 'Marcos', 0, 0, '', 2),
        (36, 'Fernanda', 0, 0, '', 2),
        (37, 'Chema', 0, 0, '', 2),
        (38, 'Kaloyan', 0, 0, '', 2),
        (39, 'Sergio', 0, 0, '', 2),
        (40, 'Frandeportista', 0, 0, '', 2),
        (41, 'Angel', 0, 0, '', 2),
        (42, 'Pablojoven', 0, 0, '', 2),
        (43, 'Fran', 0, 0, '', 2),
        (44, 'Virginia', 0, 0, '', 2),
        (45, 'Loreto', 0, 0, '', 2);
    ";  

}