<?php
    require_once('models/db_model.php');
    require_once('models/complemento_model.php');

    if(isset($_POST['insertar'])){
        $complemento = Complemento::checkComplemento($_POST['nombre']);
        if(!empty($complemento) && $complemento['Nombre'] == $_POST['nombre']){
            echo "Ya existe este complemento";
        }else{
            createComplemento($_POST['nombre']);
        }
    }
    if(isset($_POST['actualizar'])){
        $complemento = Complemento::checkComplemento($_POST['nombre']);
        if(!empty($complemento) && $complemento['Nombre'] == $_POST['nombre'] && $complemento['IdComplemento'] != $_POST['id']){
            echo "Ya existe este complemento";
        }else{
            updateComplemento($_POST['id'], $_POST['nombre']);
        }
    }
    if(isset($_POST['eliminar'])){
        deleteComplemento($_POST['id']);
    }

    function selectAllComplemento(){
        return Complemento::selectAllComplemento();
    }

    function createComplemento($nombre){
        echo Complemento::createComplemento($nombre);
    }

    function deleteComplemento($id){
        echo Complemento::deleteComplemento($id);
    }

    function updateComplemento($id, $nombre){
        echo Complemento::updateComplemento($id, $nombre);
    }
?>