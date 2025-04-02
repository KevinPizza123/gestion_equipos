<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_partido = $_POST['id_partido'];
    $jugador_entra = $_POST['jugador_entra'];
    $jugador_sale = $_POST['jugador_sale'];
    $minuto_cambio = $_POST['minuto_cambio'];

    $sql = "INSERT INTO Cambios (id_partido, jugador_entra, jugador_sale, minuto_cambio) VALUES ($id_partido, $jugador_entra, $jugador_sale, $minuto_cambio)";

    if ($conn->query($sql) === TRUE) {
        echo "Cambio registrado con éxito.";
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
    <title>Gestionar Cambios</title>
</head>
<body>
    <h1>Gestionar Cambios</h1>

    <form method="POST" action="cambios.php">
        <label for="id_partido">Partido:</label><br>
        <select id="id_partido" name="id_partido" required>
            <?php if ($result_partidos->num_rows > 0): ?>
                <?php while ($row_partido = $result_partidos->fetch_assoc()): ?>
                    <option value="<?php echo $row_partido['id_partido']; ?>"><?php echo $row_partido['fecha_partido']; ?></option>
                <?php endwhile; ?>
            <?php endif; ?>
        </select><br><br>

        <label for="jugador_entra">Jugador Entra:</label><br>
        <select id="jugador_entra" name="jugador_entra" required>
            <?php if ($result_jugadores->num_rows > 0): ?>
                <?php while ($row_jugador = $result_jugadores->fetch_assoc()): ?>
                    <option value="<?php echo $row_jugador['id_jugador']; ?>"><?php echo $row_jugador['nombre_jugador']; ?></option>
                <?php endwhile; ?>
            <?php endif; ?>
        </select><br><br>

        <label for="jugador_sale">Jugador Sale:</label><br>
        <select id="jugador_sale" name="jugador_sale" required>
            <?php if ($result_jugadores->num_rows > 0): ?>
                <?php while ($row_jugador = $result_jugadores->fetch_assoc()): ?>
                    <option value="<?php echo $row_jugador['id_jugador']; ?>"><?php echo $row_jugador['nombre_jugador']; ?></option>
                <?php endwhile; ?>
            <?php endif; ?>
        </select><br><br>

        <label for="minuto_cambio">Minuto del Cambio:</label><br>
        <input type="number" id="minuto_cambio" name="minuto_cambio" required><br><br>

        <input type="submit" value="Registrar Cambio">
    </form>
</body>
</html>