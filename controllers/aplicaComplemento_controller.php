<?php
    require_once('models/db_model.php');
    require_once('models/aplicaComplemento_model.php');
    require_once('models/complemento_model.php');
    require_once('controllers/room_controller.php');

    if(isset($_POST['aplicar'])){
        $aplicaciones = AplicarComplemento::checkAplicar($_POST['habitacion'], $_POST['complemento']);
        if(!empty($aplicaciones) && $aplicaciones['IdComplemento'] == $_POST['complemento'] && $aplicaciones['IdHabitacion'] == $_POST['habitacion']){
            echo "Ya existe esta aplicación";
        }else{
            aplicarComplemento($_POST['habitacion'], $_POST['complemento']);
        }
    }
    if(isset($_POST['eliminar'])){
        deleteAplica($_POST['habitacion'], $_POST['complemento']);
    }

    function selectAllAplica(){
        $habitaciones = selectAllSuite();
        if(empty($habitaciones)){
            $habitaciones =  [];
        }
        $aplicados = AplicarComplemento::selectAllAplica();
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
        $habitaciones = selectAllSuiteGerente();
        if(empty($habitaciones)){
            $habitaciones =  [];
        }
        $aplicados = AplicarComplemento::selectAllAplica();
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
        echo AplicarComplemento::aplicarComplemento($habitacion, $complemento);
    }

    function deleteAplica($habitacion, $complemento){
        echo AplicarComplemento::deleteAplica($habitacion, $complemento);
    }
?>