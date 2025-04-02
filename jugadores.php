<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_jugador = $_POST['nombre_jugador'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $direccion = $_POST['direccion'];
    $beca = isset($_POST['beca']) ? 1 : 0;
    $id_equipo = $_POST['id_equipo'];

    $sql = "INSERT INTO Jugadores (nombre_jugador, fecha_nacimiento, direccion, beca, id_equipo) VALUES ('$nombre_jugador', '$fecha_nacimiento', '$direccion', $beca, $id_equipo)";

    if ($conn->query($sql) === TRUE) {
        echo "Jugador registrado con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Jugadores</title>
</head>
<body>
    <h1>Registro de Jugadores</h1>

    <form method="POST" action="jugadores.php">
        <label for="nombre_jugador">Nombre del Jugador:</label><br>
        <input type="text" id="nombre_jugador" name="nombre_jugador" required><br><br>

        <label for="fecha_nacimiento">Fecha de Nacimiento:</label><br>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required><br><br>

        <label for="direccion">Dirección:</label><br>
        <input type="text" id="direccion" name="direccion" required><br><br>

        <label for="beca">Beca:</label><br>
        <input type="checkbox" id="beca" name="beca"><br><br>

        <label for="id_equipo">ID del Equipo:</label><br>
        <input type="number" id="id_equipo" name="id_equipo" required><br><br>

        <input type="submit" value="Registrar Jugador">
    </form>
</body>
</html>