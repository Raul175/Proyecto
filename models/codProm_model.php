<?php
class CodigoPromocional {
    private $codigo;
    private $descuento;
    private $habitacion;

    public function __construct($codigo = "", $descuento = 0.0, $habitacion) {
        $this->codigo = $codigo;
        $this->descuento = $descuento;
        $this->habitacion = $habitacion;
    }

    public static function createCodProm($codigo = "", $descuento = 0.0){
        try {
            $stmt = DataBase::connect()->prepare("INSERT INTO CodigoPromocional (Codigo, Descuento) VALUES (?, ?)");
            $stmt->execute([$codigo, $descuento]);
            return true;
        } catch (PDOException $e) {
            return "Error al crear el código promocional";
        }
    }

    public static function checkCodProm($codigo,$habitacion){
        try {
            if($habitacion !== null){
                $stmt = DataBase::connect()->prepare("
                    SELECT C.codigo,C.idCodigo,C.descuento 
                    FROM CodigoPromocional C JOIN Aplica A ON C.IdCodigo = A.idCodigo
                    WHERE codigo LIKE ? AND FInicio <= CURDATE() AND FFin >= CURDATE() AND A.IdHabitacion = ?
                ");
                $stmt->execute([$codigo, $habitacion]);
            }else{
                $stmt = DataBase::connect()->prepare("SELECT codigo,idCodigo,descuento FROM CodigoPromocional WHERE codigo LIKE ?");
                $stmt->execute([$codigo]);
            }
            $usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $usuario;
        } catch (PDOException $e) {
            return false;
        }
    }


    public static function selectAllCodProm(){
        try {
            $stmt = DataBase::connect()->prepare("SELECT * FROM CodigoPromocional");
            $stmt->execute();
            $codProms = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $codProms;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function deleteCodProm($id = 0){
        try {
            $stmt = DataBase::connect()->prepare("DELETE FROM CodigoPromocional WHERE idCodigo LIKE ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            return "Error al eliminar el código promocional: " . $e->getMessage();
        }
    }

    public static function updateCodProm($id = 0, $codigo = "", $descuento = 0.0){
        try {
            $stmt = DataBase::connect()->prepare("UPDATE CodigoPromocional SET Codigo = ?, Descuento = ? WHERE idCodigo LIKE ?");
            $stmt->execute([$codigo, $descuento, $id]);
            return true;
        } catch (PDOException $e) {
            return "Error al actualizar el código promocional: " . $e->getMessage();
        }
    }

    public static function aplicarCodProm($habitacion, $codigo, $inicio, $fin){
        try {
            $stmt = DataBase::connect()->prepare("INSERT INTO Aplica (IdHabitacion, IdCodigo, FInicio, FFin) VALUES (?, ?, ?, ?)");
            $stmt->execute([$habitacion, $codigo, $inicio, $fin]);
            return true;
        } catch (PDOException $e) {
            return "Error al aplicar el código promocional: " . $e->getMessage();
        }
    }

    public static function updateAplica($habitacion, $codigo, $inicio, $fin){
        try {
            $stmt = DataBase::connect()->prepare("UPDATE Aplica SET FInicio = ?, FFin = ? WHERE IdHabitacion LIKE ? AND IdCodigo LIKE ?");
            $stmt->execute([$inicio, $fin, $habitacion, $codigo]);
            return true;
        } catch (PDOException $e) {
            return "Error al actualizar el aplicado: " . $e->getMessage();
        }
    }

    public static function checkAplicar($habitacion, $codigo){
        try {
            $stmt = DataBase::connect()->prepare("SELECT IdHabitacion, IdCodigo FROM Aplica WHERE IdHabitacion LIKE ? AND IdCodigo LIKE ?");
            $stmt->execute([$habitacion, $codigo]);
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

    public static function deleteAplica($habitacion, $codigo){
        try {
            $stmt = DataBase::connect()->prepare("DELETE FROM Aplica WHERE IdHabitacion LIKE ? AND IdCodigo LIKE ?");
            $stmt->execute([$habitacion, $codigo]);
            return true;
        } catch (PDOException $e) {
            return "Error al eliminar el aplicar: " . $e->getMessage();
        }
    }
}
?>
