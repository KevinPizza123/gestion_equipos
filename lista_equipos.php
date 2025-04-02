<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

// Obtener la lista de equipos
$sql_equipos = "SELECT id_equipo, nombre_equipo FROM Equipos";
$result_equipos = $conn->query($sql_equipos);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Equipos</title>
</head>
<body>
    <h1>Lista de Equipos</h1>

    <?php if ($result_equipos->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row_equipo = $result_equipos->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row_equipo['id_equipo']; ?></td>
                        <td><?php echo $row_equipo['nombre_equipo']; ?></td>
                        <td>
                            <a href="editar_equipo.php?id_equipo=<?php echo $row_equipo['id_equipo']; ?>">Editar</a> |
                            <a href="eliminar_equipo.php?id_equipo=<?php echo $row_equipo['id_equipo']; ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay equipos registrados.</p>
    <?php endif; ?>
</body>
</html>