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

}
?>
