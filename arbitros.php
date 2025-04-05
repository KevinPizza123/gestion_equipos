<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

// Procesar el formulario de agregar árbitro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_arbitro'])) {
    $nombre_arbitro = $_POST['nombre_arbitro'];
    $descripcion = $_POST['descripcion'];

    $sql_insert = "INSERT INTO Arbitros (nombre_arbitro, descripcion) VALUES ('$nombre_arbitro', '$descripcion')";
    $conn->query($sql_insert);

    echo "Árbitro agregado con éxito.";
}

// Procesar el formulario de editar árbitro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_arbitro'])) {
    $id_arbitro = intval($_POST['id_arbitro']);
    $nombre_arbitro = $_POST['nombre_arbitro'];
    $descripcion = $_POST['descripcion'];

    $sql_update = "UPDATE Arbitros SET nombre_arbitro = '$nombre_arbitro', descripcion = '$descripcion' WHERE id_arbitro = $id_arbitro";
    $conn->query($sql_update);

    echo "Árbitro editado con éxito.";
}

// Procesar la solicitud de eliminar árbitro
if (isset($_GET['eliminar_arbitro'])) {
    $id_arbitro = intval($_GET['eliminar_arbitro']);

    $sql_delete = "DELETE FROM Arbitros WHERE id_arbitro = $id_arbitro";
    $conn->query($sql_delete);

    echo "Árbitro eliminado con éxito.";
}

// Obtener la lista de árbitros
$sql_arbitros = "SELECT * FROM Arbitros";
$result_arbitros = $conn->query($sql_arbitros);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Árbitros</title>
</head>
<body>
    <h1>Gestión de Árbitros</h1>

    <h2>Agregar Árbitro</h2>
    <form method="POST" action="arbitros.php">
        <label for="nombre_arbitro">Nombre:</label>
        <input type="text" name="nombre_arbitro" id="nombre_arbitro"><br><br>

        <label for="descripcion">Descripción:</label><br>
        <textarea name="descripcion" id="descripcion"></textarea><br><br>

        <input type="submit" name="agregar_arbitro" value="Agregar Árbitro">
    </form>

    <h2>Lista de Árbitros</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row_arbitro = $result_arbitros->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row_arbitro['nombre_arbitro']; ?></td>
                    <td><?php echo $row_arbitro['descripcion']; ?></td>
                    <td>
                        <a href="editar_arbitro.php?id_arbitro=<?php echo $row_arbitro['id_arbitro']; ?>">Editar</a>
                        <a href="arbitros.php?eliminar_arbitro=<?php echo $row_arbitro['id_arbitro']; ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar este árbitro?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>