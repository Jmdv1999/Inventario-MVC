-- Crear la base de datos
CREATE DATABASE `inventario-mvc`;

-- Usar la base de datos
USE `inventario-mvc`;

-- Crear la tabla caja
CREATE TABLE caja (
    id INT AUTO_INCREMENT PRIMARY KEY,
    caja VARCHAR(255) NOT NULL,
    estado INT DEFAULT 1
);

-- Crear la tabla cierre_caja
CREATE TABLE cierre_caja (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    estado INT DEFAULT 1,
    fecha DATE NOT NULL,
    hora TIME NOT NULL
);

-- Crear la tabla ventas
CREATE TABLE ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    cliente INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    estado INT DEFAULT 1
);

-- Crear la tabla categorias
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    estado INT DEFAULT 1
);

-- Crear la tabla permisos
CREATE TABLE permisos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    permiso VARCHAR(255) NOT NULL
);

-- Crear la tabla detalle_permisos
CREATE TABLE detalle_permisos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_permiso INT NOT NULL,
    FOREIGN KEY (id_permiso) REFERENCES permisos(id)
);

-- Crear la tabla clientes
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cedula VARCHAR(255) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    telefono VARCHAR(255) NOT NULL,
    direccion TEXT NOT NULL,
    estado INT DEFAULT 1
);

-- Crear la tabla productos
CREATE TABLE productos (
	id INT(10) NOT NULL AUTO_INCREMENT,
	codigo VARCHAR(255) NOT NULL,
	descripcion TEXT NOT NULL,
	precio_compra DECIMAL(10,2) NOT NULL,
	precio_venta DECIMAL(10,2) NOT NULL,
	id_categoria INT(10) NOT NULL,
	foto VARCHAR(255) NULL DEFAULT NULL,
	cantidad INT(10) NULL DEFAULT '0',
	estado INT(10) NULL DEFAULT '1',
    FOREIGN KEY (id_categoria) REFERENCES categorias(id)
);

-- Crear la tabla detalles_temp_compras
CREATE TABLE detalles_temp_compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_producto INT NOT NULL,
    id_usuario INT NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    cantidad INT NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_producto) REFERENCES productos(id)
);

-- Crear la tabla compras
CREATE TABLE compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    total DECIMAL(10, 2) NOT NULL,
    estado INT DEFAULT 1
);

-- Crear la tabla detalles_compra
CREATE TABLE detalles_compra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_compra INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_compra) REFERENCES compras(id),
    FOREIGN KEY (id_producto) REFERENCES productos(id)
);

-- Crear la tabla detalles_temp_ventas
CREATE TABLE detalles_temp_ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_producto INT NOT NULL,
    id_usuario INT NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    cantidad INT NOT NULL,
    descuento DECIMAL(10, 2),
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_producto) REFERENCES productos(id)
);

-- Crear la tabla detalles_venta
CREATE TABLE detalles_venta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_venta INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    descuento DECIMAL(10, 2) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_venta) REFERENCES ventas(id),
    FOREIGN KEY (id_producto) REFERENCES productos(id)
);

-- Crear la tabla configuracion
CREATE TABLE configuracion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rif VARCHAR(255) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    telefono VARCHAR(255) NOT NULL,
    correo VARCHAR(255) NOT NULL,
    direccion TEXT NOT NULL,
    mensaje TEXT NOT NULL
);

-- Crear la tabla usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(255) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    clave VARCHAR(255) NOT NULL,
    id_caja INT,
    estado INT DEFAULT 1,
    FOREIGN KEY (id_caja) REFERENCES caja(id)
);
