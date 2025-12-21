-- Base de datos para la gestión de asistentes a un evento
CREATE TABLE zonas (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    cupo_maximo INT(11) NOT NULL
) ENGINE = InnoDB;
INSERT INTO zonas (nombre, cupo_maximo)
VALUES ('Zona Campo A', 100),
    ('Zona Campo B', 150);
CREATE TABLE asistentes (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    codigo_alumno VARCHAR(20) NOT NULL UNIQUE,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    dni VARCHAR(15) NOT NULL,
    carrera VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    id_zona INT(11) NOT NULL,
    token_unico VARCHAR(255) NOT NULL,
    estado_ingreso ENUM('Pendiente', 'Ingresó') DEFAULT 'Pendiente',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_zona) REFERENCES zonas(id)
) ENGINE = InnoDB;
CREATE TABLE usuarios_admin (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
) ENGINE = InnoDB;
INSERT INTO usuarios_admin (usuario, password)
VALUES ('admin', '1234');