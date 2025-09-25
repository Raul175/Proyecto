<?php
abstract class users{
        private $nombre;
        private $apellidos;
        private $correo;
        private $contraseña;
        private $dni;
        private $sexo;
        private $domicilio;
        private $fNacimiento;
        private $admin;

        public function __construct($nombre,$apellidoss,$correo,$contraseña,$dni,$sexo,$domicilio,$fNacimiento,$admin) {
                $this->nombre = $nombre;
                $this->apellidos = $apellidoss;
                $this->correo = $correo;
                $this->contraseña = $contraseña;
                $this->dni = $dni;
                $this->sexo = $sexo;
                $this->domicilio = $domicilio;
                $this->fNacimiento = $fNacimiento;
                $this->admin = $admin;
        }

        public static function iniciarSesion($user,$id,$correo,$admin){       
                $_SESSION['usuario'] = $user;
                $_SESSION['id'] = $id;
                $_SESSION['correo'] = $correo;
                $_SESSION['admin'] = $admin;
        }

        public static function checkUser($correo, $dni){
                try {
                        $stmt = DataBase::connect()->prepare("SELECT * FROM Usuario WHERE correo LIKE ? OR DNI LIKE ?");
                        $stmt->execute([$correo, $dni]);
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        return $user;
                } catch (PDOException $e) {
                        return false;
                }
        }

        public static function cerrarSesion(){
                session_destroy();
                header("Location: /Proyecto/");
        }

        public static function createUser($nombre, $apellidos, $correo, $contraseña, $dni, $sexo, $domicilio, $fNacimiento, $admin = 0){
                 try {
                        $stmt = DataBase::connect()->prepare("INSERT INTO Usuario (Nombre, Apellidos, Correo, Contrasena, DNI, Sexo, Domicilio, FNacimiento, Admin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt->execute([$nombre, $apellidos, $correo, $contraseña, $dni, $sexo, $domicilio,  $fNacimiento, $admin]);
                        return true;
                 } catch (PDOException $e) {
                         return false;
                 }
        }

        public static function selectAllUsers(){
                try {
                        $stmt = DataBase::connect()->prepare("SELECT * FROM Usuario");
                        $stmt->execute();
                        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        return $users;
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

        public static function updateUser($id, $nombre, $apellidos, $correo, $contraseña, $dni, $sexo, $domicilio, $fNacimiento, $admin){
                try {
                        $stmt = DataBase::connect()->prepare("UPDATE Usuario SET Nombre = ?, Apellidos = ?, Correo = ?, Contrasena = ?, DNI = ?, Sexo = ?, Domicilio = ?, FNacimiento = ?, Admin = ? WHERE idUsuario LIKE ?");
                        $stmt->execute([$nombre, $apellidos, $correo, $contraseña, $dni, $sexo, $domicilio, $fNacimiento, $admin, $id]);
                        return true;
                } catch (PDOException $e) {
                        return "Error al actualizar el usuario: " . $e->getMessage();
                }
        }

        public static function selectUser($user,$password){
                try {
                        $stmt = DataBase::connect()->prepare("SELECT * FROM usuario WHERE correo LIKE ?");
                        $stmt->execute([$user]);
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        return $user;
                } catch (PDOException $e) {
                        return false;
                }
        }

        public static function selectUserId($id){
                $stmt = DataBase::connect()->prepare("SELECT * FROM usuario WHERE IdUsuario LIKE ?");
                $stmt->execute([$id]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                return $user;
        }
}
?>