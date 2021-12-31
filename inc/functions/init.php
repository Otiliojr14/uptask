<?php

if (!file_exists(__DIR__ . './config.php')) {
    die('ERROR:No existe config.php');
}

// Archivo de configuracion
require __DIR__ . './config.php';
// Archivo del objeto de la base de datos
require __DIR__ . './classDB.php';
// Archivo de las funciones del proyecto
require __DIR__ . './functions.php';

setlocale(LC_ALL, IDIOMA_SITIO);
date_default_timezone_set(ZONA_HORARIA);

$conn = new DB(DB_HOST, DB_USUARIO, DB_PASSWORD, DB_DATABASE);
