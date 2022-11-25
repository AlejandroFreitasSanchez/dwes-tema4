<?php

$productos = [
    ['id' => 'pan', 'valor' => 'Pan'],
    ['id' => 'aceite', 'valor' => 'Aceite'],
    ['id' => 'platano', 'valor' => 'Plátano'],
    ['id' => 'arroz', 'valor' => 'arroz'],
    ['id' => 'naranja', 'valor' => 'Naranja'],
    ['id' => 'pera', 'valor' => 'Pera']
];
//funcion que cuenta el total de productos
function totalProductos(): int {
    $numero = 0;
    if ($_SESSION) {
        foreach ($_SESSION['carro'] as $cantidad) {
            $numero += intval($cantidad);
        }
    }
    return $numero;
}
