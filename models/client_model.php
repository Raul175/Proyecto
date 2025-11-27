<?php
class cliente extends users {
    protected $domicilio;
    protected $fNacimiento;

    public function __construct($nombre,$apellidoss,$correo,$contraseña,$dni,$sexo,$domicilio,$fNacimiento,$admin) {
        parent::__construct($nombre,$apellidoss,$correo,$contraseña,$dni,$sexo,$admin);
        $this->domicilio = $domicilio;
        $this->fNacimiento = $fNacimiento;
    }

    public static function createClient($id, $domicilio,$fNacimiento){
        try {
            $stmt = DataBase::connect()->prepare("INSERT INTO Cliente (IdUsuario, domicilio, FNacimiento) VALUES (?, ?, ?)");
            $stmt->execute([$id, $domicilio, $fNacimiento]);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function updateClient($id, $domicilio, $fNacimiento){
        try {
                $stmt = DataBase::connect()->prepare("UPDATE Cliente SET FNacimiento = ?, Domicilio = ? WHERE idUsuario LIKE ?");
                $stmt->execute([$fNacimiento, $domicilio, $id]);
                return true;
        } catch (PDOException $e) {
                return "Error al actualizar el usuario: " . $e->getMessage();
        }
    }

}
?>
