<?php
class Suite extends Habitacion{

    public function __construct($nombre = "", $tipo = "", $nPersonas = 0, $precioUnitario = 0.0, $m2 = 0.0, $fkIdHotel = 0) {
        parent::__construct($nombre, $tipo, $nPersonas, $precioUnitario, $m2, $fkIdHotel);
    }

    public static function createSuite($id){
        $stmt = DataBase::connect()->prepare("INSERT INTO Suite (IdHabitacion) VALUES (?)");
        $stmt->execute([$id]);
        return true;
    }

    public static function comprobarSuite($id){
        $stmt = DataBase::connect()->prepare("SELECT * FROM VIP WHERE IdHabitacion LIKE ?");
        $stmt->execute([$id]);
        $habitacion = $stmt->fetch(PDO::FETCH_ASSOC);
        return $habitacion;
    }

    public static function selectAllSuite(){
        try {
            $stmt = DataBase::connect()->prepare("SELECT * FROM Habitacion WHERE Tipo LIKE ?");
            $stmt->execute(["suite"]);
            $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rooms;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function selectAllSuiteGerente($id){
        try {
            $stmt = DataBase::connect()->prepare("
            SELECT * FROM Habitacion 
            JOIN Hotel ho ON h.FK_IdHotel = ho.IdHotel
            WHERE Tipo LIKE ? AND ho.FK_IdUsuario LIKE ?
            ");
            $stmt->execute(["suite",$id]);
            $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rooms;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function selectSuite($id){
        try {
            $stmt = DataBase::connect()->prepare("SELECT o.IdComplemento, c.Nombre FROM Obtiene o JOIN Habitacion h ON o.IdHabitacion = h.IdHabitacion JOIN Complemento c ON o.IdComplemento = c.IdComplemento WHERE o.IdHabitacion LIKE ?");
            $stmt->execute([$id]);
            $suite = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $suite;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
