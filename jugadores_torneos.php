<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_jugador = $_POST['id_jugador'];
    $id_torneo = $_POST['id_torneo'];

    $sql = "INSERT INTO Jugadores_Torneos (id_jugador, id_torneo) VALUES ($id_jugador, $id_torneo)";

    if ($conn->query($sql) === TRUE) {
        echo "Jugador asignado al torneo con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Obtener la lista de jugadores y torneos
$sql_jugadores = "SELECT id_jugador, nombre_jugador FROM Jugadores";
$result_jugadores = $conn->query($sql_jugadores);

$sql_torneos = "SELECT id_torneo, nombre_torneo FROM Torneos";
$result_torneos = $conn->query($sql_torneos);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Asignar Jugadores a Torneos</title>
</head>
<body>
    <h1>Asignar Jugadores a Torneos</h1>

    <form method="POST" action="jugadores_torneos.php">
        <label for="id_jugador">Jugador:</label><br>
        <select id="id_jugador" name="id_jugador" required>
            <?php if ($result_jugadores->num_rows > 0): ?>
                <?php while ($row_jugador = $result_jugadores->fetch_assoc()): ?>
                    <option value="<?php echo $row_jugador['id_jugador']; ?>"><?php echo $row_jugador['nombre_jugador']; ?></option>
                <?php endwhile; ?>
            <?php endif; ?>
        </select><br><br>

        <label for="id_torneo">Torneo:</label><br>
        <select id="id_torneo" name="id_torneo" required>
            <?php if ($result_torneos->num_rows > 0): ?>
                <?php while ($row_torneo = $result_torneos->fetch_assoc()): ?>
                    <option value="<?php echo $row_torneo['id_torneo']; ?>"><?php echo $row_torneo['nombre_torneo']; ?></option>
                <?php endwhile; ?>
            <?php endif; ?>
        </select><br><br>

        <input type="submit" value="Asignar Jugador">
    </form>
</body>
</html>