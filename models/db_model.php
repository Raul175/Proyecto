<?php
class DataBase{
    public static function connect(){
        try {
            $connect = new PDO("mysql:host=localhost;dbname=rolvaHotels", "root", "");
        } catch (\Throwable $th) {
            $connect = new PDO("mysql:host=localhost", "root", "");
        }
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connect;
    }

    public static function createBD(){
        $connect = self::connect();
        try {
            $connect->exec("CREATE DATABASE rolvaHotels");
            $connect = self::connect();
            $rolvaHotelsDBSQL = file_get_contents("models/rolvaHotelsDBSQL.sql");
            $datosBDSQL = file_get_contents("models/datosBDSQL.sql");
            
            $connect->exec($rolvaHotelsDBSQL);
            $connect = self::connect();
            // Usuarios a insertar
            $usuarios = [
                ['admin123', 'admin admin', 'admin@rolvahotels.com', 'admin@3000', '29292929W', '2004-02-05', 'hombre', 'Cº Majo 25', 1],
                ['raul', 'gonzalez alvarez', 'raul@rolvahotels.com', 'raul$123', '29292921J', '2005-12-20', 'hombre', 'Cº Rio 21', 1],
                ['gerente123', 'gerente gerente', 'gerente@rolvahotels.com', 'gerente$123', '29292921J', '2005-12-20', 'hombre', 'Cº Rio 21', 2],
                ['Carlos', 'Gomez Perez', 'carlos.gomez@gmail.com', 'carlos123', '12345678A', '1990-05-10', 'hombre', 'Calle Mayor 12', 0],
                ['Lucia', 'Martínez Ruiz', 'lucia.martinez@gmail.com', 'lucia123', '87654321B', '1995-08-15', 'mujer', 'Avda. Andalucía 34', 0],
                ['Juan', 'Perez Garcia', 'juan.perez@gmail.com', 'pass123', '12345678A', '1985-05-12', 'hombre', 'Calle Falsa 123', 0],
                ['Ana', 'Lopez Martin', 'ana.lopez@gmail.com', 'pass123', '87654321B', '1990-10-01', 'mujer', 'Av. Siempre Viva 742', 0],
                ['Carlos', 'Sánchez Ruiz', 'carlos.sanchez@gmail.com', 'pass123', '11223344C', '1978-03-22', 'hombre', 'Paseo de la Reforma 10', 0],
            ];

            $stmt = $connect->prepare("INSERT INTO Usuario (nombre, apellidos, correo, contrasena, dni, FNacimiento, sexo, domicilio, admin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

            foreach ($usuarios as $user) {
                $hash = password_hash($user[3], PASSWORD_BCRYPT);
                $stmt->execute([
                    $user[0], // nombre
                    $user[1], // apellidos
                    $user[2], // correo
                    $hash,    // contraseña hasheada
                    $user[4], // dni
                    $user[5], // FNacimiento
                    $user[6], // sexo
                    $user[7], // domicilio
                    $user[8]  // admin
                ]);
            }

            $connect->exec($datosBDSQL);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function deleteBD(){
        $connect = self::connect();
        try {
            $connect->exec("DROP DATABASE rolvaHotels");
            return "Base de Datos borrada con exito";
        } catch (\Throwable $th) {
            return "La base de datos no existe";
        }
    }
}
?>