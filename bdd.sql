-- Crear la base de datos (si no existe)
--CREATE DATABASE IF NOT EXISTS equipos_db;

-- Usar la base de datos
--USE equipos_db;

-- Tabla Equipos
CREATE TABLE IF NOT EXISTS Equipos (
    id_equipo INT AUTO_INCREMENT PRIMARY KEY,
    nombre_equipo VARCHAR(255) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    lider VARCHAR(255) NOT NULL,
    fecha_creacion DATE NOT NULL,
    ubicacion VARCHAR(255) NOT NULL
);

-- Tabla Jugadores
CREATE TABLE IF NOT EXISTS Jugadores (
    id_jugador INT AUTO_INCREMENT PRIMARY KEY,
    nombre_jugador VARCHAR(255) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    beca BOOLEAN NOT NULL,
    id_equipo INT,
    FOREIGN KEY (id_equipo) REFERENCES Equipos(id_equipo)
);

-- Tabla Torneos
CREATE TABLE IF NOT EXISTS Torneos (
    id_torneo INT AUTO_INCREMENT PRIMARY KEY,
    nombre_torneo VARCHAR(255) NOT NULL,
    fecha_inicio DATE NOT NULL,
    arbitro VARCHAR(255),
    vocal VARCHAR(255),
    costo_inscripcion DECIMAL(10, 2)
);

-- Tabla Equipos_Torneos (Relación muchos a muchos)
CREATE TABLE IF NOT EXISTS Equipos_Torneos (
    id_equipo INT,
    id_torneo INT,
    PRIMARY KEY (id_equipo, id_torneo),
    FOREIGN KEY (id_equipo) REFERENCES Equipos(id_equipo),
    FOREIGN KEY (id_torneo) REFERENCES Torneos(id_torneo)
);

-- Tabla Jugadores_Torneos (Relación muchos a muchos)
CREATE TABLE IF NOT EXISTS Jugadores_Torneos (
    id_jugador INT,
    id_torneo INT,
    tarjetas_rojas INT DEFAULT 0,
    expulsiones INT DEFAULT 0,
    PRIMARY KEY (id_jugador, id_torneo),
    FOREIGN KEY (id_jugador) REFERENCES Jugadores(id_jugador),
    FOREIGN KEY (id_torneo) REFERENCES Torneos(id_torneo)
);

-- Tabla Configuraciones
CREATE TABLE IF NOT EXISTS Configuraciones (
    id_configuracion INT AUTO_INCREMENT PRIMARY KEY,
    categoria VARCHAR(50) NOT NULL,
    costo_tarjeta_roja DECIMAL(10, 2) NOT NULL,
    costo_expulsion DECIMAL(10, 2) NOT NULL
);

-- Tabla Partidos
CREATE TABLE IF NOT EXISTS Partidos (
    id_partido INT AUTO_INCREMENT PRIMARY KEY,
    id_torneo INT,
    id_equipo_local INT,
    id_equipo_visitante INT,
    fecha_partido DATETIME,
    goles_local INT DEFAULT 0,
    goles_visitante INT DEFAULT 0,
    FOREIGN KEY (id_torneo) REFERENCES Torneos(id_torneo),
    FOREIGN KEY (id_equipo_local) REFERENCES Equipos(id_equipo),
    FOREIGN KEY (id_equipo_visitante) REFERENCES Equipos(id_equipo)
);

-- Tabla Jugadores_Partidos
CREATE TABLE IF NOT EXISTS Jugadores_Partidos (
    id_jugador INT,
    id_partido INT,
    titular BOOLEAN,
    minuto_ingreso INT,
    minuto_salida INT,
    goles INT DEFAULT 0,
    tarjetas_rojas INT DEFAULT 0,
    PRIMARY KEY (id_jugador, id_partido),
    FOREIGN KEY (id_jugador) REFERENCES Jugadores(id_jugador),
    FOREIGN KEY (id_partido) REFERENCES Partidos(id_partido)
);

-- Tabla Vocalia
CREATE TABLE IF NOT EXISTS Vocalia (
    id_vocalia INT AUTO_INCREMENT PRIMARY KEY,
    id_partido INT,
    total_tarjetas_rojas INT DEFAULT 0,
    total_expulsiones INT DEFAULT 0,
    total_goles INT DEFAULT 0,
    otros_detalles TEXT,
    FOREIGN KEY (id_partido) REFERENCES Partidos(id_partido)
);

-- Tabla Cambios
CREATE TABLE IF NOT EXISTS Cambios (
    id_cambio INT AUTO_INCREMENT PRIMARY KEY,
    id_partido INT,
    jugador_entra INT,
    jugador_sale INT,
    minuto_cambio INT,
    FOREIGN KEY (id_partido) REFERENCES Partidos(id_partido),
    FOREIGN KEY (jugador_entra) REFERENCES Jugadores(id_jugador),
    FOREIGN KEY (jugador_sale) REFERENCES Jugadores(id_jugador)
);

-- Tabla Usuarios
CREATE TABLE IF NOT EXISTS Usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(255) NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    rol VARCHAR(50) NOT NULL, -- 'admin' o 'equipo'
    id_equipo INT, -- NULL si es admin
    FOREIGN KEY (id_equipo) REFERENCES Equipos(id_equipo)
);