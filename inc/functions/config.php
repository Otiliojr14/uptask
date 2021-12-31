<?php

// Configura la salida de errores por pantalla
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('URL_SITIO', 'http://localhost/uptask');
define('ZONA_HORARIA', 'America/Mexico_City');
define('IDIOMA_SITIO', ['es', 'spa', 'es_MX']);

// Valores para conectar a la base de datos

define('DB_HOST', 'localhost');
define('DB_USUARIO', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'uptask');
