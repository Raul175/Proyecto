USE rolvaHotels;

-- Tabla Localidad
CREATE TABLE Localidad (
    IdLocalidad INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100),
    CodigoPostal VARCHAR(20)
);

-- Tabla Usuario
CREATE TABLE Usuario (
    IdUsuario INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100),
    Apellidos VARCHAR(100),
    Correo VARCHAR(100),
    Contrasena VARCHAR(100),
    DNI VARCHAR(9),
    Sexo VARCHAR(50),
    Domicilio VARCHAR(50),
    FNacimiento DATE,
    Admin ENUM('0','1','2') DEFAULT '0'
);

-- Tabla Hotel
CREATE TABLE Hotel (
    IdHotel INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100),
    Ubicacion VARCHAR(100),
    FK_IdLocalidad INT,
    FK_IdUsuario INT,
    FOREIGN KEY (FK_IdLocalidad) REFERENCES Localidad(IdLocalidad) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (FK_IdUsuario) REFERENCES Usuario(IdUsuario) ON DELETE SET NULL ON UPDATE CASCADE
);

-- Tabla Factura
CREATE TABLE Factura (
    IdFactura INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100),
    Correo VARCHAR(100),
    Precio DECIMAL(10,2)
);

-- Tabla Comentario
CREATE TABLE Comentario (
    IdComentario INT AUTO_INCREMENT PRIMARY KEY,
    NEstrellas INT,
    Fecha DATE,
    Comentario VARCHAR(500)
);

-- Tabla Habitación
CREATE TABLE Habitacion (
    IdHabitacion INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100),
    Tipo VARCHAR(50),
    NPersonas INT,
    PrecioUnitario DECIMAL(10,2),
    m2 DECIMAL(10,2),
    imagen VARCHAR(100),
    NEstrellas INT,
    FK_IdHotel INT,
    Wifi INT,
    Minibar INT,
    CajaFuerte INT,
    FOREIGN KEY (FK_IdHotel) REFERENCES Hotel(IdHotel) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabla Contempla
CREATE TABLE contempla (
    IdComentario INT,
    IdHabitacion INT,
    IdUsuario INT,
    PRIMARY KEY (IdComentario, IdHabitacion, IdUsuario),
    FOREIGN KEY (IdComentario) REFERENCES Comentario(IdComentario) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (IdHabitacion) REFERENCES Habitacion(IdHabitacion) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (IdUsuario) REFERENCES Usuario(IdUsuario) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabla Código Promocional
CREATE TABLE CodigoPromocional (
    IdCodigo INT AUTO_INCREMENT PRIMARY KEY,
    Codigo VARCHAR(50),
    Descuento DECIMAL(5,2)
);

-- Tabla Reserva
CREATE TABLE Reserva (
    IdReserva INT AUTO_INCREMENT PRIMARY KEY,
    IdUsuario INT,
    IdHabitacion INT,
    IdFactura INT,
    FComienzo DATETIME,
    FInicio DATE,
    FFin DATE,
    nombre VARCHAR(50),
    correo VARCHAR(50),
    codigo VARCHAR(50),
    vip VARCHAR(50),
    complemento VARCHAR(50),
    Estado VARCHAR(50),
    Incidencia VARCHAR(500),
    FOREIGN KEY (IdUsuario) REFERENCES Usuario(IdUsuario) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (IdHabitacion) REFERENCES Habitacion(IdHabitacion) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (IdFactura) REFERENCES Factura(IdFactura) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabla Cama
CREATE TABLE Cama (
    IdCama INT AUTO_INCREMENT PRIMARY KEY,
    Tipo VARCHAR(50)
);

-- Tabla intermedia Tiene (Habitacion-Cama)
CREATE TABLE Tiene (
    IdTiene INT AUTO_INCREMENT PRIMARY KEY,
    IdHabitacion INT,
    IdCama INT,
    FOREIGN KEY (IdHabitacion) REFERENCES Habitacion(IdHabitacion) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (IdCama) REFERENCES Cama(IdCama) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabla intermedia Aplica (CodigoPromocional-Habitacion)
CREATE TABLE Aplica (
    IdCodigo INT,
    IdHabitacion INT,
    FInicio DATE,
    FFin DATE,
    PRIMARY KEY (IdCodigo, IdHabitacion),
    FOREIGN KEY (IdCodigo) REFERENCES CodigoPromocional(IdCodigo) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (IdHabitacion) REFERENCES Habitacion(IdHabitacion) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabla Complemento
CREATE TABLE Complemento (
    IdComplemento INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100)
);

-- Subtipos de Habitaciones: VIP y Suite
-- (Asumimos que heredan de Habitacion usando su misma PK)

-- Tabla VIP
CREATE TABLE VIP (
    IdHabitacion INT PRIMARY KEY,
    Codigo VARCHAR(50),
    FOREIGN KEY (IdHabitacion) REFERENCES Habitacion(IdHabitacion) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabla Suite
CREATE TABLE Suite (
    IdHabitacion INT PRIMARY KEY,
    FOREIGN KEY (IdHabitacion) REFERENCES Habitacion(IdHabitacion) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabla intermedia Obtiene (Suite-Habitacion-Complemento)
CREATE TABLE Obtiene (
    IdHabitacion INT,
    IdComplemento INT,
    PRIMARY KEY (IdHabitacion, IdComplemento),
    FOREIGN KEY (IdHabitacion) REFERENCES Suite(IdHabitacion) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (IdComplemento) REFERENCES Complemento(IdComplemento) ON DELETE CASCADE ON UPDATE CASCADE
);
