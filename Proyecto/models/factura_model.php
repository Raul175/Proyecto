<?php
class Factura {
    private $correo;
    private $contraseña;

    public function __construct($correo, $contraseña) {
        $this->correo = $correo;
        $this->contraseña = $contraseña;
    }

    public static function createFactura($monto){
        try {
            $conn = DataBase::connect();
            $stmt = $conn->prepare("INSERT INTO Factura (Correo, Precio) VALUES (?, ?)");
            if ($stmt->execute([null, $monto])) {
                return $conn->lastInsertId();
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function selectFactura($id){
        try {
            $stmt = DataBase::connect()->prepare("SELECT * FROM Factura WHERE IdFactura LIKE ?");
            $stmt->execute([$id]);
            $factura = $stmt->fetch(PDO::FETCH_ASSOC);
            return $factura;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function updateFactura($factura,$reserva,$nombre,$email){
        try {
            if ($reserva == null) {
                $stmt = DataBase::connect()->prepare("UPDATE Factura SET Correo = ?, Nombre = ? WHERE IdFactura LIKE ?");
                $stmt->execute([$email,$nombre,$factura]);
            }else{
                $stmt = DataBase::connect()->prepare("UPDATE Factura F JOIN Reserva R ON F.IdFactura = R.IdFactura SET F.Correo = ?, F.Nombre = ? WHERE R.IdReserva LIKE ?");
                $stmt->execute([$email,$nombre,$reserva]);
            }
            return true;
        } catch (PDOException $e) {
            return "Error al actualizar la factura: " . $e->getMessage();
        }
    }
}
?>
