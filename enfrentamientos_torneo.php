<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

$id_torneo = $_GET['id_torneo']; // Obtener el ID del torneo de la URL

// Obtener los enfrentamientos del torneo
$sql = "SELECT Equipos_local.nombre_equipo AS equipo_local, Equipos_visitante.nombre_equipo AS equipo_visitante, Partidos.fecha_partido, Partidos.goles_local, Partidos.goles_visitante FROM Partidos INNER JOIN Equipos Equipos_local ON Partidos.id_equipo_local = Equipos_local.id_equipo INNER JOIN Equipos Equipos_visitante ON Partidos.id_equipo_visitante = Equipos_visitante.id_equipo WHERE Partidos.id_torneo = $id_torneo";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tabla de Enfrentamientos</title>
</head>
<body>
    <h1>Tabla de Enfrentamientos</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Equipo Local</th>
                    <th>Equipo Visitante</th>
                    <th>Fecha y Hora</th>
                    <th>Goles Local</th>
                    <th>Goles Visitante</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['equipo_local']; ?></td>
                        <td><?php echo $row['equipo_visitante']; ?></td>
                        <td><?php echo $row['fecha_partido']; ?></td>
                        <td><?php echo $row['goles_local']; ?></td>
                        <td><?php echo $row['goles_visitante']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay enfrentamientos programados para este torneo.</p>
    <?php endif; ?>
</body>
</html>