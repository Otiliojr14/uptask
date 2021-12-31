<?php
require './inc/functions/init.php';
if (isset($_GET['cerrar_session'])) {
    $_SESSION = array();
}
usuario_autenticado();
include './inc/templates/header.php';
include './inc/templates/formulario.php';
include './inc/templates/footer.php';
