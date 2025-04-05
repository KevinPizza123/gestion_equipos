<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

// Obtener la información del partido
$id_partido = intval($_GET['id_partido']);
$sql_partido = "SELECT * FROM Partidos WHERE id_partido = $id_partido";
$result_partido = $conn->query($sql_partido);
$partido = $result_partido->fetch_assoc();

// Obtener la lista de equipos y árbitros
$sql_equipos = "SELECT * FROM Equipos";
$result_equipos = $conn->query($sql_equipos);
$sql_arbitros = "SELECT * FROM Arbitros";
$result_arbitros = $conn->query($sql_arbitros);

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_cambios'])) {
    $fecha_partido = $_POST['fecha_partido'];
    $id_equipo_local = intval($_POST['id_equipo_local']);
    $id_equipo_visitante = intval($_POST['id_equipo_visitante']);
    $id_arbitro = intval($_POST['id_arbitro']);
    $id_equipo_vocalia = intval($_POST['id_equipo_vocalia']);

    $sql_update = "UPDATE Partidos SET fecha_partido = '$fecha_partido', id_equipo_local = $id_equipo_local, id_equipo_visitante = $id_equipo_visitante, id_arbitro = $id_arbitro, id_equipo_vocalia = $id_equipo_vocalia WHERE id_partido = $id_partido";
    $conn->query($sql_update);

    echo "Cambios guardados con éxito.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Partido</title>
</head>
<body>
    <h1>Editar Partido</h1>

    <form method="POST" action="editar_partido.php?id_partido=<?php echo $id_partido; ?>">
        <label for="fecha_partido">Fecha y Hora:</label>
        <input type="datetime-local" name="fecha_partido" id="fecha_partido" value="<?php echo date('Y-m-d\TH:i', strtotime($partido['fecha_partido'])); ?>"><br><br>

        <label for="id_equipo_local">Equipo Local:</label>
        <select name="id_equipo_local" id="id_equipo_local">
            <?php while ($row_equipo = $result_equipos->fetch_assoc()): ?>
                <option value="<?php echo $row_equipo['id_equipo']; ?>" <?php if ($row_equipo['id_equipo'] == $partido['id_equipo_local']) echo "selected"; ?>><?php echo $row_equipo['nombre_equipo']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="id_equipo_visitante">Equipo Visitante:</label>
        <select name="id_equipo_visitante" id="id_equipo_visitante">
            <?php
            $result_equipos->data_seek(0); // Reiniciar el puntero del resultado
            while ($row_equipo = $result_equipos->fetch_assoc()):
            ?>
                <option value="<?php echo $row_equipo['id_equipo']; ?>" <?php if ($row_equipo['id_equipo'] == $partido['id_equipo_visitante']) echo "selected"; ?>><?php echo $row_equipo['nombre_equipo']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="id_arbitro">Árbitro:</label>
        <select name="id_arbitro" id="id_arbitro">
            <?php while ($row_arbitro = $result_arbitros->fetch_assoc()): ?>
                <option value="<?php echo $row_arbitro['id_arbitro']; ?>" <?php if ($row_arbitro['id_arbitro'] == $partido['id_arbitro']) echo "selected"; ?>><?php echo $row_arbitro['nombre_arbitro']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="id_equipo_vocalia">Equipo Vocalía:</label>
        <select name="id_equipo_vocalia" id="id_equipo_vocalia">
            <?php
            $result_equipos->data_seek(0); // Reiniciar el puntero del resultado
            while ($row_equipo = $result_equipos->fetch_assoc()):
            ?>
                <option value="<?php echo $row_equipo['id_equipo']; ?>" <?php if ($row_equipo['id_equipo'] == $partido['id_equipo_vocalia']) echo "selected"; ?>><?php echo $row_equipo['nombre_equipo']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <input type="submit" name="guardar_cambios" value="Guardar Cambios">
    </form>
</body>
</html>