<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_partido = $_POST['id_partido'];
    $total_tarjetas_rojas = $_POST['total_tarjetas_rojas'];
    $total_expulsiones = $_POST['total_expulsiones'];
    $total_goles = $_POST['total_goles'];
    $otros_detalles = $_POST['otros_detalles'];

    $sql = "INSERT INTO Vocalia (id_partido, total_tarjetas_rojas, total_expulsiones, total_goles, otros_detalles) VALUES ($id_partido, $total_tarjetas_rojas, $total_expulsiones, $total_goles, '$otros_detalles')";

    if ($conn->query($sql) === TRUE) {
        echo "Vocalia registrada con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Obtener la lista de partidos
$sql_partidos = "SELECT id_partido, fecha_partido FROM Partidos";
$result_partidos = $conn->query($sql_partidos);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestionar Vocalías</title>
</head>
<body>
    <h1>Gestionar Vocalías</h1>

    <form method="POST" action="vocalias_admin.php">
        <label for="id_partido">Partido:</label><br>
        <select id="id_partido" name="id_partido" required>
            <?php if ($result_partidos->num_rows > 0): ?>
                <?php while ($row_partido = $result_partidos->fetch_assoc()): ?>
                    <option value="<?php echo $row_partido['id_partido']; ?>"><?php echo $row_partido['fecha_partido']; ?></option>
                <?php endwhile; ?>
            <?php endif; ?>
        </select><br><br>

        <label for="total_tarjetas_rojas">Total de Tarjetas Rojas:</label><br>
        <input type="number" id="total_tarjetas_rojas" name="total_tarjetas_rojas" value="0"><br><br>

        <label for="total_expulsiones">Total de Expulsiones:</label><br>
        <input type="number" id="total_expulsiones" name="total_expulsiones" value="0"><br><br>

        <label for="total_goles">Total de Goles:</label><br>
        <input type="number" id="total_goles" name="total_goles" value="0"><br><br>

        <label for="otros_detalles">Otros Detalles:</label><br>
        <textarea id="otros_detalles" name="otros_detalles"></textarea><br><br>

        <input type="submit" value="Registrar Vocalia">
    </form>
</body>
</html>