<?php
class Reserva {
    private $habitacion;
    private $usuario;
    private $factura;
    private $comienzo;
    private $inicio;
    private $fin;
    private $estado;

    public function __construct($habitacion,$usuario,$factura,$comienzo,$inicio,$fin,$estado) {
        $this->habitacion = $habitacion;
        $this->usuario = $usuario;
        $this->factura = $factura;
        $this->comienzo = $comienzo;
        $this->inicio = $inicio;
        $this->fin = $fin;
        $this->estado = $estado;
    }

    public static function reservar($habitacion,$usuario,$factura,$comienzo,$inicio,$fin,$codigo,$vip,$complemento,$nombre,$correo){
        try {
            $stmt = DataBase::connect()->prepare("INSERT INTO Reserva (IdHabitacion, IdUsuario, IdFactura, FComienzo, FInicio, FFin, Estado, Codigo, vip, complemento, nombre, correo) VALUES (?, ?, ? ,? ,? ,?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$habitacion,$usuario,$factura,$comienzo,$inicio,$fin,"Por Confirmar",$codigo,$vip,$complemento,$nombre,$correo]);
            return true;
        } catch (PDOException $e) {
            return "Error al realizar la reserva: " . $e->getMessage();
        }
    }

    public static function checkReserva($habitacion,$usuario,$inicio,$fin){
        try {
            $stmt = DataBase::connect()->prepare(
                "SELECT *
                        FROM Reserva
                        WHERE IdHabitacion = ?
                        AND Estado NOT IN ('Cancelado', 'Completado')
                        AND (FInicio <= ? AND FFin >= ?)
                        OR (IdUsuario = ? AND IdHabitacion = ? AND Estado NOT IN ('Cancelado', 'Completado'));
                    ");
            $stmt->execute([$habitacion,$fin,$inicio,$usuario,$habitacion]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function selectReservasUserId($usuario){
        try{
            $stmt = DataBase::connect()->prepare(
                "SELECT R.*, F.Precio
                        FROM Reserva R JOIN Factura F ON R.IdFactura = F.IdFactura
                        WHERE IdUsuario = ?;
                    ");
            $stmt->execute([$usuario]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function confirmar($habitacion,$usuario,$factura,$comienzo,$reserva){
        try {
            if($reserva != null){
                $stmt = DataBase::connect()->prepare("UPDATE Reserva SET FComienzo = ?, Estado = ? WHERE IdReserva LIKE ?");
                $stmt->execute([$comienzo,"Por Pagar",$reserva]);
            }else{
                $stmt = DataBase::connect()->prepare("UPDATE Reserva SET FComienzo = ?, Estado = ? WHERE IdHabitacion LIKE ? AND IdUsuario LIKE ? AND IdFactura LIKE ?");
                $stmt->execute([$comienzo,"Por Pagar",$habitacion,$usuario,$factura]);
            }
            return true;
        } catch (PDOException $e) {
            return "Error al realizar la reserva: " . $e->getMessage();
        }
    }

    public static function selectReserva($habitacion,$usuario,$factura,$reserva){
        try {
            if($reserva != null){
                $stmt = DataBase::connect()->prepare("SELECT * FROM Reserva WHERE IdReserva LIKE ?");
                $stmt->execute([$reserva]);
            }else{
                $stmt = DataBase::connect()->prepare("SELECT * FROM Reserva WHERE IdHabitacion LIKE ? AND IdUsuario LIKE ? AND IdFactura LIKE ?");
                $stmt->execute([$habitacion,$usuario,$factura]);
            }
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error al realizar la consulta: " . $e->getMessage();
        }
    }

    public static function resolver($reserva){
        try {
            $stmt = DataBase::connect()->prepare("UPDATE reserva SET Incidencia = null WHERE IdReserva LIKE ?");
            $stmt->execute([$reserva]);
            return 1;
        } catch (PDOException $e) {
            return "Error al realizar la consulta: " . $e->getMessage();
        }
    }

    public static function selectAllReservas(){
        try {
            $stmt = DataBase::connect()->prepare("
                SELECT 
                r.IdReserva AS Reserva,
                h.Nombre AS Habitacion,
                u.Nombre AS Usuario,
                u.Correo AS Correo,
                r.FInicio AS FEntrada,
                r.FFin AS FSalida, 
                r.Estado AS Estado,
                f.Precio AS Precio,
                r.Incidencia AS Incidencia
                FROM Reserva r
                JOIN Factura f ON r.IdFactura = f.IdFactura
                JOIN Usuario u ON r.IdUsuario = u.IdUsuario
                JOIN Habitacion h ON r.IdHabitacion = h.IdHabitacion
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error al realizar la consulta: " . $e->getMessage();
        }
    }

    public static function pagar($habitacion,$usuario,$factura, $reserva){
        try {
            if($reserva != null){
                $stmt = DataBase::connect()->prepare("UPDATE Reserva SET Estado = ? WHERE IdReserva LIKE ?");
                $stmt->execute(["Pagado",$reserva]);
            }else{
                $stmt = DataBase::connect()->prepare("UPDATE Reserva SET Estado = ? WHERE IdHabitacion LIKE ? AND IdUsuario LIKE ? AND IdFactura LIKE ?");
                $stmt->execute(["Pagado",$habitacion,$usuario,$factura]);
            }
            return true;
        } catch (PDOException $e) {
            return "Error al realizar la reserva: " . $e->getMessage();
        }
    }

    public static function insertarIncidencia($reserva, $incidencia){
        try {
            $stmt = DataBase::connect()->prepare("UPDATE Reserva SET Incidencia = ? WHERE IdReserva LIKE ?");
            $stmt->execute([$incidencia,$reserva]);
            return true;
        } catch (PDOException $e) {
            return "Error al realizar la reserva: " . $e->getMessage();
        }
    }

    public static function cancelar($reserva){
        try {
            $stmt = DataBase::connect()->prepare("UPDATE Reserva SET Estado = ? WHERE IdReserva LIKE ?");
            $stmt->execute(["Cancelado",$reserva]);
            return true;
        } catch (PDOException $e) {
            return "Error al realizar al cancelar la reserva: " . $e->getMessage();
        }
    }

    public static function ajustar(){
        try {
            $stmt = DataBase::connect()->prepare("UPDATE Reserva SET Estado = ? WHERE FComienzo <= DATE_SUB(NOW(), INTERVAL 1 HOUR) AND Estado LIKE ?");
            $stmt->execute(["Cancelado","Por Confirmar"]);
            $stmt = DataBase::connect()->prepare("UPDATE Reserva SET Estado = ? WHERE FComienzo <= DATE_SUB(NOW(), INTERVAL 12 HOUR) AND Estado LIKE ?");
            $stmt->execute(["Cancelado","Por Pagar"]);
            $stmt = DataBase::connect()->prepare("UPDATE Reserva SET Estado = ? WHERE FFin < CURDATE() AND Estado LIKE ?");
            $stmt->execute(["Completado","Pagado"]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
