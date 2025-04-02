<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

$id_torneo = $_GET['id_torneo']; // Obtener el ID del torneo de la URL

// Obtener los mejores jugadores del torneo (ejemplo: por goles)
$sql = "SELECT Jugadores.nombre_jugador, SUM(Jugadores_Partidos.goles) AS total_goles FROM Jugadores INNER JOIN Jugadores_Partidos ON Jugadores.id_jugador = Jugadores_Partidos.id_jugador INNER JOIN Partidos ON Jugadores_Partidos.id_partido = Partidos.id_partido WHERE Partidos.id_torneo = $id_torneo GROUP BY Jugadores.id_jugador ORDER BY total_goles DESC LIMIT 10";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mejores Jugadores</title>
</head>
<body>
    <h1>Mejores Jugadores</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Jugador</th>
                    <th>Total de Goles</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['nombre_jugador']; ?></td>
                        <td><?php echo $row['total_goles']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay datos de mejores jugadores disponibles.</p>
    <?php endif; ?>
</body>
</html>