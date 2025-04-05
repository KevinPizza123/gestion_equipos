<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

if (isset($_GET['id_equipo'])) {
    $id_equipo = intval($_GET['id_equipo']);

    $sql_delete = "DELETE FROM Equipos WHERE id_equipo = $id_equipo";
    if ($conn->query($sql_delete) === TRUE) {
        echo "Equipo eliminado con éxito.";
    } else {
        echo "Error al eliminar el equipo: " . $conn->error;
    }
} else {
    echo "ID de equipo no proporcionado.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Eliminar Equipo</title>
</head>
<body>
    <h1>Eliminar Equipo</h1>
    <p><a href="lista_equipos.php">Volver a la lista de equipos</a></p>
</body>
</html>