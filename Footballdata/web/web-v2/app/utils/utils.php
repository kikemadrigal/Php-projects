<?php
function ordenarArray($array, $key) {
    usort($array, function ($a, $b) use ($key) {
        return $a[$key] <=> $b[$key];
    });
    return $array;
}

?>