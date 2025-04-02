<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

$id_torneo = $_GET['id_torneo']; // Obtener el ID del torneo de la URL

// Obtener los detalles del torneo
$sql_torneo = "SELECT * FROM Torneos WHERE id_torneo = $id_torneo";
$result_torneo = $conn->query($sql_torneo);
$torneo = $result_torneo->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_torneo = $_POST['nombre_torneo'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $arbitro = $_POST['arbitro'];
    $vocal = $_POST['vocal'];
    $costo_inscripcion = $_POST['costo_inscripcion'];

    $sql_update = "UPDATE Torneos SET nombre_torneo = '$nombre_torneo', fecha_inicio = '$fecha_inicio', arbitro = '$arbitro', vocal = '$vocal', costo_inscripcion = $costo_inscripcion WHERE id_torneo = $id_torneo";

    if ($conn->query($sql_update) === TRUE) {
        echo "Torneo actualizado con éxito.";
    } else {
        echo "Error: " . $sql_update . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Torneo</title>
</head>
<body>
    <h1>Editar Torneo</h1>

    <?php if ($torneo): ?>
        <form method="POST" action="editar_torneo.php?id_torneo=<?php echo $id_torneo; ?>">
            <label for="nombre_torneo">Nombre del Torneo:</label><br>
            <input type="text" id="nombre_torneo" name="nombre_torneo" value="<?php echo $torneo['nombre_torneo']; ?>" required><br><br>

            <label for="fecha_inicio">Fecha de Inicio:</label><br>
            <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo $torneo['fecha_inicio']; ?>" required><br><br>

            <label for="arbitro">Árbitro:</label><br>
            <input type="text" id="arbitro" name="arbitro" value="<?php echo $torneo['arbitro']; ?>"><br><br>

            <label for="vocal">Vocal:</label><br>
            <input type="text" id="vocal" name="vocal" value="<?php echo $torneo['vocal']; ?>"><br><br>

            <label for="costo_inscripcion">Costo de Inscripción:</label><br>
            <input type="number" id="costo_inscripcion" name="costo_inscripcion" value="<?php echo $torneo['costo_inscripcion']; ?>" required><br><br>

            <input type="submit" value="Guardar Cambios">
        </form>
    <?php else: ?>
        <p>Torneo no encontrado.</p>
    <?php endif; ?>
</body>
</html>