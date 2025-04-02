<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
</head>
<body>
    <h1>Registro de Usuario</h1>

    <form method="POST" action="register_procesar.php">
        <label for="nombre_usuario">Nombre de Usuario:</label><br>
        <input type="text" id="nombre_usuario" name="nombre_usuario" required><br><br>

        <label for="contrasena">Contraseña:</label><br>
        <input type="password" id="contrasena" name="contrasena" required><br><br>

        <label for="rol">Rol:</label><br>
        <select id="rol" name="rol" required>
            <option value="admin">Administrador</option>
            <option value="equipo">Equipo</option>
        </select><br><br>

        <label for="id_equipo">ID de Equipo (Solo para equipos):</label><br>
        <input type="number" id="id_equipo" name="id_equipo"><br><br>

        <input type="submit" value="Registrar">
    </form>
</body>
</html>