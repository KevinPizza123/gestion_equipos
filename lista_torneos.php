<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

// Obtener la lista de torneos
$sql = "SELECT * FROM Torneos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Torneos</title>
</head>
<body>
    <h1>Lista de Torneos</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Fecha de Inicio</th>
                    <th>Árbitro</th>
                    <th>Vocal</th>
                    <th>Costo Inscripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_torneo']; ?></td>
                        <td><?php echo $row['nombre_torneo']; ?></td>
                        <td><?php echo $row['fecha_inicio']; ?></td>
                        <td><?php echo $row['arbitro']; ?></td>
                        <td><?php echo $row['vocal']; ?></td>
                        <td><?php echo $row['costo_inscripcion']; ?></td>
                        <td>
                            <a href="detalles_torneo.php?id_torneo=<?php echo $row['id_torneo']; ?>">Detalles</a> |
                            <a href="editar_torneo.php?id_torneo=<?php echo $row['id_torneo']; ?>">Editar</a> |
                            <a href="eliminar_torneo.php?id_torneo=<?php echo $row['id_torneo']; ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay torneos disponibles.</p>
    <?php endif; ?>
</body>
</html>