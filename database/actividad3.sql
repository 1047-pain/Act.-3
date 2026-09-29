CREATE DATABASE IF NOT EXISTS actividad3_web2 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE actividad3_web2;
DROP TABLE IF EXISTS productos; DROP TABLE IF EXISTS usuarios; DROP TABLE IF EXISTS roles;
CREATE TABLE roles (id INT AUTO_INCREMENT PRIMARY KEY,nombre_rol VARCHAR(50) NOT NULL UNIQUE,descripcion VARCHAR(255) NULL);
CREATE TABLE usuarios (id INT AUTO_INCREMENT PRIMARY KEY,usuario VARCHAR(50) NOT NULL UNIQUE,email VARCHAR(120) NOT NULL UNIQUE,password_hash VARCHAR(255) NOT NULL,rol_id INT NOT NULL,estado TINYINT(1) NOT NULL DEFAULT 1,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,CONSTRAINT fk_usuario_rol FOREIGN KEY(rol_id) REFERENCES roles(id));
CREATE TABLE productos (id INT AUTO_INCREMENT PRIMARY KEY,nombre VARCHAR(120) NOT NULL,descripcion VARCHAR(255) NULL,categoria VARCHAR(50) NOT NULL,precio DECIMAL(12,2) NOT NULL,cantidad INT NOT NULL DEFAULT 0,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,INDEX idx_categoria(categoria),INDEX idx_nombre(nombre));
INSERT INTO roles(nombre_rol,descripcion) VALUES ('Administrador','Acceso total al sistema, usuarios, CRUD y reportes'),('Usuario','Consulta y exportación de informes');
INSERT INTO usuarios(usuario,email,password_hash,rol_id,estado) VALUES
('admin','admin@proyectoweb.local','$2y$12$OwMnz.aIJAxr/4dV.IZRg.QXpKU6jqTSYptIteIltIF7hrUXA8LrK',1,1),
('usuario','usuario@proyectoweb.local','$2y$12$nRG34Uwz1csueK.IxDuB1OlqxYlSdHuPfrUWs2ep4f7N5GILEuW8K',2,1);
INSERT INTO productos(nombre,descripcion,categoria,precio,cantidad) VALUES
('Laptop Pro','Equipo portátil','Tecnología',3500000,8),('Monitor 24"','Pantalla Full HD','Tecnología',850000,12),('Teclado Mecánico','Teclado RGB','Accesorios',280000,20),('Mouse Inalámbrico','Conexión Bluetooth','Accesorios',120000,35),('Silla Ergonómica','Silla de oficina','Oficina',620000,10),('Escritorio','Escritorio modular','Oficina',980000,6),('Webcam HD','Cámara para videollamadas','Tecnología',210000,15),('Audífonos','Audio con micrófono','Accesorios',175000,18),('Archivador','Archivador metálico','Oficina',390000,7),('Tablet','Dispositivo portátil','Tecnología',1250000,9);
