<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_equipo = $_POST['nombre_equipo'];
    $categoria = $_POST['categoria'];
    $lider = $_POST['lider'];
    $fecha_creacion = $_POST['fecha_creacion'];
    $ubicacion = $_POST['ubicacion'];

    $sql = "INSERT INTO Equipos (nombre_equipo, categoria, lider, fecha_creacion, ubicacion) VALUES ('$nombre_equipo', '$categoria', '$lider', '$fecha_creacion', '$ubicacion')";

    if ($conn->query($sql) === TRUE) {
        echo "Equipo registrado con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Equipos</title>
</head>
<body>
    <h1>Registro de Equipos</h1>

    <form method="POST" action="equipos.php">
        <label for="nombre_equipo">Nombre del Equipo:</label><br>
        <input type="text" id="nombre_equipo" name="nombre_equipo" required><br><br>

        <label for="categoria">Categoría:</label><br>
        <select id="categoria" name="categoria" required>
            <option value="Mujeres">Mujeres</option>
            <option value="Hombres">Hombres</option>
        </select><br><br>

        <label for="lider">Líder:</label><br>
        <input type="text" id="lider" name="lider" required><br><br>

        <label for="fecha_creacion">Fecha de Creación:</label><br>
        <input type="date" id="fecha_creacion" name="fecha_creacion" required><br><br>

        <label for="ubicacion">Ubicación:</label><br>
        <input type="text" id="ubicacion" name="ubicacion" required><br><br>

        <input type="submit" value="Registrar Equipo">
    </form>
</body>
</html>