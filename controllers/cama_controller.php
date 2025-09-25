<?php
    require_once('models/db_model.php');
    require_once('models/cama_model.php');

    if(isset($_POST['insertar'])){
        $cama = Cama::checkCama($_POST['tipo']);
        if(!empty($cama) && $cama[0]['Tipo'] == $_POST['tipo']){
            echo "Ya existe este tipo de cama";
        }else{
            createCama($_POST['tipo']);
        }
    }
    if(isset($_POST['actualizar'])){
        $cama = Cama::checkCama($_POST['tipo']);
        if(!empty($cama) && $cama[0]['Tipo'] == $_POST['tipo'] && $cama[0]['IdCama'] != $_POST['id']){
            echo "Ya existe este tipo de cama";
        }else{
            updateCama($_POST['id'], $_POST['tipo']);
        }
    }
    if(isset($_POST['eliminar'])){
        deleteCama($_POST['id']);
    }
    

    function selectAllCama(){
        return Cama::selectAllCama();
    }

    function selectAllCamaRoom($habitacion){
        return Cama::selectAllCamaRoom($habitacion);
    }

    function createCama($tipo){
        echo Cama::createCama($tipo);
    }

    function deleteCama($id){
        echo Cama::deleteCama($id);
    }

    function updateCama($id, $tipo){
        echo Cama::updateCama($id, $tipo);
    }
?>