<?php
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

// Ejemplo de uso:
// generar_partidos(1); // Genera partidos para el torneo con ID 1
?>