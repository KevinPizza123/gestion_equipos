<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'equipo') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Panel del Equipo</title>
</head>
<body>
    <h1>Bienvenido, Equipo</h1>

    <ul>
        <li><a href="torneos_equipo.php">Lista de Torneos</a></li>
        <li><a href="clasificacion_equipo.php">Clasificación del Equipo</a></li>
        <li><a href="clasificacion_jugadores.php">Clasificación de Jugadores</a></li>
        <li><a href="calendario_partidos.php">Calendario de Partidos</a></li>
        <li><a href="vocalia_equipo.php">Vocalia</a></li>
        </ul>

    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>