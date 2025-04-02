<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

// Obtener la lista de jugadores
$sql_jugadores = "SELECT id_jugador, nombre_jugador, posicion, numero_camiseta, fecha_nacimiento FROM Jugadores";
$result_jugadores = $conn->query($sql_jugadores);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Jugadores</title>
</head>
<body>
    <h1>Lista de Jugadores</h1>

    <?php if ($result_jugadores->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Posición</th>
                    <th>Número de Camiseta</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row_jugador = $result_jugadores->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row_jugador['id_jugador']; ?></td>
                        <td><?php echo $row_jugador['nombre_jugador']; ?></td>
                        <td><?php echo $row_jugador['posicion']; ?></td>
                        <td><?php echo $row_jugador['numero_camiseta']; ?></td>
                        <td><?php echo $row_jugador['fecha_nacimiento']; ?></td>
                        <td>
                            <a href="editar_jugador.php?id_jugador=<?php echo $row_jugador['id_jugador']; ?>">Editar</a> |
                            <a href="eliminar_jugador.php?id_jugador=<?php echo $row_jugador['id_jugador']; ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay jugadores registrados.</p>
    <?php endif; ?>
</body>
</html>