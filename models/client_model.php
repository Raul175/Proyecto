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
        $stmt = DataBase::connect()->prepare("INSERT INTO Cliente (IdHabitacion, domicilio, FNacimiento) VALUES (?, ?, ?)");
        $stmt->execute([$id, $domicilio, $fNacimiento]);
    }

    public static function updateClient($id, $fNacimiento, $domicilio){
        try {
                $stmt = DataBase::connect()->prepare("UPDATE Gerente SET FNacimiento = ?, Domicilio = = ? WHERE idUsuario LIKE ?");
                $stmt->execute([$fNacimiento, $domicilio, $id]);
                return true;
        } catch (PDOException $e) {
                return "Error al actualizar el usuario: " . $e->getMessage();
        }
    }

}
?>
