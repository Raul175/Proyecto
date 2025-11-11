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
        $stmt = DataBase::connect()->prepare("INSERT INTO Cliente (IdHabitacion, domicilio, fNacimiento) VALUES (?, ?, ?)");
        $stmt->execute([$id, $domicilio, $fNacimiento]);
    }

}
?>
