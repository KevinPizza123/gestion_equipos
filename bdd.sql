-- Estructura de la tabla Usuarios
CREATE TABLE Usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'equipo', 'jugador') NOT NULL
);

-- Estructura de la tabla Equipos
CREATE TABLE Equipos (
    id_equipo INT AUTO_INCREMENT PRIMARY KEY,
    nombre_equipo VARCHAR(100) NOT NULL UNIQUE,
    categoria ENUM('Mujeres', 'Hombres') NULL,
    lider VARCHAR(100) NULL,
    fecha_creacion DATE NULL,
    ubicacion VARCHAR(100) NULL,
    descripcion_equipo TEXT NULL
);

-- Estructura de la tabla Jugadores
CREATE TABLE Jugadores (
    id_jugador INT AUTO_INCREMENT PRIMARY KEY,
    id_equipo INT,
    nombre_jugador VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE NULL,
    posicion VARCHAR(50) NULL,
    FOREIGN KEY (id_equipo) REFERENCES Equipos(id_equipo)
);

-- Estructura de la tabla Torneos
CREATE TABLE Torneos (
    id_torneo INT AUTO_INCREMENT PRIMARY KEY,
    nombre_torneo VARCHAR(100) NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NULL,
    arbitro VARCHAR(100) NULL,
    vocal VARCHAR(100) NULL,
    costo_inscripcion DECIMAL(10, 2) NULL
);

-- Estructura de la tabla Partidos
CREATE TABLE Partidos (
    id_partido INT AUTO_INCREMENT PRIMARY KEY,
    id_torneo INT,
    id_equipo_local INT,
    id_equipo_visitante INT,
    fecha_partido DATETIME,
    id_arbitro INT NULL, -- Puedes crear una tabla de árbitros si es necesario
    id_equipo_vocalia INT NULL,
    observaciones TEXT NULL,
    pago_vocalia DECIMAL(10, 2) DEFAULT 0,
    goles_local INT DEFAULT 0,
    goles_visitante INT DEFAULT 0,
    FOREIGN KEY (id_torneo) REFERENCES Torneos(id_torneo),
    FOREIGN KEY (id_equipo_local) REFERENCES Equipos(id_equipo),
    FOREIGN KEY (id_equipo_visitante) REFERENCES Equipos(id_equipo),
    FOREIGN KEY (id_equipo_vocalia) REFERENCES Equipos(id_equipo)
);

-- Estructura de la tabla Equipos_Torneos (Relación muchos a muchos entre Equipos y Torneos)
CREATE TABLE Equipos_Torneos (
    id_equipos_torneos INT AUTO_INCREMENT PRIMARY KEY,
    id_torneo INT,
    id_equipo INT,
    FOREIGN KEY (id_torneo) REFERENCES Torneos(id_torneo),
    FOREIGN KEY (id_equipo) REFERENCES Equipos(id_equipo),
    UNIQUE KEY equipo_torneo (id_torneo, id_equipo)
);

-- Estructura de la tabla Arbitros (Opcional, si quieres gestionar árbitros en una tabla separada)
CREATE TABLE Arbitros (
    id_arbitro INT AUTO_INCREMENT PRIMARY KEY,
    nombre_arbitro VARCHAR(100) NOT NULL
);

-- Estructura de la tabla Goles
CREATE TABLE Goles (
    id_gol INT AUTO_INCREMENT PRIMARY KEY,
    id_partido INT,
    id_jugador INT,
    minuto_gol INT NULL,
    FOREIGN KEY (id_partido) REFERENCES Partidos(id_partido),
    FOREIGN KEY (id_jugador) REFERENCES Jugadores(id_jugador)
);

-- Estructura de la tabla Tarjetas
CREATE TABLE Tarjetas (
    id_tarjeta INT AUTO_INCREMENT PRIMARY KEY,
    id_partido INT,
    id_jugador INT,
    tipo_tarjeta ENUM('amarilla', 'roja') NOT NULL,
    minuto_tarjeta INT NULL,
    FOREIGN KEY (id_partido) REFERENCES Partidos(id_partido),
    FOREIGN KEY (id_jugador) REFERENCES Jugadores(id_jugador)
);

-- Estructura de la tabla Cambios
CREATE TABLE Cambios (
    id_cambio INT AUTO_INCREMENT PRIMARY KEY,
    id_partido INT,
    id_jugador_entra INT,
    id_jugador_sale INT,
    minuto_cambio INT NULL,
    FOREIGN KEY (id_partido) REFERENCES Partidos(id_partido),
    FOREIGN KEY (id_jugador_entra) REFERENCES Jugadores(id_jugador),
    FOREIGN KEY (id_jugador_sale) REFERENCES Jugadores(id_jugador)
);

-- Estructura de la tabla Jugadores_Partidos (Relación para indicar qué jugadores participan en qué partido)
CREATE TABLE Jugadores_Partidos (
    id_jugador_partido INT AUTO_INCREMENT PRIMARY KEY,
    id_partido INT,
    id_jugador INT,
    FOREIGN KEY (id_partido) REFERENCES Partidos(id_partido),
    FOREIGN KEY (id_jugador) REFERENCES Jugadores(id_jugador),
    UNIQUE KEY jugador_partido (id_partido, id_jugador)
);

-- Estructura de la tabla Vocalias (Opcional, si quieres gestionar las asignaciones de vocalía por separado)
CREATE TABLE Vocalias (
    id_vocal INT AUTO_INCREMENT PRIMARY KEY,
    id_partido INT UNIQUE,
    id_equipo_vocal INT,
    FOREIGN KEY (id_partido) REFERENCES Partidos(id_partido),
    FOREIGN KEY (id_equipo_vocal) REFERENCES Equipos(id_equipo)
);