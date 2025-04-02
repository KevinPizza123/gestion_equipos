<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

$id_usuario = $_GET['id_usuario']; // Obtener el ID del usuario de la URL

// Obtener los detalles del usuario
$sql_usuario = "SELECT * FROM Usuarios WHERE id_usuario = $id_usuario";
$result_usuario = $conn->query($sql_usuario);
$usuario = $result_usuario->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $rol = $_POST['rol'];

    $sql_update = "UPDATE Usuarios SET nombre_usuario = '$nombre_usuario', rol = '$rol' WHERE id_usuario = $id_usuario";

    if ($conn->query($sql_update) === TRUE) {
        echo "Usuario actualizado con éxito.";
    } else {
        echo "Error: " . $sql_update . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Usuario</title>
</head>
<body>
    <h1>Editar Usuario</h1>

    <?php if ($usuario): ?>
        <form method="POST" action="editar_usuario.php?id_usuario=<?php echo $id_usuario; ?>">
            <label for="nombre_usuario">Nombre de Usuario:</label><br>
            <input type="text" id="nombre_usuario" name="nombre_usuario" value="<?php echo $usuario['nombre_usuario']; ?>" required><br><br>

            <label for="rol">Rol:</label><br>
            <select id="rol" name="rol" required>
                <option value="admin" <?php if ($usuario['rol'] === 'admin') echo 'selected'; ?>>Administrador</option>
                <option value="usuario" <?php if ($usuario['rol'] === 'usuario') echo 'selected'; ?>>Usuario</option>
            </select><br><br>

            <input type="submit" value="Guardar Cambios">
        </form>
    <?php else: ?>
        <p>Usuario no encontrado.</p>
    <?php endif; ?>
</body>
</html>