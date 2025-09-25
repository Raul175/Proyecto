<?php
class AplicarComplemento {
    private $habitacion;
    private $complemento;

    public function __construct($habitacion, $complemento) {
        $this->habitacion = $habitacion;
        $this->complemento = $complemento;
    }

    public static function aplicarComplemento($habitacion, $complemento){
        try {
            $stmt = DataBase::connect()->prepare("INSERT INTO Obtiene (IdHabitacion, IdComplemento) VALUES (?, ?)");
            $stmt->execute([$habitacion, $complemento]);
            return true;
        } catch (PDOException $e) {
            return "Error al aplicar el complemento: " . $e->getMessage();
        }
    }

    public static function checkAplicar($habitacion, $complemento){
        try {
            $stmt = DataBase::connect()->prepare("SELECT IdHabitacion, IdComplemento FROM Obtiene WHERE IdHabitacion LIKE ? AND IdComplemento LIKE ?");
            $stmt->execute([$habitacion, $complemento]);
            $aplica = $stmt->fetch(PDO::FETCH_ASSOC);
            return $aplica;
        } catch (PDOException $e) {
            return false;
        }
    }


    public static function selectAllAplica(){
        try {
            $stmt = DataBase::connect()->prepare("SELECT * FROM Obtiene o JOIN Complemento c ON o.IdComplemento = c.IdComplemento");
            $stmt->execute();
            $aplica = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $aplica;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function deleteAplica($habitacion, $complemento){
        try {
            $stmt = DataBase::connect()->prepare("DELETE FROM Obtiene WHERE IdHabitacion LIKE ? AND IdComplemento LIKE ?");
            $stmt->execute([$habitacion, $complemento]);
            return true;
        } catch (PDOException $e) {
            return "Error al eliminar el aplicar: " . $e->getMessage();
        }
    }
}
?>
