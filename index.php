<?php
require './inc/functions/init.php';
verificar_session();
if (isset($_GET['id_proyecto'])) {
    $id_proyecto = $_GET['id_proyecto'];
}
include './inc/templates/header.php';
include './inc/templates/barra.php';
?>

<div class="contenedor">
    <?php include './inc/templates/sidebar.php' ?>

    <main class="contenido-principal">
        <h1>
            <?php
            if (isset($id_proyecto)) :
                $consulta = "SELECT nombre_proyecto FROM proyectos WHERE id_proyecto = {$id_proyecto}";
                $proyecto = $conn->query_consult($consulta);

                foreach ($proyecto as $nombre) : ?>
                    <span><?php echo $nombre['nombre_proyecto']; ?></span>
                <?php endforeach; ?>
        </h1>

        <form action="#" class="agregar-tarea">
            <div class="campo">
                <label for="tarea">Tarea:</label>
                <input type="text" placeholder="Nombre Tarea" class="nombre-tarea">
            </div>
            <div class="campo enviar">
                <input type="hidden" id="id_proyecto" value="<?php echo $id_proyecto; ?>">
                <input type="submit" class="boton nueva-tarea" value="Agregar">
            </div>
        </form>

        <h2>Listado de tareas:</h2>

        <div class="listado-pendientes">
            <ul>
                <?php
                $consulta = "SELECT id_tarea, nombre_tarea, estado_tarea FROM tareas WHERE proyecto_id = {$id_proyecto}";
                $tareas = $conn->query_consult($consulta);

                if ($tareas->num_rows > 0) {
                    foreach ($tareas as $tarea) : ?>
                        <li id="tarea:<?php echo $tarea['id_tarea'] ?>" class="tarea">
                            <p><?php echo $tarea['nombre_tarea'] ?></p>
                            <div class="acciones">
                                <i class="far fa-check-circle <?php echo ($tarea['estado_tarea'] === "1" ? 'completo' : ''); ?>"></i>
                                <i class="fas fa-trash"></i>
                            </div>
                        </li>
                <?php endforeach;
                } else {
                    echo "<p class='lista-vacia'>No hay tareas en este proyecto</p>";
                }



                ?>

            </ul>
        </div>
        <div class="avance">
            <h2>Avance del proyecto:</h2>
            <div id="barra-avance" class="barra-avance">
                <div id="porcentaje" class="porcentaje"></div>
            </div>
        </div>
    <?php else :

                echo "<p>Selecciona un proyecto a la izquierda</p>";


            endif; ?>
    </main>
</div>
<!--.contenedor-->

<?php include './inc/templates/footer.php'; ?>