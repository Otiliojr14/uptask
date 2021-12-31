<?php

require '../functions/init.php';

$proyecto = $_POST['proyecto'];
$accion = $_POST['accion'];

if ($accion === 'crear') {


    $consulta = "INSERT INTO proyectos (nombre_proyecto) VALUES (?) ";
    $tipo_datos = 's';
    $parametros = array(&$proyecto);

    $respuesta = $conn->query_modify($consulta, $tipo_datos, $parametros);
    $respuesta['tipo'] = $accion;
    $respuesta['nombre_proyecto'] = $proyecto;

    echo json_encode($respuesta);
}
