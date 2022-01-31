CREATE DATABASE fototienda CHARACTER SET 'UTF8' COLLATE 'utf8_general_ci';



CREATE TABLE clientes(
idCliente SMALLINT unsigned NOT NULL AUTO_INCREMENT,
correo VARCHAR(50) NOT NULL,
nombre VARCHAR(40)	NOT NULL,
password VARCHAR(255) NOT NULL,
telefono int(10),
PRIMARY KEY (idCliente)

);
CREATE TABLE pedidos(
idPedido SMALLINT unsigned NOT NULL AUTO_INCREMENT,
idCliente SMALLINT unsigned NOT NULL,
fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY(idPedido),
FOREIGN KEY (idCliente) REFERENCES clientes(idCliente)    
);