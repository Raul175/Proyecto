<?php
class DataBase{
    public static function connect(){
        try {
            $options = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            );
            $connect = new PDO("mysql:host=localhost;dbname=rolvahotels", "root", "", $options);
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
            $rolvaHotelsDBSQL = file_get_contents("database/rolvaHotelsDBSQL.sql");
            $datosBDSQL = file_get_contents("database/datosBDSQL.sql");
            $connect->exec($rolvaHotelsDBSQL);
            
            $connect = self::connect();
            //Usuarios a insertar
            $usuarios = [
               ['admin123', 'admin admin', 'admin@rolvahotels.com', 'admin@3000', '29292929W', 'hombre', 1],
               ['raul', 'gonzalez alvarez', 'raul@rolvahotels.com', 'raul$123', '29292921J', 'hombre', 1],
               ['gerente123', 'gerente gerente', 'gerente@rolvahotels.com', 'gerente$123', '24292921Q', 'hombre', 2],
               ['Carlos', 'Gomez Perez', 'carlos.gomez@gmail.com', 'carlos123', '12345678A', 'hombre', 0],
               ['Lucia', 'Martínez Ruiz', 'lucia.martinez@gmail.com', 'lucia123', '87654321B', 'mujer', 0],
               ['Juan', 'Perez Garcia', 'juan.perez@gmail.com', 'pass123', '12345678A', 'hombre', 0],
               ['Ana', 'Lopez Martin', 'ana.lopez@gmail.com', 'pass123', '87654524N', 'mujer', 0],
               ['Carlos', 'Sánchez Ruiz', 'carlos.sanchez@gmail.com', 'pass123', '11223344C', 'hombre', 0],
               ['pepe', 'pepito pepito', 'pepito123@gmail.com', 'pepito_1', '11222344C', 'hombre', 2],
            ];

            $stmt = $connect->prepare("INSERT INTO Usuario (nombre, apellidos, correo, contrasena, dni, sexo, admin) VALUES (?, ?, ?, ?, ?, ?, ?)");

            foreach ($usuarios as $user) {
               $hash = password_hash($user[3], PASSWORD_BCRYPT);
               $stmt->execute([
                   $user[0], // nombre
                   $user[1], // apellidos
                   $user[2], // correo
                   $hash,    // contraseña hasheada
                   $user[4], // dni
                   $user[5], // sexo
                   $user[6] // admin
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