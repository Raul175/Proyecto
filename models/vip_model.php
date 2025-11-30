<?php
class vip extends Habitacion {

    public function __construct($nombre = "", $tipo = "", $nPersonas = 0, $precioUnitario = 0.0, $m2 = 0.0, $fkIdHotel = 0) {
        parent::__construct($nombre, $tipo, $nPersonas, $precioUnitario, $m2, $fkIdHotel);
    }

    public static function createVIP($id,$cod){
        try {
            $stmt = DataBase::connect()->prepare("INSERT INTO VIP (IdHabitacion, Codigo) VALUES (?, ?)");
            $stmt->execute([$id, $cod]);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function checkVIP($habitacion, $vip){
        $stmt = DataBase::connect()->prepare("SELECT * FROM VIP WHERE IdHabitacion LIKE ? AND Codigo LIKE ?");
        $stmt->execute([$habitacion, $vip]);
        $habitacion = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $habitacion;
    }
}
?>
