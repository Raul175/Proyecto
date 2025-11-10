<?php
class Cama {
    private $tipo;
    private $habitacion;
    private $cama;

    public function __construct($tipo, $habitacion, $cama) {
        $this->tipo = $tipo;
        $this->habitacion = $habitacion;
        $this->cama = $cama;
    }

    public static function createCama($tipo){
        try {
            $stmt = DataBase::connect()->prepare("INSERT INTO Cama (Tipo) VALUES (?)");
            $stmt->execute([$tipo]);
            return true;
        } catch (PDOException $e) {
            return "Error al crear la cama";
        }
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

    public static function checkCama($tipo){
        try {
            $stmt = DataBase::connect()->prepare("SELECT * FROM Cama WHERE tipo LIKE ?");
            $stmt->execute([$tipo]);
            $cama = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $cama;
        } catch (PDOException $e) {
            return false;
        }
    }


    public static function selectAllCama(){
        try {
            $stmt = DataBase::connect()->prepare("SELECT * FROM Cama");
            $stmt->execute();
            $camas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $camas;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function selectAllCamaRoom($habitacion){
        try {
            $stmt = DataBase::connect()->prepare("
                SELECT Cama.Tipo,COUNT(Cama.IdCama) AS camas FROM Cama 
                JOIN Tiene ON Cama.IdCama = Tiene.IdCama 
                WHERE Tiene.IdHabitacion LIKE ?
                GROUP BY Cama.IdCama;
            ");
            $stmt->execute([$habitacion]);
            $camas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $camas;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function deleteCama($id){
        try {
            $stmt = DataBase::connect()->prepare("DELETE FROM Cama WHERE idCama LIKE ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            return "Error al eliminar la cama: " . $e->getMessage();
        }
    }

    public static function updateCama($id, $tipo){
        try {
            $stmt = DataBase::connect()->prepare("UPDATE Cama SET tipo = ? WHERE idCama LIKE ?");
            $stmt->execute([$tipo, $id]);
            return true;
        } catch (PDOException $e) {
            return "Error al actualizar la cama: " . $e->getMessage();
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
