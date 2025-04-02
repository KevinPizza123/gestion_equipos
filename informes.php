<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

// Obtener datos para el informe (ejemplo: partidos con más goles)
$sql = "SELECT Partidos.id_partido, Equipos_local.nombre_equipo AS equipo_local, Equipos_visitante.nombre_equipo AS equipo_visitante, Partidos.goles_local, Partidos.goles_visitante FROM Partidos INNER JOIN Equipos Equipos_local ON Partidos.id_equipo_local = Equipos_local.id_equipo INNER JOIN Equipos Equipos_visitante ON Partidos.id_equipo_visitante = Equipos_visitante.id_equipo ORDER BY (Partidos.goles_local + Partidos.goles_visitante) DESC LIMIT 10";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Informes</title>
</head>
<body>
    <h1>Informes</h1>

    <h2>Partidos con Más Goles</h2>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Partido ID</th>
                    <th>Equipo Local</th>
                    <th>Equipo Visitante</th>
                    <th>Goles Local</th>
                    <th>Goles Visitante</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_partido']; ?></td>
                        <td><?php echo $row['equipo_local']; ?></td>
                        <td><?php echo $row['equipo_visitante']; ?></td>
                        <td><?php echo $row['goles_local']; ?></td>
                        <td><?php echo $row['goles_visitante']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay datos disponibles para el informe.</p>
    <?php endif; ?>

    </body>
</html>