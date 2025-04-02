<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_equipo = $_POST['id_equipo'];
    $id_torneo = $_POST['id_torneo'];

    $sql = "INSERT INTO Equipos_Torneos (id_equipo, id_torneo) VALUES ($id_equipo, $id_torneo)";

    if ($conn->query($sql) === TRUE) {
        echo "Equipo asignado al torneo con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Obtener la lista de equipos y torneos
$sql_equipos = "SELECT id_equipo, nombre_equipo FROM Equipos";
$result_equipos = $conn->query($sql_equipos);

$sql_torneos = "SELECT id_torneo, nombre_torneo FROM Torneos";
$result_torneos = $conn->query($sql_torneos);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Asignar Equipos a Torneos</title>
</head>
<body>
    <h1>Asignar Equipos a Torneos</h1>

    <form method="POST" action="equipos_torneos.php">
        <label for="id_equipo">Equipo:</label><br>
        <select id="id_equipo" name="id_equipo" required>
            <?php if ($result_equipos->num_rows > 0): ?>
                <?php while ($row_equipo = $result_equipos->fetch_assoc()): ?>
                    <option value="<?php echo $row_equipo['id_equipo']; ?>"><?php echo $row_equipo['nombre_equipo']; ?></option>
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

        <input type="submit" value="Asignar Equipo">
    </form>
</body>
</html>