<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

$id_usuario = $_GET['id_usuario']; // Obtener el ID del usuario de la URL

// Obtener el permiso actual del usuario
$sql_permiso = "SELECT permiso FROM Permisos WHERE id_usuario = $id_usuario";
$result_permiso = $conn->query($sql_permiso);
$permiso = $result_permiso->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $permiso = $_POST['permiso'];

    // Actualizar o insertar el permiso
    if ($permiso) {
        $sql_update = "UPDATE Permisos SET permiso = '$permiso' WHERE id_usuario = $id_usuario";
    } else {
        $sql_insert = "INSERT INTO Permisos (id_usuario, permiso) VALUES ($id_usuario, '$permiso')";
    }

    if ($conn->query($sql_update ?? $sql_insert) === TRUE) {
        echo "Permiso actualizado con éxito.";
    } else {
        echo "Error: " . ($sql_update ?? $sql_insert) . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Permiso</title>
</head>
<body>
    <h1>Editar Permiso</h1>

    <form method="POST" action="editar_permiso.php?id_usuario=<?php echo $id_usuario; ?>">
        <label for="permiso">Permiso:</label><br>
        <input type="text" id="permiso" name="permiso" value="<?php echo $permiso['permiso'] ?? ''; ?>"><br><br>

        <input type="submit" value="Guardar Permiso">
    </form>
</body>
</html>