<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_torneo = $_POST['nombre_torneo'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $arbitro = $_POST['arbitro'];
    $vocal = $_POST['vocal'];
    $costo_inscripcion = $_POST['costo_inscripcion'];

    $sql = "INSERT INTO Torneos (nombre_torneo, fecha_inicio, arbitro, vocal, costo_inscripcion) VALUES ('$nombre_torneo', '$fecha_inicio', '$arbitro', '$vocal', $costo_inscripcion)";

    if ($conn->query($sql) === TRUE) {
        echo "Torneo creado con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Creación de Torneos</title>
</head>
<body>
    <h1>Creación de Torneos</h1>

    <form method="POST" action="torneos.php">
        <label for="nombre_torneo">Nombre del Torneo:</label><br>
        <input type="text" id="nombre_torneo" name="nombre_torneo" required><br><br>

        <label for="fecha_inicio">Fecha de Inicio:</label><br>
        <input type="date" id="fecha_inicio" name="fecha_inicio" required><br><br>

        <label for="arbitro">Árbitro:</label><br>
        <input type="text" id="arbitro" name="arbitro"><br><br>

        <label for="vocal">Vocal:</label><br>
        <input type="text" id="vocal" name="vocal"><br><br>

        <label for="costo_inscripcion">Costo de Inscripción:</label><br>
        <input type="number" id="costo_inscripcion" name="costo_inscripcion" required><br><br>

        <input type="submit" value="Crear Torneo">
    </form>
</body>
</html>