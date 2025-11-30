<?php
    require_once('database/db.php');
    require_once('models/comentario_model.php');

    extract($_POST);

    if(isset($_POST['insertar'])){
        $comentarios = Comentario::checkComentario($habitacion, $usuario);
        if(!empty($comentarios)){
            updateComentario($habitacion, $comentario, $usuario, $estrellas, $fecha);
        }else{
            createComentario($habitacion, $comentario, $usuario, $estrellas, $fecha);
        }
        Comentario::actualizarEstrellas($habitacion);
    }

    function selectAllComentario($habitacion){
        return Comentario::selectAllComentario($habitacion);
    }
    function selectAllComentarios(){
        return Comentario::selectAllComentarios();
    }

    function selectComentario($habitacion, $usuario){
        return Comentario::selectComentario($habitacion, $usuario);
    }

    function createComentario($habitacion, $comentario, $usuario, $estrellas, $fecha){
        echo Comentario::createComentario($habitacion, $comentario, $usuario, $estrellas, $fecha);
    }

    function updateComentario($habitacion, $comentario, $usuario, $estrellas, $fecha){
        echo Comentario::updateComentario($habitacion, $comentario, $usuario, $estrellas, $fecha);
    }
?>