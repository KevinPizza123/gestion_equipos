<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'equipo') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

$sql = "SELECT Equipos.nombre_equipo, COUNT(Partidos.goles_local) AS goles FROM Equipos INNER JOIN Partidos ON Equipos.id_equipo = Partidos.id_equipo_local WHERE Partidos.id_torneo = (SELECT id_torneo FROM Equipos_Torneos WHERE id_equipo = " . $_SESSION['id_equipo'] . ") GROUP BY Equipos.id_equipo ORDER BY goles DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Clasificación del Equipo</title>
</head>
<body>
    <h1>Clasificación del Equipo</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Equipo</th>
                    <th>Goles</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['nombre_equipo']; ?></td>
                        <td><?php echo $row['goles']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay datos de clasificación disponibles.</p>
    <?php endif; ?>
</body>
</html>