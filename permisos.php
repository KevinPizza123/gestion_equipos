<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

// Obtener la lista de usuarios con sus permisos
$sql = "SELECT Usuarios.id_usuario, Usuarios.nombre_usuario, Permisos.permiso FROM Usuarios LEFT JOIN Permisos ON Usuarios.id_usuario = Permisos.id_usuario";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Permisos</title>
</head>
<body>
    <h1>Gestión de Permisos</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Usuario ID</th>
                    <th>Nombre de Usuario</th>
                    <th>Permiso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_usuario']; ?></td>
                        <td><?php echo $row['nombre_usuario']; ?></td>
                        <td><?php echo $row['permiso']; ?></td>
                        <td><a href="editar_permiso.php?id_usuario=<?php echo $row['id_usuario']; ?>">Editar Permiso</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay usuarios registrados.</p>
    <?php endif; ?>
</body>
</html>