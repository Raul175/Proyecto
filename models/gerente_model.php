<?php
class gerente extends users {
    protected $fNacimiento;

    public function __construct($nombre,$apellidoss,$correo,$contraseña,$dni,$sexo,$fNacimiento,$admin) {
        parent::__construct($nombre,$apellidoss,$correo,$contraseña,$dni,$sexo,$admin);
        $this->fNacimiento = $fNacimiento;
    }

    public static function createGerente($id, $fNacimiento){
        $stmt = DataBase::connect()->prepare("INSERT INTO Gerente (IdUsuario, fNacimiento) VALUES (?, ?)");
        $stmt->execute([$id, $fNacimiento]);
    }

    public static function updateGerente($id, $fNacimiento){
        try {
                $stmt = DataBase::connect()->prepare("UPDATE Gerente SET fNacimiento = ? WHERE idUsuario LIKE ?");
                $stmt->execute([$fNacimiento, $id]);
                return true;
        } catch (PDOException $e) {
                return "Error al actualizar el usuario: " . $e->getMessage();
        }
    }

}
?>
