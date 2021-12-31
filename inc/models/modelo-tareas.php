<?php

require '../functions/init.php';

$accion = $_POST['accion'];

if ($accion === 'crear') {
    $id_proyecto = (int) $_POST['id_proyecto'];
    $tarea = $_POST['tarea'];
    $consulta = "INSERT INTO tareas (nombre_tarea, proyecto_id) VALUES (?, ?) ";
    $tipo_datos = 'si';
    $parametros = array(&$tarea, &$id_proyecto);
    $respuesta = $conn->query_modify($consulta, $tipo_datos, $parametros);
    $respuesta['tipo'] = $accion;
    $respuesta['tarea'] = $tarea;
    echo json_encode($respuesta);
}

if ($accion === 'actualizar') {
    $id_tarea = (int) $_POST['id'];
    $estado = (int) $_POST['estado'];
    $consulta = "UPDATE tareas SET estado_tarea = ? WHERE id_tarea = ? ";
    $tipo_datos = 'ii';
    $parametros = array(&$estado, &$id_tarea);
    $respuesta = $conn->query_modify_data($consulta, $tipo_datos, $parametros);

    echo json_encode($respuesta);
}

if ($accion === 'eliminar') {
    $id_tarea = (int) $_POST['id'];
    $consulta = "DELETE FROM tareas WHERE id_tarea = ? ";
    $tipo_datos = 'i';
    $parametros = array(&$id_tarea);
    $respuesta = $conn->query_modify_data($consulta, $tipo_datos, $parametros);
    echo json_encode($respuesta);
}
