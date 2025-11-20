<?php
abstract class users{
        protected $nombre;
        protected $apellidos;
        protected $correo;
        protected $contraseña;
        protected $dni;
        protected $sexo;
        protected $admin;

        public function __construct($nombre,$apellidoss,$correo,$contraseña,$dni,$sexo,$admin) {
                $this->nombre = $nombre;
                $this->apellidos = $apellidoss;
                $this->correo = $correo;
                $this->contraseña = $contraseña;
                $this->dni = $dni;
                $this->sexo = $sexo;
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

        public static function selectAllUsersGerente(){
                try {
                        $stmt = DataBase::connect()->prepare("SELECT * FROM Gerente");
                        $stmt->execute();
                        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        return $users;
                } catch (PDOException $e) {
                        return false;
                }
        }

        public static function selectAllUsers(){
                try {
                        $stmt = DataBase::connect()->prepare("
                        SELECT
    U.*,
    C.Domicilio,
    COALESCE(C.FNacimiento, G.FNacimiento) AS FNacimiento
FROM
    Usuario U
LEFT JOIN Cliente C ON U.IdUsuario = C.IdUsuario
LEFT JOIN Administrador A ON U.IdUsuario = A.IdUsuario
LEFT JOIN Gerente G ON U.IdUsuario = G.IdUsuario;
                        ");
                        $stmt->execute();
                        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        return $users;
                } catch (PDOException $e) {
                        return false;
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
                $stmt = DataBase::connect()->prepare("SELECT u.*, c.* 
                                                      FROM usuario u JOIN cliente c ON u.IdUsuario = c.IdUsuario
                                                      WHERE u.IdUsuario LIKE ?");
                $stmt->execute([$id]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                return $user;
        }
}
?>