<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = mysqli_real_escape_string($conn, $_POST['nombre_usuario']);
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $rol = mysqli_real_escape_string($conn, $_POST['rol']);
    $id_equipo = ($_POST['id_equipo']) ? intval($_POST['id_equipo']) : null;

    $sql = "INSERT INTO Usuarios (nombre_usuario, contrasena, rol, id_equipo) VALUES ('$nombre_usuario', '$contrasena', '$rol', " . ($id_equipo === null ? 'NULL' : $id_equipo) . ")";

    if ($conn->query($sql) === TRUE) {
        echo "Usuario registrado con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>