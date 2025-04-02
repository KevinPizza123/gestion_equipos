<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

$id_usuario = $_GET['id_usuario']; // Obtener el ID del usuario de la URL

$sql_delete = "DELETE FROM Usuarios WHERE id_usuario = $id_usuario";

if ($conn->query($sql_delete) === TRUE) {
    echo "Usuario eliminado con éxito.";
} else {
    echo "Error: " . $sql_delete . "<br>" . $conn->error;
}

header("Location: usuarios.php"); // Redirigir a la lista de usuarios
exit();
?>