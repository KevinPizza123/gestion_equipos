<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

if (isset($_GET['id_jugador'])) {
    $id_jugador = intval($_GET['id_jugador']);

    $sql = "DELETE FROM Jugadores WHERE id_jugador = $id_jugador";

    if ($conn->query($sql) === TRUE) {
        echo "Jugador eliminado con éxito.";
        header("Location: lista_jugadores.php"); // Redirige a la lista de jugadores
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "ID de jugador no proporcionado.";
}

$conn->close();
?>