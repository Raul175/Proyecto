<?php
class CodigoPromocional {
    private $codigo;
    private $descuento;

    public function __construct($codigo = "", $descuento = 0.0) {
        $this->codigo = $codigo;
        $this->descuento = $descuento;
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

    public function getCodigo() {
        return $this->codigo;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function getDescuento() {
        return $this->descuento;
    }

    public function setDescuento($descuento) {
        $this->descuento = $descuento;
    }
}
?>
