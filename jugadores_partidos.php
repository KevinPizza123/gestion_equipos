<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_jugador = $_POST['id_jugador'];
    $id_partido = $_POST['id_partido'];
    $titular = isset($_POST['titular']) ? 1 : 0;
    $minuto_ingreso = $_POST['minuto_ingreso'];
    $minuto_salida = $_POST['minuto_salida'];

    $sql = "INSERT INTO Jugadores_Partidos (id_jugador, id_partido, titular, minuto_ingreso, minuto_salida) VALUES ($id_jugador, $id_partido, $titular, $minuto_ingreso, $minuto_salida)";

    if ($conn->query($sql) === TRUE) {
        echo "Jugador asignado al partido con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Obtener la lista de jugadores y partidos
$sql_jugadores = "SELECT id_jugador, nombre_jugador FROM Jugadores";
$result_jugadores = $conn->query($sql_jugadores);

$sql_partidos = "SELECT id_partido, fecha_partido FROM Partidos";
$result_partidos = $conn->query($sql_partidos);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Asignar Jugadores a Partidos</title>
</head>
<body>
    <h1>Asignar Jugadores a Partidos</h1>

    <form method="POST" action="jugadores_partidos.php">
        <label for="id_jugador">Jugador:</label><br>
        <select id="id_jugador" name="id_jugador" required>
            <?php if ($result_jugadores->num_rows > 0): ?>
                <?php while ($row_jugador = $result_jugadores->fetch_assoc()): ?>
                    <option value="<?php echo $row_jugador['id_jugador']; ?>"><?php echo $row_jugador['nombre_jugador']; ?></option>
                <?php endwhile; ?>
            <?php endif; ?>
        </select><br><br>

        <label for="id_partido">Partido:</label><br>
        <select id="id_partido" name="id_partido" required>
            <?php if ($result_partidos->num_rows > 0): ?>
                <?php while ($row_partido = $result_partidos->fetch_assoc()): ?>
                    <option value="<?php echo $row_partido['id_partido']; ?>"><?php echo $row_partido['fecha_partido']; ?></option>
                <?php endwhile; ?>
            <?php endif; ?>
        </select><br><br>

        <label for="titular">Titular:</label><br>
        <input type="checkbox" id="titular" name="titular"><br><br>

        <label for="minuto_ingreso">Minuto de Ingreso:</label><br>
        <input type="number" id="minuto_ingreso" name="minuto_ingreso"><br><br>

        <label for="minuto_salida">Minuto de Salida:</label><br>
        <input type="number" id="minuto_salida" name="minuto_salida"><br><br>

        <input type="submit" value="Asignar Jugador">
    </form>
</body>
</html>