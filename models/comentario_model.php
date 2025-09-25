<?php
class Comentario {
    private $comentario;

    public function __construct($comentario) {
        $this->comentario = $comentario;
    }

    public static function createComentario($habitacion, $comentario, $usuario, $estrellas, $fecha){
        try {
            $conn = DataBase::connect();
            $stmt = $conn->prepare("INSERT INTO Comentario (Comentario,NEstrellas,Fecha) VALUES (?, ?, ?)");
            $stmt->execute([$comentario, $estrellas, $fecha]);

            $stmt = $conn->prepare("INSERT INTO Contempla (IdHabitacion, IdComentario, IdUsuario) VALUES (?, ?, ?)");
            $stmt->execute([$habitacion,$conn->lastInsertId(), $usuario]);
            return true;
        } catch (PDOException $e) {
            return "Error al crear el código promocional: " . $e->getMessage();
        }
    }

    public static function checkComentario($habitacion, $usuario){
        try{
            $stmt = DataBase::connect()->prepare("
                SELECT Comentario.* 
                FROM Comentario JOIN Contempla ON Comentario.IdComentario = Contempla.IdComentario 
                WHERE Contempla.IdHabitacion = ? AND Contempla.IdUsuario = ?
            ");
            $stmt->execute([$habitacion, $usuario]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            return $usuario;
        }catch (PDOException $e) {
            return false;
        }
    }


    public static function selectAllComentario($habitacion){
        try {
            $stmt = DataBase::connect()->prepare("
                SELECT Comentario.*, Usuario.Nombre
                FROM Comentario 
                JOIN Contempla ON Comentario.IdComentario = Contempla.IdComentario
                JOIN Usuario ON Contempla.IdUsuario = Usuario.IdUsuario
                WHERE Contempla.IdHabitacion = ?
            ");
            $stmt->execute([$habitacion]);
            $comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $comentarios;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function selectAllComentarios(){
        try {
            $stmt = DataBase::connect()->prepare("
                SELECT Comentario.*, Usuario.Nombre, Habitacion.Nombre AS habitacion, Habitacion.IdHabitacion
                FROM Comentario 
                JOIN Contempla ON Comentario.IdComentario = Contempla.IdComentario
                JOIN Usuario ON Contempla.IdUsuario = Usuario.IdUsuario
                JOIN Habitacion ON Contempla.IdHabitacion = Habitacion.IdHabitacion
            ");
            $stmt->execute();
            $comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $comentarios;
        } catch (PDOException $e) {
            return false;
        }
        
    }
    
    public static function selectComentario($habitacion, $usuario){
        try {
            $stmt = DataBase::connect()->prepare("
                SELECT Comentario.*
                FROM Comentario 
                JOIN Contempla ON Comentario.IdComentario = Contempla.IdComentario
                JOIN Usuario ON Contempla.IdUsuario = Usuario.IdUsuario
                WHERE Contempla.IdHabitacion = ? AND Contempla.IdUsuario = ?
            ");
            $stmt->execute([$habitacion, $usuario]);
            $comentario = $stmt->fetch(PDO::FETCH_ASSOC);
            return $comentario;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function actualizarEstrellas($habitacion,){
        try {
            $stmt = DataBase::connect()->prepare("
                UPDATE Habitacion h
                SET NEstrellas = (
                    SELECT AVG(cm.NEstrellas)
                    FROM Contempla c
                    JOIN Comentario cm ON c.IdComentario = cm.IdComentario
                    WHERE c.IdHabitacion = h.IdHabitacion
                )
                WHERE h.IdHabitacion = ?;
            ");
            $stmt->execute([$habitacion]);
            return true;
        } catch (PDOException $e) {
            return "Error al actualizar el código promocional: " . $e->getMessage();
        }
    }

    public static function updateComentario($habitacion, $comentario, $usuario, $estrellas){
        try {
            $stmt = DataBase::connect()->prepare("
                UPDATE Comentario 
                JOIN Contempla ON Comentario.IdComentario = Contempla.IdComentario 
                JOIN Usuario ON Contempla.IdUsuario = Usuario.IdUsuario
                SET Comentario = ?, NEstrellas = ?
                WHERE Contempla.IdHabitacion LIKE ? AND Contempla.IdUsuario = ?
            ");
            $stmt->execute([$comentario, $estrellas, $habitacion, $usuario]);
            return true;
        } catch (PDOException $e) {
            return "Error al actualizar el código promocional: " . $e->getMessage();
        }
    }
}
?>
