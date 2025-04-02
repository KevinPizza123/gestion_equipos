<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

$id_torneo = $_GET['id_torneo']; // Obtener el ID del torneo de la URL

// Obtener la clasificación de los equipos en el torneo
$sql = "SELECT Equipos.nombre_equipo, COUNT(Partidos.id_partido) AS partidos_jugados, SUM(Partidos.goles_local + Partidos.goles_visitante) AS goles_totales, SUM(CASE WHEN Partidos.goles_local > Partidos.goles_visitante THEN 1 ELSE 0 END) AS partidos_ganados, SUM(CASE WHEN Partidos.goles_local = Partidos.goles_visitante THEN 1 ELSE 0 END) AS partidos_empatados, SUM(CASE WHEN Partidos.goles_local < Partidos.goles_visitante THEN 1 ELSE 0 END) AS partidos_perdidos FROM Equipos INNER JOIN Partidos ON Equipos.id_equipo = Partidos.id_equipo_local OR Equipos.id_equipo = Partidos.id_equipo_visitante WHERE Partidos.id_torneo = $id_torneo GROUP BY Equipos.id_equipo ORDER BY partidos_ganados DESC, goles_totales DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tabla de Clasificación</title>
</head>
<body>
    <h1>Tabla de Clasificación</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Equipo</th>
                    <th>Partidos Jugados</th>
                    <th>Goles Totales</th>
                    <th>Partidos Ganados</th>
                    <th>Partidos Empatados</th>
                    <th>Partidos Perdidos</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['nombre_equipo']; ?></td>
                        <td><?php echo $row['partidos_jugados']; ?></td>
                        <td><?php echo $row['goles_totales']; ?></td>
                        <td><?php echo $row['partidos_ganados']; ?></td>
                        <td><?php echo $row['partidos_empatados']; ?></td>
                        <td><?php echo $row['partidos_perdidos']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay datos de clasificación disponibles.</p>
    <?php endif; ?>
</body>
</html>