<?php
class Hotel {
    private $nombre;
    private $ubicacion;
    private $fkIdLocalidad;

    public function __construct($nombre = "", $fkIdLocalidad = 0, $ubicacion) {
        $this->nombre = $nombre;
        $this->ubicacion = $ubicacion;
        $this->fkIdLocalidad = $fkIdLocalidad;
    }

    public static function createHotel($nombre, $fkIdLocalidad, $ubicacion, $usuario = null){
        try {
            $stmt = DataBase::connect()->prepare("INSERT INTO Hotel (Nombre, FK_IdLocalidad, Ubicacion, FK_IdUsuario) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nombre, $fkIdLocalidad, $ubicacion, $usuario]);
            return true;
        } catch (PDOException $e) {
            return "Error al crear hotel: " . $e->getMessage();
        }
    }

    public static function checkHotel($nombre){
        try {
            $stmt = DataBase::connect()->prepare("SELECT * FROM Hotel WHERE Nombre = ?");
            $stmt->execute([$nombre]);
            $hotel = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $hotel;
        } catch (PDOException $e) {
            return "Error al verificar el hotel: " . $e->getMessage();
        }
    }

    public static function selectAllHotels(){
        try {
            $stmt = DataBase::connect()->prepare("SELECT * FROM Hotel");
            $stmt->execute();
            $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $hotels;
        } catch (PDOException $e) {
            return "Error al obtener los hoteles: " . $e->getMessage();
        }
    }

    public static function selectAllHotelsRooms(){
        try {
            $stmt = DataBase::connect()->prepare("
                SELECT 
                h.IdHotel AS hotel_IdHotel,
                h.Nombre AS hotel_nombre,
                h.Ubicacion AS hotel_ubicacion,
                h.FK_IdLocalidad AS hotel_FK_IdLocalidad,
                hab.IdHabitacion AS hab_IdHabitacion,
                hab.Nombre AS hab_nombre,
                hab.Tipo AS hab_Tipo,
                hab.PrecioUnitario AS hab_PrecioUnitario,
                hab.m2 AS hab_m2,
                hab.Imagen AS hab_Imagen
                FROM Hotel h 
                JOIN Habitacion hab ON hab.FK_IdHotel = h.IdHotel
                GROUP BY h.IdHotel, hab.IdHabitacion
                ORDER BY h.IdHotel, hab.IdHabitacion
                
            ");
            $stmt->execute();
            $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $hotels;
        } catch (\Throwable $th) {
            //throw $th;
        }
        
    }

    public static function selectAllHotelsGerente($id){
        try {
            $stmt = DataBase::connect()->prepare("SELECT * FROM Hotel WHERE FK_IdUsuario LIKE ?");
            $stmt->execute([$id]);
            $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $hotels;
        } catch (PDOException $e) {
            return "Error al obtener los hoteles: " . $e->getMessage();
        }
    }

    public static function selectAllHotelsLocal(){
        try {
            $stmt = DataBase::connect()->prepare("
                SELECT 
                h.IdHotel AS hotel_IdHotel,
                h.Nombre AS hotel_nombre,
                h.Ubicacion AS hotel_ubicacion,
                h.FK_IdLocalidad AS hotel_FK_IdLocalidad,
                hab.IdHabitacion AS hab_IdHabitacion,
                hab.Nombre AS hab_nombre,
                hab.Tipo AS hab_Tipo,
                hab.PrecioUnitario AS hab_PrecioUnitario,
                hab.m2 AS hab_m2,
                hab.Imagen AS hab_Imagen
                FROM Hotel h 
                LEFT JOIN Habitacion hab ON hab.FK_IdHotel = h.IdHotel
                ORDER BY h.IdHotel, hab.IdHabitacion
            ");
            $stmt->execute();
            $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $hotels;
        } catch (\Throwable $th) {
            //throw $th;
        }
        
    }

    public static function selectAllHotelsLocalGerente($id){
        try {
            $stmt = DataBase::connect()->prepare("
                SELECT 
                h.IdHotel AS hotel_IdHotel,
                h.Nombre AS hotel_nombre,
                h.Ubicacion AS hotel_ubicacion,
                h.FK_IdLocalidad AS hotel_FK_IdLocalidad,
                hab.IdHabitacion AS hab_IdHabitacion,
                hab.Nombre AS hab_nombre,
                hab.Tipo AS hab_Tipo,
                hab.PrecioUnitario AS hab_PrecioUnitario,
                hab.m2 AS hab_m2,
                hab.Imagen AS hab_Imagen
                FROM Hotel h 
                LEFT JOIN Habitacion hab ON hab.FK_IdHotel = h.IdHotel
                JOIN Usuario u ON u.IdUsuario = h.FK_IdUsuario
                WHERE u.IdUsuario LIKE ?
                ORDER BY h.IdHotel, hab.IdHabitacion
            ");
            $stmt->execute([$id]);
            $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $hotels;
        } catch (\Throwable $th) {
            //throw $th;
        }
        
    }
    
    public static function selectHotel($id){
        try {
            $stmt = DataBase::connect()->prepare("SELECT * FROM Hotel WHERE idHotel LIKE ?");
            $stmt->execute([$id]);
            $hotel = $stmt->fetch(PDO::FETCH_ASSOC);
            return $hotel;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function selectIdHotel($id){
        try {
            $stmt = DataBase::connect()->prepare("SELECT * FROM Hotel WHERE idHotel LIKE ?");
            $stmt->execute([$id]);
            $hotel = $stmt->fetch(PDO::FETCH_ASSOC);
            return $hotel;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function deleteHotel($id = 0){
        try {
            $stmt = DataBase::connect()->prepare("DELETE FROM Hotel WHERE idHotel LIKE ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            return "Error al eliminar el hotel: " . $e->getMessage();
        }
    }

    public static function updateHotel($id = 0, $nombre = "", $fkIdLocalidad = 0, $ubicacion){
        try {
            $stmt = DataBase::connect()->prepare("UPDATE Hotel SET Nombre = ?, FK_IdLocalidad = ?, Ubicacion = ? WHERE idHotel LIKE ?");
            $stmt->execute([$nombre, $fkIdLocalidad, $ubicacion, $id]);
            return true;
        } catch (PDOException $e) {
            return "Error al actualizar el hotel: " . $e->getMessage();
        }
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getFkIdLocalidad() {
        return $this->fkIdLocalidad;
    }

    public function setFkIdLocalidad($fkIdLocalidad) {
        $this->fkIdLocalidad = $fkIdLocalidad;
    }
}
?>
