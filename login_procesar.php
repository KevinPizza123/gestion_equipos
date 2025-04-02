<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT * FROM Usuarios WHERE nombre_usuario = '$nombre_usuario'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($contrasena, $row['contrasena'])) {
            $_SESSION['id_usuario'] = $row['id_usuario'];
            $_SESSION['nombre_usuario'] = $row['nombre_usuario'];
            $_SESSION['rol'] = $row['rol'];
            $_SESSION['id_equipo'] = $row['id_equipo'];

            if ($row['rol'] === 'admin') {
                header("Location: admin_dashboard.php"); // Redirigir a la página de administración
            } else {
                header("Location: equipo_dashboard.php"); // Redirigir a la página del equipo
            }
            exit();
        } else {
            header("Location: login.php?error=1"); // Contraseña incorrecta
            exit();
        }
    } else {
        header("Location: login.php?error=1"); // Usuario no encontrado
        exit();
    }
}

$conn->close();
?>