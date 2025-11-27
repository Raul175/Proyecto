-- Insert de datos de las localidades
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Álava', '01000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Albacete', '02000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Alicante', '03000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Almería', '04000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Ávila', '05000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Badajoz', '06000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Baleares', '07000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Barcelona', '08000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Burgos', '09000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Cáceres', '10000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Cádiz', '11000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Castellón', '12000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Ceuta', '51000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Ciudad Real', '13000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Córdoba', '14000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('La Coruña', '15000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('La Rioja', '26000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Cuenca', '16000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Gerona', '17000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Granada', '18000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Guadalajara', '19000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Gipuzkoa', '20000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Huelva', '21000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Huesca', '22000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Jaén', '23000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('León', '24000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Lérida', '25000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Lugo', '27000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Madrid', '28000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Málaga', '29000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Melilla', '52000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Murcia', '30000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Navarra', '31000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Orense', '32000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Las Palmas', '35000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Asturias', '33000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Cantabria', '39000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Palencia', '34000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Pontevedra', '36000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Salamanca', '37000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Santa Cruz de Tenerife', '38000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Segovia', '40000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Sevilla', '41000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Soria', '42000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Tarragona', '43000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Teruel', '44000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Toledo', '45000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Valencia', '46000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Valladolid', '47000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Bizkaia', '48000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Zamora', '49000');
INSERT INTO Localidad (Nombre, CodigoPostal) VALUES ('Zaragoza', '50000');

-- Usuarios
INSERT INTO Usuario (nombre, apellidos, correo, contrasena, dni, sexo, admin) VALUES ('admin123', 'admin admin', 'admin@rolvahotels.com', SHA2('admin@3000', 256), '29292929W', 'hombre', 1);
INSERT INTO Usuario (nombre, apellidos, correo, contrasena, dni, sexo, admin) VALUES ('raul', 'gonzalez alvarez', 'raul@rolvahotels.com', SHA2('raul$123', 256), '29292921J', 'hombre', 1);
INSERT INTO Usuario (nombre, apellidos, correo, contrasena, dni, sexo, admin) VALUES ('gerente123', 'gerente gerente', 'gerente@rolvahotels.com', SHA2('gerente$123', 256), '29292921J', 'hombre', 2);
INSERT INTO Usuario (nombre, apellidos, correo, contrasena, dni, sexo, admin) VALUES ('Carlos', 'Gomez Perez', 'carlos.gomez@gmail.com', SHA2('carlos123', 256), '12345678A', 'hombre', 0);
INSERT INTO Usuario (nombre, apellidos, correo, contrasena, dni, sexo, admin) VALUES ('Lucia', 'Martínez Ruiz', 'lucia.martinez@gmail.com', SHA2('lucia123', 256), '87654321B', 'mujer', 0);
INSERT INTO Usuario (nombre, apellidos, correo, contrasena, dni, sexo, admin) VALUES ('Juan', 'Perez Garcia', 'juan.perez@gmail.com', SHA2('pass123', 256), '12345678A', 'hombre', 0);
INSERT INTO Usuario (nombre, apellidos, correo, contrasena, dni, sexo, admin) VALUES ('Ana', 'Lopez Martin', 'ana.lopez@gmail.com', SHA2('pass123', 256), '87654321B', 'mujer', 0);
INSERT INTO Usuario (nombre, apellidos, correo, contrasena, dni, sexo, admin) VALUES ('Carlos', 'Sánchez Ruiz', 'carlos.sanchez@gmail.com', SHA2('pass123', 256), '11223344C', 'hombre', 0);
INSERT INTO Usuario (nombre, apellidos, correo, contrasena, dni, sexo, admin) VALUES ('pepe', 'pepito pepito', 'pepito123@gmail.com', SHA2('pepito_1', 256), '11222344C', 'hombre', 2);
-- Clientes
INSERT INTO Cliente (idUsuario, domicilio, FNacimiento) VALUES (4, 'Calle Mayor 12', '1990-05-10');
INSERT INTO Cliente (idUsuario, domicilio, FNacimiento) VALUES (5, 'Avda. Andalucía 34', '1995-08-15');
INSERT INTO Cliente (idUsuario, domicilio, FNacimiento) VALUES (6, 'Calle Falsa 123', '1985-05-12');
INSERT INTO Cliente (idUsuario, domicilio, FNacimiento) VALUES (7, 'Av. Siempre Viva 742', '1990-10-01');
INSERT INTO Cliente (idUsuario, domicilio, FNacimiento) VALUES (8, 'Paseo de la Reforma 10', '1978-03-22');
-- Gerentes
INSERT INTO Gerente (idUsuario, FNacimiento) VALUES (3, '2005-12-20');
INSERT INTO Gerente (idUsuario, FNacimiento) VALUES (9, '1971-03-22');
-- Admins
INSERT INTO Administrador (idUsuario) VALUES (1);
INSERT INTO Administrador (idUsuario) VALUES (2);

-- Insert de datos hoteles
INSERT INTO Hotel (Nombre, Ubicacion, FK_IdLocalidad, FK_IdUsuario) VALUES ('Hotel Mirador', 'Calle Mayor 12', 1, 3); -- alava
INSERT INTO Hotel (Nombre, Ubicacion, FK_IdLocalidad, FK_IdUsuario) VALUES ('Gran Hotel Castilla', 'Avenida del Rey 45', 2, 3); -- Albacete
INSERT INTO Hotel (Nombre, Ubicacion, FK_IdLocalidad, FK_IdUsuario) VALUES ('Hotel Sol y Mar', 'Paseo Maritimo 5', 3, 9); -- Alicante
INSERT INTO Hotel (Nombre, Ubicacion, FK_IdLocalidad, FK_IdUsuario) VALUES ('Hotel Costa Azul', 'Plaza del Puerto 7', 7, 3); -- Baleares
INSERT INTO Hotel (Nombre, Ubicacion, FK_IdLocalidad, FK_IdUsuario) VALUES ('Hotel Serrano', 'Calle Real 90', 14, 9); -- Cordoba
INSERT INTO Hotel (Nombre, Ubicacion, FK_IdLocalidad, FK_IdUsuario) VALUES ('Hotel del Norte', 'Av. de la Montaña 3', 9, 9); -- Burgos
INSERT INTO Hotel (Nombre, Ubicacion, FK_IdLocalidad, FK_IdUsuario) VALUES ('Hotel San Telmo', 'Camino del Sur 88', 38, 9); -- Santa Cruz de Tenerife
INSERT INTO Hotel (Nombre, Ubicacion, FK_IdLocalidad, FK_IdUsuario) VALUES ('Hotel Central', 'Calle Alcala 100', 28, 3); -- Madrid
INSERT INTO Hotel (Nombre, Ubicacion, FK_IdLocalidad, FK_IdUsuario) VALUES ('Hotel Guadalquivir', 'Paseo del Rio 33', 41, 3); -- Sevilla
INSERT INTO Hotel (Nombre, Ubicacion, FK_IdLocalidad, FK_IdUsuario) VALUES ('Hotel Monteverde', 'Avenida del Bosque 20', 47, 9); -- Valladolid

-- Facturas
INSERT INTO Factura (Nombre, Correo, Precio) 
VALUES 
('Juan Perez', 'juan.perez@gmail.com', 150.00),
('Ana Lopez', 'ana.lopez@gmail.com', 200.00),
('Carlos Sanchez', 'carlos.sanchez@gmail.com', 180.00);

-- Comentario
INSERT INTO Comentario (NEstrellas, Fecha, Comentario) VALUES
(5, '2024-05-01', 'Excelente servicio y comodidad.'),
(4, '2024-05-10', 'Muy buena ubicacion, volvere.'),
(3, '2024-04-15', 'Buen hotel pero un poco caro.');

-- CodigoPromocional
INSERT INTO CodigoPromocional (Codigo, Descuento) VALUES
('PROMO10', 10.00),
('VERANO15', 15.00),
('PER2025', 20.00);

-- Insert de datos habitaciones
INSERT INTO Habitacion (Nombre, Tipo, NPersonas, PrecioUnitario, m2, imagen, FK_IdHotel, NEstrellas, CajaFuerte, Minibar, Wifi) VALUES
('Habitacion VIP Centro', 'vip', 2, 130.00, 30, '406901_640.png', 1, 0, 1, 1, 1),
('Suite Real', 'suite', 2, 160.00, 40, '1505455_640.png', 2, 0, 1, 1, 1),
('Habitacion Familiar', '', 4, 90.00, 35, '8709665_640.png', 3, 0, 0, 1, 1),
('VIP Bahia', 'vip', 2, 140.00, 32, '7772422_640.png', 4, 0, 1, 1, 1),
('Suite Atardecer', 'suite', 2, 155.00, 38, '406901_640.png', 5, 0, 1, 1, 1),
('Habitacion Doble Est.', '', 2, 75.00, 24, '1677347_640.png', 6, 0, 0, 0, 1),
('Suite Tropical', 'suite', 2, 165.00, 42, '8732506_640.png', 7, 0, 1, 1, 1),
('Habitacion Economica', '', 1, 50.00, 18, '389254_640.png', 8, 0, 0, 0, 0),
('VIP Ejecutiva', 'vip', 2, 145.00, 34, '4467769_640.png', 9, 0, 1, 1, 1),
('Habitacion Patio Interior', '', 2, 70.00, 22, '5540926_640.png', 10, 0, 0, 0, 0);


-- contempla (suponiendo IdComentario 1 a 3, IdHabitacion 1 a 3, IdUsuario 3 a 5)
INSERT INTO contempla (IdComentario, IdHabitacion, IdUsuario) VALUES
(1, 1, 3),
(2, 2, 4),
(3, 3, 5);

-- Aplica (CodigoPromocional y Habitacion)
INSERT INTO Aplica (IdCodigo, IdHabitacion, FInicio, FFin) VALUES
(1, 1, '2024-01-01', '2024-12-31'), -- PROMO10 aplica a Habitacion 1 todo el año
(2, 2, '2024-06-01', '2024-08-31'), -- VERANO15 aplica a Habitacion 2 en verano
(3, 3, '2024-12-01', '2024-12-31'); -- NAVIDAD20 aplica a Habitacion 3 en diciembre

-- Cama
INSERT INTO Cama (Tipo) VALUES
('Individual'),
('Matrimonial'),
('Litera'),
('Sofa cama');

-- Habitacion VIP Centro (IdHabitacion = 1) tiene 1 matrimonial y 1 sofa cama
INSERT INTO Tiene (IdHabitacion, IdCama) VALUES
(1, 2), -- 1 cama Matrimonial
(1, 4); -- 1 sofa cama

-- Suite Real (IdHabitacion = 2) tiene 2 camas matrimoniales
INSERT INTO Tiene (IdHabitacion, IdCama) VALUES
(2, 2),
(2, 2); -- 2 camas Matrimoniales

-- Habitacion Familiar (IdHabitacion = 3) tiene 2 camas individuales y 1 litera
INSERT INTO Tiene (IdHabitacion, IdCama) VALUES
(3, 1),
(3, 1), -- 2 camas individuales
(3, 3); -- 1 litera

-- VIP Bahia (IdHabitacion = 4) tiene 1 cama matrimonial y 1 sofa cama
INSERT INTO Tiene (IdHabitacion, IdCama) VALUES
(4, 2),
(4, 4);

-- Suite Atardecer (IdHabitacion = 5) tiene 2 camas matrimoniales
INSERT INTO Tiene (IdHabitacion, IdCama) VALUES
(5, 2),
(5, 2);

-- Habitacion Doble Estandar (IdHabitacion = 6) tiene 2 camas individuales
INSERT INTO Tiene (IdHabitacion, IdCama) VALUES
(6, 1),
(6, 1);

-- Suite Tropical (IdHabitacion = 7) tiene 2 camas matrimoniales
INSERT INTO Tiene (IdHabitacion, IdCama) VALUES
(7, 2),
(7, 2);

-- Habitacion Economica (IdHabitacion = 8) tiene 1 cama individual
INSERT INTO Tiene (IdHabitacion, IdCama) VALUES
(8, 1);

-- VIP Ejecutiva (IdHabitacion = 9) tiene 1 cama matrimonial y 1 sofa cama
INSERT INTO Tiene (IdHabitacion, IdCama) VALUES
(9, 2),
(9, 4);

-- Habitacion Patio Interior (IdHabitacion = 10) tiene 2 camas individuales
INSERT INTO Tiene (IdHabitacion, IdCama) VALUES
(10, 1),
(10, 1);


-- Complemento
INSERT INTO Complemento (Nombre) VALUES
('Desayuno incluido'),
('Vista al mar'),
('Late check-out'),
('Parking gratis');

-- Suite (IdHabitacion 2, 5, 7 son Suite segun tus datos)
INSERT INTO Suite (IdHabitacion) VALUES
(2),
(5),
(7);

-- VIP (IdHabitacion 1, 4, 9 son VIP segun tus datos)
INSERT INTO VIP (IdHabitacion, Codigo) VALUES
(1, 'VIP001'),
(4, 'VIP002'),
(9, 'VIP003');

-- Obtiene (relaciona Suites con Complementos)
INSERT INTO Obtiene (IdHabitacion, IdComplemento) VALUES
(2, 1), -- Suite Real obtiene Desayuno incluido
(2, 2), -- Suite Real obtiene Vista al mar
(5, 3), -- Suite Atardecer obtiene Late check-out
(7, 4); -- Suite Tropical obtiene Parking gratis

-- Reserva
INSERT INTO Reserva (IdUsuario, IdHabitacion, IdFactura, FComienzo, FInicio, FFin, nombre, correo, codigo, vip, complemento, Estado, Incidencia) VALUES
(6, 1, 1, '2024-06-01 14:00:00', '2025-06-05', '2025-06-10', 'Juan Perez', 'juan.perez@gmail.com', 'PROMO10', 'no', '', 'Pagado', ''),
(7, 2, 2, '2024-06-07 16:00:00', '2025-07-20', '2025-07-25', 'Ana Lopez', 'ana.lopez@gmail.com', 'VERANO15', 'si', 'desayuno', 'pendiente', ''),
(8, 3, 3, '2024-06-12 12:00:00', '2025-08-15', '2025-08-18', 'Carlos Sanchez', 'carlos.sanchez@gmail.com', 'NAVIDAD20', 'no', '', 'Cancelado', 'Cliente no se presento');