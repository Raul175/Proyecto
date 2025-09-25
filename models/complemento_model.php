<?php
class Complemento {
    private $nombre;

    public function __construct($nombre = "") {
        $this->nombre = $nombre;
    }

    public static function createComplemento($nombre){
        try {
            $stmt = DataBase::connect()->prepare("INSERT INTO Complemento (Nombre) VALUES (?)");
            $stmt->execute([$nombre]);
            return true;
        } catch (PDOException $e) {
            return "Error al crear el complemento";
        }
    }

    public static function checkComplemento($nombre){
        try {
            $stmt = DataBase::connect()->prepare("SELECT * FROM Complemento WHERE Nombre LIKE ?");
            $stmt->execute([$nombre]);
            $complemento = $stmt->fetch(PDO::FETCH_ASSOC);
            return $complemento;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function selectAllComplemento(){
        try {
            $stmt = DataBase::connect()->prepare("SELECT * FROM Complemento");
            $stmt->execute();
            $complementos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $complementos;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function deleteComplemento($id = 0){
        try {
            $stmt = DataBase::connect()->prepare("DELETE FROM Complemento WHERE IdComplemento LIKE ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            return "Error al eliminar el complemento: " . $e->getMessage();
        }
    }

    public static function updateComplemento($id, $nombre){
        try {
            $stmt = DataBase::connect()->prepare("UPDATE Complemento SET Nombre = ? WHERE IdComplemento LIKE ?");
            $stmt->execute([$nombre, $id]);
            return true;
        } catch (PDOException $e) {
            return "Error al actualizar el complemento: " . $e->getMessage();
        }
    }
}
?>
