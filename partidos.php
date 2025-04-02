<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_torneo = $_POST['id_torneo'];
    $id_equipo_local = $_POST['id_equipo_local'];
    $id_equipo_visitante = $_POST['id_equipo_visitante'];
    $fecha_partido = $_POST['fecha_partido'];

    $sql = "INSERT INTO Partidos (id_torneo, id_equipo_local, id_equipo_visitante, fecha_partido) VALUES ($id_torneo, $id_equipo_local, $id_equipo_visitante, '$fecha_partido')";

    if ($conn->query($sql) === TRUE) {
        echo "Partido programado con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Obtener la lista de torneos y equipos
$sql_torneos = "SELECT id_torneo, nombre_torneo FROM Torneos";
$result_torneos = $conn->query($sql_torneos);

$sql_equipos = "SELECT id_equipo, nombre_equipo FROM Equipos";
$result_equipos = $conn->query($sql_equipos);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Programar Partidos</title>
</head>
<body>
    <h1>Programar Partidos</h1>

    <form method="POST" action="partidos.php">
        <label for="id_torneo">Torneo:</label><br>
        <select id="id_torneo" name="id_torneo" required>
            <?php if ($result_torneos->num_rows > 0): ?>
                <?php while ($row_torneo = $result_torneos->fetch_assoc()): ?>
                    <option value="<?php echo $row_torneo['id_torneo']; ?>"><?php echo $row_torneo['nombre_torneo']; ?></option>
                <?php endwhile; ?>
            <?php endif; ?>
        </select><br><br>

        <label for="id_equipo_local">Equipo Local:</label><br>
        <select id="id_equipo_local" name="id_equipo_local" required>
            <?php if ($result_equipos->num_rows > 0): ?>
                <?php while ($row_equipo = $result_equipos->fetch_assoc()): ?>
                    <option value="<?php echo $row_equipo['id_equipo']; ?>"><?php echo $row_equipo['nombre_equipo']; ?></option>
                <?php endwhile; ?>
            <?php endif; ?>
        </select><br><br>

        <label for="id_equipo_visitante">Equipo Visitante:</label><br>
        <select id="id_equipo_visitante" name="id_equipo_visitante" required>
            <?php if ($result_equipos->num_rows > 0): ?>
                <?php while ($row_equipo = $result_equipos->fetch_assoc()): ?>
                    <option value="<?php echo $row_equipo['id_equipo']; ?>"><?php echo $row_equipo['nombre_equipo']; ?></option>
                <?php endwhile; ?>
            <?php endif; ?>
        </select><br><br>

        <label for="fecha_partido">Fecha y Hora del Partido:</label><br>
        <input type="datetime-local" id="fecha_partido" name="fecha_partido" required><br><br>

        <input type="submit" value="Programar Partido">
    </form>
</body>
</html>