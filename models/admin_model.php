<?php
class admin extends users {

    public function __construct($nombre,$apellidoss,$correo,$contraseña,$dni,$sexo,$fNacimiento,$admin) {
        parent::__construct($nombre,$apellidoss,$correo,$contraseña,$dni,$sexo,$admin);
    }

    public static function createAdmin($id){
        try {
            $stmt = DataBase::connect()->prepare("INSERT INTO Administrador (IdUsuario) VALUES (?)");
            $stmt->execute([$id]);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function createUser($nombre, $apellidos, $correo, $contraseña, $dni, $sexo, $admin = 0){
        try {
            $conn = DataBase::connect();
            $stmt = $conn->prepare("INSERT INTO Usuario (Nombre, Apellidos, Correo, Contrasena, DNI, Sexo, Admin) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nombre, $apellidos, $correo, $contraseña, $dni, $sexo, $admin]);
            $id = $conn->lastInsertId();
            return (int) trim($id);
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function deleteUser($id = 0){
        try {
                $stmt = DataBase::connect()->prepare("DELETE FROM Usuario WHERE idUsuario LIKE ?");
                $stmt->execute([$id]);
                return true;
        } catch (PDOException $e) {
                return "Error al eliminar el usuario: " . $e->getMessage();
        }
    }

    public static function updateUser($id, $nombre, $apellidos, $correo, $contraseña, $dni, $sexo, $admin){
        try {
                $conn = DataBase::connect();
                $stmt = $conn->prepare("UPDATE Usuario SET Nombre = ?, Apellidos = ?, Correo = ?, Contrasena = ?, DNI = ?, Sexo = ?, Admin = ? WHERE idUsuario LIKE ?");
                $stmt->execute([$nombre, $apellidos, $correo, $contraseña, $dni, $sexo, $admin, $id]);
                return true;
        } catch (PDOException $e) {
                return "Error al actualizar el usuario: " . $e->getMessage();
        }
    }
}
?>
