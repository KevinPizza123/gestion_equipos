<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

// Obtener la lista de usuarios con el nombre del equipo
$sql = "SELECT Usuarios.id_usuario, Usuarios.nombre_usuario, Usuarios.rol, Equipos.nombre_equipo
        FROM Usuarios
        LEFT JOIN Equipos ON Usuarios.id_equipo = Equipos.id_equipo"; // Usamos LEFT JOIN para mostrar usuarios sin equipo
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Usuarios</title>
</head>
<body>
    <h1>Gestión de Usuarios</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de Usuario</th>
                    <th>Rol</th>
                    <th>Equipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_usuario']; ?></td>
                        <td><?php echo $row['nombre_usuario']; ?></td>
                        <td><?php echo $row['rol']; ?></td>
                        <td><?php echo $row['nombre_equipo']; ?></td>
                        <td>
                            <a href="editar_usuario.php?id_usuario=<?php echo $row['id_usuario']; ?>">Editar</a> |
                            <a href="eliminar_usuario.php?id_usuario=<?php echo $row['id_usuario']; ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay usuarios registrados.</p>
    <?php endif; ?>

    <a href="register.php">Registrar Nuevo Usuario</a>
</body>
</html>