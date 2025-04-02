<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>

    <?php
    if (isset($_GET['error'])) {
        echo "<p style='color: red;'>Nombre de usuario o contraseña incorrectos.</p>";
    }
    ?>

    <form method="POST" action="login_procesar.php">
        <label for="nombre_usuario">Nombre de Usuario:</label><br>
        <input type="text" id="nombre_usuario" name="nombre_usuario"><br><br>

        <label for="contrasena">Contraseña:</label><br>
        <input type="password" id="contrasena" name="contrasena"><br><br>

        <input type="submit" value="Iniciar Sesión">
    </form>
</body>
</html>