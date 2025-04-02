<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'equipo') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

$sql = "SELECT Jugadores.nombre_jugador, SUM(Jugadores_Partidos.goles) AS goles FROM Jugadores INNER JOIN Jugadores_Partidos ON Jugadores.id_jugador = Jugadores_Partidos.id_jugador INNER JOIN Partidos ON Jugadores_Partidos.id_partido = Partidos.id_partido WHERE Jugadores.id_equipo = " . $_SESSION['id_equipo'] . " GROUP BY Jugadores.id_jugador ORDER BY goles DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Clasificación de Jugadores</title>
</head>
<body>
    <h1>Clasificación de Jugadores</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Jugador</th>
                    <th>Goles</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['nombre_jugador']; ?></td>
                        <td><?php echo $row['goles']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay datos de clasificación de jugadores disponibles.</p>
    <?php endif; ?>
</body>
</html>