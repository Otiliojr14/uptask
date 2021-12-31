<?php $actual = obtenerPaginaActual(); ?>
<div class="contenedor-formulario">
    <h1>UpTask <?php echo ($actual === 'crear-cuenta') ? '<span>Crear Cuenta</span>' : ''; ?> </h1>
    <form id="formulario" class=" caja-login" method="post">
        <div class="campo">
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" placeholder="Usuario">
        </div>
        <div class="campo">
            <label for="password">Password: </label>
            <input type="password" name="password" id="password" placeholder="Password">
        </div>
        <div class="campo enviar">
            <input type="hidden" id="tipo" value="<?php echo ($actual === 'crear-cuenta') ? 'crear' : 'login'; ?>">
            <input type="submit" class="boton" value="<?php echo ($actual === 'crear-cuenta') ? 'Crear cuenta' : 'Iniciar Sesión'; ?>">
        </div>
        <div class="campo">
            <a href="<?php echo ($actual === 'crear-cuenta') ? 'login.php' : 'crear-cuenta.php'; ?>"><?php echo ($actual === 'crear-cuenta') ? 'Inicia Sesión Aquí' : 'Crea una cuenta nueva'; ?></a>
        </div>
    </form>
</div>