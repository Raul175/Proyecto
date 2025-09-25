<?php
class Localidad {
    private $nombre;
    private $CodigoPostal;

    public function __construct($nombre = "", $CodigoPostal = "") {
        $this->nombre = $nombre;
        $this->CodigoPostal = $CodigoPostal;
    }

    public static function createLocalidad($nombre = "", $CodigoPostal = ""){
        try {
            $stmt = DataBase::connect()->prepare("INSERT INTO Localidad (Nombre, CodigoPostal) VALUES (?, ?)");
            $stmt->execute([$nombre, $CodigoPostal]);
            return true;
        } catch (PDOException $e) {
            return "Error al crear la localidad: " . $e->getMessage();
        }
    }

    public static function checkLocalidad($nombre,$codigo){
        try {
            $stmt = DataBase::connect()->prepare("SELECT * FROM Localidad WHERE Nombre LIKE ? OR CodigoPostal LIKE ?");
            $stmt->execute([$nombre, $codigo]);
            $localidad = $stmt->fetch(PDO::FETCH_ASSOC);
            return $localidad;
        } catch (PDOException $e) {
            return "Error al verificar la localidad";
        }
    }

    public static function selectAllLocalidades(){
        try {
            $stmt = DataBase::connect()->prepare("SELECT * FROM Localidad");
            $stmt->execute();
            $localidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $localidades;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function selectAllLocalidadesHoteles(){
        try {
            $stmt = DataBase::connect()->prepare("SELECT Localidad.* FROM Localidad JOIN Hotel ON Localidad.IdLocalidad = Hotel.FK_IdLocalidad;");
            $stmt->execute();
            $localidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $localidades;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function selectLocalidad($id){
        $stmt = DataBase::connect()->prepare("SELECT Nombre FROM Localidad WHERE IdLocalidad LIKE ?");
        $stmt->execute([$id]);
        $localidad = $stmt->fetchColumn();
        return $localidad;
    }

    public static function deleteLocalidad($id = 0){
        try {
            $stmt = DataBase::connect()->prepare("DELETE FROM Localidad WHERE IdLocalidad LIKE ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            return "Error al eliminar la localidad: " . $e->getMessage();
        }
    }

    public static function updateLocalidad($id = 0, $nombre = "", $CodigoPostal = ""){
        try {
            $stmt = DataBase::connect()->prepare("UPDATE Localidad SET Nombre = ?, CodigoPostal = ? WHERE IdLocalidad LIKE ?");
            $stmt->execute([$nombre, $CodigoPostal, $id]);
            return true;
        } catch (PDOException $e) {
            return "Error al actualizar la localidad: " . $e->getMessage();
        }
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getCodigoPostal() {
        return $this->CodigoPostal;
    }

    public function setCodigoPostal($CodigoPostal) {
        $this->CodigoPostal = $CodigoPostal;
    }
}
?>
