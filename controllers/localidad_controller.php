<?php
    require_once('database/db.php');
    require_once('models/localidad_model.php');

    if(isset($_POST['insertar'])){
        $localidad = Localidad::checkLocalidad($_POST['nombre'],$_POST['codigo']);
        //if (!is_array($localidad)) {
        //    echo $localidad;
        //}else{
            if(!empty($localidad) && $localidad['Nombre'] == $_POST['nombre'] ||  !empty($localidad) && $localidad['CodLocalidad'] == $_POST['codigo']){
            echo "Ya existe esta localidad";
            }else{
                createLocalidad($_POST['nombre'], $_POST['codigo']);
            }
        //}
        
    }
    if(isset($_POST['actualizar'])){
        $localidad = Localidad::checkLocalidad($_POST['nombre'],$_POST['codigo']);
        if(!empty($localidad) && $localidad['Nombre'] == $_POST['nombre'] && $localidad['IdLocalidad'] != $_POST['id'] || !empty($localidad) && $localidad['CodigoPostal'] == $_POST['codigo'] && $localidad['IdLocalidad'] != $_POST['id']){
            echo "Ya existe esta localidad";
        }else{
            updateLocalidad($_POST['id'], $_POST['nombre'], $_POST['codigo']);
        }
    }
    if(isset($_POST['eliminar'])){
        deleteLocalidad($_POST['id']);
    }

    function selectAllLocalidades(){
        $localidades = Localidad::selectAllLocalidades();
        return $localidades;
    }

    function selectAllLocalidadesHoteles(){
        $localidades = Localidad::selectAllLocalidadesHoteles();
        return $localidades;
    }

    function createLocalidad($nombre, $codLocalidad){
        echo Localidad::createLocalidad($nombre, $codLocalidad);
    }

    function deleteLocalidad($id){
        echo Localidad::deleteLocalidad($id);
    }

    function updateLocalidad($id, $nombre, $codLocalidad){
        echo Localidad::updateLocalidad($id, $nombre, $codLocalidad);
    }
?>