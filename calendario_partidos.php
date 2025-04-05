<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

// Obtener la lista de partidos
$sql_partidos = "SELECT Partidos.id_partido, Partidos.fecha_partido, EquiposLocal.nombre_equipo AS local, EquiposVisitante.nombre_equipo AS visitante
                FROM Partidos
                INNER JOIN Equipos EquiposLocal ON Partidos.id_equipo_local = EquiposLocal.id_equipo
                INNER JOIN Equipos EquiposVisitante ON Partidos.id_equipo_visitante = EquiposVisitante.id_equipo";
$result_partidos = $conn->query($sql_partidos);

// Procesar la solicitud de eliminar partido
if (isset($_GET['eliminar_partido'])) {
    $id_partido = intval($_GET['eliminar_partido']);

    $sql_delete = "DELETE FROM Partidos WHERE id_partido = $id_partido";
    $conn->query($sql_delete);

    echo "Partido eliminado con éxito.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Calendario de Partidos</title>
</head>
<body>
    <h1>Calendario de Partidos</h1>

    <?php if ($result_partidos->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Fecha y Hora</th>
                    <th>Local</th>
                    <th>Visitante</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row_partido = $result_partidos->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row_partido['fecha_partido']; ?></td>
                        <td><?php echo $row_partido['local']; ?></td>
                        <td><?php echo $row_partido['visitante']; ?></td>
                        <td>
                            <a href="editar_partido.php?id_partido=<?php echo $row_partido['id_partido']; ?>">Editar</a>
                            <a href="calendario_partidos.php?eliminar_partido=<?php echo $row_partido['id_partido']; ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar este partido?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay partidos programados.</p>
    <?php endif; ?>
</body>
</html>