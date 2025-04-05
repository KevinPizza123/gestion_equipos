<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel de Administración</title>
</head>
<body>
    <h1>Bienvenido, Administrador</h1>

    <ul>
        <li><a href="usuarios.php">Gestión de Usuarios</a></li>
        <li><a href="equipos.php">Registrar Equipo</a></li>
        <li><a href="jugadores.php">Registrar Jugador</a></li>
        <li><a href="lista_jugadores.php">Lista de Jugadores</a></li>
        <li><a href="equipos_torneos.php">Asignar Equipos a Torneos</a></li>
        <li><a href="jugadores_torneos.php">Asignar Jugadores a Torneos</a></li>
        <li><a href="admin_torneo.php">Gestionar Torneos</a></li>
        <li><a href="torneos.php">Crear Torneos</a></li>
        <li><a href="partidos.php">Programar Partidos</a></li>
        <li><a href="jugadores_partidos.php">Asignar Jugadores a Partidos</a></li>
        <li><a href="tarjetas_expulsiones.php">Gestionar Tarjetas y Expulsiones</a></li>
        <li><a href="cambios.php">Gestionar Cambios</a></li>
        <li><a href="configuraciones.php">Configuraciones</a></li>
        <li><a href="clasificacion_torneo.php?id_torneo=1">Tabla de Clasificación</a></li>
        <li><a href="enfrentamientos_torneo.php?id_torneo=1">Tabla de Enfrentamientos</a></li>
        <li><a href="vocalias_admin.php">Gestionar Vocalías</a></li>
        <li><a href="mejores_jugadores.php?id_torneo=1">Mejores Jugadores</a></li>
        <li><a href="lista_torneos.php">Lista de Torneos</a></li>
        <li><a href="clasificacion.php">Clasificación</a></li>
        <li><a href="resultados_partidos.php">Resultados de Partidos</a></li>
        <li><a href="informes.php">Informes</a></li>
        <li><a href="calendario_partidos.php">Calendario de Partidos</a></li>
        <li><a href="permisos.php">Gestión de Permisos</a></li>
        <li><a href="lista_equipos.php">Lista de Equipos</a></li>
        <li><a href="arbitros.php">Gestión de Árbitros</a></li>
    </ul>

    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>