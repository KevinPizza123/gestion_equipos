<?php
function calcular_clasificacion($id_torneo) {
    global $conn;

    // Obtener los equipos del torneo
    $sql_equipos = "SELECT Equipos.id_equipo, Equipos.nombre_equipo
                    FROM Equipos_Torneos
                    INNER JOIN Equipos ON Equipos_Torneos.id_equipo = Equipos.id_equipo
                    WHERE Equipos_Torneos.id_torneo = $id_torneo";
    $result_equipos = $conn->query($sql_equipos);

    $clasificacion = [];
    while ($row_equipo = $result_equipos->fetch_assoc()) {
        $id_equipo = $row_equipo['id_equipo'];
        $nombre_equipo = $row_equipo['nombre_equipo'];
        $clasificacion[$id_equipo] = ['nombre' => $nombre_equipo, 'puntos' => 0, 'goles_favor' => 0, 'goles_contra' => 0];
    }

    // Obtener los resultados de los partidos
    $sql_partidos = "SELECT id_equipo_local, id_equipo_visitante, goles_local, goles_visitante
                    FROM Partidos
                    WHERE id_torneo = $id_torneo";
    $result_partidos = $conn->query($sql_partidos);

    while ($row_partido = $result_partidos->fetch_assoc()) {
        $id_local = $row_partido['id_equipo_local'];
        $id_visitante = $row_partido['id_equipo_visitante'];
        $goles_local = $row_partido['goles_local'];
        $goles_visitante = $row_partido['goles_visitante'];

        $clasificacion[$id_local]['goles_favor'] += $goles_local;
        $clasificacion[$id_local]['goles_contra'] += $goles_visitante;
        $clasificacion[$id_visitante]['goles_favor'] += $goles_visitante;
        $clasificacion[$id_visitante]['goles_contra'] += $goles_local;

        if ($goles_local > $goles_visitante) {
            $clasificacion[$id_local]['puntos'] += 3;
        } elseif ($goles_local < $goles_visitante) {
            $clasificacion[$id_visitante]['puntos'] += 3;
        } else {
            $clasificacion[$id_local]['puntos'] += 1;
            $clasificacion[$id_visitante]['puntos'] += 1;
        }
    }

    // Ordenar la clasificación por puntos y diferencia de goles
    usort($clasificacion, function ($a, $b) {
        if ($a['puntos'] == $b['puntos']) {
            $diff_a = $a['goles_favor'] - $a['goles_contra'];
            $diff_b = $b['goles_favor'] - $b['goles_contra'];
            return $diff_b <=> $diff_a;
        }
        return $b['puntos'] <=> $a['puntos'];
    });

    return $clasificacion;
}
?>