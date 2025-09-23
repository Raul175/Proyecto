<?php
    require_once('models/db_model.php');
    require_once('models/aplicaCama_model.php');
    require_once('models/cama_model.php');
    require_once('controllers/room_controller.php');

    if(isset($_POST['aplicar'])){
        $aplicaciones = AplicarCama::checkAplicar($_POST['habitacion'], $_POST['cama']);
        //if(!empty($aplicaciones) && $aplicaciones['IdCama'] == $_POST['cama'] && $aplicaciones['IdHabitacion'] == $_POST['habitacion']){
        //    echo "Ya existe esta aplicación";
        //}else{
            aplicarCama($_POST['habitacion'], $_POST['cama']);
        //}
    }
    if(isset($_POST['eliminar'])){
        deleteAplica($_POST['habitacion'], $_POST['cama']);
    }

    function selectAllAplica(){
        $habitaciones = selectAllRooms();
        if(empty($habitaciones)){
            $habitaciones =  [];
        }
        $aplicados = AplicarCama::selectAllAplica();
        if(empty($aplicados)){
            $aplicados = [];
        }
        $codAplicados = [];

        foreach ($habitaciones as $habitacion) {
            $codAplicados[$habitacion['IdHabitacion']] = [
                'habitacion' => $habitacion,
                'camas' => []
            ];
            foreach ($aplicados as $aplicado) {
                if($habitacion['IdHabitacion'] == $aplicado['IdHabitacion']){
                    $codAplicados[$habitacion['IdHabitacion']]['camas'][] = $aplicado;
                }
            }
        }

        return $codAplicados;
    }

    function aplicarCama($habitacion, $cama){
        echo AplicarCama::aplicarCama($habitacion, $cama);
    }
    
    function deleteAplica($habitacion, $cama){
        echo AplicarCama::deleteAplica($habitacion, $cama);
    }
?>