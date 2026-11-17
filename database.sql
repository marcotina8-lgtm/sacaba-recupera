-- Script de Base de Datos para SACABA RECUPERA (PHP + MySQL)
-- Nota: En hostings gratuitos como InfinityFree, primero creas la BD desde su panel
-- y luego seleccionas esa BD en phpMyAdmin antes de importar este archivo.

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS reportes;
DROP TABLE IF EXISTS usuarios;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. Tabla de Usuarios
CREATE TABLE usuarios (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('ciudadano', 'conductor', 'admin') NOT NULL DEFAULT 'ciudadano',
    creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uk_usuarios_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Tabla de Reportes de Pérdidas y Hallazgos
CREATE TABLE reportes (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    usuario_id INT UNSIGNED NOT NULL,
    tipo ENUM('perdida', 'hallazgo') NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    categoria ENUM('documento', 'objeto', 'celular', 'billetera', 'otro') NOT NULL,
    descripcion TEXT NOT NULL,
    lugar_ruta VARCHAR(150) NOT NULL,
    fecha_evento DATE NOT NULL,
    imagen VARCHAR(255) DEFAULT NULL,
    estado ENUM('perdido', 'encontrado', 'en_verificacion', 'devuelto') NOT NULL DEFAULT 'perdido',
    creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_reportes_usuario_id (usuario_id),
    CONSTRAINT fk_reportes_usuario
        FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Usuario Administrador por defecto
-- Correo: admin@sacabarecupera.com
-- Contraseña: admin123
INSERT INTO usuarios (nombre, email, telefono, password, rol) VALUES (
    'Administrador Sacaba',
    'admin@sacabarecupera.com',
    '70000000',
    '$2y$10$3sR7bAkybYy168Q2rFq8uepC71c5zC/yEwQ9E8iOskT.L56hZpL2a',
    'admin'
);