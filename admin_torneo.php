<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

// Obtener la lista de torneos
$sql_torneos = "SELECT * FROM Torneos";
$result_torneos = $conn->query($sql_torneos);

// Obtener la lista de equipos
$sql_equipos = "SELECT * FROM Equipos";
$result_equipos = $conn->query($sql_equipos);
// Obtener la lista de árbitros y equipos
$sql_arbitros = "SELECT * FROM Arbitros";
$result_arbitros = $conn->query($sql_arbitros);
// Procesar el formulario de asignación de equipos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['asignar_equipos'])) {
    $id_torneo = intval($_POST['id_torneo']);
    $equipos_seleccionados = $_POST['equipos'];

    // Eliminar las relaciones existentes para el torneo
    $sql_eliminar = "DELETE FROM Equipos_Torneos WHERE id_torneo = $id_torneo";
    $conn->query($sql_eliminar);

    // Insertar las nuevas relaciones
    foreach ($equipos_seleccionados as $id_equipo) {
        $id_equipo = intval($id_equipo);
        $sql_insert = "INSERT INTO Equipos_Torneos (id_torneo, id_equipo) VALUES ($id_torneo, $id_equipo)";
        $conn->query($sql_insert);
    }
    echo "Equipos asignados al torneo con éxito.";
}

// Procesar el formulario de generación de partidos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generar_partidos'])) {
    $id_torneo = intval($_POST['id_torneo']);
    generar_partidos($id_torneo);
    echo "Partidos generados con éxito.";
}

function generar_partidos($id_torneo) {
    global $conn;

    // Obtener los equipos del torneo
    $sql_equipos = "SELECT id_equipo FROM Equipos_Torneos WHERE id_torneo = $id_torneo";
    $result_equipos = $conn->query($sql_equipos);
    $equipos = [];
    while ($row_equipo = $result_equipos->fetch_assoc()) {
        $equipos[] = $row_equipo['id_equipo'];
    }

    // Generar enfrentamientos aleatorios
    $partidos = [];
    for ($i = 0; $i < count($equipos); $i++) {
        for ($j = $i + 1; $j < count($equipos); $j++) {
            $partidos[] = [$equipos[$i], $equipos[$j]];
        }
    }
    shuffle($partidos);

    // Guardar los partidos en la base de datos
    foreach ($partidos as $partido) {
        $id_equipo_local = $partido[0];
        $id_equipo_visitante = $partido[1];
        $fecha_partido = date('Y-m-d H:i:s'); // Asigna una fecha y hora por defecto

        $sql_insert = "INSERT INTO Partidos (id_torneo, id_equipo_local, id_equipo_visitante, fecha_partido) VALUES ($id_torneo, $id_equipo_local, $id_equipo_visitante, '$fecha_partido')";
        $conn->query($sql_insert);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Administración de Torneos</title>
</head>
<body>
    <h1>Administración de Torneos</h1>

    <h2>Asignar Equipos a Torneo</h2>
    <form method="POST" action="admin_torneo.php">
        <label for="id_torneo">Seleccionar Torneo:</label>
        <select name="id_torneo" id="id_torneo">
            <?php while ($row_torneo = $result_torneos->fetch_assoc()): ?>
                <option value="<?php echo $row_torneo['id_torneo']; ?>"><?php echo $row_torneo['nombre_torneo']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Seleccionar Equipos:</label><br>
        <?php while ($row_equipo = $result_equipos->fetch_assoc()): ?>
            <input type="checkbox" name="equipos[]" value="<?php echo $row_equipo['id_equipo']; ?>"> <?php echo $row_equipo['nombre_equipo']; ?><br>
        <?php endwhile; ?>

        <input type="submit" name="asignar_equipos" value="Asignar Equipos">
    </form>

    <h2>Generar Partidos</h2>
    <form method="POST" action="admin_torneo.php">
        <label for="id_torneo">Seleccionar Torneo:</label>
        <select name="id_torneo" id="id_torneo">
            <?php
            $result_torneos->data_seek(0); // Reiniciar el puntero del resultado
            while ($row_torneo = $result_torneos->fetch_assoc()):
            ?>
                <option value="<?php echo $row_torneo['id_torneo']; ?>"><?php echo $row_torneo['nombre_torneo']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="id_arbitro">Árbitro:</label>
        <select name="id_arbitro" id="id_arbitro">
            <?php while ($row_arbitro = $result_arbitros->fetch_assoc()): ?>
                <option value="<?php echo $row_arbitro['id_arbitro']; ?>"><?php echo $row_arbitro['nombre_arbitro']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="id_equipo_vocalia">Equipo Vocalía:</label>
        <select name="id_equipo_vocalia" id="id_equipo_vocalia">
            <?php
            $result_equipos->data_seek(0); // Reiniciar el puntero del resultado
            while ($row_equipo = $result_equipos->fetch_assoc()):
            ?>
                <option value="<?php echo $row_equipo['id_equipo']; ?>"><?php echo $row_equipo['nombre_equipo']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <input type="submit" name="generar_partidos" value="Generar Partidos">
    </form>
</body>
</html>