<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_jugador = mysqli_real_escape_string($conn, $_POST['nombre_jugador']);
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $id_equipo = intval($_POST['id_equipo']);
    $numero_camiseta = intval($_POST['numero_camiseta']);

    $sql = "INSERT INTO Jugadores (nombre_jugador, fecha_nacimiento, id_equipo, numero_camiseta) VALUES ('$nombre_jugador', '$fecha_nacimiento', $id_equipo, $numero_camiseta)";

    if ($conn->query($sql) === TRUE) {
        echo "Jugador registrado con éxito.";
        header("Location: lista_jugadores.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql_equipos = "SELECT id_equipo, nombre_equipo FROM Equipos";
$result_equipos = $conn->query($sql_equipos);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Jugadores</title>
</head>
<body>
    <h1>Registro de Jugadores</h1>

    <form method="POST" action="jugadores.php">
        <label for="nombre_jugador">Nombre del Jugador:</label><br>
        <input type="text" id="nombre_jugador" name="nombre_jugador" required><br><br>

        <label for="fecha_nacimiento">Fecha de Nacimiento:</label><br>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required><br><br>

        <label for="id_equipo">Equipo:</label><br>
        <select id="id_equipo" name="id_equipo" required>
            <?php if ($result_equipos->num_rows > 0): ?>
                <?php while ($row_equipo = $result_equipos->fetch_assoc()): ?>
                    <option value="<?php echo $row_equipo['id_equipo']; ?>"><?php echo $row_equipo['nombre_equipo']; ?></option>
                <?php endwhile; ?>
            <?php endif; ?>
        </select><br><br>

        <label for="numero_camiseta">Número de Camiseta:</label><br>
        <input type="number" id="numero_camiseta" name="numero_camiseta"><br><br>

        <input type="submit" value="Registrar Jugador">
    </form>
</body>
</html>