<?php

// Obtener nombre de la pagina actual
function obtenerPaginaActual()
{
    $archivo = basename($_SERVER['PHP_SELF']);
    $pagina = str_replace(".php", "", $archivo);
    return $pagina;
}

// Encriptar password
function hashear_password($pass)
{
    // Nivel de encriptacion
    $opciones = array(
        'cost' => 10
    );
    $hash_password = password_hash($pass, PASSWORD_BCRYPT, $opciones);

    return $hash_password;
}

// Verificar si el usuario inició sesión, si no lo devuelve al area de login
function verificar_session()
{
    if (!(isset($_SESSION['nombre']))) {
        header('Location:login.php');
        exit();
    }
}

// Verifica si el usuario ya tiene una sesión abierta, en caso de que si lo redirige al área interna
function usuario_autenticado()
{
    if ((isset($_SESSION['nombre']))) {
        header('Location:index.php');
        exit();
    }
}

session_start();
