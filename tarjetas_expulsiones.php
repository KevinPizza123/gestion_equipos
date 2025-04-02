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
    $tarjetas_rojas = $_POST['tarjetas_rojas'];
    $expulsiones = $_POST['expulsiones'];

    $sql = "UPDATE Jugadores_Partidos SET tarjetas_rojas = $tarjetas_rojas, expulsiones = $expulsiones WHERE id_jugador = $id_jugador AND id_partido = $id_partido";

    if ($conn->query($sql) === TRUE) {
        echo "Tarjetas y expulsiones registradas con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Obtener la lista de jugadores y partidos
$sql_jugadores = "SELECT Jugadores.id_jugador, Jugadores.nombre_jugador FROM Jugadores INNER JOIN Jugadores_Partidos ON Jugadores.id_jugador = Jugadores_Partidos.id_jugador WHERE Jugadores_Partidos.id_partido IN (SELECT id_partido FROM Partidos)";
$result_jugadores = $conn->query($sql_jugadores);

$sql_partidos = "SELECT id_partido, fecha_partido FROM Partidos";
$result_partidos = $conn->query($sql_partidos);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestionar Tarjetas y Expulsiones</title>
</head>
<body>
    <h1>Gestionar Tarjetas y Expulsiones</h1>

    <form method="POST" action="tarjetas_expulsiones.php">
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

        <label for="tarjetas_rojas">Tarjetas Rojas:</label><br>
        <input type="number" id="tarjetas_rojas" name="tarjetas_rojas" value="0"><br><br>

        <label for="expulsiones">Expulsiones:</label><br>
        <input type="number" id="expulsiones" name="expulsiones" value="0"><br><br>

        <input type="submit" value="Guardar Cambios">
    </form>
</body>
</html>