CREATE DATABASE fototienda CHARACTER SET 'UTF8' COLLATE 'utf8_general_ci';



CREATE TABLE clientes(
idCliente TINYINT unsigned NOT NULL AUTO_INCREMENT,
correo VARCHAR(50) NOT NULL,
nombre VARCHAR(40)	NOT NULL,
password VARCHAR(80) NOT NULL,
telefono int(10),
PRIMARY KEY (idCliente)

);
CREATE TABLE pedidos(
idPedido TINYINT unsigned NOT NULL AUTO_INCREMENT,
idCliente TINYINT unsigned NOT NULL,
fecha DATE NOT NULL,
rutaImgCarpeta VARCHAR(20) NOT NULL,
PRIMARY KEY(idPedido),
FOREIGN KEY (idCliente) REFERENCES clientes(idCliente)    
);