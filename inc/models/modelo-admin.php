<?php
require '../functions/init.php';

$accion = $_POST['accion'];
$password = $_POST['password'];
$usuario = $_POST['usuario'];

if ($accion === 'crear') {
    $password_hasheado = hashear_password($password);

    $consulta = "INSERT INTO users (user_name, user_password) VALUES (?, ?) ";
    $tipo_datos = 'ss';
    $parametros = array(&$usuario, &$password_hasheado);

    $status = $conn->query_modify($consulta, $tipo_datos, $parametros);

    $status['tipo'] = $accion;

    $respuesta = $status;

    echo (json_encode($respuesta));
}

if ($accion === 'login') {

    $consulta = "SELECT id_user, user_name, user_password FROM users WHERE user_name = ? ";
    $tipo_datos = 's';
    $parametros = array(&$usuario);

    $status = $conn->query_login($consulta, $tipo_datos, $parametros, $password);

    $status['tipo'] = $accion;

    $respuesta = $status;

    echo (json_encode($respuesta));
}
