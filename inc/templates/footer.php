<?php

$actual = obtenerPaginaActual();

// Si esta en la seccion de login utiliza este plugin para avisar al usuario de la autenticacion
if ($actual === 'crear-cuenta' || $actual === 'login') {
    echo '<script src="js/formulario.js" type="module"></script>';
} else {
    echo '<script src="js/scripts.js" type="module"></script>';
}


?>
<script src="js/sweetalert2.all.min.js"></script>
</body>

</html>