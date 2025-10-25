<?php
class Habitacion {
    private $nombre;
    private $tipo;
    private $nPersonas;
    private $precioUnitario;
    private $m2;
    private $fkIdHotel;

    public function __construct($nombre = "", $tipo = "", $nPersonas = 0, $precioUnitario = 0.0, $m2 = 0.0, $fkIdHotel = 0) {
        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->nPersonas = $nPersonas;
        $this->precioUnitario = $precioUnitario;
        $this->m2 = $m2;
        $this->fkIdHotel = $fkIdHotel;
    }

    public static function createRoom($nombre, $tipo, $nPersonas, $precioUnitario, $m2, $fkIdHotel, $img, $vip){
        try {
            $conn = DataBase::connect();
            $stmt = $conn->prepare("INSERT INTO Habitacion (Nombre, Tipo, NPersonas, PrecioUnitario, m2, imagen, FK_IdHotel, NEstrellas) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nombre, $tipo, $nPersonas, $precioUnitario, $m2, $img, $fkIdHotel, 0]);
            $id = $conn->lastInsertId();
            if ($tipo == "suite") {
                Habitacion::createSuite($id);
            }elseif ($tipo == "vip") {
                Habitacion::createVIP($id,$vip);
            }
            return true;
        } catch (PDOException $e) {
            return "Error al crear la habitación: " . $e->getMessage();
        }
    }

    public static function createSuite($id){
        $stmt = DataBase::connect()->prepare("INSERT INTO Suite (IdHabitacion) VALUES (?)");
        $stmt->execute([$id]);
    }

    public static function comprobarSuite($id){
        $stmt = DataBase::connect()->prepare("SELECT * FROM VIP WHERE IdHabitacion LIKE ?");
        $stmt->execute([$id]);
        $habitacion = $stmt->fetch(PDO::FETCH_ASSOC);
        return $habitacion;
    }

    public static function createVIP($id,$cod){
        $stmt = DataBase::connect()->prepare("INSERT INTO VIP (IdHabitacion, Codigo) VALUES (?, ?)");
        $stmt->execute([$id, $cod]);
    }

    public static function checkRoom($nombre){
        $stmt = DataBase::connect()->prepare("SELECT nombre,idHabitacion FROM Habitacion WHERE nombre LIKE ?");
        $stmt->execute([$nombre]);
        $habitacion = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $habitacion;
    }

    public static function checkVIP($habitacion, $vip){
        $stmt = DataBase::connect()->prepare("SELECT * FROM VIP WHERE IdHabitacion LIKE ? AND Codigo LIKE ?");
        $stmt->execute([$habitacion, $vip]);
        $habitacion = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $habitacion;
    }

    public static function searchRoom($lugar,$npersonas,$entrada,$salida){
        try {
            $stmt = DataBase::connect()->prepare("
                SELECT h.*, COUNT(t.IdCama) AS NumCamas 
                FROM Habitacion h
                JOIN Hotel ht ON h.FK_IdHotel = ht.IdHotel 
                JOIN Localidad l ON ht.FK_IdLocalidad = l.IdLocalidad
                LEFT JOIN Reserva r ON r.IdHabitacion = h.IdHabitacion 
                AND (
                    (r.FInicio <= ? AND r.FFin >= ?)
                    AND r.Estado NOT IN ('Cancelado', 'Completado')
                )
                LEFT JOIN Tiene t 
                        ON t.IdHabitacion = h.IdHabitacion
                WHERE h.NPersonas >= ?
                AND l.IdLocalidad = ?
                AND (r.IdReserva IS NULL OR r.Estado IN ('Cancelado', 'Completado'))
                GROUP BY h.IdHabitacion;"
            );
            $stmt->execute([$entrada,$salida,$npersonas,$lugar]);
            $habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $habitaciones;
        }catch (PDOException $e) {
            return false;
        }
    }

    public static function selectAllRooms(){
        try {
            $stmt = DataBase::connect()->prepare("SELECT * FROM Habitacion");
            $stmt->execute();
            $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rooms;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function selectAllRoomsGerente($id){
        try {
            $stmt = DataBase::connect()->prepare("
            SELECT * FROM Habitacion h
            JOIN Hotel ho ON h.FK_IdHotel = ho.IdHotel
            WHERE ho.FK_IdUsuario LIKE ?
            ");
            $stmt->execute([$id]);
            $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rooms;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function selectRoom($habitacion){
        try {
            $stmt = DataBase::connect()->prepare("SELECT IdHabitacion,Nombre FROM Habitacion WHERE IdHabitacion = ?");
            $stmt->execute([$habitacion]);
            $room = $stmt->fetch(PDO::FETCH_ASSOC);
            return $room;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function selectAllRoomsFecha(){
        try {
            $stmt = DataBase::connect()->prepare("
                SELECT h.*, COUNT(t.IdCama) AS NumCamas, l.CodigoPostal AS localidad
                FROM Habitacion h
                LEFT JOIN Reserva r 
                    ON r.IdHabitacion = h.IdHabitacion
                    AND (
                        (r.FInicio <= CURDATE() AND r.FFin >= CURDATE())
                        AND r.Estado NOT IN ('Cancelado', 'Completado')
                    )
                LEFT JOIN Tiene t 
                    ON t.IdHabitacion = h.IdHabitacion
                LEFT JOIN Hotel ho
                    ON h.FK_IdHotel = ho.IdHotel
                LEFT JOIN Localidad l
                    ON ho.FK_IdLocalidad = l.IdLocalidad
                WHERE r.IdReserva IS NULL
                GROUP BY h.IdHabitacion;"
            );
            $stmt->execute();
            $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rooms;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function añadir($habitacion,$caja,$wifi,$bar){
        try {
            $stmt = DataBase::connect()->prepare("UPDATE Habitacion SET CajaFuerte = ?, Minibar = ?, Wifi = ? WHERE idHabitacion LIKE ?");
            $stmt->execute([$caja,$bar,$wifi,$habitacion]);
        }catch (PDOException $e) {
            return false;
        }
    }

    public static function total(){
        try {
            $stmt = DataBase::connect()->prepare("
                SELECT
                    SUM(CASE WHEN admin = '1' THEN 1 ELSE 0 END) AS personal,
                    SUM(CASE WHEN admin = '0' THEN 1 ELSE 0 END) AS usuario,
                    (SELECT COUNT(*) FROM Habitacion) AS habitacion,
                    (SELECT COUNT(*) FROM Hotel) AS hotel
                FROM Usuario;"
            );
            $stmt->execute();
            $total = $stmt->fetch(PDO::FETCH_ASSOC);
            return $total;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function selectAllRoomsFechaLimite(){
        try {
            $stmt = DataBase::connect()->prepare("
                SELECT h.*, COUNT(t.IdCama) AS NumCamas
                FROM Habitacion h
                LEFT JOIN Reserva r 
                    ON r.IdHabitacion = h.IdHabitacion
                    AND (
                        (r.FInicio <= CURDATE() AND r.FFin >= CURDATE())
                        AND r.Estado NOT IN ('Cancelado', 'Completado')
                    )
                LEFT JOIN Tiene t 
                    ON t.IdHabitacion = h.IdHabitacion
                WHERE r.IdReserva IS NULL
                GROUP BY h.IdHabitacion
                LIMIT 3;"
            );
            $stmt->execute();
            $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rooms;
        } catch (PDOException $e) {
            return false;
        }
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

    public static function deleteRoom($id = 0){
        try {
            $stmt = DataBase::connect()->prepare("DELETE FROM Habitacion WHERE idHabitacion LIKE ?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            return "Error al eliminar la habitación: " . $e->getMessage();
        }
    }

    public static function updateRoom($id = 0, $nombre = "", $tipo = "", $nPersonas = 0, $precioUnitario = 0.0, $m2 = 0.0, $fkIdHotel = 0){
        try {
            $stmt = DataBase::connect()->prepare("UPDATE Habitacion SET Nombre = ?, Tipo = ?, NPersonas = ?, PrecioUnitario = ?, m2 = ?, FK_IdHotel = ?  WHERE idHabitacion LIKE ?");
            $stmt->execute([$nombre, $tipo, $nPersonas, $precioUnitario, $m2, $fkIdHotel, $id]);
            return true;
        } catch (PDOException $e) {
            return "Error al actualizar la habitación: " . $e->getMessage();
        }
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getNPersonas() {
        return $this->nPersonas;
    }

    public function setNPersonas($nPersonas) {
        $this->nPersonas = $nPersonas;
    }


    public function getPrecioUnitario() {
        return $this->precioUnitario;
    }

    public function setPrecioUnitario($precioUnitario) {
        $this->precioUnitario = $precioUnitario;
    }

    public function getM2() {
        return $this->m2;
    }

    public function setM2($m2) {
        $this->m2 = $m2;
    }

    public function getFkIdHotel() {
        return $this->fkIdHotel;
    }

    public function setFkIdHotel($fkIdHotel) {
        $this->fkIdHotel = $fkIdHotel;
    }
}
?>
