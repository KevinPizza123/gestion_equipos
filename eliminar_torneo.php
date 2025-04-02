<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

$id_torneo = $_GET['id_torneo']; // Obtener el ID del torneo de la URL

$sql_delete = "DELETE FROM Torneos WHERE id_torneo = $id_torneo";

if ($conn->query($sql_delete) === TRUE) {
    echo "Torneo eliminado con éxito.";
} else {
    echo "Error: " . $sql_delete . "<br>" . $conn->error;
}

header("Location: lista_torneos.php"); // Redirigir a la lista de torneos
exit();
?>