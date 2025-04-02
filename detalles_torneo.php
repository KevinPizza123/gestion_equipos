<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

$id_torneo = $_GET['id_torneo']; // Obtener el ID del torneo de la URL

// Obtener los detalles del torneo
$sql_torneo = "SELECT * FROM Torneos WHERE id_torneo = $id_torneo";
$result_torneo = $conn->query($sql_torneo);
$torneo = $result_torneo->fetch_assoc();

// Obtener los equipos participantes
$sql_equipos = "SELECT Equipos.nombre_equipo FROM Equipos INNER JOIN Equipos_Torneos ON Equipos.id_equipo = Equipos_Torneos.id_equipo WHERE Equipos_Torneos.id_torneo = $id_torneo";
$result_equipos = $conn->query($sql_equipos);

// Obtener los jugadores participantes
$sql_jugadores = "SELECT Jugadores.nombre_jugador FROM Jugadores INNER JOIN Jugadores_Torneos ON Jugadores.id_jugador = Jugadores_Torneos.id_jugador WHERE Jugadores_Torneos.id_torneo = $id_torneo";
$result_jugadores = $conn->query($sql_jugadores);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detalles del Torneo</title>
</head>
<body>
    <h1>Detalles del Torneo</h1>

    <?php if ($torneo): ?>
        <h2><?php echo $torneo['nombre_torneo']; ?></h2>
        <p>Fecha de Inicio: <?php echo $torneo['fecha_inicio']; ?></p>
        <p>Árbitro: <?php echo $torneo['arbitro']; ?></p>
        <p>Vocal: <?php echo $torneo['vocal']; ?></p>
        <p>Costo de Inscripción: <?php echo $torneo['costo_inscripcion']; ?></p>

        <h3>Equipos Participantes:</h3>
        <?php if ($result_equipos->num_rows > 0): ?>
            <ul>
                <?php while ($row_equipo = $result_equipos->fetch_assoc()): ?>
                    <li><?php echo $row_equipo['nombre_equipo']; ?></li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No hay equipos participantes.</p>
        <?php endif; ?>

        <h3>Jugadores Participantes:</h3>
        <?php if ($result_jugadores->num_rows > 0): ?>
            <ul>
                <?php while ($row_jugador = $result_jugadores->fetch_assoc()): ?>
                    <li><?php echo $row_jugador['nombre_jugador']; ?></li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No hay jugadores participantes.</p>
        <?php endif; ?>
    <?php else: ?>
        <p>Torneo no encontrado.</p>
    <?php endif; ?>
</body>
</html>