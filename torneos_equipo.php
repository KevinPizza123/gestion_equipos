<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'equipo') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

$sql = "SELECT Torneos.* FROM Torneos INNER JOIN Equipos_Torneos ON Torneos.id_torneo = Equipos_Torneos.id_torneo WHERE Equipos_Torneos.id_equipo = " . $_SESSION['id_equipo'];
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
        <ul>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li><?php echo $row['nombre_torneo']; ?> (<?php echo $row['fecha_inicio']; ?>)</li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No hay torneos disponibles.</p>
    <?php endif; ?>
</body>
</html>