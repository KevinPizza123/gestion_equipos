<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

// Obtener la lista de partidos
$sql_partidos = "SELECT id_partido, EquiposLocal.nombre_equipo AS local, EquiposVisitante.nombre_equipo AS visitante
                FROM Partidos
                INNER JOIN Equipos EquiposLocal ON Partidos.id_equipo_local = EquiposLocal.id_equipo
                INNER JOIN Equipos EquiposVisitante ON Partidos.id_equipo_visitante = EquiposVisitante.id_equipo
                WHERE goles_local IS NULL AND goles_visitante IS NULL"; // Obtener solo partidos sin resultados
$result_partidos = $conn->query($sql_partidos);

// Procesar el formulario de resultados
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_resultados'])) {
    $id_partido = intval($_POST['id_partido']);
    $goles_local = intval($_POST['goles_local']);
    $goles_visitante = intval($_POST['goles_visitante']);

    $sql_update = "UPDATE Partidos SET goles_local = $goles_local, goles_visitante = $goles_visitante WHERE id_partido = $id_partido";
    $conn->query($sql_update);

    echo "Resultados guardados con éxito.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Resultados de Partidos</title>
</head>
<body>
    <h1>Resultados de Partidos</h1>

    <?php if ($result_partidos->num_rows > 0): ?>
        <form method="POST" action="resultados_partidos.php">
            <label for="id_partido">Seleccionar Partido:</label>
            <select name="id_partido" id="id_partido">
                <?php while ($row_partido = $result_partidos->fetch_assoc()): ?>
                    <option value="<?php echo $row_partido['id_partido']; ?>"><?php echo $row_partido['local'] . " vs " . $row_partido['visitante']; ?></option>
                <?php endwhile; ?>
            </select><br><br>

            <label for="goles_local">Goles Local:</label>
            <input type="number" name="goles_local" id="goles_local" value="0"><br><br>

            <label for="goles_visitante">Goles Visitante:</label>
            <input type="number" name="goles_visitante" id="goles_visitante" value="0"><br><br>

            <input type="submit" name="guardar_resultados" value="Guardar Resultados">
        </form>
    <?php else: ?>
        <p>No hay partidos sin resultados pendientes.</p>
    <?php endif; ?>
</body>
</html>