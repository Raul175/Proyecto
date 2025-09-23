<?php
class Aplicar {
    private $habitacion;
    private $codProm;

    public function __construct($habitacion, $codProm) {
        $this->habitacion = $habitacion;
        $this->codProm = $codProm;
    }

    public static function aplicarCodProm($habitacion, $codProm, $inicio, $fin){
        try {
            $stmt = DataBase::connect()->prepare("INSERT INTO Aplica (IdHabitacion, IdCodigo, FInicio, FFin) VALUES (?, ?, ?, ?)");
            $stmt->execute([$habitacion, $codProm, $inicio, $fin]);
            return true;
        } catch (PDOException $e) {
            return "Error al aplicar el código promocional: " . $e->getMessage();
        }
    }

    public static function updateAplica($habitacion, $codProm, $inicio, $fin){
        try {
            $stmt = DataBase::connect()->prepare("UPDATE Aplica SET FInicio = ?, FFin = ? WHERE IdHabitacion LIKE ? AND IdCodigo LIKE ?");
            $stmt->execute([$inicio, $fin, $habitacion, $codProm]);
            return true;
        } catch (PDOException $e) {
            return "Error al actualizar el aplicado: " . $e->getMessage();
        }
    }

    public static function checkAplicar($habitacion, $codProm){
        try {
            $stmt = DataBase::connect()->prepare("SELECT IdHabitacion, IdCodigo FROM Aplica WHERE IdHabitacion LIKE ? AND IdCodigo LIKE ?");
            $stmt->execute([$habitacion, $codProm]);
            $aplica = $stmt->fetch(PDO::FETCH_ASSOC);
            return $aplica;
        } catch (PDOException $e) {
            return false;
        }
    }


    public static function selectAllAplica(){
        try {
            $stmt = DataBase::connect()->prepare("SELECT * FROM Aplica a JOIN CodigoPromocional c ON a.IdCodigo = c.IdCodigo JOIN Habitacion h ON a.IdHabitacion = h.IdHabitacion;");
            $stmt->execute();
            $aplica = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $aplica;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function deleteAplica($habitacion, $codProm){
        try {
            $stmt = DataBase::connect()->prepare("DELETE FROM Aplica WHERE IdHabitacion LIKE ? AND IdCodigo LIKE ?");
            $stmt->execute([$habitacion, $codProm]);
            return true;
        } catch (PDOException $e) {
            return "Error al eliminar el aplicar: " . $e->getMessage();
        }
    }

    public function getCodigo() {
        return $this->codProm;
    }

    public function setCodigo($codigo) {
        $this->codProm = $codigo;
    }

    public function getHabitacion() {
        return $this->habitacion;
    }

    public function setHabitacion($habitacion) {
        $this->habitacion = $habitacion;
    }
}
?>
