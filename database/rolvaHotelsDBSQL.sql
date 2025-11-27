USE rolvaHotels;

CREATE TABLE `Localidad` (
  `IdLocalidad` INT PRIMARY KEY AUTO_INCREMENT,
  `Nombre` VARCHAR(100),
  `CodigoPostal` VARCHAR(20)
);

CREATE TABLE `Hotel` (
  `IdHotel` INT PRIMARY KEY AUTO_INCREMENT,
  `Nombre` VARCHAR(100),
  `Ubicacion` VARCHAR(100),
  `FK_IdLocalidad` INT,
  `FK_IdUsuario` INT
);

CREATE TABLE `Usuario` (
  `IdUsuario` INT PRIMARY KEY AUTO_INCREMENT,
  `Nombre` VARCHAR(100),
  `Apellidos` VARCHAR(100),
  `Correo` VARCHAR(100),
  `Contrasena` VARCHAR(100),
  `DNI` VARCHAR(9),
  `Sexo` VARCHAR(50),
  `Admin` ENUM ('0', '1', '2') DEFAULT '0'
);

CREATE TABLE `Cliente` (
  `IdUsuario` INT PRIMARY KEY,
  `Domicilio` VARCHAR(50),
  `FNacimiento` DATE
);

CREATE TABLE `Administrador` (
  `IdUsuario` INT PRIMARY KEY
);

CREATE TABLE `Gerente` (
  `IdUsuario` INT PRIMARY KEY,
  `FNacimiento` DATE
);

CREATE TABLE `Factura` (
  `IdFactura` INT PRIMARY KEY AUTO_INCREMENT,
  `Nombre` VARCHAR(100),
  `Correo` VARCHAR(100),
  `Precio` DECIMAL(10,2)
);

CREATE TABLE `Comentario` (
  `IdComentario` INT PRIMARY KEY AUTO_INCREMENT,
  `NEstrellas` INT,
  `Fecha` DATE,
  `Comentario` VARCHAR(500)
);

CREATE TABLE `Habitacion` (
  `IdHabitacion` INT PRIMARY KEY AUTO_INCREMENT,
  `Nombre` VARCHAR(100),
  `Tipo` VARCHAR(50),
  `NPersonas` INT,
  `PrecioUnitario` DECIMAL(10,2),
  `m2` DECIMAL(10,2),
  `imagen` VARCHAR(100),
  `NEstrellas` INT,
  `FK_IdHotel` INT,
  `Wifi` INT,
  `Minibar` INT,
  `CajaFuerte` INT
);

CREATE TABLE `contempla` (
  `IdComentario` INT,
  `IdHabitacion` INT,
  `IdUsuario` INT,
  PRIMARY KEY (`IdComentario`, `IdHabitacion`, `IdUsuario`)
);

CREATE TABLE `CodigoPromocional` (
  `IdCodigo` INT PRIMARY KEY AUTO_INCREMENT,
  `Codigo` VARCHAR(50),
  `Descuento` DECIMAL(5,2)
);

CREATE TABLE `Reserva` (
  `IdReserva` INT PRIMARY KEY AUTO_INCREMENT,
  `IdUsuario` INT,
  `IdHabitacion` INT,
  `IdFactura` INT,
  `FComienzo` DATETIME,
  `FInicio` DATE,
  `FFin` DATE,
  `nombre` VARCHAR(50),
  `correo` VARCHAR(50),
  `codigo` VARCHAR(50),
  `vip` VARCHAR(50),
  `complemento` VARCHAR(50),
  `Estado` VARCHAR(50),
  `Incidencia` VARCHAR(500)
);

CREATE TABLE `Cama` (
  `IdCama` INT PRIMARY KEY AUTO_INCREMENT,
  `Tipo` VARCHAR(50)
);

CREATE TABLE `Tiene` (
  `IdTiene` INT PRIMARY KEY AUTO_INCREMENT,
  `IdHabitacion` INT,
  `IdCama` INT
);

CREATE TABLE `Aplica` (
  `IdCodigo` INT,
  `IdHabitacion` INT,
  `FInicio` DATE,
  `FFin` DATE,
  PRIMARY KEY (`IdCodigo`, `IdHabitacion`)
);

CREATE TABLE `Complemento` (
  `IdComplemento` INT PRIMARY KEY AUTO_INCREMENT,
  `Nombre` VARCHAR(100)
);

CREATE TABLE `VIP` (
  `IdHabitacion` INT PRIMARY KEY,
  `Codigo` VARCHAR(50)
);

CREATE TABLE `Suite` (
  `IdHabitacion` INT PRIMARY KEY
);

CREATE TABLE `Obtiene` (
  `IdHabitacion` INT,
  `IdComplemento` INT,
  PRIMARY KEY (`IdHabitacion`, `IdComplemento`)
);

ALTER TABLE `Hotel` ADD FOREIGN KEY (`FK_IdLocalidad`) REFERENCES `Localidad` (`IdLocalidad`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Hotel` ADD FOREIGN KEY (`FK_IdUsuario`) REFERENCES `Gerente` (`IdUsuario`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `Cliente` ADD FOREIGN KEY (`IdUsuario`) REFERENCES `Usuario` (`IdUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Gerente` ADD FOREIGN KEY (`IdUsuario`) REFERENCES `Usuario` (`IdUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Administrador` ADD FOREIGN KEY (`IdUsuario`) REFERENCES `Usuario` (`IdUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Habitacion` ADD FOREIGN KEY (`FK_IdHotel`) REFERENCES `Hotel` (`IdHotel`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `contempla` ADD FOREIGN KEY (`IdComentario`) REFERENCES `Comentario` (`IdComentario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `contempla` ADD FOREIGN KEY (`IdHabitacion`) REFERENCES `Habitacion` (`IdHabitacion`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `contempla` ADD FOREIGN KEY (`IdUsuario`) REFERENCES `Usuario` (`IdUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Reserva` ADD FOREIGN KEY (`IdUsuario`) REFERENCES `Cliente` (`IdUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Reserva` ADD FOREIGN KEY (`IdHabitacion`) REFERENCES `Habitacion` (`IdHabitacion`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Reserva` ADD FOREIGN KEY (`IdFactura`) REFERENCES `Factura` (`IdFactura`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Tiene` ADD FOREIGN KEY (`IdHabitacion`) REFERENCES `Habitacion` (`IdHabitacion`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Tiene` ADD FOREIGN KEY (`IdCama`) REFERENCES `Cama` (`IdCama`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Aplica` ADD FOREIGN KEY (`IdCodigo`) REFERENCES `CodigoPromocional` (`IdCodigo`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Aplica` ADD FOREIGN KEY (`IdHabitacion`) REFERENCES `Habitacion` (`IdHabitacion`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `VIP` ADD FOREIGN KEY (`IdHabitacion`) REFERENCES `Habitacion` (`IdHabitacion`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Suite` ADD FOREIGN KEY (`IdHabitacion`) REFERENCES `Habitacion` (`IdHabitacion`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Obtiene` ADD FOREIGN KEY (`IdHabitacion`) REFERENCES `Suite` (`IdHabitacion`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Obtiene` ADD FOREIGN KEY (`IdComplemento`) REFERENCES `Complemento` (`IdComplemento`) ON DELETE CASCADE ON UPDATE CASCADE;
