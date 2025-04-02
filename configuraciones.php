<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoria = $_POST['categoria'];
    $costo_tarjeta_roja = $_POST['costo_tarjeta_roja'];
    $costo_expulsion = $_POST['costo_expulsion'];

    $sql = "INSERT INTO Configuraciones (categoria, costo_tarjeta_roja, costo_expulsion) VALUES ('$categoria', $costo_tarjeta_roja, $costo_expulsion)";

    if ($conn->query($sql) === TRUE) {
        echo "Configuración guardada con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Configuraciones</title>
</head>
<body>
    <h1>Configuraciones</h1>

    <form method="POST" action="configuraciones.php">
        <label for="categoria">Categoría:</label><br>
        <input type="text" id="categoria" name="categoria" required><br><br>

        <label for="costo_tarjeta_roja">Costo de Tarjeta Roja:</label><br>
        <input type="number" id="costo_tarjeta_roja" name="costo_tarjeta_roja" required><br><br>

        <label for="costo_expulsion">Costo de Expulsión:</label><br>
        <input type="number" id="costo_expulsion" name="costo_expulsion" required><br><br>

        <input type="submit" value="Guardar Configuración">
    </form>
</body>
</html>