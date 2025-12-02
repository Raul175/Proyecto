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

    public static function backup($copiaSeguridad){
        // Comando mysqldump para exportar la base de datos y comprimirla
        // Nota: 'mysqldump' debe estar accesible desde la ruta de comandos de PHP.
        // Si no lo está, deberás especificar la ruta completa, por ejemplo: 'C:/xampp/mysql/bin/mysqldump'
        $comando = "C:/xampp/mysql/bin/mysqldump --opt -h localhost -u root rolvahotels > $copiaSeguridad";

        // --- Ejecutar el Comando ---
        $resultado = 0;
        $salida = [];
        exec($comando, $salida, $resultado);

        if ($resultado === 0) {
            return "SUCCESS"; // Devuelve éxito y el nombre del archivo
        } else {
            // Devuelve el código de error para depuración
            return "ERROR|Código: $resultado. Salida: " . print_r($salida, true); 
        }
    }

    public static function import($db_host,$db_user,$db_pass,$sql_path_temp,$mysql_path){
        // Comando mysqldump para exportar la base de datos y comprimirla
        // Nota: 'mysqldump' debe estar accesible desde la ruta de comandos de PHP.
        // Si no lo está, deberás especificar la ruta completa, por ejemplo: 'C:/xampp/mysql/bin/mysqldump'
        $pass_param = empty($db_pass) ? '' : "-p$db_pass";
        $comando = "$mysql_path -h $db_host -u $db_user $pass_param $pass_param rolvahotels < \"$sql_path_temp\" 2>&1";

        // --- Ejecutar el Comando ---
        $resultado = 0;
        $salida = [];
        exec($comando, $output, $resultado);

        // Intenta eliminar el archivo .sql temporal
        @unlink($sql_path_temp);

        if ($resultado === 0) {
            return "SUCCESS";
        } else {
            return "ERROR: Fallo en la importación. Mensaje: " . implode("\n", $salida);
        }
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