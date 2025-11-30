<?php
    require_once('database/db.php');
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

    if(isset($_POST['aplicar'])){
        $aplicaciones = Complemento::checkAplicar($_POST['habitacion'], $_POST['complemento']);
        if(!empty($aplicaciones) && $aplicaciones['IdComplemento'] == $_POST['complemento'] && $aplicaciones['IdHabitacion'] == $_POST['habitacion']){
            echo "Ya existe esta aplicación";
        }else{
            aplicarComplemento($_POST['habitacion'], $_POST['complemento']);
        }
    }
    if(isset($_POST['eliminar1'])){
        deleteAplica($_POST['habitacion'], $_POST['complemento']);
    }

    function selectAllAplica(){
        require_once('controllers/room_controller.php');
        $habitaciones = selectAllSuite();
        if(empty($habitaciones)){
            $habitaciones =  [];
        }
        $aplicados = Complemento::selectAllAplica();
        if(empty($aplicados)){
            $aplicados = [];
        }
        $codAplicados = [];

        foreach ($habitaciones as $habitacion) {
            $codAplicados[$habitacion['IdHabitacion']] = [
                'habitacion' => $habitacion,
                'complementos' => []
            ];
            foreach ($aplicados as $aplicado) {
                if($habitacion['IdHabitacion'] == $aplicado['IdHabitacion']){
                    $codAplicados[$habitacion['IdHabitacion']]['complementos'][] = $aplicado;
                }
            }
        }

        return $codAplicados;
    }

    function selectAllAplicaGerente(){
        require_once('controllers/room_controller.php');
        $habitaciones = selectAllSuiteGerente();
        if(empty($habitaciones)){
            $habitaciones =  [];
        }
        $aplicados = Complemento::selectAllAplica();
        if(empty($aplicados)){
            $aplicados = [];
        }
        $codAplicados = [];

        foreach ($habitaciones as $habitacion) {
            $codAplicados[$habitacion['IdHabitacion']] = [
                'habitacion' => $habitacion,
                'complementos' => []
            ];
            foreach ($aplicados as $aplicado) {
                if($habitacion['IdHabitacion'] == $aplicado['IdHabitacion']){
                    $codAplicados[$habitacion['IdHabitacion']]['complementos'][] = $aplicado;
                }
            }
        }

        return $codAplicados;
    }

    function aplicarComplemento($habitacion, $complemento){
        echo Complemento::aplicarComplemento($habitacion, $complemento);
    }

    function deleteAplica($habitacion, $complemento){
        echo Complemento::deleteAplica($habitacion, $complemento);
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