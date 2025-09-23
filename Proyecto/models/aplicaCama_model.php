<?php
class AplicarCama {
    private $habitacion;
    private $cama;

    public function __construct($habitacion, $cama) {
        $this->habitacion = $habitacion;
        $this->cama = $cama;
    }

    public static function aplicarCama($habitacion, $cama){
        try {
            $stmt = DataBase::connect()->prepare("INSERT INTO Tiene (IdHabitacion, IdCama) VALUES (?, ?)");
            $stmt->execute([$habitacion, $cama]);
            return true;
        } catch (PDOException $e) {
            return "Error al aplicar el código promocional: " . $e->getMessage();
        }
    }

    public static function checkAplicar($habitacion, $cama){
        try {
            $stmt = DataBase::connect()->prepare("SELECT IdHabitacion, IdCama FROM Tiene WHERE IdHabitacion LIKE ? AND IdCama LIKE ?");
            $stmt->execute([$habitacion, $cama]);
            $aplica = $stmt->fetch(PDO::FETCH_ASSOC);
            return $aplica;
        } catch (PDOException $e) {
            return false;
        }
    }


    public static function selectAllAplica(){
        try {
            $stmt = DataBase::connect()->prepare("SELECT * FROM Tiene t JOIN Cama c ON t.IdCama = c.IdCama");
            $stmt->execute();
            $aplica = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $aplica;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function deleteAplica($habitacion, $cama){
        try {
            $stmt = DataBase::connect()->prepare("DELETE FROM Tiene WHERE IdHabitacion LIKE ? AND IdCama LIKE ?");
            $stmt->execute([$habitacion, $cama]);
            return true;
        } catch (PDOException $e) {
            return "Error al eliminar el aplicar: " . $e->getMessage();
        }
    }
}
?>
